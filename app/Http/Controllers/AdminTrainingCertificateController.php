<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminTrainingCertificateController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificate::leftJoin('users', 'certificates.user_id', '=', 'users.id')
        ->select('certificates.*', 'users.fullname');


        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('certificates.certificate_name', 'like', "%{$search}%")
                    ->orWhere('users.fullname', 'like', "%{$search}%")
                    ->orWhere('users.id', 'like', "%{$search}%");
            });
        }

        $certificates = $query->orderBy('certificates.created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('training.admin.index', compact('certificates'));
    }

    public function create()
    {
        $users = User::orderBy('fullname')->get(['id', 'fullname']);

        return view('training.admin.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'certificate_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Format tanggal
        $validatedData['start_date'] = date('Y-m-d', strtotime($validatedData['start_date']));
        $validatedData['end_date'] = date('Y-m-d', strtotime($validatedData['end_date']));

        // Upload file (jika ada)
        if ($request->hasFile('certificate_file')) {
            $file = $request->file('certificate_file');
            $extension = $file->getClientOriginalExtension() ?: 'pdf';
            $filename = str_replace(' ', '_', $validatedData['certificate_name']).'_'.$validatedData['user_id'].'_'.time().'.'.$extension;
            
            // Simpan langsung ke public/storage/certificates
            $certDir = public_path('storage/certificates');
            if (!file_exists($certDir)) {
                mkdir($certDir, 0775, true);
            }
            $file->move($certDir, $filename);
            
            $validatedData['certificate_file'] = 'certificates/' . $filename;
        }

        Certificate::create($validatedData);

        return redirect()
            ->route('admin.training.certificates.index')
            ->with('success', 'Sertifikat berhasil ditambahkan!');
    }

    public function show(Certificate $certificate)
    {
        return view('training.admin.show', compact('certificate'));
    }

    public function edit(Certificate $certificate)
    {
        $users = User::orderBy('fullname')->get(['id', 'fullname']);

        return view('training.admin.edit', compact('certificate', 'users'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validatedData = $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
            'certificate_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('certificate_file')) {
            // Hapus file lama jika ada
            if ($certificate->certificate_file) {
                $oldPath = public_path('storage/' . $certificate->certificate_file);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            $file = $request->file('certificate_file');
            $extension = $file->getClientOriginalExtension() ?: 'pdf';
            $filename = str_replace(' ', '_', $validatedData['certificate_name']).'_'.$validatedData['user_id'].'_'.time().'.'.$extension;
            
            $certDir = public_path('storage/certificates');
            if (!file_exists($certDir)) {
                mkdir($certDir, 0775, true);
            }
            $file->move($certDir, $filename);
            
            $validatedData['certificate_file'] = 'certificates/' . $filename;
        } elseif ($request->boolean('remove_file')) {
            if ($certificate->certificate_file) {
                $oldPath = public_path('storage/' . $certificate->certificate_file);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    unlink($oldPath);
                }
                $validatedData['certificate_file'] = null;
            }
        }

        $certificate->update($validatedData);

        return redirect()->route('admin.training.certificates.index')->with('success', 'Sertifikat berhasil diperbarui!');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->certificate_file) {
            $oldPath = public_path('storage/' . $certificate->certificate_file);
            if (file_exists($oldPath) && is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        $certificate->delete();

        return redirect()->route('admin.training.certificates.index')->with('success', 'Sertifikat berhasil dihapus!');
    }
}
