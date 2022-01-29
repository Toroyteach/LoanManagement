@extends('layouts.admin')
@section('content')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                    @if( $user == 'admin' )
                        <h5 class="card-title mb-0">Total Deposits</h5>
                    @else
                        <h5 class="card-title mb-0">Monthly contribution</h5>
                    @endif
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                @if( $user == 'admin' )
                                    <h2 class="d-flex align-items-center mb-0" id="amount">ksh{{ $savings ?? '0.00' }}</h2>
                                @else
                                    <h2 class="d-flex align-items-center mb-0" id="amount">ksh{{ $savings['total_contributed'] ?? '0.00' }}</h2>
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
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                        @if( $user == 'admin' )
                            <h5 class="card-title mb-0">Loan Book</h5>
                        @else
                            <h5 class="card-title mb-0">Pending Loan</h5>
                        @endif
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0" id="amount">
                                ksh{{ $loan_pending ?? '0.00' }}
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
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="card l-bg-green-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Total Paid</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0" id="amount">
                                ksh{{ $amount_paid ?? '0.00' }}
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
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
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
                            <h2 class="d-flex align-items-center mb-0" id="amount">
                                ksh{{ $approved_loan ?? '0.00' }}
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
        <div class="card bg-default col-xs-12 col-sm-12 col-md-6 col-lg-6" id="chartLoans">
            <div class="card-body">
            <h5 class="card-title">Loans</h5>
                <div class="chart">
                    <!-- Chart wrapper -->
                    <canvas id="myChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="card bg-default col-xs-12 col-sm-12 col-md-6 col-lg-4">
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

@if(!\Auth::user()->is_member)
    <div class="container-fluid" id="chartMembers">
        <div class="row justify-content-around">
            <div class="card bg-default col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
                <div class="card-body">
                <h5 class="card-title">Top Ten Member Loans Requests</h5>
                    <div class="chart">
                        <!-- Chart wrapper -->
                        <canvas id="myChart3" width="400" height="auto"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    
console.log('rand'+Math.pow(10, 8));
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
    var data2 = {!! $pie !!}
    var myChart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Emergency', 'SchoolFees', 'Development', 'InstantLoan'],
            datasets: [{
                label: 'Loan type share',
                data: data2,
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

    const MEMBERS = {!! $members_json !!};


    var ctx3 = document.getElementById('myChart3').getContext('2d');
    var dataAmountLoaned = {!! $membersAquiredLoans_json !!}
    var dataCurrentAmount = {!! $membersActiveLoans_json !!}
    var myChart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: MEMBERS,
            datasets: [
                {
                label: 'Total Amount Loaned',
                data: dataAmountLoaned,
                backgroundColor: 'rgb(28, 97, 36)',
                },
                {
                    label: 'Current Loan',
                data: dataCurrentAmount,
                backgroundColor: 'rgb(201, 35, 22)',
                },
            ]
        },
        responsive: true,
        scales: {
            x: {
                stacked: true,
            },
            y: {
                stacked: true
            }
        },
    });

});
</script>

@endsection
