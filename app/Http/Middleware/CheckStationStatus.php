<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckStationStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Pengecualian Super Admin
            if ($user->role === 'Admin') {
                return $next($request);
            }

            // 1. CEK STATUS AKUN USER (INDIVIDU)
            if ($user->is_active == 0) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // return redirect()->route('login')->withErrors([
                //     'email' => 'Akun Anda dinonaktifkan sementara oleh Admin. Silakan hubungi HRD/Pusat.'
                // ]);
            }

            // 2. CEK STATUS STATION (GLOBAL)
            $stationStatus = DB::table('stations')
                ->where('code', $user->station)
                ->value('is_active');

            if ($stationStatus === 0) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => 'Station Anda (' . $user->station . ') sedang dibekukan operasionalnya.'
                ]);
            }
        }

        return $next($request);
    }
}