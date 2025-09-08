@extends('layouts.app')

@section('title', 'Registrasi Wajah')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Registrasi Wajah</h1>
    </div>

    <div class="section-body">
        <div class="row">
            {{-- Kamera --}}
            <div class="col-md-6 mb-4">
                <form method="POST" action="{{ route('absensi.face.register') }}" enctype="multipart/form-data" id="faceForm">
                    @csrf

                    <div class="form-group">
                        <label class="fw-bold mb-2">Ambil Foto Wajah</label>
                        <div class="mb-3 border rounded shadow-sm p-2 bg-light">
                            <video id="webcam" autoplay playsinline class="img-fluid rounded" style="width: 100%; max-height: 300px;"></video>
                        </div>
                        <input type="hidden" name="face_image" id="face_image">
                        <button type="button" class="btn btn-primary" onclick="captureAndSubmit()">📸 Ambil & Validasi</button>
                    </div>
                </form>
            </div>

            {{-- Preview --}}
            <div class="col-md-6 mb-4">
                <label class="fw-bold mb-2">Preview Foto</label>
                <div class="border rounded shadow-sm p-2 bg-light">
                    <canvas id="snapshot" class="img-fluid rounded" style="width: 100%; max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const video = document.getElementById('webcam');
    const canvas = document.getElementById('snapshot');
    const faceInput = document.getElementById('face_image');
    const form = document.getElementById('faceForm');

    // Aktifkan kamera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            alert("Akses kamera ditolak atau tidak tersedia.");
            console.error(err);
        });

    // Ambil gambar dan submit otomatis
    function captureAndSubmit() {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL('image/jpeg');
        faceInput.value = imageData;

        form.submit();
    }
</script>
@endpush
