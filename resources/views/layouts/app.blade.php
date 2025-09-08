<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Absensi App')</title>

  <!-- Stisla CSS -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <meta name="theme-color" content="#6777ef">
</head>
<body class="sidebar-mini">
  <div id="app">
    <div class="main-wrapper">
      @include('layouts.navbar')
      @include('layouts.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @yield('content')
        </section>
      </div>

      @include('layouts.footer')
    </div>
  </div>

    <!-- JS -->
  <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>
  <script src="{{ asset('assets/js/scripts.js') }}"></script>


  <!-- Toggle Sidebar Mobile -->
  <script>
    $(document).ready(function () {
      $('[data-toggle="sidebar"]').click(function (e) {
        e.preventDefault();
        $("body").toggleClass("sidebar-show");
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  @stack('scripts')
</body>
</html>
