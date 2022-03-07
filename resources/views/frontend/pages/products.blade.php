@extends('frontend.app')
@section('content')

<main id="main">

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
  <div class="container">

    <ol>
      <li><a href="index.html">Home</a></li>
      <li>Products</li>
    </ol>
    <h2>Products</h2>

  </div>
</section><!-- End Breadcrumbs -->

<!-- ======= Our Skills Section ======= -->
<section id="skills" class="skills">
  <div class="container">

    <div class="section-title">
      <h2>Our Service Requirements</h2>
      <p>Every applicant for membership shall complete an application for membership form. This form shall be drawn to show all the information required for the purpose of registration of members.
      An applicant shall be admitted to membership on application upon payment of an entrance fee of kshs, 1000 and a minimum share deposit of kshs 2000. The following are qualifications for membership.</p>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <img src="{{ asset ( 'frontend/assets/img/slide/mtangaza3.jpg')}}" class="img-fluid" alt="">
      </div>
      <div class="col-lg-6 pt-1 content">

        <div class="skills-content">

          <div class="">
            <h4 class="">Elligibility </h4>
            <div class="">
              <p class="text"> Is within the field of membership consisting of the following common bond; employees of Kenya broadcasting corporation (KBC).</p>
            </div>
          </div>

          <div class="">
            <h4 class="">Age </h4>
            <div class="">
              <p class="text"> Has attained the age of 18 years.</p>
            </div>
          </div>

          <div class="">
            <h4 class="">character </h4>
            <div class="">
              <p class="text"> Is of good character and sound mind.</p>
            </div>
          </div>

          <div class="">
            <h4 class="">Registration </h4>
            <div class="">
              <p class="text"> Pays the entrance fee and share capital as prescribed in the by-laws provided that no member shall belong to more than one Sacco society having similar objects.</p>
            </div>
          </div>

        </div>

      </div>
    </div>

  </div>
</section><!-- End Our Skills Section -->

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

    <!-- ======= Services Section ======= -->
<section id="services" class="services">
  <div class="container">
    <div class="section-title">
          <h2>Our Products</h2>
        </div>

    <div class="row">
      
      <div class="col-lg-6 col-md-6 col-sm-12 d-flex align-items-stretch">
        <div class="icon-box">
          <div class="icon"><i class="bx bx-building"></i></div>
          <h4><a href="">Normal Loan</a></h4>
          <p>Payable Within a period of 36 months with an interest of 1% on reducing balance</p>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12 d-flex align-items-stretch mt-4 mt-md-0">
        <div class="icon-box">
          <div class="icon"><i class="bx bx-file"></i></div>
          <h4><a href="">School fee Loans</a></h4>
          <p>Payable Within a period of 12 months with an interest of 1% on reducing balance</p>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12 d-flex align-items-stretch mt-4">
        <div class="icon-box">
        <div class="icon"><i class="bx bx-save"></i></div>
          <h4><a href="">Emergency Loans</a></h4>
          <p>Payable Within a period of 12 months with an interest of 1% on reducing balance</p>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12 d-flex align-items-stretch mt-4">
        <div class="icon-box">
          <div class="icon"><i class="bx bx-world"></i></div>
          <h4><a href="">Instant Loan</a></h4>
          <p>Payable Within a period of 6 months with an interest of 10% once</p>
        </div>
      </div>

    </div>

  </div>
</section><!-- End Services Section -->

</main><!-- End #main -->

@endsection