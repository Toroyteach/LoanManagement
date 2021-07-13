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
                        <a class="btn btn-warning" href="{{ route('profile.password.edit') }}">
                            {{ trans('global.edit_profile') }}
                        </a>
                    </div>
                </div>
            <div class="container_fluid" style="width:200px;height:auto">
                       @if(Auth::user()->avatar != 'default.jpg')
                        <img src="{{ asset( 'images/'.Auth::user()->avatar ) }}" width="40" height="40" class="rounded-circle">
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
                            {{ $user->email_verified_at }}
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
                            {{ $user->userAccount->total_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.currentloan') }}
                        </th>
                        <td>
                            @if(!empty($currentLoanAmount))
                                @if ($currentLoanAmount->status_id === 1)
                                    <span class="badge badge-primary">0.00</span>
                                @elseif($currentLoanAmount->status_id === 8)
                                    <span class="badge badge-warning">{{ $currentLoanAmount->loan_amount }}</span>
                                @elseif($currentLoanAmount->status_id === 10)
                                    <span class="badge badge-success">{{ $currentLoanAmount->loan_amount }}</span>
                                @else
                                    <span class="badge badge-danger">0.00</span>
                                @endif
                            @else
                                ksh0.00
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
            </table>
            <div class="container-fluid">
                <h2 class="section-title"> Downloadable Forms</h2>
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
            </div>
        </div>
    </div>
</div>



@endsection