<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title') - SIKULAP</title>

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
              <div class="dropdown-title">Petugas</div>
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
            <a href="{{ route('petugas.dashboard') }}">SIKULAB</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('petugas.dashboard') }}">SK</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
              <a class="nav-link" href="{{ route('petugas.dashboard') }}">
                <i class="fas fa-fire"></i> <span>Dashboard</span>
              </a>
            </li>

            <li class="menu-header">Menu</li>
            <li>
              <a class="nav-link" href="{{ route('datanapi.index') }}">
                <i class="fas fa-address-book"></i> <span>Data Narapidana</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="{{ route('petugas.kunjungan.index') }}">
                <i class="fas fa-calendar-check"></i> <span>Verifikasi Pengunjung</span>
              </a>
            </li>
            <li>
              <a class="nav-link" href="#">
                <i class="fas fa-list"></i> <span>Riwayat Kunjungan</span>
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
        <div class="footer-right"></div>
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
<!-- Auto Active Sidebar Menu Script -->
  <script>
    $(document).ready(function () {
      var currentUrl  = window.location.href;
      var currentPath = window.location.pathname;

      // Fungsi untuk set active
      function setActive($el) {
        $('.sidebar-menu li').removeClass('active');
        $el.closest('li').addClass('active');
      }

      // 1. Coba cocokkan berdasarkan URL saat ini (untuk link yang punya href nyata)
      var matched = false;
      $('.sidebar-menu li a').each(function () {
        var linkHref = $(this).attr('href');
        if (!linkHref || linkHref === '#' || linkHref === 'javascript:void(0)') return;

        try {
          var linkPath = new URL(linkHref, window.location.origin).pathname;
          if (currentPath.startsWith(linkPath) && linkPath !== '/') {
            setActive($(this));
            matched = true;
            return false;
          }
        } catch (e) {}

        if (currentUrl.indexOf(linkHref) !== -1) {
          setActive($(this));
          matched = true;
          return false;
        }
      });

      // 2. Jika tidak ada yang cocok dari URL, cek localStorage (klik sebelumnya)
      if (!matched) {
        var savedHref = localStorage.getItem('activeMenuHref');
        if (savedHref) {
          $('.sidebar-menu li a').each(function () {
            if ($(this).attr('href') === savedHref) {
              setActive($(this));
              return false;
            }
          });
        }
      }

      // 3. Saat menu diklik, simpan ke localStorage & langsung beri highlight
      $('.sidebar-menu li a').on('click', function () {
        var href = $(this).attr('href');
        localStorage.setItem('activeMenuHref', href);
        setActive($(this));
      });
    });
  </script>

  @stack('scripts')
</body>
</html>