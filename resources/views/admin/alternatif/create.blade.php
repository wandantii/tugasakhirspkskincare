@extends('admin.alternatif.layout')

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
          <li><a href="{{ url('admin/nilaikriteria') }}">Nilai Kriteria</a></li>
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
          <li class="mm-active"><a href="{{ url('admin/alternatif') }}" class="mm-active">Alternatif</a></li>
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
          <h4 class="card-title"><b>Alternatif</b></h4>
          <p class="mb-0 subtitle">Hi beauty! Disini kamu bisa memproses data-data untuk Alternatif</p>
        </div>
      </div>
    </div>
    <!-- row -->
    <div class="row">
      <div class="col-12">
        <form method="POST" action="{{ url('admin/alternatif') }}" enctype="multipart/form-data">
        @csrf
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Cari Produk</h4>
            </div>
            <div class="basic-form">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Cari Produk</button>
                  </div>
                </div>
                <div class="row" id="dataprodukpilihan">
                  <input type="hidden" class="form-control @error('id_produk') is-invalid @enderror" value="" name="id_produk" id="id_produk" readonly>
                  @error('id_produk')
                  <div class="invalid-feedback">
                    Harap pilih produk terlebih dahulu.
                  </div>
                  @enderror
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Nilai Kriteria</h4>
            </div>
            <div class="basic-form">
              <div class="card-body">
                @foreach($kriterias as $kriteria)
                <div class="row mt-4 mb-4">
                  <div class="col-sm" style="text-align:center;">
                    <h4 class="text-primary"><b>{{ $kriteria->nama }}</b></h4>
                  </div>
                  <div class="row">
                    @if($kriteria->nama == 'Tipe Kulit Wajah')
                    @foreach($subkriterias as $subkriteria)
                    @if($subkriteria->id_kriteria == $kriteria->id_kriteria)
                      <div class="col-sm-4 mb-3">
                        <label class="col-form-label"><b>Untuk {{ $subkriteria->namasubkriteria }}</b></label><span class="text-danger">*</span>
                        <select class="default-select form-control wide" id="nilai{{ $subkriteria->id_subkriteria }}" name="nilai{{ $subkriteria->id_subkriteria }}" required>
                            <option value="" disabled="disabled" selected>Pilih Nilai</option>
                          @forelse($nilais as $nilai)
                          @if($nilai->id_kriteria == $kriteria->id_kriteria)
                            <option value="{{$nilai->id_nilai}}">{{ $nilai->nama }} - {{ $nilai->nilai }}</option>
                          @endif
                          @empty
                            <p>Tidak ada nilai</p>
                          @endforelse
                        </select>
                      </div>
                    @endif
                    @endforeach
                    @elseif($kriteria->nama == 'Jenis Kelamin')
                    @foreach($subkriterias as $subkriteria)
                    @if($subkriteria->id_kriteria == $kriteria->id_kriteria)
                      <div class="col-sm mb-3">
                        <label class="col-form-label"><b>Untuk {{ $subkriteria->namasubkriteria }}</b></label><span class="text-danger">*</span>
                        <select class="default-select form-control wide" id="nilai{{ $subkriteria->id_subkriteria }}" name="nilai{{ $subkriteria->id_subkriteria }}" required>
                            <option value="" disabled="disabled" selected>Pilih Nilai</option>
                          @forelse($nilais as $nilai)
                          @if($nilai->id_kriteria == $kriteria->id_kriteria)
                            <option value="{{$nilai->id_nilai}}">{{ $nilai->nama }} - {{ $nilai->nilai }}</option>
                          @endif
                          @empty
                            <p>Tidak ada nilai</p>
                          @endforelse
                        </select>
                      </div>
                    @endif
                    @endforeach
                    @else
                    <div class="col-sm mb-3">
                      <label class="col-form-label"><b>Untuk {{ $kriteria->nama }}</b></label><span class="text-danger">*</span>
                      <select class="default-select form-control wide" id="nilai{{ $kriteria->id_kriteria }}" name="nilai{{ $kriteria->id_kriteria }}" required>
                          <option value="" disabled="disabled" selected>Pilih Nilai</option>
                        @forelse($nilais as $nilai)
                        @if($nilai->id_kriteria == $kriteria->id_kriteria)
                          <option value="{{$nilai->id_nilai}}">{{ $nilai->nama }} - {{ $nilai->nilai }}</option>
                        @endif
                        @empty
                          <p>Tidak ada nilai</p>
                        @endforelse
                      </select>
                    </div>
                    @endif
                  </div>
                </div>
                @endforeach
                <div class="row">
                  <div class="col-sm">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Content body end -->

<div class="modal fade bd-example-modal-lg" id="cari" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cari Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal">
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-sm">
            <label class="col-form-label"><b>Kategori Produk</b></label>
            <select class="default-select form-control wide" id="id_kategoriprodukaa" name="id_kategoriprodukaa">
              <option selected="true" disabled="disabled">Pilih kategori produk</option>
              @foreach($kategoriproduks as $kategoriproduk)
                <option value="{{$kategoriproduk->id_kategoriproduk}}">{{ $kategoriproduk->nama }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <br>
        <div class="table-responsive" style="padding:10px;">
          <table class="display table table-hover table-responsive-sm" id="pilihproduk" style="min-width:100%;">
            <thead>
              <tr>
                <th>No</th>
                <th>Merk</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Netto</th>
              </tr>
            </thead>
            <tbody id="pilihproduk">
              <tr>
                <td colspan='5' style='text-align:center'>Tidak ada data yang ditemukan</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Merk</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Netto</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection