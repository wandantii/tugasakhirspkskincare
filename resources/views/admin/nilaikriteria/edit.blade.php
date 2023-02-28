@extends('admin.layout')

@section('content')

<!-- Sidebar start -->
<div class="dlabnav">
  <div class="dlabnav-scroll">
    <ul class="metismenu" id="menu">
      <!-- Beranda menu start -->
      <li>
        <a class="" href="{{ url('admin') }}" aria-expanded="false">
          <i class="fas fa-home"></i>
          <span class="nav-text">Beranda</span>
        </a>
      </li>
      <!-- Beranda menu end -->
      <!-- Data Master menu start -->
      <li>
        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
          <i class="fas fa-table"></i>
          <span class="nav-text">Data Master</span>
        </a>
        <ul aria-expanded="false">
          <li><a href="{{ url('admin/kriteria') }}">Kriteria</a></li>
          <li><a href="{{ url('admin/subkriteria') }}">Sub Kriteria</a></li>
          <li class="mm-active"><a href="{{ url('admin/nilaikriteria') }}" class="mm-active">Nilai Kriteria</a></li>
          <li><a href="{{ url('admin/kategoriproduk') }}">Kategori Produk</a></li>
          <li><a href="{{ url('admin/user') }}">User</a></li>
        </ul>
      </li>
      <!-- Data Master menu end -->
      <!-- Data Perhitungan menu start -->
      <li>
        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
          <i class="fas fa-file-alt"></i>
          <span class="nav-text">Perhitungan</span>
        </a>
        <ul aria-expanded="false">
          <li><a href="{{ url('admin/produk') }}">Produk</a></li>
          <li><a href="{{ url('admin/alternatif') }}">Alternatif</a></li>
          <li><a href="{{ url('admin/penilaian') }}">Penilaian</a></li>
        </ul>
      </li>
      <!-- Data Perhitungan menu end -->
    </ul>
  </div>
</div>
<!-- Sidebar end -->
    
<!-- Content body start -->
<div class="content-body">
  <div class="container-fluid">
    <div class="col-lg-12">
      @if(session()->has('success'))
      <div class="alert alert-outline-success alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        <strong>Success!</strong> {{ session('success') }}
      </div>
      @endif
      @if(session()->has('error'))
      <div class="alert alert-outline-danger alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        <strong>Failed!</strong> {{ session('error') }}
      </div>
      @endif
      <div class="card">
        <div class="card-header d-block">
          <h4 class="card-title"><b>Nilai Kriteria</b></h4>
          <p class="mb-0 subtitle">Hi beauty! Disini kamu bisa memproses data-data untuk Nilai Kriteria</p>
        </div>
      </div>
    </div>
    <!-- row -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit Nilai Kriteria</h4>
          </div>
          <div class="card-body">
            <div class="basic-form">
              <form method="POST" action="{{ url('admin/nilaikriteria/'.$data->id_nilai) }}">
                @csrf {{ method_field('PUT') }}
                <div class="row">
                  <div class="col-sm mb-3">
                    <label class="col-form-label"><b>Kriteria</b></label><span class="text-danger">*</span>
                    <select class="default-select form-control wide" id="id_kriteria" name="id_kriteria">
                      @foreach($kriterias as $kriteria)
                      <option value="{{ $kriteria->id_kriteria }}" {{($kriteria->id_kriteria === $data->id_kriteria) ? 'Selected' : ''}}>{{ $kriteria->nama }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label class="col-form-label"><b>Nama Nilai</b></label><span class="text-danger">*</span>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ $data->nama }}" name="nama" id="nama" required>
                    @error('nama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label class="col-form-label"><b>Nilai</b></label><span class="text-danger">*</span>
                    <input type="text" class="form-control @error('nilai') is-invalid @enderror" value="{{ $data->nilai }}" name="nilai" id="nilai" required>
                    @error('nilai')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Content body end -->

@endsection