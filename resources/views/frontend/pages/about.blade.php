@extends('frontend.app')
@section('content')

<main id="main">

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
  <div class="container">

    <ol>
      <li><a href="index.html">Home</a></li>
      <li>About Us</li>
    </ol>
    <h2>About Us</h2>

  </div>
</section><!-- End Breadcrumbs -->

<!-- ======= About Section ======= -->
<section id="about" class="about">
  <div class="container">

    <div class="row">
      <div class="col-lg-6">
        <img src="{{ asset ( 'frontend/assets/img/slide/mtangaza2.jpg')}}" class="img-fluid" alt="">
      </div>
      <div class="col-lg-6 pt-4 pt-lg-0 content">
        <h3>About Mtangazaji Sacco.</h3>
        <p class="">
        Mtangazaji Sacco was established 22 years ago on the 22nd April 1999 in accordance with the co-operative societies 
          Act Cap 490 laws of Kenya by staff at the Kenya Broadcasting Corporation (KBC).
        </p>
        <p>
          It has since expanded its horizons to accommodate members from different sectors of the economy with a common interest of cooperation in financial matters.
        </p>
      </div>
    </div>

  </div>
</section><!-- End About Section -->

<!-- ======= Counts Section ======= -->
<section id="counts" class="counts">
  <div class="container">

    <div class="row no-gutters">

      <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
        <div class="count-box">
          <i class="icofont-simple-smile"></i>
          <span data-toggle="counter-up">232</span>
          <p><strong>Happy Members</strong></p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
        <div class="count-box">
          <i class="icofont-document-folder"></i>
          <span data-toggle="counter-up">521</span>
          <p><strong>Years Experience</strong></p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
        <div class="count-box">
          <i class="icofont-live-support"></i>
          <span data-toggle="counter-up">1,463</span>
          <p><strong>Year we Started</strong></p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
        <div class="count-box">
          <i class="icofont-users-alt-5"></i>
          <span data-toggle="counter-up">15</span>
          <p><strong>Member Workers</strong></p>
        </div>
      </div>

    </div>

  </div>
</section><!-- End Counts Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container">

        <div class="row">

          <div class="col-lg-6">
            <div class="testimonial-item">
              <h3>Our Mission</h3>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  To promote the financial well-being and economic interests of members through provision of affordable credit and promotion of a savings culture.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="testimonial-item mt-4 mt-lg-0">
              <h3>Our Vision</h3>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  To provide continuous financial education programs on prudent use of credit with a view to reduce poverty, promote human dignity and enhance the spirit of co-operation.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="testimonial-item text-center mt-6">
              <h3>Our Core Values</h3>
              <p>
                <ul style="list-style-type:none;">
                  <li><i class="icofont-check-circled"></i> Honesty</li>
                  <li><i class="icofont-check-circled"></i> Self help</li>
                  <li><i class="icofont-check-circled"></i> Mutual Responsibility</li>
                  <li><i class="icofont-check-circled"></i> Equality</li>
                  <li><i class="icofont-check-circled"></i> Equity</li>
                  
                </ul>
              </p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Testimonials Section -->

</main><!-- End #main -->

@endsection