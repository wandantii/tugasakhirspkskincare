<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="{{ asset('css/front/bootstrap.min.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">
  <!-- <link rel="stylesheet" href="{{ asset('css/front/owl.carousel.min.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('css/front/owl.theme.default.min.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('css/front/jquery.fancybox.min.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('fonts/flaticon/font/flaticon.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('css/front/daterangepicker.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('css/front/aos.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('css/front/style.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('vendor/jquery-nice-select/css/nice-select.css') }}"> -->
  
  <title>SPK Rekomendasi Produk Skincare yang Sesuai dengan Jenis Kulit Wajah</title>
  <style>
    div.smom {
      overflow: auto;
      white-space: nowrap;
      width:100%;
      margin-left:15px;
    }
    div.smom div.strolls {
      display: inline-block;
      color: white;
      text-align: center;
      padding: 10px;
      text-decoration: none;
    }
    ::-webkit-scrollbar {
      width: 10px;
    }
    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey; 
    }
    ::-webkit-scrollbar-thumb {
      background: #402c66; 
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #6c4bae; 
    }
  </style>
</head>

<body>
  
  <div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close">
        <span class="icofont-close js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>
  
  @yield('content')
  
  <div class="site-footer">
    <div class="inner dark">
      <div class="container">
        <div class="row text-center">
          <div class="col-md-8 mt-5 mb-md-0 mx-auto">
            <p>Copyright ©2022. All Rights Reserved. &mdash;  Designed &amp; Developed with love by <a href="" target="_blank">Wanda Berlian Mardianti</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <script src="{{ asset('js/front/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/front/popper.min.js') }}"></script>
  <script src="{{ asset('js/front/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/front/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('js/front/jquery.animateNumber.min.js') }}"></script>
  <script src="{{ asset('js/front/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('js/front/jquery.fancybox.min.js') }}"></script>
  <script src="{{ asset('js/front/aos.js') }}"></script>
  <script src="{{ asset('js/front/moment.min.js') }}"></script>
  <script src="{{ asset('js/front/daterangepicker.js') }}"></script>
  <script src="{{ asset('js/front/typed.js') }}"></script>
  <!-- Scripts Required vendors -->
  <script src="{{ asset('vendor/global/global.min.js') }}"></script>
  <script src="{{ asset('js/custom.min.js') }}"></script>
  <script>
    $(function() {
      var slides = $('.slides'),
      images = slides.find('img');
      images.each(function(i) {
        $(this).attr('data-id', i + 1);
      })
      var typed = new Typed('.typed-words', {
        strings: [" incredible."," powerful."," strong.", " worth it."],
        typeSpeed: 80,
        backSpeed: 80,
        backDelay: 4000,
        startDelay: 1000,
        loop: true,
        showCursor: true,
        preStringTyped: (arrayPos, self) => {
          arrayPos++;
          console.log(arrayPos);
          $('.slides img').removeClass('active');
          $('.slides img[data-id="'+arrayPos+'"]').addClass('active');
        }
      });
    })
  </script>
  <script src="{{ asset('js/front/custom.js') }}"></script>
</body>

</html>
