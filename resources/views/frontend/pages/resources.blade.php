@extends('frontend.app')
@section('content')

<main id="main">

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
  <div class="container">

    <ol>
      <li><a href="index.html">Home</a></li>
      <li>Resources</li>
    </ol>
    <h2>Resources</h2>

  </div>
</section><!-- End Breadcrumbs -->

<!-- ======= Pricing Section ======= -->
<section id="pricing" class="pricing">
  <div class="container">

    <div class="row no-gutters">

      <div class="col-lg-4 box">
        <h3>Free</h3>
        <h4>$0<span>per month</span></h4>
        <ul>
          <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
          <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
          <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
          <li class="na"><i class="bx bx-x"></i> <span>Pharetra massa massa ultricies</span></li>
          <li class="na"><i class="bx bx-x"></i> <span>Massa ultricies mi quis hendrerit</span></li>
        </ul>
        <a href="#" class="buy-btn">Buy Now</a>
      </div>

      <div class="col-lg-4 box featured">
        <h3>Business</h3>
        <h4>$29<span>per month</span></h4>
        <ul>
          <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
          <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
          <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
          <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
          <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
        </ul>
        <a href="#" class="buy-btn">Buy Now</a>
      </div>

      <div class="col-lg-4 box">
        <h3>Developer</h3>
        <h4>$49<span>per month</span></h4>
        <ul>
          <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
          <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
          <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
          <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
          <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
        </ul>
        <a href="#" class="buy-btn">Buy Now</a>
      </div>

    </div>

  </div>
</section><!-- End Pricing Section -->

</main><!-- End #main -->

@endsection