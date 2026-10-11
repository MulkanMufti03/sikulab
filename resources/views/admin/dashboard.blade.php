@extends('admin.sidebar')

@section('title','Dashboard Admin')

@section('content')
        <section class="section">
          <div class="section-header">
            <h1>Dashboard Admin</h1>
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
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Akun Petugas</h4>
                  </div>
                  <div class="card-body">
                    10
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-balance-scale"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Narapidana</h4>
                  </div>
                  <div class="card-body">
                    5
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Pengunjung</h4>
                  </div>
                  <div class="card-body">
                    15
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
                  <p>Anda login sebagai <strong>Administrator</strong></p>
                  <p>Sistem Informasi Kunjungan Lapas III Labuha (SIKULAP) Membantu Anda Dalam Mengelola Data Kunjungan dan Data Narapidana</p>
                </div>
              </div>
            </div>
          </div>
        </section>
@endsection