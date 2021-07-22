@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="container_fluid" style="width:200px;height:auto">
            @if($user->avatar != 'default.jpg')
                        <img src="{{ asset( 'images/'.$user->avatar ) }}" width="40" height="40" class="rounded-circle">
                       @else
                        <img src="{{ asset( 'images/avatar.jpg' ) }}" width="40" height="40" class="rounded-circle">
                       @endif            </div><br>
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
                            ksh {{ $user->userAccount->total_amount }}
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
                        @elseif(\Carbon\Carbon::parse($user->monthlySavings->modified_at)->format('d F Y') === \Carbon\Carbon::now()->format('d F Y'))
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
            </div>
        </div>
    </div>
</div>
@endsection
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">


    function submitMonthly(id) {

        swal.fire({
            title: "Monthly Credit",
            icon: 'question',
            text: "{{ $user->firstname }} will be credited ksh {{ $user->monthlysavings->monthly_amount }}. Please ensure this, then confirm!",
            showCancelButton: !0,
            confirmButtonText: "Yes, Submit",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {

            if (e.value === true) {

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.monthly.update') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: "{{ $user->id }}",
                        amount: "{{ $user->monthlysavings->monthly_amount }}"
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