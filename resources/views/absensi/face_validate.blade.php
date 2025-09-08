@extends('layouts.app')

@section('title', 'Validasi Wajah')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Validasi Wajah Sebelum Absensi</h1>
    </div>

    <div class="section-body">
        <div class="row">
            {{-- Validasi dengan Kamera --}}
            <div class="col-md-6">
                <form method="POST" action="{{ route('absensi.face.match') }}">
                    @csrf

                    <div class="form-group">
                        <label for="webcam-preview">Arahkan Wajah Anda ke Kamera</label>
                        <div class="mb-3">
                            <video id="webcam" autoplay playsinline class="img-fluid rounded shadow" width="100%"></video>
                        </div>
                        <input type="hidden" name="current_face" id="current_face">
                        <button type="button" class="btn btn-primary" onclick="capturePhoto()">Validasi Wajah</button>
                    </div>

                    <div class="form-group mt-3">
                        <label>Preview Gambar Terkini</label>
                        <canvas id="snapshot" class="img-fluid rounded border"></canvas>
                    </div>

                    <button type="submit" class="btn btn-success mt-4">Lanjut ke Absensi</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    let video = document.getElementById('webcam');
    let canvas = document.getElementById('snapshot');
    let currentFaceInput = document.getElementById('current_face');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            alert("Akses kamera ditolak!");
            console.error(err);
        });

    function capturePhoto() {
        let context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0);

        // Simpan ke input hidden
        let imageData = canvas.toDataURL('image/jpeg');
        currentFaceInput.value = imageData;
    }
</script>
@endsection
