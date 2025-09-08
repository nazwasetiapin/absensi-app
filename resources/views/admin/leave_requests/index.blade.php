@extends('layouts.app')

@section('content')
    <div class="section-header">
        <h1>Permohonan Izin & Cuti</h1>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Type</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                    <tr>
                        <td>{{ $req->user->name }}</td>
                        <td>
                            @if($req->type == 1)
                                Izin
                            @elseif($req->type == 2)
                                Cuti
                            @else
                                Tidak Diketahui
                            @endif
                        </td>
                        <td>{{ $req->start_date }}</td>
                        <td>{{ $req->end_date }}</td>
                        <td>{{ $req->reason }}</td>
                        <td><strong>{{ $req->status_label }}</strong></td>
                        <td>
                            @if($req->status === 'pending')
                                <form method="POST" action="{{ route('admin.leave.update', $req->id) }}">
                                    @csrf
                                    <select name="status" class="form-control d-inline w-auto">
                                        <option value="approved">Setujui</option>
                                        <option value="rejected">Tolak</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </form>
                            @else
                                <span class="badge badge-success">{{ $req->status_label }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection