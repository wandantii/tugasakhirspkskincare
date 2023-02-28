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
        <li>&nbsp;&nbsp;&nbsp;</li>
        <li><a href="{{ url('login') }}" class="btn btn-primary btn-block" style="color:#fff;"><b>Login</b></a></li>
      </ul>
      <a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light" data-toggle="collapse" data-target="#main-navbar">
        <span></span>
      </a>
    </div>
  </div>
</nav>

<div class="hero" style="background-color:transparent;">
  <div class="container">
    <div class="intro-wrap">
      <div class="row mt-5">
        <div class="col-md-7"></div>
        <div class="col-md-5" style="background-color:#fff;padding:0;">
          <div class="authincation-content">
            <div class="auth-form" style="padding:50px 75px;">
              <div class="row">
                <h3 class="text-center text-primary"><b>Hello skin lover!</b></h3>
              </div>
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
              <form method="POST" action="{{ url('register') }}">
                @csrf
                <div class="mt-3">
                  <label style="margin:0px;">Email</label>
                  <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" name="email" autofocus required>
                  @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="mt-3">
                  <label style="margin:0px;">Username</label>
                  <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" id="username" name="username" required>
                  @error('username')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="mt-3">
                  <label style="margin:0px;">Nama Lengkap</label>
                  <input type="text" class="form-control @error('namalengkap') is-invalid @enderror" value="{{ old('namalengkap') }}" id="namalengkap" name="namalengkap" required>
                  @error('namalengkap')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="mt-3">
                  <label style="margin:0px;">Password</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                  @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <br>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
              </form>
              <div class="new-account mt-3">
                <p>Already have an account? <a class="text-primary" href="{{ url('login') }}"><b>Login</b></a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection