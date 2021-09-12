<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ trans('panel.site_title') }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset ( 'onepage/logo.jpeg')}}" rel="icon">
  <link href="{{ asset ( 'onepage/logo.jpeg')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset ( 'fronttheme/assets/vendor/bootstrap/css/bootstrap.min.css')}} " rel="stylesheet">
  <link href="{{ asset ( 'fronttheme/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'fronttheme/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'fronttheme/assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'fronttheme/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'fronttheme/assets/vendor/venobox/venobox.css')}}" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

  <!-- Template Main CSS File -->
  <link href="{{ asset ( 'fronttheme/assets/css/style.css')}}" rel="stylesheet">
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container d-flex">
      <div class="contact-info mr-auto">
        <i class="icofont-envelope"></i><a href="mailto:mtangazajisacco@gmail.com">mtangazajisacco@gmail.com</a>
        <i class="icofont-phone"></i> +254 726616120
      </div>
      <div class="social-links">
        <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
        <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
        <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
        <a href="#" class="skype"><i class="icofont-skype"></i></a>
        <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
      </div>
    </div>
  </section>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container d-flex">

      <div class="logo mr-auto">
        <!-- <h1 class="text-light"><a href="index.html"><span>Eterna</span></a></h1> -->
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="{{ route('index')}}"><img src="{{ asset ( 'onepage/logo.jpeg')}}" width="100" height="200" alt="" class="img-responsive"></a>
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="{{ route('index')}}">Home</a></li>

          <li class="drop-down"><a href="javascript:void(0)">About</a>
            <ul>
              <li><a href="{{ route('about')}}">About Us</a></li>
              <li><a href="{{ route('team')}}">Team</a></li>

              <!-- <li class="drop-down"><a href="#">Drop Down 2</a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li> -->

            </ul>
          </li>

          <li><a href="{{ route('products')}}">Products</a></li>
          <li><a href="{{ route('resources')}}">Resources</a></li>
          <li><a href="{{ route('contact')}}">Contact Us</a></li>
          <li><a href="{{ route('login')}}">Member Login</a></li>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  @yield('content')

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Resources</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Member Login</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Society Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> Emergency Loan</li>
              <li><i class="bx bx-chevron-right"></i> Developments Loan</li>
              <li><i class="bx bx-chevron-right"></i> Retirement Savings</li>
              <li><i class="bx bx-chevron-right"></i> Holiday Savings</li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              Harry Thuku Road <br>
              P.O BOX 303456-00100<br>
              Nairobi <br><br>
              <strong>Phone:</strong> +254726616120<br>
              <strong>Email:</strong> mtangazajisacco@gmail.com<br>
            </p>

          </div>

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>About Mtangazaji</h3>
            <p>This Sacco was formed and established on 22nd April 1999 and is located at Harry Thuku Road.</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Bellenortherdynamics</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://bellenorthedynamics.com" target="_blank">Bellenorthe Dynamics</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset ( 'fronttheme/assets/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset ( 'fronttheme/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset ( 'fronttheme/assets/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
  <script src="{{ asset ( 'fronttheme/assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset ( 'fronttheme/assets/vendor/jquery-sticky/jquery.sticky.js')}}"></script>
  <script src="{{ asset ( 'fronttheme/assets/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
  <script src="{{ asset ( 'fronttheme/assets/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
  <script src="{{ asset ( 'fronttheme/assets/vendor/counterup/counterup.min.js')}}"></script>
  <script src="{{ asset ( 'fronttheme/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset ( 'fronttheme/assets/vendor/venobox/venobox.min.js')}}"></script>
  <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset ( 'fronttheme/assets/js/main.js')}}"></script>

</body>

</html>