<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $absensi = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('absensi.index', compact('absensi', 'user'));
    }

    public function checkin(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'face_image' => 'required|string',
        ]);

        $user = Auth::user();

        if (!$user->face_image) {
            return back()->with('error', 'Wajah belum diregistrasi.');
        }

        // Simpan foto dari base64 ke file sementara
        $uploadedImage = $this->saveTempImage($request->face_image);

        // Validasi wajah
        $match = $this->validateFaceWithAPI($uploadedImage, public_path($user->face_image));
        if (!$match) {
            return back()->with('error', 'Wajah tidak cocok.');
        }

        $today = Carbon::today()->toDateString();

        $existing = Absensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah check-in hari ini.');
        }

        $activeLocation = Location::where('is_active', true)->first();
        if (!$activeLocation) {
            return back()->with('error', 'Lokasi absensi belum diset oleh admin.');
        }

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $activeLocation->latitude,
            $activeLocation->longitude
        );

        if ($distance > $activeLocation->radius) {
            return back()->with('error', 'Kamu berada di luar radius absensi.');
        }

        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'check_in' => Carbon::now()->toTimeString(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return back()->with('success', 'Berhasil check-in!');
    }

   public function checkout(Request $request)
{
    $request->validate([
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'face_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = Auth::user();

    if (!$user->face_image) {
        return redirect()->back()->with('error', 'Wajah belum diregistrasi.');
    }

    // ✅ Validasi wajah menggunakan method helper
    $match = $this->validateFaceWithAPI($request->file('face_image'), $user->face_image);
    if (!$match) {
        return redirect()->back()->with('error', 'Wajah tidak cocok atau gagal memverifikasi.');
    }

    $today = Carbon::today()->toDateString();

    $absen = Absensi::where('user_id', $user->id)
        ->where('tanggal', $today)
        ->first();

    if (!$absen) {
        return redirect()->back()->with('error', 'Kamu belum check-in hari ini.');
    }

    if ($absen->check_out) {
        return redirect()->back()->with('error', 'Kamu sudah check-out hari ini.');
    }

    // ✅ Validasi lokasi
    $activeLocation = Location::where('is_active', true)->first();
    if (!$activeLocation) {
        return back()->with('error', 'Lokasi absensi belum diset oleh admin.');
    }

    $distance = $this->calculateDistance(
        $request->latitude,
        $request->longitude,
        $activeLocation->latitude,
        $activeLocation->longitude
    );

    if ($distance > $activeLocation->radius) {
        return back()->with('error', 'Kamu berada di luar radius absensi.');
    }

    // ✅ Update data absensi untuk check-out
    $absen->update([
        'check_out' => Carbon::now()->toTimeString(),
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    return redirect()->back()->with('success', 'Berhasil check-out!');
}

    public function faceRegister()
    {
        $user = Auth::user();

        if ($user->face_image) {
            return redirect()->route('absensi.index')->with('error', 'Wajah sudah diregistrasi.');
        }

        return view('absensi.face_register', compact('user'));
    }

    public function faceRegisterStore(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'face_image' => 'required|string',
        ]);

        $image = str_replace('data:image/jpeg;base64,', '', $request->face_image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'face_' . $user->id . '_' . time() . '.jpg';
        $imagePath = public_path('uploads/faces/' . $imageName);

        file_put_contents($imagePath, base64_decode($image));

        $user->face_image = 'uploads/faces/' . $imageName;
        $user->save();

        return redirect()->route('absensi.index')->with('success', 'Wajah berhasil diregistrasi.');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) ** 2 +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    private function validateFaceWithAPI($imagePath1, $imagePath2)
    {
        try {
            $response = Http::attach('image1', file_get_contents($imagePath1), 'upload.jpg')
                ->attach('image2', file_get_contents($imagePath2), 'stored.jpg')
                ->post('http://127.0.0.1:5000/compare');

            if ($response->ok()) {
                return $response->json('match') === true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function saveTempImage($base64)
    {
        $image = str_replace('data:image/jpeg;base64,', '', $base64);
        $image = str_replace(' ', '+', $image);
        $imagePath = storage_path('app/temp_face_' . time() . '.jpg');
        file_put_contents($imagePath, base64_decode($image));
        return $imagePath;
    }
}
