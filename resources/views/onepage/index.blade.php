<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Mtangazaji | Sacco</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset ( 'frontend/assets/img/favicon.png')}}" rel="icon">
  <link href="{{ asset ( 'frontend/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i,900" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset ( 'frontend/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'frontend/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'frontend/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'frontend/assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'frontend/assets/vendor/venobox/venobox.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'frontend/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{ asset ( 'frontend/assets/vendor/aos/aos.css')}}" rel="stylesheet">

  <link href="{{ asset ( 'frontend/assets/css/style.css')}}" rel="stylesheet">
  <!-- =======================================================
  * Template Name: Mamba - v2.5.1
  * Template URL: https://bootstrapmade.com/mamba-one-page-bootstrap-template-free/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container clearfix">
      <div class="contact-info float-left">
        <i class="icofont-envelope"></i><a href="mailto:contact@example.com">mtangazajisacco@gmail.com</a>
        <i class="icofont-phone"></i> +254 726616120
      </div>
      <div class="social-links float-right">
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
    <div class="container">

      <div class="logo float-left">
        <!-- <h2 class="text-light"><a href="index.html">Mtangazaji<span> Sacco</span></a></h2> -->
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href=""><img src="{{ asset ( 'onepage/logo.jpeg')}}" width="100" height="200" alt="" class="img-responsive"></a>
      </div>

      <nav class="nav-menu float-right d-none d-lg-block">
        <ul>
          <li class="active"><a href="{{ route('index')}}">Home</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#contact">Contact Us</a></li>
          <li><a href="{{ route('login')}}">Member Login</a></li>
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">

          <!-- Slide 1 -->
          <div class="carousel-item active" style="background-image: url('{{ asset ( 'frontend/assets/img/slide/mtangaza2.jpg')}}');">
            <div class="carousel-container">
              <div class="carousel-content container">
                <h2 class="animate__animated animate__fadeInDown">Mtangazaji <span>Sacco</span></h2>
                <p class="animate__animated animate__fadeInUp">The Sacco was formed and established on 22nd April 1999 and is located at Harry Thuku Road.</p>
                <!-- <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a> -->
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item" style="background-image: url('{{ asset ( 'frontend/assets/img/slide/mtangaza3.jpg')}}');">
            <div class="carousel-container">
              <div class="carousel-content container">
                <h2 class="animate__animated animate__fadeInDown"></h2>
                <p class="animate__animated animate__fadeInUp">The Sacco draws its membership within the Kenya Broadcasting Corporation (KBC) employees.</p>
                <!-- <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a> -->
              </div>
            </div>
          </div>

          <!-- Slide 3 -->
          <!-- <div class="carousel-item" style="background-image: url('{{ asset ( 'frontend/assets/img/slide/slide-3.jpg')}}');">
            <div class="carousel-container">
              <div class="carousel-content container">
                <h2 class="animate__animated animate__fadeInDown">Sequi ea ut et est quaerat</h2>
                <p class="animate__animated animate__fadeInUp">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam. Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus deleniti vel. Minus et tempore modi architecto.</p>
                <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
              </div>
            </div>
          </div> -->

        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon icofont-rounded-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon icofont-rounded-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row no-gutters">
          <div class="col-lg-6 video-box">
            <img src="{{ asset ( 'frontend/assets/img/slide/mtangaza1.jpg')}}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 d-flex flex-column justify-content-center about-content">

            <div class="section-title">
              <h2>About Us</h2>
              <p>The objectives for which the society is established are to organize and promote the welfare and economic interest of its members.</p>
            </div>

            <div class="icon-box " data-aos="fade-up" data-aos-delay="100">
              <h4 class="title">Loan Application Form</h4>
              <div class="icon"><a href="{{ route('files.download', $file[1]->uuid) }}"><i class="bx bx-download"></i></a></div>
              <!-- <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p> -->
            </div>

            <div class="icon-box " data-aos="fade-up" data-aos-delay="100">
              <h4 class="title">Membership Application Form</h4>
              <div class="icon"><a href="#"><i class="bx bx-download"></i></a></div>
              <!-- <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p> -->
            </div>

            <div class="icon-box " data-aos="fade-up" data-aos-delay="100">
              <h4 class="title">Society By Laws</h4>
              <div class="icon"><a href="{{ route('files.download', $file[0]->uuid) }}"><i class="bx bx-download"></i></a></div>
              <!-- <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p> -->
            </div>

          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= About Lists Section ======= -->
    <section class="about-lists">
      <div class="container">

      <div class="section-title">
          <h3>In particular, the Sacco shall undertake:</h3>
        </div>

        <div class="row no-gutters">

          <div class="col-lg-3 col-md-4 col-sm-6 content-item" data-aos="fade-up">
            <span>01</span>
            <!-- <h4>Lorem Ipsum</h4> -->
            <p style="color:#222;">To promote its members by affording them an opportunity for accumulating their savings and deposits</p>
          </div>

          <div class="col-lg-3 col-md-4 col-sm-6 content-item" data-aos="fade-up" data-aos-delay="100">
            <span>02</span>
            <!-- <h4>Repellat Nihil</h4> -->
            <p style="color:#222;">To ensure personal growth through the introduction of new products and services that will promote the economic base of the members.</p>
          </div>

          <div class="col-lg-3 col-md-4 col-sm-6 content-item" data-aos="fade-up" data-aos-delay="200">
            <span>03</span>
            <!-- <h4> Ad ad velit qui</h4> -->
            <p style="color:#222;">To ensure progress of members and society through continuous education programs on proper use of credit, reduction of poverty, human dignity and co-operation</p>
          </div>

          <div class="col-lg-3 col-md-4 col-sm-6 content-item" data-aos="fade-up" data-aos-delay="300">
            <span>04</span>
            <!-- <h4>Repellendus molestiae</h4> -->
            <p style="color:#222;">To apply the co-operative principle of co-operation among co-operatives in order to promote members’ interests</p>
          </div>

        </div>

      </div>
    </section><!-- End About Lists Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          <h2>Loan Services</h2>
          <p>There are three loans available that is emergency loan, school fees loan and development loans. 
          Every applicant for membership shall complete an application for membership form. This form shall be drawn to show all the information required for the purpose of registration of members.</p>
          <p>An applicant shall be admitted to membership on application upon payment of an entrance fee of kshs, 1000 and a minimum share deposit of kshs 2000. The following are qualifications for membership</p>
        </div><br><br><br>


        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6 icon-box" data-aos="fade-up">
            <!-- <div class="icon"><i class="icofont-computer"></i></div> -->
            <h4 class="title"><a href="">Elligibility</a></h4>
            <p class="description">Is within the field of membership consisting of the following common bond; employees of Kenya broadcasting corporation (KBC).</p>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 icon-box" data-aos="fade-up" data-aos-delay="100">
            <!-- <div class="icon"><i class="icofont-chart-bar-graph"></i></div> -->
            <h4 class="title"><a href="">Age</a></h4>
            <p class="description">Has attained the age of 18 years</p>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 icon-box" data-aos="fade-up" data-aos-delay="200">
            <!-- <div class="icon"><i class="icofont-earth"></i></div> -->
            <h4 class="title"><a href="">character</a></h4>
            <p class="description">Is of good character and sound mind</p>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-6 icon-box" data-aos="fade-up" data-aos-delay="300">
            <!-- <div class="icon"><i class="icofont-image"></i></div> -->
            <h4 class="title"><a href="">Registration</a></h4>
            <p class="description">Pays the entrance fee and share capital as prescribed in the by-laws provided that no member shall belong to more than one Sacco society having similar objects</p>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Lending Requirements</h2>
        </div>

        <div class="row  d-flex align-items-stretch">

          <div class="col-lg-6 faq-item" data-aos="fade-up">
            <h1><i class="icofont-checked"></i></h1>
            <p>
            Be an active member of the Sacco with regular deposit contribution.
            </p>
          </div>

          <div class="col-lg-6 faq-item" data-aos="fade-up" data-aos-delay="100">
          <h1><i class="icofont-checked"></i></h1>
            <p>
            Must have paid (or is paying) the minimum share capital requirements by the Sacco.
            </p>
          </div>

          <div class="col-lg-6 faq-item" data-aos="fade-up" data-aos-delay="200">
          <h1><i class="icofont-checked"></i></h1>
            <p>
            Must be a member of the Sacco for at least 6 months.
            </p>
          </div>

          <div class="col-lg-6 faq-item" data-aos="fade-up" data-aos-delay="300">
          <h1><i class="icofont-checked"></i></h1>
            <p>
            Must have a regular source of income to support loan repayment (salary, business etc).
            </p>
          </div>

          <div class="col-lg-6 faq-item" data-aos="fade-up" data-aos-delay="400">
          <h1><i class="icofont-checked"></i></h1>
            <p>
            Must provide security for the loan applied for such as guarantors etc.
            </p>
          </div>

          <div class="col-lg-6 faq-item" data-aos="fade-up" data-aos-delay="500">
          <h1><i class="icofont-checked"></i></h1>
            <p>
            All deductions should not exceed1/3 of gross salary.
            </p>
          </div>

          <div class="col-lg-6 faq-item" data-aos="fade-up" data-aos-delay="500">
          <h1><i class="icofont-checked"></i></h1>
            <p>
            Most current pay slip certified by the employer.
            </p>
          </div>

        </div>

        <div class="section-title">
              <h2>Interest</h2>
              <p>The interest rate applicable for loan is 1% on reducing balance.</p>
            </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Us Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact Us</h2>
        </div>

        <div class="row">

          <div class="col-lg-6 d-flex align-items-stretch" data-aos="fade-up">
            <div class="info-box">
              <i class="bx bx-map"></i>
              <h3>Our Address</h3>
              <p>Harry Thuku Road, P.O Box 303456-00100, Nairobi</p>
            </div>
          </div>

          <div class="col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="info-box">
              <i class="bx bx-envelope"></i>
              <h3>Email Us</h3>
              <p><br>mtangazajisacco@gmail.com</p>
            </div>
          </div>

          <div class="col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="info-box ">
              <i class="bx bx-phone-call"></i>
              <h3>Call Us</h3>
              <p>+254726616120</p>
            </div>
          </div>

          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="300">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="form-row">
                <div class="col-lg-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validate"></div>
                </div>
                <div class="col-lg-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Us Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>Mtangazaji Sacco</h3>
            <p>
            This Sacco was formed and established on 22nd April 1999 and is located at Harry Thuku Road.
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-info">
            <h4>Contact us</h4>
            <p>
              NBI 30456-00100, Nairobi<br><br>
              <strong>Phone:</strong> +254726616120<br>
              <strong>Email:</strong> mtangazajisacco@gmail.com<br>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('index')}}">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Social Links</h4>
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
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset ( 'frontend/assets/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/jquery-sticky/jquery.sticky.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/venobox/venobox.min.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/counterup/counterup.min.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset ( 'frontend/assets/vendor/aos/aos.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset ( 'frontend/assets/js/main.js')}}"></script>

</body>

</html>