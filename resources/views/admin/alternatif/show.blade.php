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
        <form method="POST" action="{{ url('admin/alternatif/'.$dataproduk->id_produk) }}" enctype="multipart/form-data">
          @csrf {{ method_field('PUT') }}
          <div class="card">
            <div class="basic-form">
              <div class="card-body">
                <div class="row" id="dataprodukpilihan">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="col-sm-6 mb-3">
                          <label class="col-form-label"><b>Kategori Produk</b></label>
                          <input type="hidden" class="form-control" value="{{ $dataproduk->id_kategoriproduk }}" name="id_kategoriproduk" id="id_kategoriproduk" readonly>
                          <input type="text" class="form-control" value="{{ $dataproduk->kategoriproduk }}" name="kategoriproduk" id="kategoriproduk" readonly>
                        </div>
                        <div class="col-sm-6 mb-3">
                          <label class="col-form-label"><b>Merk</b></label>
                          <input type="text" class="form-control" value="{{ $dataproduk->merk }}" name="merk" id="merk" readonly>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm mb-3">
                          <label class="col-form-label"><b>Nama Produk</b></label>
                          <input type="hidden" class="form-control" value="{{ $dataproduk->id_produk }}" name="id_produk" id="id_produk" readonly>
                          <input type="text" class="form-control" value="{{ $dataproduk->nama }}" name="nama" id="nama" readonly>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm mb-3">
                          <label class="col-form-label"><b>Deskripsi</b></label>
                          <textarea class="form-control" style="height:75px;" name="deskripsi" id="deskripsi" readonly>{{ $dataproduk->deskripsi }}</textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4 mb-3">
                          <label class="col-form-label"><b>Harga</b></label>
                          <input type="number" min="1000" class="form-control" value="{{ $dataproduk->harga }}" name="harga" id="harga" readonly>
                        </div>
                        <div class="col-sm-4 mb-3">
                          <label class="col-form-label"><b>Netto</b></label>
                          <input type="text" class="form-control" value="{{ $dataproduk->netto }}" name="netto" id="netto" readonly>
                        </div>
                        <div class="col-sm-4 mb-3">
                          <label class="col-form-label"><b>Minimal Usia</b></label>
                          <div class="input-group">
                            <input type="number" min="1" max="75" class="form-control" value="{{ $dataproduk->minimalusia }}" name="minimalusia" id="minimalusia" readonly>
                            <span class="input-group-text" style="height:3rem;">Tahun</span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="col-form-label"><b>Untuk Jenis Kelamin</b></label>
                            @foreach($jeniskelamins as $jeniskelamin)
                            <br><input class="form-check-input" type="checkbox" value="{{ $jeniskelamin->namasubkriteria }}" name="jeniskelamin[]" id="jeniskelamin" style="pointer-events: none;" <?php if(str_contains($dataproduk->jeniskelamin, $jeniskelamin->namasubkriteria)) { ?> checked="" <?php } ?>><label class="form-check-label">{{ $jeniskelamin->namasubkriteria }}</label>
                            @endforeach
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label"><b>Komposisi Berbahaya</b></label><br>
                            <input class="form-check-input" type="checkbox" <?php if(str_contains($dataproduk->komposisiberbahaya, 'Alcohol')) { ?> checked="" <?php } ?> value="Alcohol" name="komposisiberbahaya[]" id="komposisiberbahaya" style="pointer-events: none;"><label class="form-check-label">Alcohol</label><br>
                            <input class="form-check-input" type="checkbox" <?php if(str_contains($dataproduk->komposisiberbahaya, 'Fragrance')) { ?> checked="" <?php } ?> value="Fragrance" name="komposisiberbahaya[]" id="komposisiberbahaya" style="pointer-events: none;"><label class="form-check-label">Fragrance</label>
                            <?php if($dataproduk->komposisiberbahaya == '') { ?>
                              <br><span class="badge badge-pill light badge-success">Alcohol and Fragrance Free</span>
                            <?php } ?>
                          </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                          <label class="col-form-label"><b>Untuk Tipe Kulit</b></label>
                          @foreach($tipekulits as $tipekulit)
                          <br><input class="form-check-input" type="checkbox" value="{{ $tipekulit->namasubkriteria }}" name="tipekulit[]" id="tipekulit" style="pointer-events: none;" <?php if(str_contains($dataproduk->tipekulit, $tipekulit->namasubkriteria)) { ?> checked="" <?php } ?>><label class="form-check-label">{{ $tipekulit->namasubkriteria }}</label>
                          @endforeach
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                      <label class="col-form-label"><b>Gambar</b></label>
                      <div class="form-file">
                        @if($dataproduk->gambar)
                          <img src="{{ asset('storage/'.$dataproduk->gambar) }}" alt="Gambar Produk" style="width:100%;">
                        @else
                          <span class="badge badge-xs light badge-danger" style="margin:0 0 0.5rem 0.5rem;">Belum ada foto produk.</span>
                        @endif
                      </div>
                    </div>
                  </div>
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
                    @foreach($dataviewalternatifs as $dataalternatifsub)
                    @if($dataalternatifsub->id_kriteria == $kriteria->id_kriteria)
                      <div class="col-sm mb-3">
                        <label class="col-form-label"><b>Untuk {{ $dataalternatifsub->namasubkriteria }}</b></label>
                        <input type="text" class="form-control" value="{{ $dataalternatifsub->namanilai }} - {{ $dataalternatifsub->nilai }}" name="netto" id="netto" readonly>
                      </div>
                    @endif
                    @endforeach
                    @elseif($kriteria->nama == 'Jenis Kelamin')
                    @foreach($dataviewalternatifs as $dataalternatifsub)
                    @if($dataalternatifsub->id_kriteria == $kriteria->id_kriteria)
                      <div class="col-sm mb-3">
                        <label class="col-form-label"><b>Untuk {{ $dataalternatifsub->namasubkriteria }}</b></label>
                        <input type="text" class="form-control" value="{{ $dataalternatifsub->namanilai }} - {{ $dataalternatifsub->nilai }}" name="netto" id="netto" readonly>
                      </div>
                    @endif
                    @endforeach
                    @else
                    @foreach($dataalternatif as $dataalternatifkriteria)
                    @if($dataalternatifkriteria->id_kriteria == $kriteria->id_kriteria)
                    <div class="col-sm mb-3">
                      <label class="col-form-label"><b>Untuk {{ $kriteria->nama }}</b></label>
                      <input type="text" class="form-control" value="{{ $dataalternatifsub->namanilai }} - {{ $dataalternatifsub->nilai }}" name="netto" id="netto" readonly>
                    </div>
                    @endif
                    @endforeach
                    @endif
                  </div>
                </div>
                @endforeach
                <div class="row">
                  <div class="col-sm">
										<a href="{{ url('admin/alternatif') }}" class="btn btn-primary">Kembali</a>
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

@endsection