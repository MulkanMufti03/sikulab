@extends('petugas.sidebar')

@section('title','Dashboard Petugas')

@section('content')

<body>
        <section class="section">
          <div class="section-header">
            <h1>Dashboard Petugas</h1>
          </div>
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>JUMLAH PENGUNJUNG HARI INI</h4>
                  </div>
                  <div class="card-body">
                    10
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-balance-scale"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Jumlah NARAPIDANA</h4>
                  </div>
                  <div class="card-body">
                    12
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Selamat Datang di SIKULAP</h4>
                </div>
                <div class="card-body">
                  <p>Anda login sebagai <strong>Petugas Lapas</strong></p>
                  <p>Sistem Informasi Kunjungan Lapas III Labuha (SIKULAP) Membantu Anda Dalam Mengelola Data Kunjungan dan Data Narapidana</p>
                </div>
              </div>
            </div>
          </div>
        </section>
@endsection
