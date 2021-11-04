@extends('frontend.app')
@section('content')


  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">

          <!-- Slide 1 -->
          <div class="carousel-item active" style="background: url({{asset('fronttheme/assets/img/slide/slide-1.jpg')}})">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">Welcome to <span>Mtangazaji Sacco</span></h2>
                <p class="animate__animated animate__fadeInUp">Mtangazaji Sacco was established 22 years ago on the 22nd April 1999 in accordance with the co-operative societies Act Cap 490 laws of Kenya by staff at the Kenya Broadcasting Corporation (KBC).</p>
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item" style="background: url({{asset('fronttheme/assets/img/slide/slide-2.jpg')}})">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated fanimate__adeInDown">our <span>Mission</span></h2>
                <p class="animate__animated animate__fadeInUp">To promote the financial well-being and economic interests of members through provision of affordable credit and promotion of a savings culture.</p>
              </div>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="carousel-item" style="background: url({{asset('fronttheme/assets/img/slide/slide-3.jpg')}})">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">our <span>Vision</span></h2>
                <p class="animate__animated animate__fadeInUp">To provide continuous financial education programs on prudent use of credit with a view to reduce poverty, promote human dignity and enhance the spirit of co-operation.</p>
              </div>
            </div>
          </div>

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

    <!-- ======= Featured Section ======= -->
    <!-- <section id="featured" class="featured">
      <div class="container">

        <div class="row">
          <div class="col-lg-4">
            <div class="icon-box">
              <i class="icofont-computer"></i>
              <h3><a href="">Lorem Ipsum</a></h3>
              <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="icon-box">
              <i class="icofont-image"></i>
              <h3><a href="">Dolor Sitema</a></h3>
              <p>Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
            </div>
          </div>
          <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="icon-box">
              <i class="icofont-tasks-alt"></i>
              <h3><a href="">Sed ut perspiciatis</a></h3>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
            </div>
          </div>
        </div>

      </div>
    </section> -->
    <!-- End Featured Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row">
          <div class="col-lg-6 pt-4 pt-lg-0 content">
            <h3>Our work.</h3>

            <p class="font-italic">
              To provide continuous financial education programs on prudent use of credit with a view to reduce poverty, promote human dignity and enhance the spirit of co-operation
            </p>

            <h4>Our Core Values.</h4>

            <div class="row">
              <div class="col-md-6">
                <ul>
                  <li><i class="icofont-check-circled"></i> Self Help.</li>
                  <li><i class="icofont-check-circled"></i> Honest.</li>
                  <li><i class="icofont-check-circled"></i> Self Responsibility.</li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul>
                  <li><i class="icofont-check-circled"></i> Equality.</li>
                  <li><i class="icofont-check-circled"></i> Equity.</li>
                </ul>
              </div>
            </div>

          </div>
          <div class="col-lg-6">
            <img src="{{ asset ( 'frontend/assets/img/slide/mtangaza2.jpg')}} " class="img-fluid" alt="">
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Our Responsibility</h2>
        </div>

        <div class="row">
          <div class="col-lg-6 col-md-6 d-flex align-items-stretch">
            <div class="icon-box">
            <div class="icon"><i class="bx bx-world"></i></div>
              <p style="font-size: 17px">To promote its members by affording them an opportunity for accumulating their savings and deposits</p>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 d-flex align-items-stretch">
            <div class="icon-box">
            <div class="icon"><i class="bx bx-world"></i></div>
              <p style="font-size: 17px">To ensure personal growth through the introduction of new products and services that will promote the economic base of the members.</p>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 d-flex align-items-stretch">
            <div class="icon-box">
            <div class="icon"><i class="bx bx-world"></i></div>
              <p style="font-size: 17px">To ensure progress of members and society through continuous education programs on proper use of credit, reduction of poverty, human dignity and co-operation</p>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 d-flex align-items-stretch">
            <div class="icon-box">
            <div class="icon"><i class="bx bx-world"></i></div>
              <p style="font-size: 17px">To apply the co-operative principle of co-operation among co-operatives in order to promote members’ interests</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

  </main><!-- End #main -->

  @endsection