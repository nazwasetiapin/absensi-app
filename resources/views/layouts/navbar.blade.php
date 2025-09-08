<div class="navbar-bg" style="background-color: #4e73df;"></div>
<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li>
        <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg text-white">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" data-toggle="dropdown" 
         class="nav-link dropdown-toggle nav-link-lg d-flex align-items-center text-white px-3">
        @auth
          <span class="font-weight-bold">Hi, {{ Auth::user()->name }}</span>
        @endauth
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="#" class="dropdown-item has-icon text-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
  </ul>
</nav>
