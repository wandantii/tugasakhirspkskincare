<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
	<meta property="og:title" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
	<meta property="og:description" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
	<meta property="og:image" content="https:/fillow.dexignlab.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE -->
  <title>Admin | SPK Rekomendasi Produk Skincare yang Sesuai dengan Jenis Kulit Wajah</title>
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">
	<link href="{{ asset('vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
	<link href="{{ asset('vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('vendor/nouislider/nouislider.min.css') }}">
	<!-- Datatable -->
  <link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
	<!-- Custom Stylesheet -->
	<link href="{{ asset('vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="vh-100">
  <div class="authincation h-100">
    <div class="container h-100">
      <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-6">
          <div class="authincation-content">
            <div class="row no-gutters">
              <div class="col-xl-12">
                <div class="auth-form">
                  <div class="row mb-4">
                    <h1 class="text-center">Hello skin lover!</h1>
                    <h4 class="text-center mb-4">Welcome back, we missed you!</h4>
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
                  <form method="POST" action="{{ url('admin/login') }}">
                    @csrf
                    <div class="mb-3">
                      <label class="mb-1"><strong>Username</strong></label>
                      <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('username') }}" id="username" name="username" autofocus required>
                      @error('username')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label class="mb-1"><strong>Password</strong></label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                      @error('password')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                    <br>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
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
  
  <!-- Required vendors -->
  <script src="{{ asset('vendor/global/global.min.js') }}"></script>
  <script src="{{ asset('js/custom.min.js') }}"></script>
  <script src="{{ asset('js/dlabnav-init.js') }}"></script>
	<!-- <script src="{{ asset('js/styleSwitcher.js') }}"></script> -->
</body>
</html>