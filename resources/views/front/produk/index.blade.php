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
    <div class="row">
      <h1 class="text-primary" style="text-align:center;"><b>List Produk</b></h1>
      <div class="col-sm">
        @foreach($brands as $brand)
        <div class="row" style="margin:10vh 0px 7vh 0;">
          <h2 style="color:#fff;"><b>{{ $brand->merk }}</b></h2>
          <div class="row">
            <div class="smom">
              @foreach($data as $key=>$value)
              @if($value->merk == $brand->merk)
              <div class="strolls">
                <div class="card" style="width:200px;height:325px">
                  <div class="card-body">
                    <div class="new-arrival-product">
                      <div class="new-arrivals-img-contnent">
                      @if($value->gambar)
                        <img src="{{ asset('storage/'.$value->gambar) }}" alt="Gambar Produk" style="width:100%;">
                      @else
                        <span class="badge badge-xs light badge-danger text-center">Belum ada foto produk.</span>
                      @endif
                      </div>
                      <div class="new-arrival-content text-center mt-3">
                        <p style="white-space:pre-line;line-height: normal;"><b><span class="text-primary">{{ $value->merk }}</span><br>{{ $value->nama }}</b></p>
                      </div>
                    </div>
                  </div>
                  <a href="{{ url('produk/'.$value->id_produk.'/show') }}" class="btn-primary" style="margin:20px;color:#fff;border-radius:10px;padding:5px;font-size:10px;">Lihat Produk</a>
                </div>
              </div>
              @endif
              @endforeach
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection