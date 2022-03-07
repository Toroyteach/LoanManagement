@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Downloandable Forms
    </div>

    <div class="card-body">
        <div class="container-fluid">
                <h2 class="section-title"></h2>
            </div><br>
            <div class="row">
                <div class="icon-box col-md-4 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="title">Society By Laws</h4>
                        @if(!$files->isEmpty())
                        <div class="icon"><a href="{{ route('admin.files.download', $files[0]->uuid) }}"><i class="bx bx-download" style="font-size: 32px;"></i></a></div>                                   
                        @else
                        <div class="icon"><a href="#"><i class="bx bx-download" style="font-size: 32px;"></i></a></div>
                        @endif
                </div>
                <div class="icon-box col-md-4 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="title">Holiday Savings Form</h4>
                        @if(!$files->isEmpty())
                        <div class="icon"><a href="{{ route('admin.files.download', $files[1]->uuid) }}"><i class="bx bx-download" style="font-size: 32px;"></i></a></div>                                   
                        @else
                        <div class="icon"><a href="#"><i class="bx bx-download" style="font-size: 32px;"></i></a></div>
                        @endif
                </div>
                <div class="icon-box col-md-4 text-center" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="title">Loan Applications Form</h4>
                        @if(!$files->isEmpty())
                        <div class="icon"><a href="{{ route('admin.files.download', $files[2]->uuid) }}"><i class="bx bx-download" style="font-size: 32px;"></i></a></div>                                   
                        @else
                        <div class="icon"><a href="#"><i class="bx bx-download" style="font-size: 32px;"></i></a></div>
                        @endif
                </div>
            </div> <br>
    </div>
</div>




@endsection