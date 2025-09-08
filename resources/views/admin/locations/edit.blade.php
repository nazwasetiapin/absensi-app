@extends('layouts.app')

@section('title', 'Edit Lokasi Absensi')

@section('content')
<div class="section-header">
    <h1>Edit Lokasi Absensi</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.locations.update', $location->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nama Lokasi</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $location->name) }}" required>
    </div>

    <div class="form-group">
        <label>Latitude</label>
        <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $location->latitude) }}" required>
    </div>

    <div class="form-group">
        <label>Longitude</label>
        <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $location->longitude) }}" required>
    </div>

    <div class="form-group">
        <label>Radius (meter)</label>
        <input type="number" name="radius" class="form-control" value="{{ old('radius', $location->radius) }}" required min="10">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
