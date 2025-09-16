<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('home');
        } else {
            return view('auth.login');
        }
    }

    public function actionlogin(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('id', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (Hash::check('password123', $user->password)) {
                return redirect()->route('change.password')->with('info', 'Harap ubah password default Anda.');
            }

            return redirect()->route('home');
        }

        return back()->with('error', 'NIP atau password salah');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showChangePasswordForm()
    {
        return view('auth.change', ['pageTitle' => 'Change Password']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if ($user instanceof User) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('home')->with('success', 'Password berhasil diubah');
        }

        return back()->withErrors(['error' => 'User tidak ditemukan']);
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
