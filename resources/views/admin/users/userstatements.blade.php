@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Statements
    </div>

    <div class="card-body">
        <div class="container-fluid">
                <h2 class="section-title"></h2>
            </div><br>
            <div class="row">
                <div class="icon-box col-md-6 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="title">Monthly Contribution</h4>
                        <div class="icon">
                            <a class="btn btn-primary" href="{{ route('admin.users.pdf', 'monthly') }}">Download PDF</a>
                        </div>                                   
                </div>
                <div class="icon-box col-md-6 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="title">Loan Application</h4>
                    <div class="icon">
                            <a class="btn btn-primary" href="{{ route('admin.users.pdf', 'loan') }}">Download PDF</a>
                        </div> 
                </div>
            </div>
    </div>
</div>




@endsection