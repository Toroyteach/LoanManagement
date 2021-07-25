@extends('layouts.admin')
@section('content')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                    @if( $user == 'admin' )
                        <h5 class="card-title mb-0">Sacco Total Amount</h5>
                    @else
                        <h5 class="card-title mb-0">Monthly contribution</h5>
                    @endif
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                @if( $user == 'admin' )
                                    <h2 class="d-flex align-items-center mb-0">ksh{{ $savings }}</h2>
                                @else
                                    <h2 class="d-flex align-items-center mb-0">ksh{{ $savings['total_contributed'] }}</h2>
                                @endif
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>12.5% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <!-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Pending Loans</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                ksh{{ $loan_pending }}
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>9.23% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <!-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
            <div class="card l-bg-green-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Total Paid</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                ksh{{ $amount_paid }}
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>10% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <!-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
            <div class="card l-bg-orange-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                        @if( $user == 'admin' )
                            <h5 class="card-title mb-0">Total Approved Loan</h5>
                        @else
                            <h5 class="card-title mb-0">Approved Loan Balance</h5>
                        @endif
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                ksh{{ $approved_loan }}
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>2.5% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <!-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-around">
        <div class="card bg-default col-md-6">
            <div class="card-body">
            <h5 class="card-title">Loans</h5>
                <div class="chart">
                    <!-- Chart wrapper -->
                    <canvas id="myChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="card bg-default col-md-4 align-self-end">
            <div class="card-body">
            <h5 class="card-title">Loan Types Share</h5>
                <div class="chart">
                    <!-- Chart wrapper -->
                    <canvas id="myChart2" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">

$(document).ready(function(){

    //const labels = Utils.months({count: 7});
    var ctx = document.getElementById('myChart').getContext('2d');
    var data = {!! $line !!};
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Loans Disbursed this Month',
                data: data,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var data = {!! $pie !!}
    var myChart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Emergency', 'SchoolFees', 'Development', 'TopUp'],
            datasets: [{
                label: 'Loan type share',
                data: data,
                backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(34,139,34)',
                'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        },
    });

});
</script>
