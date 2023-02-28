@extends('front.layout')

@section('content')

<nav class="site-nav">
  <div class="container">
    <div class="site-navigation">
      <span class="logo m-0">SPK Skincare <span class="text-primary">.</span></span>
      <ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu float-right">
        <li class="active"><a href="{{ url('/') }}"><b>Home</b></a></li>
        <li><a href="{{ url('produk') }}">Produk</a></li>
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
    <div class="row align-items-center">
      <div class="col-lg-7">
        <div class="intro-wrap">
          <h1 class="mt-5 mb-5"><span class="d-block"><b>Hi, beauty!</b></span>You are <span class="typed-words"></span></h1>
          <div class="row">
            <div class="col-12">
              <form class="form">
                <div class="row mb-2">
                  <div class="col-sm">
                    <span class="caption"><i>People are like stained-glass windows. They sparkle and shine when the sun is out, but when the darkness sets in, their true beauty is revealed only if there is a light from within.</i></span>
                    <br>
                    <span class="caption"><b>- Elisabeth Kübler-Ross.</b></span>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="slides">
          <img src="{{ asset('images/front/hero-slider-1.jpg') }}" alt="Image" class="img-fluid active">
          <img src="{{ asset('images/front/hero-slider-2.jpg') }}" alt="Image" class="img-fluid">
          <img src="{{ asset('images/front/hero-slider-3.jpg') }}" alt="Image" class="img-fluid">
          <img src="{{ asset('images/front/hero-slider-4.jpg') }}" alt="Image" class="img-fluid">
          <img src="{{ asset('images/front/hero-slider-5.jpg') }}" alt="Image" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="untree_co-section">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-lg-6 text-center">
        <p></p>
        <h2 class="section-title text-center mb-3">Our Services</h2>
      </div>
    </div>
    <div class="row align-items-stretch">
      <div class="col-lg-4 order-lg-1">
        <div class="h-100"><div class="frame h-100"><div class="feature-img-bg h-100" style="background-image: url('{{ asset('images/front/hero-slider-1.jpg') }}');"></div></div></div>
      </div>
      <div class="col-6 col-sm-6 col-lg-4 feature-1-wrap d-md-flex flex-md-column order-lg-1" >
        <div class="feature-1 d-md-flex">
            <div class="align-self-center">
              <i class="fa-solid fa-5 display-4 text-primary"></i>
              <h3>Skintypes</h3>
              <p class="mb-0">There are five types of facial skin that will be taken into account in this DSS.</p>
            </div>
          </div>
          <div class="feature-1 ">
            <div class="align-self-center">
              <i class="fa-solid fa-1 display-4 text-primary"></i>
              <i class="fa-solid fa-1 display-4 text-primary"></i>
            <h3>Local Brands</h3>
            <p class="mb-0">We only use local products that have clear and well-known quality.</p>
          </div>
        </div>
      </div>
      <div class="col-6 col-sm-6 col-lg-4 feature-1-wrap d-md-flex flex-md-column order-lg-3" >
        <div class="feature-1 d-md-flex">
          <div class="align-self-center">
            <i class="fa-solid fa-3 display-4 text-primary"></i>
            <h3>Basic Skincare</h3>
            <p class="mb-0">Divided into several categories of basic skincare products.</p>
          </div>
        </div>
        <div class="feature-1 d-md-flex">
          <div class="align-self-center">
            <i class="fa-solid fa-2 display-4 text-primary"></i>
            <h3>DSS Method</h3>
            <p class="mb-0">Using two DSS methods to determine skincare product recommendations.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection