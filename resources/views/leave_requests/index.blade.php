@extends('layouts.app')

@section('content')
    <div class="section-header">
        <h1>Daftar Permohonan Izin & Cuti</h1>
    </div>

    <div class="section-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('leave_requests.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajukan Izin / Cuti
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Riwayat Permohonan</h4>
            </div>
            <div class="card-body">
                @if($requests->isEmpty())
                    <p>Tidak ada data permohonan.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                    <th>Dibuat Pada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $index => $req)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($req->type == 1)
                                                Izin
                                            @elseif($req->type == 2)
                                                Cuti
                                            @else
                                                Tidak Diketahui
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($req->start_date)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($req->end_date)->format('d-m-Y') }}</td>
                                        <td>{{ $req->reason }}</td>
                                        <td>
                                            @if ($req->status === 'pending')
                                                <span class="badge badge-warning">Menunggu</span>
                                            @elseif ($req->status === 'approved')
                                                <span class="badge badge-success">Disetujui</span>
                                            @elseif ($req->status === 'rejected')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $req->created_at->format('d-m-Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection