<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;



class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->toDateString());

        $absensi = Absensi::with('user')
            ->where('tanggal', $tanggal)
            ->orderBy('check_in')
            ->get();

        $bulan = $request->bulan ?? date('Y-m');

      $dataGrafik = DB::table('absensis')
    ->select(DB::raw('DATE(tanggal) as tanggal'), DB::raw('count(*) as total'))
    ->whereYear('tanggal', Carbon::parse($bulan)->year)
    ->whereMonth('tanggal', Carbon::parse($bulan)->month)
    ->groupBy('tanggal')
    ->orderBy('tanggal')
    ->get();


        return view('admin.absensi.index', [
            'absensi' => $absensi,
            'dataGrafik' => $dataGrafik,
            'bulan' => $bulan,
        ]);
    }

    public function exportPdf(Request $request)
{
    $bulan = $request->bulan ?? date('Y-m');
    $users = User::whereIn('role', [2, 3])->get();

    $tanggalList = collect();
    $daysInMonth = Carbon::createFromFormat('Y-m', $bulan)->daysInMonth;

    for ($i = 1; $i <= $daysInMonth; $i++) {
        $tanggal = "$bulan-" . str_pad($i, 2, '0', STR_PAD_LEFT);
        $tanggalList->push($tanggal);
    }

    $rekap = [];

    foreach ($users as $user) {
        foreach ($tanggalList as $tanggal) {
            $hadir = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $tanggal)
                ->exists();

            $izinCuti = LeaveRequest::where('user_id', $user->id)
                ->where('status', 'disetujui')
                ->whereDate('start_date', '<=', $tanggal)
                ->whereDate('end_date', '>=', $tanggal)
                ->first();

            if ($hadir) {
                $status = 'Hadir';
            } elseif ($izinCuti) {
                $status = ucfirst($izinCuti->type); // "Izin" atau "Cuti"
            } else {
                $status = 'Tidak Hadir';
            }

            $rekap[$user->name][$tanggal] = $status;
        }
    }

    $namaBulan = Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y');

    $pdf = Pdf::loadView('admin.absensi.export_pdf', [
        'rekap' => $rekap,
        'tanggalList' => $tanggalList,
        'bulan' => $bulan,
        'namaBulan' => $namaBulan,
    ])->setPaper('A3', 'landscape');

    return $pdf->download("Rekap Absensi - $namaBulan.pdf");
}
}
