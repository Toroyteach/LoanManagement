@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
                <div class="row">
                    <div class="form-group col-md-6">
                        <a class="btn btn-primary" href="{{ route('admin.dashboard') }}">
                            {{ trans('global.dashboard') }}
                        </a>
                    </div>
                    <div class="form-group col-md-6">
                        @if($user->is_Member)
                        <a class="btn btn-warning" href="{{ route('admin.users.profile', $user->id) }}">
                            {{ trans('global.edit_profile') }} 
                            <!-- for admin take to admin edit for memeber take to memeber update -->
                        </a>
                        @else
                        <a class="btn btn-warning" href="{{ route('admin.admin.profile', $user->id) }}">
                            {{ trans('global.edit_profile') }} 
                            <!-- for admin take to admin edit for memeber take to memeber update -->
                        </a>
                        @endif

                    </div>
                </div>
            <div class="container_fluid" style="width:300px;height:auto">
                       @if(Auth::user()->avatar != 'default.jpg')
                        <img src="{{ asset( 'img/uploads/profileavatar/'.Auth::user()->avatar ) }}" width="40" height="40" class="rounded-circle">
                       @else
                        <img src="{{ asset( 'images/avatar.jpg' ) }}" width="40" height="40" class="rounded-circle">
                       @endif            </div><br>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.firstname') }}
                        </th>
                        <td>
                            {{ $user->firstname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.middlename') }}
                        </th>
                        <td>
                            {{ $user->middlename }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.lastname') }}
                        </th>
                        <td>
                            {{ $user->lastname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.memberno') }}
                        </th>
                        <td>
                            {{ $user->idno }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.dob') }}
                        </th>
                        <td>
                            {{ $user->dateofbirth }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.dojoined') }}
                        </th>
                        <td>
                            {{ $user->joinedsacco }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.accountbal') }}
                        </th>
                        <td>
                            ksh {{ $user->userAccount['total_amount'] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.totalmonthlysavings') }}
                        </th>
                        <td>
                            ksh {{ $totalmonthlysavings }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.monthlyamount') }}
                        </th>
                        <td>
                            ksh {{ $user->monthlySavings['monthly_amount']  ?? '' }}   
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.currentloan') }}
                        </th>
                        <td>
                            @if(!empty($currentLoanAmount))
                                ksh {{ $currentLoanAmount }}
                            @else
                                ksh 0.00
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table><br>


            <div class="container-fluid">
                <h2 class="section-title"> Next of Kin</h2>
            </div>

            <div class="card-body">
                    <div class="table-responsive tile-body table-responsive-md table-responsive-lg table-responsive-xl table-responsive-sm">
                        <table class="table table-bordered table-striped table-hover datatable datatable-LoanApplication">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.id') }}
                                    </th>
                                    <th>
                                        Kin Name
                                    </th>
                                    <th>
                                        Phone Number
                                    </th>
                                    <th>
                                        Relationship
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kins as $key => $kin)
                                    <tr data-entry-id="">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $key+1 }}
                                        </td>
                                        <td>
                                            {{ $kin->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $kin->phone ?? '' }}
                                        </td>
                                        <td>
                                            {{ $kin->relationship ?? '' }}
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        No Records to show
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><br>

        </div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">


    function updateMonthlyAmount($id) {


            swal.fire({
            title: "Update Monthly Contribution",
            icon: 'warning',
            text: "Are you sure you want to update your monthly contribution. Please ensure this, then confirm!",
            input: 'range',
            inputAttributes: {
                min: 1000,
                max: 20000,
                step: 500,
            },
            inputValue: "{{ $user->monthlysavings->monthly_amount ?? '' }}",
            inputLabel: "Amount",
            showCancelButton: !0,
            confirmButtonText: "Yes, Submit",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
            }).then(function (e) {


                if (e.isConfirmed) {

                    const value = document.getElementById("swal2-input").value; 

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.monthly.update.amount') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: "{{ $user->id }}",
                            amount: value
                            },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.response === true) {

                                swal.fire("Done!", results.message, "success");
                                // refresh page after 2 seconds
                                setTimeout(function(){
                                    location.reload();
                                },3000);

                            } else if(results.response === false) {

                                swal.fire("Error!", results.failure, "error");

                            }
                        }
                    });

                } else {
                    
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })


    }

</script>
@endsection