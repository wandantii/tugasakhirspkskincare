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
    <!-- row -->
    <div class="row">
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
        <div class="profile card card-body px-3 pt-3 pb-0">
          <div class="profile-head">
            <div class="photo-content">
              <div class="cover-photo rounded"></div>
            </div>
            <div class="profile-info">
							<div class="profile-details">
								<div class="profile-email px-2 pt-2">
									<h4 class="text-muted mb-0">Hai, {{ $data->namalengkap }}!</h4>
									<p>Admin SPK Skincare</p>
								</div>
							</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm">
        <div class="card">
          <div class="card-body">
            <div class="profile-tab">
              <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                  <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link active show">Setting</a></li>
                  <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link">About Me</a></li>
                </ul>
                <div class="tab-content">
                  <div id="profile-settings" class="tab-pane fade active show">
                    <div class="pt-4">
                      <div class="settings-form">
                        <form method="POST" action="{{ url('admin/profile/'.$data->id_user) }}" enctype="multipart/form-data">
                          @csrf {{ method_field('PUT') }}
                          <div class="row">
                            <div class="col-sm pt-3">
                              <div class="row">
                                <div class="col-sm-6 mb-4">
                                  <label style="margin:0px;"><b>Username</b></label><span class="text-danger">*</span>
                                  <input type="hidden" value="{{ $data->username }}" name="oldusername" id="oldusername">
                                  <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ $data->username }}" name="username" id="username" required>
                                  @error('username')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                                <div class="col-sm-6 mb-4">
                                  <label style="margin:0px;"><b>Email</b></label><span class="text-danger">*</span>
                                  <input type="hidden" value="{{ $data->email }}" name="oldemail" id="oldemail">
                                  <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ $data->email }}" name="email" id="email" required>
                                  @error('email')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm mb-4">
                                  <label style="margin:0px;"><b>Nama Lengkap</b></label><span class="text-danger">*</span>
                                  <input type="text" class="form-control @error('namalengkap') is-invalid @enderror" value="{{ $data->namalengkap }}" name="namalengkap" id="namalengkap" required>
                                  @error('namalengkap')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-4 mb-4">
                                  <label style="margin:0px;"><b>Tipe Kulit</b></label><span class="text-danger">*</span>
                                  <select class="default-select form-control wide" id="tipekulit" name="tipekulit" required>
                                    <option value="" <?php if(!isset($data->tipekulit)) { echo 'selected'; } ?> disabled="disabled">Pilih Tipe Kulit</option>
                                    @foreach($tipekulits as $tipekulit)
                                    <option value="{{ $tipekulit->id_subkriteria }}" <?php if($tipekulit->id_subkriteria == $data->tipekulit) { echo 'selected'; } ?>>{{ $tipekulit->namasubkriteria }}</option>
                                    @endforeach
                                  </select>
                                  @error('tipekulit')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                                <div class="col-sm-4 mb-4">
                                  <label style="margin:0px;"><b>Jenis Kelamin</b></label><span class="text-danger">*</span>
                                  <select class="default-select form-control wide" id="jeniskelamin" name="jeniskelamin" required>
                                    <option value="" <?php if(!isset($data->jeniskelamin)) { echo 'selected'; } ?> disabled="disabled">Pilih Jenis Kelamin</option>
                                    @foreach($jeniskelamins as $jeniskelamin)
                                    <option value="{{ $jeniskelamin->id_subkriteria }}" <?php if($jeniskelamin->id_subkriteria == $data->jeniskelamin) { echo 'selected'; } ?>>{{ $jeniskelamin->namasubkriteria }}</option>
                                    @endforeach
                                  </select>
                                  @error('jeniskelamin')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                                <div class="col-sm-4 mb-4">
                                  <label style="margin:0px;"><b>Usia</b></label><span class="text-danger">*</span>
                                  <div class="input-group">
                                    <input type="number" class="form-control @error('usia') is-invalid @enderror" value="{{ $data->usia }}" name="usia" id="usia" required>
                                    <span class="input-group-text" style="height:3rem;">Tahun</span>
                                    @error('usia')
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
                  <div id="about-me" class="tab-pane fade">
                    <div class="profile-about-me">
                      <div class="pt-4 border-bottom-1 pb-3">
                        <h4 class="text-primary">About Me</h4>
                        <p class="mb-2">Dengan memanjatkan puji syukur kehadirat Allah SWT atas ridha-Nya peneliti dapat menyelesaikan tugas akhir yang berjudul “PERBANDINGAN METODE COPRAS DAN MOORA DALAM PENENTUAN REKOMENDASI PRODUK SKINCARE YANG SESUAI DENGAN JENIS KULIT WAJAH”.</p>
                        <p>Adapun tujuan utama penulisan tugas akhir ini adalah untuk memenuhi persyaratan akademik agar dapat memperoleh gelar sarjana, serta untuk melatih kemampuan penulis dalam memecahkan masalah secara sistematis dengan menggunakan teori yang sudah dipelajari di bangku perkuliahan.</p>
                      </div>
                    </div>
                    <div class="profile-skills mb-5">
                      <h4 class="text-primary mb-2">Application and Data</h4>
                      <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1">PHP</a>
                      <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1">Laravel 8</a>
                      <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1">MySQL</a>
                      <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1">Bootstrap</a>
                      <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1">Javascript</a>
                      <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1">HTML5</a>
                    </div>
                    <div class="profile-personal-info">
                      <h4 class="text-primary mb-4">Personal Information</h4>
                      <div class="row mb-2">
                        <div class="col-sm-3 col-5">
                          <h5 class="f-w-500">Name <span class="pull-end">:</span></h5>
                        </div>
                        <div class="col-sm-9 col-7"><span>Wanda Berlian Mardianti</span></div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-sm-3 col-5">
                          <h5 class="f-w-500">Email <span class="pull-end">:</span></h5>
                        </div>
                        <div class="col-sm-9 col-7"><span>qr.wandantii@gmail.com</span></div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-sm-3 col-5">
                          <h5 class="f-w-500">Availability <span class="pull-end">:</span></h5>
                        </div>
                        <div class="col-sm-9 col-7"><span>Full Time (Free Lancer)</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Content body end -->

@endsection