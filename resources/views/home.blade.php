<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 via-white to-blue-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-6 py-4 bg-white shadow-md">
        <h1 class="text-2xl font-bold text-blue-600">Absensi<span class="text-gray-800">App</span></h1>
    </nav>

    <!-- Hero Section -->
    <main class="flex flex-1 flex-col md:flex-row items-center justify-center px-8 md:px-16">
        <div class="md:w-1/2 space-y-6 text-center md:text-left">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight">
                Sistem Absensi <span class="text-blue-600">Modern</span> & Mudah
            </h2>
            <p class="text-lg text-gray-600">
                Absensi dengan mudah, cepat, dan akurat.
                Dilengkapi fitur lokasi, dan Face ID untuk keamanan maksimal.
            </p>
            <div class="flex justify-center md:justify-start space-x-4">
                <a href="{{ route('login') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg shadow hover:bg-gray-200 hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                    Register
                </a>
            </div>
        </div>

        <!-- Gambar -->
        <div class="md:w-1/2 mt-10 md:mt-0 flex justify-center">
            <img src="https://cdn-icons-png.flaticon.com/512/3597/3597075.png" alt="Absensi Ilustrasi"
                class="w-80 md:w-96 drop-shadow-lg">
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 text-gray-500 text-sm">
        &copy; {{ date('Y') }} AbsensiApp. All rights reserved.
    </footer>

</body>

</html>