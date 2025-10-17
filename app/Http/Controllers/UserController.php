<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(): View
    {
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $search = request('search');

        $user = User::when($search, function ($query, $search) {
            return $query->where('fullname', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        })
            ->orderBy('fullname', 'asc')
            ->paginate(10)
            ->withQueryString();

        $title = 'Konfirmasi Hapus Data User';
        $text = 'Data user yang dihapus tidak dapat dikembalikan. Apakah Anda yakin ingin menghapus data ini?';
        confirmDelete($title, $text);

        return view('user.index', [
            'user' => $user,
        ]);
    }

    public function indexApron(): View
    {
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $search = request('search');

        $user = User::where('role', 'Porter Apron')
            ->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
                }
            })
            ->orderBy('fullname', 'asc')
            ->paginate(10)
            ->withQueryString();

        $title = 'Konfirmasi Hapus Data User';
        $text = 'Data user yang dihapus tidak dapat dikembalikan. Apakah Anda yakin ingin menghapus data ini?';
        confirmDelete($title, $text);

        return view('user.apron', [
            'user' => $user,
        ]);
    }

    public function indexBGE(): View
    {
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $search = request('search');

        $user = User::where('role', 'Porter Bge')
            ->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
                }
            })
            ->orderBy('fullname', 'asc')
            ->paginate(10)
            ->withQueryString();

        $title = 'Konfirmasi Hapus Data User';
        $text = 'Data user yang dihapus tidak dapat dikembalikan. Apakah Anda yakin ingin menghapus data ini?';
        confirmDelete($title, $text);

        return view('user.bge', [
            'user' => $user,
        ]);
    }

    public function indexOffice(): View
    {
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $search = request('search');

        $user = User::whereNotIn('role', ['Porter Bge', 'Porter Apron'])
            ->where(function ($q) use ($search) {
                if ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%");
                }
            })
            ->orderBy('fullname', 'asc')
            ->paginate(10)
            ->withQueryString();

        $title = 'Konfirmasi Hapus Data User';
        $text = 'Data user yang dihapus tidak dapat dikembalikan. Apakah Anda yakin ingin menghapus data ini?';
        confirmDelete($title, $text);

        return view('user.office', [
            'user' => $user,
        ]);
    }

    public function CountIndex(): View
    {
        $user = User::latest()->paginate(10);

        return view('index', [
            'userCount' => $user->count(),
        ]);
    }

    public function show(User $user, Request $request): View
    {
        // Pengecekan peran manual
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $page = $request->get('page', 1);

        return view('user.show', compact('user', 'page'));
    }

    public function create(): View
    {
        // Pengecekan peran manual
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('user.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'id' => 'required|string|max:15|unique:users',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|max:50',
            'station' => 'required|string|max:15',
            'gender' => 'required|in:Male,Female',
            'is_qantas' => 'required|boolean',
            'join_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
        ]);

        try {
            $user = new User;
            $user->id = $request->id;
            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->station = $request->station;
            $user->gender = $request->gender;
            $user->is_qantas = $request->is_qantas;
            $user->join_date = $request->join_date;
            $user->salary = $request->salary;
            $user->password = Hash::make('password123');

            $user->save();

            Alert::success('Success', 'User berhasil ditambahkan.');

            return redirect()->route('users.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan: '.$e->getMessage());

            return back()->withInput();
        }
    }

    public function edit(User $user, Request $request): View
    {
        // Pengecekan peran manual
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        $page = $request->get('page', 1);

        return view('user.edit', compact('user', 'page'));
    }

    public function update(Request $request, User $user)
    {

        Log::info('Request masuk ke update()', ['data' => $request->all()]);

        $request->validate([
            'fullname' => 'required',
            'role' => 'required',
            'station' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'gender' => 'required|in:Male,Female',
            'is_qantas' => 'required|boolean',
            'join_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
        ]);

        try {
            $user->update($request->all());

            Alert::success('Success', 'Data user berhasil diupdate');

            return redirect()->route('users.index');
        } catch (\Exception $e) {
            Log::error('Gagal update user', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'request_data' => $request->all(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat mengupdate user: '.$e->getMessage());

            return back()->withInput();
        }
    }

    public function destroy(User $user)
    {
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        try {
            $user->delete();

            Alert::success('Berhasil', 'Data berhasil dihapus');

            return redirect()->route('users.index');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus user', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data: '.$e->getMessage());

            return back();
        }
    }

    public function kontrak(): View
    {

        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $user = User::orderBy('fullname', 'asc')->paginate(10);

        return view('user.kontrak', [
            'user' => $user,
        ]);
    }

    public function KontrakEdit($id, Request $request): View
    {

        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $user = User::findOrFail($id);
        $page = $request->get('page', 1);

        return view('user.kontrak_edit', compact('user', 'page'));
    }

    public function KontrakUpdate(Request $request, User $user)
    {

        Log::info('Request masuk ke KontrakUpdate()', ['data' => $request->all()]);

        $request->validate([
            'contract_start' => 'nullable|date',
            'contract_end' => 'nullable|date',
        ]);

        Log::info('Validasi berhasil');

        try {
            $user->update($request->only(['contract_start', 'contract_end']));

            Log::info('Data berhasil diupdate', ['user_id' => $user->id]);

            Alert::success('Berhasil', 'Data kontrak berhasil diperbarui');

            return redirect()->route('users.kontrak');
        } catch (\Exception $e) {
            Log::error('Gagal update kontrak user', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'request_data' => $request->all(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui kontrak: '.$e->getMessage());

            return back()->withInput();
        }
    }

    public function pas(): View
    {

        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $user = User::orderBy('fullname', 'asc')->paginate(10);

        return view('user.pas', [
            'user' => $user,
        ]);
    }

    public function PASEdit($id)
    {

        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $user = User::findOrFail($id);

        return view('user.pas_edit', compact('user'));
    }

    public function PASUpdate(Request $request, User $user)
    {

        Log::info('Request masuk ke PASUpdate()', ['data' => $request->all()]);

        $request->validate([
            'pas_expired' => 'nullable|date',
            'pas_registered' => 'nullable|date',
        ]);

        Log::info('Validasi berhasil');

        try {
            $user->update($request->only(['pas_expired', 'pas_registered']));

            Log::info('Data PAS berhasil diupdate', ['user_id' => $user->id]);

            Alert::success('Berhasil', 'Data PAS berhasil diperbarui');

            return redirect()->route('users.pas')->with('success', 'Data user berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Gagal update data PAS user', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'request_data' => $request->all(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data PAS: '.$e->getMessage());

            return back()->withInput();
        }
    }

    public function profile()
    {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    public function updatePhoto(Request $request, $userId)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $user = User::findOrFail($userId);
            $file = $request->file('profile_picture');

            $filename = now()->timestamp.'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('storage/photo');

            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            $file->move($destinationPath, $filename);

            if ($user->profile_picture && file_exists($destinationPath.'/'.$user->profile_picture)) {
                unlink($destinationPath.'/'.$user->profile_picture);
            }

            $user->profile_picture = $filename;
            $user->save();

            Log::info('Foto profil berhasil diperbarui', ['user_id' => $user->id, 'filename' => $filename]);

            return back()->with('success', 'Foto profil berhasil diubah.');
        } catch (\Exception $e) {
            Log::error('Gagal update foto profil', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat mengubah foto profil: '.$e->getMessage());
        }
    }

    public function indexAdmin(Request $request): View
    {
        // Pengecekan peran manual
        if (! in_array(Auth::user()->role, ['Admin', 'CHIEF'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = Certificate::with('user');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('fullname', 'like', '%'.$searchTerm.'%')
                    ->orWhere('id', 'like', '%'.$searchTerm.'%');
            })->orWhere('certificate_name', 'like', '%'.$searchTerm.'%');
        }

        $certificates = $query->orderBy('end_date', 'asc')->paginate(10);

        return view('admin.certificates.index', compact('certificates'));
    }

    public function indexUser(): View
    {

        $certificates = Auth::user()->certificates()->orderBy('end_date', 'asc')->get();

        return view('user.certificates.index', compact('certificates'));
    }

    public function createCertificate(): View
    {

        if (! in_array(Auth::user()->role, ['Admin', 'CHIEF'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $users = User::whereIn('role', ['USER', 'ASS LEADER', 'CHIEF', 'LEADER'])->orderBy('fullname', 'asc')->get();

        return view('admin.certificates.create', compact('users'));
    }

    public function storeCertificate(Request $request)
    {

        if (! in_array(Auth::user()->role, ['Admin', 'CHIEF'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'certificate_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            Certificate::create($request->all());
            Alert::success('Success', 'Sertifikat berhasil ditambahkan!');

            return redirect()->route('training.admin');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan sertifikat', ['error' => $e->getMessage(), 'request' => $request->all()]);
            Alert::error('Gagal', 'Terjadi kesalahan saat menambahkan sertifikat: '.$e->getMessage());

            return back()->withInput();
        }
    }

    public function editCertificate(Certificate $certificate): View
    {

        if (! in_array(Auth::user()->role, ['Admin', 'CHIEF'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $users = User::whereIn('role', ['USER', 'ASS LEADER', 'CHIEF', 'LEADER'])->orderBy('fullname', 'asc')->get();

        return view('admin.certificates.edit', compact('certificate', 'users'));
    }

    public function updateCertificate(Request $request, Certificate $certificate)
    {

        if (! in_array(Auth::user()->role, ['Admin', 'CHIEF'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'certificate_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $certificate->update($request->all());
            Alert::success('Success', 'Sertifikat berhasil diperbarui!');

            return redirect()->route('training.admin');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui sertifikat', ['error' => $e->getMessage(), 'certificate_id' => $certificate->id, 'request' => $request->all()]);
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui sertifikat: '.$e->getMessage());

            return back()->withInput();
        }
    }

    public function destroyCertificate(Certificate $certificate)
    {

        if (! in_array(Auth::user()->role, ['Admin', 'CHIEF'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        try {
            $certificate->delete();
            Alert::success('Berhasil', 'Sertifikat berhasil dihapus!');

            return redirect()->route('training.admin');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus sertifikat', ['error' => $e->getMessage(), 'certificate_id' => $certificate->id]);
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus sertifikat: '.$e->getMessage());

            return back();
        }
    }

    public function resetPassword(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            abort(405, 'The GET method is not supported for this route.');
        }

        $user = User::findOrFail($id);
        $user->password = bcrypt('password123');
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil direset.');
    }
}
