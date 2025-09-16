<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    public function myCertificates()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat sertifikat Anda.');
        }

        $certificates = Certificate::where('user_id', Auth::id())
                                   ->orderBy('end_date', 'asc')
                                   ->paginate(10);

        return view('training.my-certificates', compact('certificates'));
    }
}