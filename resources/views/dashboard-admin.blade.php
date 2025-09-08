@extends('layouts.app')

@section('content')
<div class="section-header">
  <h1>Dashboard Admin</h1>
</div>

<div class="row">
  <div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-users"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Karyawan</h4>
        </div>
        <div class="card-body">
          {{ $jumlahKaryawan }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="fas fa-user-graduate"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Anak PKL</h4>
        </div>
        <div class="card-body">
          {{ $jumlahPkl }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-success">
        <i class="fas fa-calendar-check"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Absen Hari Ini</h4>
        </div>
        <div class="card-body">
          {{ $absensiHariIni }}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
