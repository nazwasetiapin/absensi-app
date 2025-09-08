@extends('layouts.app')

@section('title', 'Manajemen Lokasi Absensi')

@section('content')
<div class="section-header">
    <h1>Lokasi Absensi</h1>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($locations->where('is_active', true)->count())
    <div class="alert alert-info text-left">
        Lokasi aktif saat ini: <strong>{{ $locations->where('is_active', true)->first()->name }}</strong>
    </div>
@else
    <div class="alert alert-warning text-left">
        Belum ada lokasi aktif. Silakan aktifkan salah satu lokasi.
    </div>
@endif

<a href="{{ route('admin.locations.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Lokasi
</a>

<div class="table-responsive">
    <table class="table table-sm table-bordered text-center">
        <thead class="thead-light">
            <tr>
                <th class="align-middle">Nama Lokasi</th>
                <th class="align-middle">Latitude</th>
                <th class="align-middle">Longitude</th>
                <th class="align-middle">Radius (m)</th>
                <th class="align-middle">Status</th>
                <th class="align-middle">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locations as $location)
            <tr>
                <td class="align-middle">{{ $location->name }}</td>
                <td class="align-middle">{{ $location->latitude }}</td>
                <td class="align-middle">{{ $location->longitude }}</td>
                <td class="align-middle">{{ $location->radius }}</td>
                <td class="align-middle">
                    <span class="badge {{ $location->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ $location->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="align-middle">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            {{-- Aktifkan / Nonaktifkan --}}
                            @if (!$location->is_active)
                                <form action="{{ route('admin.locations.activate', $location->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-success">
                                        <i class="fas fa-check-circle"></i> Aktifkan
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.locations.deactivate', $location->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-warning">
                                        <i class="fas fa-ban"></i> Nonaktifkan
                                    </button>
                                </form>
                            @endif

                            {{-- Edit --}}
                            <a href="{{ route('admin.locations.edit', $location->id) }}" class="dropdown-item">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('admin.locations.destroy', $location->id) }}" method="POST" onsubmit="return confirm('Hapus lokasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
