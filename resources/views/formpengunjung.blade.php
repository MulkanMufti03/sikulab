<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Daftar Kunjungan - SIKULAP</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  {{-- <link href="{{ asset('assetsss/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assetsss/img/apple-touch-icon.png') }}" rel="apple-touch-icon"> --}}

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assetss/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assetss/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assetss/css/main.css') }}" rel="stylesheet">

  <style>
    /* Sedikit tambahan khusus form kunjungan */
    #kunjungan .slot-item { cursor: pointer; }
    #kunjungan .slot-item.disabled { opacity: .55; cursor: not-allowed; }
    #kunjungan .slot-item:has(input:checked) { border-color: var(--accent-color, #0d6efd); background: rgba(13, 110, 253, .06); }
    #preview { max-width: 100%; max-height: 220px; display: none; }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ route('halamanutama') }}" class="logo d-flex align-items-center me-auto">
        <img src="{{ asset('assets/img/logo.png') }}" alt="">
        <h1 class="sitename">SIKULAP.</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('halamanutama') }}#hero">Beranda</a></li>
          <li><a href="{{ route('halamanutama') }}#about">Tentang Kami</a></li>
          <li><a href="{{ route('halamanutama') }}#services">Panduan</a></li>
          <li><a href="{{ route('cekstatus') }}">Cek Status</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- ======= Pendaftaran Kunjungan ======= -->
    <section id="kunjungan" class="kunjungan section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Daftar Kunjungan</h2>
        <p>Pilih jadwal kunjungan hari ini, lengkapi data diri, lalu unggah foto KTP Anda.
           Sudah mendaftar? <a href="{{ route('cekstatus') }}">Cek status pendaftaran</a>.</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 p-md-5">

                @if ($errors->any())
                  <div class="alert alert-danger">
                    Periksa kembali isian Anda:
                    <ul class="mb-0">
                      @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <form action="{{ route('formpengunjung.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  {{-- Jadwal --}}
                  <label class="form-label fw-semibold">Jadwal Kunjungan Hari Ini
                    <small class="text-muted fw-normal">({{ now()->isoFormat('dddd, D MMMM Y') }})</small>
                  </label>
                  <div class="list-group mb-1">
                    @forelse ($slots as $s)
                      @php $penuh = $s->sisa <= 0; @endphp
                      <label class="list-group-item slot-item d-flex gap-3 align-items-start {{ $penuh ? 'disabled' : '' }}">
                        <input class="form-check-input flex-shrink-0 mt-1" type="radio" name="slot"
                               value="{{ $s->key }}"
                               {{ old('slot') === $s->key ? 'checked' : '' }}
                               {{ $penuh ? 'disabled' : '' }} required>
                        <span>
                          <strong class="d-block">{{ $s->tanggal->isoFormat('dddd, D MMMM Y') }}</strong>
                          Pukul {{ $s->jadwal->jam_kunjungan }}
                          <small class="text-muted d-block">
                            {{ $penuh ? 'Kuota penuh' : 'Sisa kuota ' . $s->sisa . ' orang' }}
                            @if ($s->jadwal->keterangan) &middot; {{ $s->jadwal->keterangan }} @endif
                          </small>
                        </span>
                      </label>
                    @empty
                      <div class="list-group-item text-muted">
                        Tidak ada jadwal kunjungan yang tersedia hari ini.
                        @if ($berikutnya)
                          Jadwal berikutnya: <strong>{{ $berikutnya->tanggal->isoFormat('dddd, D MMMM Y') }}</strong>,
                          pukul {{ $berikutnya->jam }}.
                        @endif
                      </div>
                    @endforelse
                  </div>
                  @error('slot') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                  {{-- Narapidana --}}
                  <div class="mt-3">
                    <label class="form-label fw-semibold" for="napidana_id">Narapidana yang Dikunjungi</label>
                    <select name="napidana_id" id="napidana_id" class="form-select @error('napidana_id') is-invalid @enderror" required>
                      <option value="">-- Pilih --</option>
                      @foreach ($napi as $n)
                        <option value="{{ $n->id }}" {{ old('napidana_id') == $n->id ? 'selected' : '' }}>
                          {{ $n->nama_lengkap }} ({{ $n->no_registrasi }})
                        </option>
                      @endforeach
                    </select>
                    @error('napidana_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>

                  <div class="row">
                    <div class="col-md-6 mt-3">
                      <label class="form-label fw-semibold" for="nama">Nama Lengkap (sesuai KTP)</label>
                      <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                             class="form-control @error('nama') is-invalid @enderror" required>
                      @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                      <label class="form-label fw-semibold" for="nik">NIK</label>
                      <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" inputmode="numeric"
                             class="form-control @error('nik') is-invalid @enderror" required>
                      @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                      <label class="form-label fw-semibold" for="no_hp">No. HP / WhatsApp</label>
                      <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" placeholder="081234567890"
                             class="form-control @error('no_hp') is-invalid @enderror" required>
                      @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                      <label class="form-label fw-semibold" for="hubungan">Hubungan dengan Narapidana</label>
                      <input type="text" name="hubungan" id="hubungan" value="{{ old('hubungan') }}" placeholder="Contoh: Istri, Anak, Saudara"
                             class="form-control @error('hubungan') is-invalid @enderror" required>
                      @error('hubungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>

                  <div class="mt-3">
                    <label class="form-label fw-semibold" for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3"
                              class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>

                  <div class="mt-3">
                    <label class="form-label fw-semibold" for="ktp">Upload Foto KTP <small class="text-muted fw-normal">(JPG/PNG, maks 2 MB)</small></label>
                    <input type="file" name="foto_ktp" id="ktp" accept="image/png,image/jpeg"
                           class="form-control @error('foto_ktp') is-invalid @enderror" required>
                    @error('foto_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <img id="preview" class="img-thumbnail mt-2" alt="Preview KTP">
                  </div>

                  <button type="submit" class="btn btn-primary w-100 mt-4 py-2" {{ count($slots) ? '' : 'disabled' }}>Kirim Pendaftaran</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Pendaftaran Kunjungan -->

  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ route('halamanutama') }}#hero" class="d-flex align-items-center">
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
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('halamanutama') }}#hero">Beranda</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('halamanutama') }}#about">Tentang Kami</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('halamanutama') }}#services">Panduan</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#kunjungan">Daftar Kunjungan</a></li>
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
  <script src="{{ asset('assetss/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assetss/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assetss/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assetss/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assetss/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assetss/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('assetss/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assetss/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assetss/js/main.js') }}"></script>

  <script>
    // Preview foto KTP sebelum dikirim
    document.getElementById('ktp').addEventListener('change', function (e) {
      const file = e.target.files[0], img = document.getElementById('preview');
      if (!file) { img.style.display = 'none'; return; }
      img.src = URL.createObjectURL(file);
      img.style.display = 'block';
    });

    @if ($errors->any())
      // Kembali ke bagian form jika ada error validasi
      window.addEventListener('load', function () {
        document.getElementById('kunjungan').scrollIntoView();
      });
    @endif
  </script>

</body>

</html>