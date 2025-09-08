<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaceController extends Controller
{
    public function register()
    {
        return view('absensi.face_register');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $user->face_image = $request->input('image'); // base64
        $user->save();

        return redirect()->route('absensi.index')->with('success', 'Wajah berhasil diregistrasi, silakan lakukan check-in.');
    }

    public function validateFace()
    {
        return view('absensi.face_validate'); // ← inilah method yang sebelumnya error
    }

    public function match(Request $request)
    {
        $request->validate([
            'current_face' => 'required|string',
        ]);

        $user = Auth::user();

        $registeredFace = $user->face_image;
        $currentFace = $request->input('current_face');

        if (!$registeredFace) {
            return redirect()->back()->with('error', 'Anda belum mendaftarkan wajah!');
        }

        if ($this->compareBase64Images($registeredFace, $currentFace)) {
            session()->put('face_verified', true);
            return redirect()->route('absensi.index')->with('success', 'Validasi wajah berhasil!');
        } else {
            return redirect()->back()->with('error', 'Wajah tidak cocok, silakan coba lagi.');
        }
    }

    // Tambahkan helper untuk membandingkan 2 base64
    protected function compareBase64Images($image1, $image2)
    {
        return $image1 === $image2;
        // Nanti bisa diganti dengan metode yang lebih akurat (misal pakai ML)
    }
}
