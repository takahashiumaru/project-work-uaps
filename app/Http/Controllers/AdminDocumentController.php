<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class AdminDocumentController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();

        $documents = Document::with(['creator', 'updater'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_dokumen', 'like', "%{$search}%")
                        ->orWhere('deskripsi_dokumen', 'like', "%{$search}%")
                        ->orWhere('nama_file', 'like', "%{$search}%")
                        ->orWhere('role_akses_dokumen', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('document.admin.index', [
            'documents' => $documents,
        ]);
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('document.admin.create', [
            'availableRoles' => $this->availableRoles(),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $this->validatedData($request, requireFile: true);
        $fileData = $this->storeUploadedFile($request->file('document_file'), $validated['nama_dokumen']);

        Document::create(array_merge($validated, $fileData, [
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]));

        Alert::success('Berhasil', 'Dokumen berhasil ditambahkan.');

        return redirect()->route('admin.documents.index');
    }

    public function edit(Document $document)
    {
        $this->ensureAdmin();

        return view('document.admin.edit', [
            'document' => $document,
            'availableRoles' => $this->availableRoles(),
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $this->ensureAdmin();

        $validated = $this->validatedData($request, requireFile: false);
        $validated['updated_by'] = Auth::id();

        if ($request->hasFile('document_file')) {
            $this->deleteDocumentFile($document);
            $validated = array_merge(
                $validated,
                $this->storeUploadedFile($request->file('document_file'), $validated['nama_dokumen'])
            );
        }

        $document->update($validated);

        Alert::success('Berhasil', 'Dokumen berhasil diperbarui.');

        return redirect()->route('admin.documents.index');
    }

    public function destroy(Document $document)
    {
        $this->ensureAdmin();

        $this->deleteDocumentFile($document);
        $document->delete();

        Alert::success('Berhasil', 'Dokumen berhasil dihapus.');

        return redirect()->route('admin.documents.index');
    }

    private function ensureAdmin(): void
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403);
        }
    }

    private function availableRoles(): array
    {
        return User::query()
            ->whereNotNull('role')
            ->select('role')
            ->distinct()
            ->orderBy('role')
            ->pluck('role')
            ->filter()
            ->values()
            ->all();
    }

    private function rules(bool $requireFile): array
    {
        return [
            'nama_dokumen' => ['required', 'string', 'max:255'],
            'deskripsi_dokumen' => ['required', 'string'],
            'role_akses_dokumen' => ['required', 'array', 'min:1'],
            'role_akses_dokumen.*' => [
                'required',
                Rule::in(array_merge([Document::ACCESS_ALL], $this->availableRoles())),
            ],
            'document_file' => [
                $requireFile ? 'required' : 'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
                'max:10240',
            ],
        ];
    }

    private function validatedData(Request $request, bool $requireFile): array
    {
        $validated = $request->validate($this->rules($requireFile));
        $validated['role_akses_dokumen'] = $this->normalizeRoleAccess($validated['role_akses_dokumen']);
        unset($validated['document_file']);

        return $validated;
    }

    private function normalizeRoleAccess(array $roles): array
    {
        $roles = collect($roles)
            ->map(fn ($role) => trim((string) $role))
            ->filter()
            ->unique()
            ->values();

        if ($roles->contains(Document::ACCESS_ALL)) {
            return [Document::ACCESS_ALL];
        }

        return $roles->all();
    }

    private function storeUploadedFile(UploadedFile $file, string $documentName): array
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeBaseName = trim((string) preg_replace('/[^A-Za-z0-9]+/', '_', $originalName), '_');

        if ($safeBaseName === '') {
            $safeBaseName = trim((string) preg_replace('/[^A-Za-z0-9]+/', '_', $documentName), '_') ?: 'dokumen';
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'pdf');
        $fileName = $safeBaseName . '_' . now()->format('YmdHis') . '_' . uniqid() . '.' . $extension;
        $filePath = $file->storeAs('file', $fileName, 'public');

        return [
            'nama_file' => $fileName,
            'file_path' => $filePath,
            'ukuran_file' => $this->formatFileSize((int) $file->getSize()),
        ];
    }

    private function deleteDocumentFile(Document $document): void
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
    }

    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return rtrim(rtrim(number_format($bytes / 1048576, 1), '0'), '.') . ' MB';
        }

        return max(1, (int) ceil($bytes / 1024)) . ' KB';
    }
}
