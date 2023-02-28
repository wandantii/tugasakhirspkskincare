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

<body>
  <!-- Preloader start -->
  <div id="preloader">
  <div class="lds-ripple">
    <div></div>
    <div></div>
  </div>
  </div>
  <!-- Preloader end -->

  <!-- Main wrapper start -->
  <div id="main-wrapper">

    <!-- Nav header start -->
    <div class="nav-header">
      <a href="index.html" class="brand-logo">
        <svg class="logo-abbr" width="55" height="55" viewbox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M27.5 0C12.3122 0 0 12.3122 0 27.5C0 42.6878 12.3122 55 27.5 55C42.6878 55 55 42.6878 55 27.5C55 12.3122 42.6878 0 27.5 0ZM28.0092 46H19L19.0001 34.9784L19 27.5803V24.4779C19 14.3752 24.0922 10 35.3733 10V17.5571C29.8894 17.5571 28.0092 19.4663 28.0092 24.4779V27.5803H36V34.9784H28.0092V46Z" fill="url(#paint0_linear)"></path>
          <defs></defs>
        </svg>
        <div class="brand-title">
          <h2 class="">Admin</h2>
          <span class="brand-sub-title">SPK Skincare</span>
        </div>
      </a>
      <div class="nav-control">
        <div class="hamburger">
          <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
      </div>
    </div>
    <!-- Nav header end -->

    <!-- Header start -->
    <div class="header border-bottom">
      <div class="header-content">
        <nav class="navbar navbar-expand">
          <div class="collapse navbar-collapse justify-content-between">
            <div class="header-left">
              <div class="dashboard_bar"></div>
            </div>
            <ul class="navbar-nav header-right">
              @auth
              <li class="nav-item dropdown header-profile">
                <a class="nav-link" href="{{ asset('javascript:void(0);') }}" role="button" data-bs-toggle="dropdown">
                <div style="padding:0.5rem;">
									<span class="me-1"><i class="flaticon-381-heart"></i></span>
                  <span class="">Hi, {{ auth()->user()->username }}!</span>
                </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a href="{{ url('admin/profile') }}" class="dropdown-item ai-icon">
                    <i class="fa fa-user-circle text-primary me-2"></i> View profile
                  </a>
                  <form action="{{ url('admin/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item ai-icon">
                      <i class="fa fa-ban text-danger me-2"></i> Logout
                    </button>
                  </form>
                  <hr class="col-sm border-1 border-top border-primary mb-3">
                  <a href="{{ url('admin/register') }}" class="dropdown-item ai-icon">
                    <i class="fa fa-users text-success me-2"></i> Register New Admin
                  </a>
                </div>
              </li>
              @else
              <li class="nav-item dropdown">
                <a href="{{ url('admin/login') }}" class="nav-link"><span class="ms-2">Login</span></a>
              </li>
              @endauth
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <!-- Header end ti-comment-alt -->

    @yield('content')

    <!-- Footer start -->
    <div class="footer">
      <div class="copyright">
        <p>Copyright ©2022. All Rights Reserved. &mdash;  Designed &amp; Developed with love by <a href="" target="_blank">Wanda Berlian Mardianti</a></p>
      </div>
    </div>
    <!-- Footer end -->
  </div>
  <!-- Main wrapper end -->

  <!-- Scripts Required vendors -->
  <script src="{{ asset('vendor/global/global.min.js') }}"></script>
  <script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
  <!-- Apex Chart -->
  <script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script>
  <script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
  <!-- Chart piety plugin files -->
  <script src="{{ asset('vendor/peity/jquery.peity.min.js') }}"></script>
  <!-- Dashboard 1 -->
  <script src="{{ asset('js/dashboard/dashboard-1.js') }}"></script>
  <script src="{{ asset('vendor/owl-carousel/owl.carousel.js') }}"></script>
  <script src="{{ asset('js/custom.min.js') }}"></script>
  <script src="{{ asset('js/dlabnav-init.js') }}"></script>
  <script src="{{ asset('js/demo.js') }}"></script>
  <!-- <script src="{{ asset('js/styleSwitcher.js') }}"></script> -->
  <!-- Datatable -->
  <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
  <script>
    function cardsCenter() {
      /*  testimonial one function by = owl.carousel.js */
      jQuery('.card-slider').owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        //center:true,
        slideSpeed: 3000,
        paginationSpeed: 3000,
        dots: true,
        navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
        responsive:{
          0:{
            items:1
          },
          576:{
            items:1
          },	
          800:{
            items:1
          },			
          991:{
            items:1
          },
          1200:{
            items:1
          },
          1600:{
            items:1
          }
        }
      })
    }
    jQuery(window).on('load',function(){
      setTimeout(function(){
        cardsCenter();
      }, 1000); 
    });
  </script>
</body>
</html>