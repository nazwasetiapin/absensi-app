@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header">
            <h4>Riwayat Absensi Saya</h4>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-striped table-bordered">
              <thead class="thead-light">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Check-in</th>
                  <th>Check-out</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($riwayat as $index => $absen)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}</td>
                  <td>{{ $absen->check_in ?? '-' }}</td>
                  <td>{{ $absen->check_out ?? '-' }}</td>
                  <td>
                    @if(!$absen->check_in)
                      <span class="badge badge-danger">Tidak Absen</span>
                    @elseif($absen->check_in > '08:00:00')
                      <span class="badge badge-warning">Terlambat</span>
                    @else
                      <span class="badge badge-success">Hadir</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center">Belum ada data absensi.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
