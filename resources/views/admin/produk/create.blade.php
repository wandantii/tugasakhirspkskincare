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
          <li><a href="{{ url('admin/nilaikriteria') }}" class="mm-active">Nilai Kriteria</a></li>
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
          <li class="mm-active"><a href="{{ url('admin/produk') }}" class="mm-active">Produk</a></li>
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
          <h4 class="card-title"><b>Produk</b></h4>
          <p class="mb-0 subtitle">Hi beauty! Disini kamu bisa memproses data-data untuk Produk</p>
        </div>
      </div>
    </div>
    <!-- row -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Tambah Produk</h4>
          </div>
          <div class="card-body">
            <div class="basic-form">
              <form method="POST" action="{{ url('admin/produk') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <label class="col-form-label"><b>Kategori Produk</b></label><span class="text-danger">*</span>
                    <select class="default-select form-control wide" id="id_kategoriproduk" name="id_kategoriproduk" required>
                      <option value="" disabled="disabled" selected>Pilih Kategori Produk</option>
                      @foreach($kategoriproduks as $kategoriproduk)
                      <option value="{{ $kategoriproduk->id_kategoriproduk }}">{{ $kategoriproduk->nama }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label class="col-form-label"><b>Merk</b></label><span class="text-danger">*</span>
                    <input type="text" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk') }}" name="merk" id="merk" required>
                    @error('merk')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm mb-3">
                    <label class="col-form-label"><b>Nama Produk</b></label><span class="text-danger">*</span>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" name="nama" id="nama" required>
                    @error('nama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm mb-3">
                    <label class="col-form-label"><b>Deskripsi</b></label><span class="text-danger">*</span>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" style="height:75px;" name="deskripsi" id="deskripsi">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="row">
                      <div class="col-sm-6 mb-3">
                        <label class="col-form-label"><b>Harga</b></label><span class="text-danger">*</span>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" name="harga" id="harga" required>
                        @error('harga')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="col-sm-6 mb-3">
                        <label class="col-form-label"><b>Netto</b></label><span class="text-danger">*</span>
                        <input type="text" class="form-control @error('netto') is-invalid @enderror" value="{{ old('netto') }}" name="netto" id="netto" required>
                        @error('netto')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="col-sm-6 mb-3">
                        <label class="col-form-label"><b>Minimal Usia</b></label><span class="text-danger">*</span>
                        <div class="input-group">
                          <input type="number" class="form-control @error('minimalusia') is-invalid @enderror" value="{{ old('minimalusia') }}" name="minimalusia" id="minimalusia" required>
                          <span class="input-group-text" style="height:3rem;">Tahun</span>
                          @error('minimalusia')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-sm-6 mb-3">
                        <label class="col-form-label"><b>Gambar</b></label><span class="text-danger">*</span>
                        <div class="form-file">
                          <input type="file" class="form-file-input form-control @error('gambar') is-invalid @enderror" style="padding:1rem 1.5rem;" name="gambar" id="gambar" required>
                          @error('gambar')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="row">
                      <div class="col-sm-6 mb-3">
                        <label class="col-form-label"><b>Untuk Tipe Kulit</b></label><span class="text-danger">*</span>
                        @foreach($tipekulits as $tipekulit)
                        <br><input class="form-check-input @error('tipekulit') is-invalid @enderror" type="checkbox" value="{{ $tipekulit->namasubkriteria }}" name="tipekulit[]" id="tipekulit"><label class="form-check-label">{{ $tipekulit->namasubkriteria }}</label>
                        @endforeach
                        @error('tipekulit')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="col-form-label"><b>Untuk Jenis Kelamin</b></label><span class="text-danger">*</span>
                          @foreach($jeniskelamins as $jeniskelamin)
                          <br><input class="form-check-input @error('jeniskelamin') is-invalid @enderror" type="checkbox" value="{{ $jeniskelamin->namasubkriteria }}" name="jeniskelamin[]" id="jeniskelamin"><label class="form-check-label">{{ $jeniskelamin->namasubkriteria }}</label>
                          @endforeach
                          @error('jeniskelamin')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>  
                        <div class="mb-3">
                          <label class="col-form-label"><b>Komposisi Berbahaya</b></label><br>
                          <input class="form-check-input @error('komposisiberbahaya') is-invalid @enderror" type="checkbox" value="Alcohol" name="komposisiberbahaya[]" id="komposisiberbahaya"><label class="form-check-label">Alcohol</label><br>
                          <input class="form-check-input @error('komposisiberbahaya') is-invalid @enderror" type="checkbox" value="Fragrance" name="komposisiberbahaya[]" id="komposisiberbahaya"><label class="form-check-label">Fragrance</label>
                          <input type="hidden" class="@error('komposisiberbahaya') is-invalid @enderror">
                          @error('komposisiberbahaya')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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