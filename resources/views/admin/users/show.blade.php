@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="container_fluid" style="width:200px;height:auto">
                    @if($user->avatar != "default.jpg")
                        <img src="{{ asset( 'img/uploads/profileavatar/'.$user->avatar ) }}" width="40" height="40" class="rounded-circle">
                       @else
                        <img src="{{ asset( 'images/avatar.jpg' ) }}" width="40" height="40" class="rounded-circle">
                       @endif            
            </div><br>
            <div class="row">
                <div class="form-group col-md-6">
                    <a class="btn btn-primary" href="{{ route('admin.users.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                    @can('update_monthly_contribution')
                        @if(empty($user->monthlySavings->modified_at))
                        <div class="form-group col-md-6">
                                    <a class="btn btn-success" onclick="submitMonthly()">
                                        {{ trans('global.monthlyupdate') }}
                                    </a>
                                </div>
                        @elseif(\Carbon\Carbon::parse($user->monthlySavings->modified_at)->format('F Y') === \Carbon\Carbon::now()->format('F Y'))
                        <div class="form-group col-md-6">
                                <a class="btn btn-warning" disabled>
                                    {{ trans('global.monthlyupdatedisable') }}
                                </a>
                            </div>
                        @else
                        <div class="form-group col-md-6">
                                    <a class="btn btn-success" onclick="submitMonthly()">
                                        {{ trans('global.monthlyupdate') }}
                                    </a>
                                </div>
                        @endif
                    @endcan
            </div><br>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
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
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <td>
                            @if(empty($user->email_verified_at))
                                <span class="badge badge-danger"> Not Verified</span>
                            @else
                                {{ $user->email_verified_at }}
                            @endif

                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.nationalid') }}
                        </th>
                        <td>
                            {{ $user->nationalid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.idno') }}
                        </th>
                        <td>
                            {{ $user->idno }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.address') }}
                        </th>
                        <td>
                            {{ $user->address }}
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
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="badge badge-success">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.accountbal') }}
                        </th>
                        <td>
                            ksh {{ $user->userAccount['total_amount'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.currentloan') }}
                        </th>
                        <td>
                            @if(!empty($currentLoanAmount))
                                @if ($currentLoanAmount->status_id === 1)
                                    ksh 0.00
                                @elseif($currentLoanAmount->status_id === 8)
                                    ksh {{ $currentLoanAmount->loan_amount }}
                                @elseif($currentLoanAmount->status_id === 10)
                                    ksh {{ $currentLoanAmount->loan_amount }}
                                @else
                                    ksh0.00
                                @endif
                            @else
                                ksh0.00
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.currentloantype') }}
                        </th>
                        <td>
                            @if(!empty($currentLoanAmount))
                                @if(Auth::user()->getIsAdminAttribute())
                                    <span class="badge  badge-pill badge-info">{{ $currentLoanAmount->loan_type }}</span>
                                @else
                                    @if ($currentLoanAmount->status_id === 8)
                                    <span class="badge  badge-pill badge-info">{{ $currentLoanAmount->loan_type }}</span>
                                    @else
                                    
                                    @endif
                                @endif
                            @else
                                null
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="container-fluid">
                <h2 class="section-title"> Current Loans</h2>
            </div>
            <div class="card">

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
                                        Loan Id
                                    </th>
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.loan_amount') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.description') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.loanApplication.fields.status') }}
                                    </th>
                                    <th>
                                        Loan Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($loanApplications as $key => $loanApplication)
                                    <tr data-entry-id="{{ $loanApplication->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ 1+$key++ }}
                                        </td>
                                        <td>
                                            {{ $loanApplication->loan_entry_number ?? '' }}
                                        </td>
                                        <td>
                                            {{ $loanApplication->loan_amount ?? '' }}
                                        </td>
                                        <td>
                                            {{ $loanApplication->description ?? '' }}
                                        </td>
                                        <td>
                                            @if(in_array($loanApplication->status_id, [7, 4, 9]))
                                                <span class="badge badge-danger">Rejected</span>
                                            @else
                                                @if($loanApplication->status_id === 8)
                                                    <span class="badge badge-success">{{ $loanApplication->status->name }}</span>
                                                @else
                                                    <span class="badge badge-info">{{ $user->is_user && $loanApplication->status_id < 8 ? 'Processing' : $loanApplication->status->name }}</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{ $loanApplication->loan_type }}
                                        </td>

                                    </tr>
                                @empty

                                    No Current Records

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><br>

            <div class="container-fluid">
                    <h2 class="section-title"> Guranteed Loans</h2>
            </div>
    
            <div class="card">
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
                                    Loan Id
                                </th>
                                <th>
                                    {{ trans('cruds.loanApplication.fields.loan_amount') }}
                                </th>
                                <th>
                                    {{ trans('cruds.loanApplication.fields.description') }}
                                </th>
                                <th>
                                    {{ trans('cruds.loanApplication.fields.status') }}
                                </th>
                                <th>
                                    Loan Type
                                </th>
                                <th>
                                    Loan Applicant Name
                                </th>
                                <th>
                                    Applicant Member No
                                </th>
    
                                <th>
                                    Member Applicant Number
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gurantors as $key => $gurantor)
                                <tr>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>
                                        {{ $gurantor->loan->loan_entry_number }}
                                    </td>
                                    <td>
                                        {{ $gurantor->loan->loan_amount }}
                                    </td>
                                    <td>
                                        {{ $gurantor->loan->description }}
                                    </td>
                                    <td>
                                        {{ $gurantor->loan->status->name }}
                                    </td>
                                    <td>
                                        {{ $gurantor->loan->loan_type }}
                                    </td>
                                    <td>
                                        {{ $gurantor->loan->created_by->name }}
                                    </td>
                                    <td>
                                        {{ $gurantor->loan->created_by->idno }}
                                    </td>
                                    <td>
                                        {{ $gurantor->loan->created_by->number }}
                                    </td>
    
                                </tr>
                        @empty
                                <p class="alert alert-warning">Sorry you do not have any loan gurantees yet</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>

        <div class="container-fluid">
                <h2 class="section-title"> Next of Kin</h2>
            </div>

            <div class="card">
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
                                    <tr>
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
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">


    function submitMonthly() {
        
        let fullScreenLoader = document.getElementById("fullLoader");

        swal.fire({
            title: "Monthly Credit",
            icon: 'question',
            text: "{{ $user->firstname }} will be credited ksh {{ $user->monthlysavings->monthly_amount ?? '' }}. Please ensure this, then confirm!",
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

            const value = document.getElementById("swal2-input").value; 
            
            if (e.isConfirmed) {

                //console.log(value);
                fullScreenLoader.style.display = "block";

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.monthly.update') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: "{{ $user->id }}",
                        amount: value
                        },
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.response === true) {

                            swal.fire("Done!", results.message, "success");
                            fullScreenLoader.style.display = "none";
                            // refresh page after 2 seconds
                            setTimeout(function(){
                                location.reload();
                            },3000);

                        } else if(results.response === false) {

                            swal.fire("Error!", results.failure, "error");
                            fullScreenLoader.style.display = "none";

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