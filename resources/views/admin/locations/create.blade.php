@extends('layouts.app')

@section('title', 'Tambah Lokasi Absensi')

@section('content')
<div class="section-header"><h1>Tambah Lokasi Absensi</h1></div>

<form method="POST" action="{{ route('admin.locations.store') }}">
    @csrf
    <div class="form-group">
        <label>Nama Lokasi</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Latitude</label>
        <input type="text" name="latitude" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Longitude</label>
        <input type="text" name="longitude" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Radius (meter)</label>
        <input type="number" name="radius" class="form-control" required value="100">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection
