<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SIKULAP</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assetsss/img/favicon.png" rel="icon">
  <link href="assetsss/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assetss/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assetss/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assetss/vendor/aos/aos.css" rel="stylesheet">
  <link href="assetss/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assetss/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assetss/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo.png" alt="">
        <h1 class="sitename">SIKULAP.</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Beranda</a></li>
          <li><a href="#about">Tentang Kami</a></li>
          <li><a href="#services">Panduan</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ route ("formpengunjung") }}">Daftar Kunjungan</a>

    </div>
  </header>

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
            <h1>Selamat Datang di Sistem Informasi Kunjungan Lapas Kelas III Labuha</h1>
            <p>Daftar Kunjungan Lapas Kini Lebih Mudah & Cepat</p>
            <div class="d-flex">
              <a href="{{ route ("formpengunjung") }}" class="btn-get-started">Daftar Kunjungan</a>
             
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
            <img src="assetss/img/hero-img.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

 <!-- About Section -->
<!-- About Section -->
  <section id="about" class="about section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Tentang Kami</h2>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-4">

        <!-- Kiri -->
        <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
          <p>
            <strong>Sistem Informasi Kunjungan Lembaga Pemasyarakatan Kelas III Labuha</strong> merupakan layanan digital 
            yang dirancang untuk mempermudah masyarakat dalam melakukan pendaftaran kunjungan secara online. 
            Sistem ini hadir untuk meningkatkan kualitas pelayanan menjadi lebih cepat, tertib, dan transparan.
          </p>
          <ul>
            <li><i class="bi bi-check2-circle"></i> <span>Pendaftaran kunjungan dapat dilakukan secara online tanpa antre.</span></li>
            <li><i class="bi bi-check2-circle"></i> <span>Memudahkan pengunjung dalam memilih jadwal yang tersedia.</span></li>
            <li><i class="bi bi-check2-circle"></i> <span>Meningkatkan efisiensi dan transparansi pelayanan kunjungan.</span></li>
          </ul>
        </div>

        <!-- Kanan -->
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
          <p>
            Dengan adanya sistem ini, diharapkan proses kunjungan ke warga binaan dapat berjalan lebih teratur 
            dan nyaman bagi masyarakat. Selain itu, petugas juga dapat mengelola data kunjungan dengan lebih 
            efektif dan terstruktur.
          </p>

          <!-- MAP LOKASI -->
          <div class="mt-3" style="border-radius: 10px; overflow: hidden;">
            <iframe 
              src="https://www.google.com/maps?q=Lapas+Kelas+III+Labuha&output=embed" 
              width="100%" 
              height="200" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy">
            </iframe>
          </div>
        </div>
      </div>
    </div>

  </section><!-- /About Section -->

    <!-- Services Section -->
  <section id="services" class="services section light-background">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Panduan Pendaftaran Kunjungan</h2>
    <p>Ikuti langkah-langkah berikut untuk melakukan pendaftaran kunjungan secara online dengan mudah</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="row gy-4">

      <!-- Step 1 -->
      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-person-plus icon"></i></div>
          <h4><a class="stretched-link">Isi Data Diri</a></h4>
          <p>Masukkan data diri Anda secara lengkap sebagai pengunjung sesuai dengan identitas yang berlaku.</p>
        </div>
      </div><!-- End Item -->

      <!-- Step 2 -->
      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-people icon"></i></div>
          <h4><a class="stretched-link">Pilih Warga Binaan</a></h4>
          <p>Pilih nama warga binaan yang akan Anda kunjungi sesuai dengan data yang tersedia.</p>
        </div>
      </div><!-- End Item -->

      <!-- Step 3 -->
      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-calendar-check icon"></i></div>
          <h4><a class="stretched-link">Pilih Jadwal</a></h4>
          <p>Tentukan hari dan jam kunjungan sesuai dengan jadwal yang masih tersedia.</p>
        </div>
      </div><!-- End Item -->

      <!-- Step 4 -->
      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-check2-square icon"></i></div>
          <h4><a class="stretched-link">Konfirmasi & Datang</a></h4>
          <p>Pastikan data sudah benar, lalu datang sesuai jadwal yang telah dipilih.</p>
        </div>
      </div><!-- End Item -->
      
    </div>

  </div>

  </section><!-- /Services Section -->

</main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="#hero" class="d-flex align-items-center">
            <span class="sitename">SIKULAP</span>
          </a>
          <div class="footer-contact pt-3">
            <p class="bi bi-house"><span>  LAPAS KELAS III LABUHA</span></p>
            <p class="bi bi-geo-alt">  Jl. Karet Putih Desa Makian Kec. Bacan Selatan Kab. Halmahera Selatan </p>
            <p class="bi bi-telephone"><span>  081341449787</span></p>
            <p class="bi bi-envelope"><span>  lp.labuha@kemenkumham.go.id</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#hero">Beranda</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#about">Tentang Kami</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#services">Panduan</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <p>Silahkan Follow Sosial Media Kami Untuk Mengetahui Info lebih Lanjut</p>
          <div class="social-links d-flex">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Heartware Digital</strong></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assetss/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assetss/vendor/php-email-form/validate.js"></script>
  <script src="assetss/vendor/aos/aos.js"></script>
  <script src="assetss/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assetss/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assetss/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assetss/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assetss/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assetss/js/main.js"></script>

</body>

</html>