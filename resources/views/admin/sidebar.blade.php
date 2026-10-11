<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title') - SIKULAB</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

   <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  @stack('styles')
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Admin</div>
              <a href="#" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="#" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
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
      
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">SIKULAB</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">SK</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
              <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fire"></i> <span>Dashboard</span>
              </a>
            </li>
            <li class="menu-header">Menu</li>
            <li>
              <a class="nav-link" href="{{ route('manajemenakun.index') }}">
                <i class="fas fa-users"></i> <span>Manajemen User</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="{{ route('manajemennapi.index') }}">
                <i class="fas fa-balance-scale"></i> <span>Data Narapidana</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="{{ route ('jadwal.index') }}">
                <i class="fas fa-calendar"></i> <span>Manajemen Jadwal</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="#">
                <i class="fas fa-clipboard-list"></i> <span>Data Pengunjung</span>
              </a>
            </li>
          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @yield('content')
        </section>
      </div>
      
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; {{ date('Y') }} <div class="bullet"></div> Heartware Digital
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/modules/popper.js') }}"></script>
  <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <!-- DataTables (hanya sekali) -->
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <!-- Auto Active Sidebar Menu Script -->
  <script>
    $(document).ready(function() {
      // Get current URL
      var currentUrl = window.location.href;
      var currentPath = window.location.pathname;
      
      // Remove any existing active class
      $('.sidebar-menu li').removeClass('active');
      
      // Loop through each menu item
      $('.sidebar-menu li a').each(function() {
        var linkHref = $(this).attr('href');
        
        // Skip empty or hash links
        if (!linkHref || linkHref === '#' || linkHref === 'javascript:void(0)') {
          return;
        }
        
        // Check if current URL contains the link href
        if (currentUrl.indexOf(linkHref) !== -1) {
          $(this).closest('li').addClass('active');
        }
        
        // Alternative: Check by path segments
        if (linkHref !== '#') {
          var linkPath = new URL(linkHref, window.location.origin).pathname;
          if (currentPath.startsWith(linkPath) && linkPath !== '/') {
            $(this).closest('li').addClass('active');
          }
        }
      });
      
      // Fallback: if no menu is active, activate based on URL segments
      if ($('.sidebar-menu li.active').length === 0) {
        var segments = currentPath.split('/').filter(function(segment) {
          return segment.length > 0;
        });
        
        if (segments.length > 0) {
          var firstSegment = segments[0];
          
          $('.sidebar-menu li a').each(function() {
            var href = $(this).attr('href');
            if (href && href.indexOf(firstSegment) !== -1) {
              $(this).closest('li').addClass('active');
              return false; // break loop
            }
          });
        }
      }
    });
  </script>

  @stack('scripts')
</body>
</html>