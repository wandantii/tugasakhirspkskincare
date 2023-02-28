@extends('front.layout')

@section('content')

<div style="background:url({{asset('images/front/beautiful-eucalyptus-with-beauty-products.jpg')}});width:100%;background-position:center;background-repeat:no-repeat;background-attachment:fixed;background-size:cover;box-shadow:inset 0px 0px 250px 250px rgba(0,0,0,0.25);">

<nav class="site-nav">
  <div class="container">
    <div class="site-navigation">
      <span class="logo m-0">SPK Skincare <span class="text-primary">.</span></span>
      <ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu float-right">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('produk') }}">Produk</a></li>
        @auth
        <li class="active"><a href="{{ url('profile') }}"><b>Profile</b></a></li>
				<li class="has-children">
					<a>Perhitungan</a>
					<ul class="dropdown">
						<li><a href="{{ url('copras') }}">Metode COPRAS</a></li>
						<li><a href="{{ url('moora') }}">Metode MOORA</a></li>
						<li><a href="{{ url('perbandingan') }}">Perbandingan COPRAS & MOORA</a></li>
					</ul>
				</li>
        <li>&nbsp;&nbsp;&nbsp;</li>
        <li>
          <form action="{{ url('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger btn-block" style="color:#fff;"><b>Logout</b></button>
          </form>
        </li>
        @else
        <li>&nbsp;&nbsp;&nbsp;</li>
        <li><a href="{{ url('login') }}" class="btn btn-primary btn-block" style="color:#fff;"><b>Login</b></a></li>
        @endauth
      </ul>
      <a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light" data-toggle="collapse" data-target="#main-navbar">
        <span></span>
      </a>
    </div>
  </div>
</nav>

<div class="hero" style="background-color:transparent;">
  <div class="container">
    <div class="row" style="margin:50px 50px -10px 50px;">
      @if(session()->has('success'))
      <div class="alert alert-outline-success alert-dismissible fade show" style="background-color:#fff;">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        <strong>Success!</strong> {{ session('success') }}
      </div>
      @endif
      @if(session()->has('error'))
      <div class="alert alert-outline-danger alert-dismissible fade show" style="background-color:#fff;">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        <strong>Failed!</strong> {{ session('error') }}
      </div>
      @endif
      <div class="col-sm">
        <div class="card">
          <div class="card-header">
            <span class="card-title text-primary"><b>Data Profile</b></span>
          </div>
          <div class="card-body">
            <div class="basic-form">
              <form method="POST" action="{{ url('profile/'.$data->id_user) }}" enctype="multipart/form-data">
                @csrf {{ method_field('PUT') }}
                <div class="row">
                  <div class="col-sm">
                    <div class="row">
                      <div class="col-sm-6 mb-3">
                        <label style="margin:0px;"><b>Username</b></label><span class="text-danger">*</span>
                        <input type="hidden" value="{{ $data->username }}" name="oldusername" id="oldusername">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ $data->username }}" name="username" id="username" required>
                        @error('username')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="col-sm-6 mb-3">
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
                      <div class="col-sm mb-3">
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
                      <div class="col-sm-4 mb-3">
                        <label style="margin:0px;"><b>Tipe Kulit</b></label><span class="text-danger">*</span>
                        <select class="default-select form-control wide" id="tipekulit" name="tipekulit" required>
                          <option value="" <?php if(!isset($data->tipekulit)) { echo 'selected'; } ?> disabled="disabled">Pilih Tipe Kulit</option>
                          @foreach($tipekulits as $tipekulit)
                          <option value="{{ $tipekulit->id_subkriteria }}" <?php if($tipekulit->id_subkriteria == $data->tipekulit) { echo 'selected'; } ?>>{{ $tipekulit->namasubkriteria }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-4 mb-3">
                        <label style="margin:0px;"><b>Jenis Kelamin</b></label><span class="text-danger">*</span>
                        <select class="default-select form-control wide" id="jeniskelamin" name="jeniskelamin" required>
                          <option value="" <?php if(!isset($data->jeniskelamin)) { echo 'selected'; } ?> disabled="disabled">Pilih Jenis Kelamin</option>
                          @foreach($jeniskelamins as $jeniskelamin)
                          <option value="{{ $jeniskelamin->id_subkriteria }}" <?php if($jeniskelamin->id_subkriteria == $data->jeniskelamin) { echo 'selected'; } ?>>{{ $jeniskelamin->namasubkriteria }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-sm-4 mb-3">
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

</div>

@endsection