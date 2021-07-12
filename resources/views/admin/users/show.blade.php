@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="container_fluid" style="width:200px;height:auto">
                <img src="{{ asset( 'images/'.$user->avatar ) }}" class="img-thumbnail" alt="profile image"> 
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
                            {{ $user->email_address }}
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
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.accountbal') }}
                        </th>
                        <td>
                            {{ $user->userAccount->total_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.currentloan') }}
                        </th>
                        <td>
                            {{ $currentLoanAmount }}
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
                <div class="form-group col-md-6">
                    <a class="btn btn-success" onclick="submitMonthly()">
                        {{ trans('global.monthlyupdate') }}
                    </a>
                </div>
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
            text: "{{ $user->firstname }} will be credited ksh 20000. Please ensure and then confirm!",
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
                        amount: 20000
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