@extends('layouts.app')

@section('content')
<div class="section-body">
    <h2>Form Pengajuan Izin / Cuti</h2>
    <form action="{{ route('leave_requests.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="type">Jenis</label>
            <select name="type" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="1">Izin</option>
                <option value="2">Cuti</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Alasan</label>
            <textarea name="reason" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ajukan</button>
    </form>
</div>
@endsection
