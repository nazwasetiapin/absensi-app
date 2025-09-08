<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ url('/') }}">Absensi App</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('/') }}">AB</a>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="nav-link">
          <i class="fas fa-fire"></i><span>Dashboard</span>
        </a>
      </li>

      @php
        $user = Auth::user();
      @endphp

      {{-- ADMIN --}}
      @if($user && $user->role == 1)
        <li class="menu-header">Manajemen Absensi</li>
        <li class="{{ request()->is('admin/absensi') ? 'active' : '' }}">
          <a href="{{ route('admin.absensi.index') }}" class="nav-link">
            <i class="fas fa-calendar-alt"></i><span>Rekap Absensi</span>
          </a>
        </li>
        <li class="{{ request()->is('admin/leave-requests') ? 'active' : '' }}">
          <a href="{{ route('admin.leave.index') }}" class="nav-link">
            <i class="fas fa-envelope-open-text"></i><span>Permohonan Izin & Cuti</span>
          </a>
        </li>
        <li class="{{ request()->is('admin/locations*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.locations.index') }}">
            <i class="fas fa-map-marker-alt"></i> <span>Lokasi Absensi</span>
          </a>
        </li>

      {{-- KARYAWAN / PKL --}}
      @elseif($user && ($user->role == 2 || $user->role == 3))
        <li class="menu-header">Absensi</li>

        <li class="{{ request()->is('absensi') || request()->is('absensi/*') ? 'active' : '' }}">
          <a href="{{ route('absensi.index') }}" class="nav-link">
            <i class="fas fa-calendar-check"></i><span>Data Absensi</span>
          </a>
        </li>

        <li class="{{ request()->is('leave_requests') || request()->is('leave_requests/*') ? 'active' : '' }}">
          <a href="{{ route('leave_requests.index') }}" class="nav-link">
            <i class="fas fa-envelope-open-text"></i><span>Izin & Cuti</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('absensi.face.register') ? 'active' : '' }}" href="{{ route('absensi.face.register') }}">
            <i class="fas fa-camera"></i> <span>Registrasi Wajah</span>
          </a>
        </li>

        {{-- STATUS WAJAH --}}
        <li class="mt-2 mb-2 pl-3 pr-3">
          @if($user->face_image)
            @if(session('face_verified'))
              <div class="alert alert-success p-2 text-center mb-0" style="font-size: 13px;">
                <i class="fas fa-check-circle"></i> Wajah tervalidasi
              </div>
            @else
              <div class="alert alert-warning p-2 text-center mb-0" style="font-size: 13px;">
                <i class="fas fa-exclamation-circle"></i> Belum tervalidasi
              </div>
            @endif
          @else
            <div class="alert alert-danger p-2 text-center mb-0" style="font-size: 13px;">
              <i class="fas fa-times-circle"></i> Wajah belum didaftarkan
            </div>
          @endif
        </li>
      @endif

      <li class="menu-header">Lainnya</li>
      <li>
        <a href="{{ route('logout') }}" class="nav-link text-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </aside>
</div>
