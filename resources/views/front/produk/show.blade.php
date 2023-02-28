@extends('front.layout')

@section('content')

<nav class="site-nav">
  <div class="container">
    <div class="site-navigation">
      <span class="logo m-0">SPK Skincare <span class="text-primary">.</span></span>
      <ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu float-right">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="active"><a href="{{ url('produk') }}"><b>Produk</b></a></li>
        @auth
        <li><a href="{{ url('profile') }}">Profile</a></li>
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

<div class="hero">
  <div class="container">
    <div class="row" style="margin:50px 50px -10px 50px;">
      <div class="col-sm">
        <div class="card">
          <div class="card-header">
            <span class="card-title text-primary"><b>Data Produk</b></span>
          </div>
          <div class="card-body">
            <div class="basic-form">
              <form method="POST" action="{{ url('admin/produk/'.$data->id_produk) }}" enctype="multipart/form-data">
                @csrf {{ method_field('PUT') }}
                <div class="row">
                  <div class="col-sm-6">
                    <div class="row">
                      <div class="col-sm-6 mb-4">
                        <label style="margin:0px;"><b>Kategori Produk</b></label>
                        <input type="text" class="form-control" value="{{ $data->kategoriproduk }}" name="kategoriproduk" id="kategoriproduk" readonly>
                      </div>
                      <div class="col-sm-6 mb-4">
                        <label style="margin:0px;"><b>Merk</b></label>
                        <input type="text" class="form-control" value="{{ $data->merk }}" name="merk" id="merk" readonly>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm mb-4">
                        <label style="margin:0px;"><b>Nama Produk</b></label>
                        <input type="text" class="form-control" value="{{ $data->nama }}" name="nama" id="nama" readonly>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm mb-4">
                        <label style="margin:0px;"><b>Deskripsi</b></label>
                        <textarea class="form-control" style="height:75px;" name="deskripsi" id="deskripsi" readonly>{{ $data->deskripsi }}</textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4 mb-4">
                        <label style="margin:0px;"><b>Harga</b></label>
                        <input type="number" min="1000" class="form-control" value="{{ $data->harga }}" name="harga" id="harga" readonly>
                      </div>
                      <div class="col-sm-4 mb-4">
                        <label style="margin:0px;"><b>Netto</b></label>
                        <input type="text" class="form-control" value="{{ $data->netto }}" name="netto" id="netto" readonly>
                      </div>
                      <div class="col-sm-4 mb-4">
                        <label style="margin:0px;"><b>Minimal Usia</b></label>
                        <div class="input-group">
                          <input type="number" min="1" max="75" class="form-control" value="{{ $data->minimalusia }}" name="minimalusia" id="minimalusia" readonly>
                          <span class="input-group-text" style="height:3rem;">Tahun</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="mb-4">
                          <label style="margin:0px;"><b>Untuk Jenis Kelamin</b></label>
                          @foreach($jeniskelamins as $jeniskelamin)
                          <br><?php if(str_contains($data->jeniskelamin, $jeniskelamin->namasubkriteria)) { ?><i class="fa fa-check text-primary" aria-hidden="true"></i> <?php } else { ?>&nbsp;<i class="fa fa-times text-muted" aria-hidden="true"> </i><?php } ?> <label class="form-check-label">{{ $jeniskelamin->namasubkriteria }}</label>
                          @endforeach
                        </div>
                        <div class="mb-4">
                          <label style="margin:0px;"><b>Komposisi Berbahaya</b></label>
                          <br><?php if(str_contains($data->komposisiberbahaya, 'Alcohol')) { ?><i class="fa fa-check text-primary" aria-hidden="true"></i> <?php } else { ?>&nbsp;<i class="fa fa-times text-muted" aria-hidden="true"> </i><?php } ?> <label class="form-check-label">Alcohol</label>
                          <br><?php if(str_contains($data->komposisiberbahaya, 'Fragrance')) { ?><i class="fa fa-check text-primary" aria-hidden="true"></i> <?php } else { ?>&nbsp;<i class="fa fa-times text-muted" aria-hidden="true"> </i><?php } ?> <label class="form-check-label">Fragrance</label>
                          <?php if($data->komposisiberbahaya == '') { ?>
                            <br><span class="badge badge-pill light badge-success">Alcohol and Fragrance Free</span>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-sm-6 mb-4">
                        <label style="margin:0px;"><b>Untuk Tipe Kulit</b></label>
                        @foreach($tipekulits as $tipekulit)
                          <br><?php if(str_contains($data->tipekulit, $tipekulit->namasubkriteria)) { ?><i class="fa fa-check text-primary" aria-hidden="true"></i> <?php } else { ?>&nbsp;<i class="fa fa-times text-muted" aria-hidden="true"> </i><?php } ?> <label class="form-check-label">{{ $tipekulit->namasubkriteria }}</label>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-4">
                    <label style="margin:0px;"><b>Gambar</b></label>
                    <div class="form-file">
                      @if($data->gambar)
                        <img src="{{ asset('storage/'.$data->gambar) }}" alt="Gambar Produk" style="width:100%;">
                      @else
                        <span class="badge badge-xs light badge-danger" style="margin:0 0 0.5rem 0.5rem;">Belum ada foto produk.</span>
                      @endif
                    </div>
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

<div class="hero" style="background-color:transparent;">
  <div class="container">
    <div class="row" style="margin:0 50px -35px 50px;">
      <span class="card-title text-primary"><b>Review</b></span>
      <div id="DZ_W_Todo3" class="widget-timeline dlab-scroll">
        <ul class="timeline">
        @forelse($reviews as $review)
          <li>
            <div class="timeline-badge primary">
              <i class="fa fa-user" aria-hidden="true" style="font-size:25px;"></i>
            </div>
            <div class="timeline-panel" style="margin-left:3rem;">
              <span class="text-muted">Posted on {{ $review->updated_at }}</span>
              <h4 ><b>{{ $review->username }}</b></h4>
              <div class="row">
                <div class="col-sm-2">
                  <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{ $review->namatipekulit }}<br>
                  <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{ $review->namajeniskelamin }}<br>
                  <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> {{ $review->usia }} Tahun
                </div>
                <div class="col-sm-10">
                  <p class="mb-1" style="word-wrap:break-word;">{{ $review->review }}</p>
                </div>
              </div>
            </div>
          </li>
        @empty
          <p class="mb-1">Belum ada review untuk produk ini.</p>
        @endforelse
        </ul>
        <div class="d-flex">
          {!! $reviews->links() !!}
        </div>
      </div>
    </div>
  </div>
</div>

<?php if($user != null) { ?>
<div style="background:url({{asset('images/front/beautiful-eucalyptus-with-beauty-products.jpg')}});width:100%;background-position:center;background-repeat:no-repeat;background-attachment:fixed;background-size:cover;box-shadow:inset 0px 0px 250px 250px rgba(0,0,0,0.25);">
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
            <span class="card-title text-primary"><b>Tulis Review</b></span>
          </div>
          <div class="card-body">
            <div class="basic-form">
            <?php if($cekreview > 0) { ?>
              <span>Hai, anda sudah membuat review untuk produk ini. Terima kasih!<br>Apakah anda ingin memperbarui review?</span><br><br>
            <div class="profile-tab">
              <div class="custom-tab-1">
                <ul class="nav nav-tabs" style="border-bottom:0px transparent;">
                  <li class="nav-item"><a href="#formupdatereview" data-bs-toggle="tab" class="nav-link text-primary"><b>Update Review</b></a></li>
                </ul> 
                <div class="tab-content">
                  <div id="formupdatereview" class="tab-pane fade"><br>
                  <form method="POST" action="{{ url('review') }}" enctype="multipart/form-data">
                    @csrf {{ method_field('PUT') }}
                    <div class="row">
                      <div class="col-sm">
                        <div class="row">
                          <div class="col-sm mb-3">
                            <label style="margin:0px;"><b>Username</b></label>
                            <input type="hidden" class="form-control" value="{{ $data->id_produk }}" name="id_produk" id="id_produk" readonly>
                            <input type="hidden" class="form-control" value="{{ $user->id_user }}" name="id_user" id="id_user" readonly>
                            <input type="text" class="form-control" value="{{ $user->username }}" name="username" id="username" readonly>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-4 mb-3">
                            <label style="margin:0px;"><b>Tipe Kulit</b></label>
                            <input type="text" class="form-control" value="{{ $user->namatipekulit }}" name="tipekulit" id="tipekulit" readonly>
                          </div>
                          <div class="col-sm-4 mb-3">
                            <label style="margin:0px;"><b>Jenis Kelamin</b></label>
                            <input type="text" class="form-control" value="{{ $user->namajeniskelamin }}" name="jeniskelamin" id="jeniskelamin" readonly>
                          </div>
                          <div class="col-sm-4 mb-3">
                            <label style="margin:0px;"><b>Usia</b></label>
                            <div class="input-group">
                              <input type="number" class="form-control" value="{{ $user->usia }}" name="usia" id="usia" readonly>
                              <span class="input-group-text" style="height:3rem;">Tahun</span>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm mb-3">
                            <label style="margin:0px;"><b>Ulasan</b></label><span class="text-danger">*</span>
                            <textarea class="form-control @error('review') is-invalid @enderror" style="height:75px;" name="review" id="review" required>{{ $getreview->review }}</textarea>
                            @error('review')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-sm">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
            <?php } else { ?>
              <form method="POST" action="{{ url('review') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-sm">
                    <div class="row">
                      <div class="col-sm mb-3">
                        <label style="margin:0px;"><b>Username</b></label>
                        <input type="hidden" class="form-control" value="{{ $data->id_produk }}" name="id_produk" id="id_produk" readonly>
                        <input type="hidden" class="form-control" value="{{ $user->id_user }}" name="id_user" id="id_user" readonly>
                        <input type="text" class="form-control" value="{{ $user->username }}" name="username" id="username" readonly>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4 mb-3">
                        <label style="margin:0px;"><b>Tipe Kulit</b></label>
                        <input type="text" class="form-control" value="{{ $user->namatipekulit }}" name="tipekulit" id="tipekulit" readonly>
                      </div>
                      <div class="col-sm-4 mb-3">
                        <label style="margin:0px;"><b>Jenis Kelamin</b></label>
                        <input type="text" class="form-control" value="{{ $user->namajeniskelamin }}" name="jeniskelamin" id="jeniskelamin" readonly>
                      </div>
                      <div class="col-sm-4 mb-3">
                        <label style="margin:0px;"><b>Usia</b></label>
                        <div class="input-group">
                          <input type="number" class="form-control" value="{{ $user->usia }}" name="usia" id="usia" readonly>
                          <span class="input-group-text" style="height:3rem;">Tahun</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm mb-3">
                        <label style="margin:0px;"><b>Ulasan</b></label><span class="text-danger">*</span>
                        <textarea class="form-control @error('review') is-invalid @enderror" style="height:75px;" name="review" id="review" required></textarea>
                        @error('review')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <?php if(isset(auth()->user()->jeniskelamin) && isset(auth()->user()->tipekulit) && isset(auth()->user()->usia)) { ?>
                <div class="row">
                  <div class="col-sm">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </div>
                </div>
                <?php } else { ?>
                  <p style="color:#fc2e53;font-weight:900;font-size:15px;">Tunggu sebentar!</p>
                  <p style="font-weight:500;font-size:12px;line-height:normal;margin-top:-20px;">Duh, maaf ya. Sepertinya kamu harus mengisi halaman profile terlebih dahulu agar bisa mengirim ulasan.</p>
                <?php } ?>
              </form>
            <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php } ?>

@endsection