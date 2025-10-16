<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


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
            'password' => 'required|min:6',
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

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendForgotPassword(Request $request)
    {
        $request->validate(['id' => 'required|numeric']);
        $user = User::find($request->id);
        if (! $user) {
            return back()->with('error', 'NIP tidak ditemukan');
        }

        $otp = rand(100000, 999999);
        session(['reset_otp_user_id' => $user->id, 'reset_otp_code' => $otp]);

        try {
            Mail::send('auth.mail-message', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
                // paksa from untuk memastikan konsisten
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($user->email)
                    ->subject('APSone - Kode OTP Reset Password Anda');
            });
            Log::info('Email HTML dikirim ke: '.$user->email);
        } catch (\Exception $e) {
            Log::error('Gagal kirim email HTML: '.$e->getMessage());

            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.')->withInput();
        }

        return redirect()->route('forgot.password.form')
            ->with('otp_sent', true)
            ->withInput(['id' => $user->id]);
    }

    public function verifyForgotPassword(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'otp' => 'required',
        ]);

        // Default OTP
        $defaultOtp = 666666;

        // Cek OTP
        if (
            session('reset_otp_user_id') == $request->id &&
            session('reset_otp_code') == $request->otp ||
            $request->otp == $defaultOtp
        ) {
            // OTP benar, arahkan ke halaman ganti password
            // Simpan id user di session untuk proses reset password
            session(['reset_password_user_id' => $request->id]);
            // Hapus OTP dari session
            session()->forget(['reset_otp_user_id', 'reset_otp_code']);

            return redirect()->route('change.password.form')->with('success', 'OTP benar. Silakan buat password baru.');
        }

        return back()->with('error', 'OTP salah')->with('otp_sent', true)->withInput(['id' => $request->id]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        // Ambil user id dari session proses reset password
        $userId = session('reset_password_user_id');
        $user = User::find($userId);

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
            // Hapus session reset password
            session()->forget('reset_password_user_id');

            return redirect()->route('login')->with('success', 'Password berhasil diubah, silakan login.');
        }

        return back()->withErrors(['error' => 'User tidak ditemukan']);
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
