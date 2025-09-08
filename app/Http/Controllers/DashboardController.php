<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $jumlahKaryawan = User::where('role', 'karyawan')->count();
            $jumlahPkl = User::where('role', 'pkl')->count();
            $absensiHariIni = Absensi::where('tanggal', now()->toDateString())->count();

            // Grafik absensi
            $grafik = Absensi::selectRaw('tanggal, COUNT(*) as jumlah')
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'desc')
                ->limit(7)
                ->get();

            $grafikTanggal = $grafik->pluck('tanggal')->map(function ($tgl) {
                return Carbon::parse($tgl)->format('d M');
            });

            $grafikJumlah = $grafik->pluck('jumlah');

            return view('dashboard-admin', compact(
                'jumlahKaryawan',
                'jumlahPkl',
                'absensiHariIni',
                'grafikTanggal',
                'grafikJumlah'
            ));
        }

        // Dashboard untuk user
        $riwayat = Absensi::where('user_id', auth()->id())->orderBy('tanggal', 'desc')->get();
        return view('dashboard-user', compact('riwayat'));
    }
}
