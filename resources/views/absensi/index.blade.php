@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Data Absensi</h1>
  </div>

  <div class="section-body">
    {{-- Notifikasi --}}
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Error Validasi --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Form Absensi --}}
    <div class="card mb-4">
      <div class="card-header">
        <h4>Form Absensi Hari Ini</h4>
      </div>
      <div class="card-body">
        @php
          $today = \Carbon\Carbon::today()->toDateString();
          $absenHariIni = $absensi->where('tanggal', $today)->first();
        @endphp

        @if(!$absenHariIni)
          <form id="checkin-form" action="{{ route('absensi.checkin') }}" method="POST">
            @csrf
            <input type="hidden" name="latitude" id="latitude_checkin">
            <input type="hidden" name="longitude" id="longitude_checkin">
            <input type="hidden" name="face_image" id="face_image">

            <div class="form-group">
              <label>Ambil Foto Wajah</label>
              <div>
                <video id="video" width="100%" autoplay muted playsinline class="rounded border mb-2"></video>
                <canvas id="canvas" style="display:none;"></canvas>
                <div>
                  <button type="button" class="btn btn-info" id="captureBtn" onclick="capturePhoto()">Ambil Foto</button>
                  <button type="submit" class="btn btn-success" id="checkinBtn" style="display: none;">Check-In</button>
                </div>
              </div>
            </div>
          </form>

        @elseif($absenHariIni && !$absenHariIni->check_out)
          <form id="checkout-form" action="{{ route('absensi.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="latitude" id="latitude_checkout">
            <input type="hidden" name="longitude" id="longitude_checkout">
            <button type="submit" class="btn btn-danger" id="checkoutBtn" disabled>Check-Out</button>
          </form>

        @else
          <div class="alert alert-info">
            Kamu sudah menyelesaikan absensi hari ini.
          </div>
        @endif
      </div>
    </div>

    {{-- Riwayat Absensi --}}
    <div class="card">
      <div class="card-header">
        <h4>Riwayat Absensi</h4>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($absensi as $absen)
                <tr>
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
                  <td colspan="4" class="text-center">Belum ada data absensi.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const faceImageInput = document.getElementById('face_image');
    const checkinBtn = document.getElementById('checkinBtn');
    const captureBtn = document.getElementById('captureBtn');

    // Aktifkan Kamera
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
          video.srcObject = stream;
          video.play();
        })
        .catch(function (error) {
          alert('❌ Gagal mengakses kamera: ' + error.message);
        });
    } else {
      alert('❌ Browser tidak mendukung kamera.');
    }

    // Fungsi Ambil Foto
    window.capturePhoto = function () {
      const context = canvas.getContext('2d');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      const imageData = canvas.toDataURL('image/jpeg');
      faceImageInput.value = imageData;

      checkinBtn.style.display = 'inline-block';
      captureBtn.style.display = 'none';
      alert('✅ Foto berhasil diambil.');
    };

    // Ambil Lokasi
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
        const lat = position.coords.latitude;
        const long = position.coords.longitude;

        const latCheckin = document.getElementById('latitude_checkin');
        const longCheckin = document.getElementById('longitude_checkin');
        const latCheckout = document.getElementById('latitude_checkout');
        const longCheckout = document.getElementById('longitude_checkout');

        if (latCheckin && longCheckin) {
          latCheckin.value = lat;
          longCheckin.value = long;
        }

        if (latCheckout && longCheckout) {
          latCheckout.value = lat;
          longCheckout.value = long;
          const btn = document.getElementById('checkoutBtn');
          if (btn) btn.disabled = false;
        }
      }, function () {
        alert('❌ Gagal mendapatkan lokasi. Aktifkan GPS dan izin lokasi di browser.');
      });
    } else {
      alert('❌ Geolocation tidak didukung oleh browser Anda.');
    }
  });
</script>
@endpush
