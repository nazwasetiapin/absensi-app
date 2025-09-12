<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckFaceRegistered
{
    public function handle($request, Closure $next)
{
    dd(auth()->user()->face_image); // cek isi
    if (auth()->check() && empty(auth()->user()->face_image)) {
        return redirect()->route('absensi.face.register')->with('error', 'Wajah belum tervalidasi. Silakan registrasi terlebih dahulu.');
    }

    return $next($request);
}

}
