@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
<div class="section-header">
  <h1>Rekap Data Absensi</h1>
</div>

<div class="mb-3">
    <form action="{{ route('admin.absensi.export.pdf') }}" method="GET" target="_blank">
        <input type="month" name="bulan" value="{{ $bulan }}" class="form-control d-inline-block w-auto" />
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
        </button>
    </form>
</div>
 

<div class="section-body">
  <div class="card">
    <div class="card-header">
      <h4>Daftar Absensi Semua User</h4>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Check-in</th>
            <th>Check-out</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($absensi as $item)
          <tr>
            <td>{{ $item->user->name }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
            <td>{{ $item->check_in ?? '-' }}</td>
            <td>{{ $item->check_out ?? '-' }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>


<form method="GET" class="mb-3">
    <input type="month" name="bulan" value="{{ $bulan }}" class="form-control w-25 d-inline"> 
    <button type="submit" class="btn btn-primary ml-2">Tampilkan</button>
</form>

<div class="card">
  <div class="card-header">
    <h4>Grafik Absensi Bulan {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</h4>
  </div>
  <div class="card-body">
    <canvas id="absensiChart"></canvas>
  </div>
</div>


@push('scripts')
<script>
  const labels = @json($dataGrafik->pluck('tanggal'));
  const data = {
    labels: labels,
    datasets: [{
      label: 'Jumlah Absensi',
      data: @json($dataGrafik->pluck('total')),
      fill: false,
      backgroundColor: 'rgba(54, 162, 235, 0.8)',
      borderColor: 'rgba(54, 162, 235, 1)',
      tension: 0.1
    }]
  };

  new Chart(document.getElementById('absensiChart'), {
    type: 'line',
    data: data,
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>

@endpush
@endsection
