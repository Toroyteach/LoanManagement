@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Admin Edit Profile
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.admin.update.profile', [$user->id]) }}">
            @csrf

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="required" for="firstname">{{ trans('cruds.user.fields.firstname') }}</label>
                        <input class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" type="text" name="firstname" id="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                        @if($errors->has('firstname'))
                            <div class="invalid-feedback">
                                {{ $errors->first('firstname') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.firstname_helper') }}</span>
                    </div>
                
                    <div class="form-group col-md-6">
                        <label class="required" for="lastname">{{ trans('cruds.user.fields.lastname') }}</label>
                        <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                        @if($errors->has('lastname'))
                            <div class="invalid-feedback">
                                {{ $errors->first('lastname') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.lastname_helper') }}</span>
                    </div>
                </div>


            <div class="row">
                <div class="form-group col-md-6">
                    <label for="middlename">{{ trans('cruds.user.fields.middlename') }}</label>
                    <input class="form-control {{ $errors->has('middlename') ? 'is-invalid' : '' }}" type="text" name="middlename" id="middlename" value="{{ old('middlename', $user->middlename) }}" required>
                    @if($errors->has('middlename'))
                        <div class="invalid-feedback">
                            {{ $errors->first('middlename') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.middlename_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="nationalid">{{ trans('cruds.user.fields.nationalid') }}</label>
                    <input class="form-control {{ $errors->has('nationalid') ? 'is-invalid' : '' }}" type="number" name="nationalid" id="nationalid" value="{{ old('nationalid', $user->nationalid) }}" required>
                    @if($errors->has('nationalid'))
                        <div class="invalid-feedback">
                            {{ $errors->first('nationalid') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.nationalid_helper') }}</span>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="number">Phone Number</label>
                    <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" placeholder="254..." value="{{ old('number', $user->number) }}" name="number" id="number" required>
                    @if($errors->has('number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('number') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-6" data-provide="datepicker">
                    <label class="required" for="dateofbirth">Date Of Birth</label>
                    <input class="form-control {{ $errors->has('dateofbirth') ? 'is-invalid' : '' }}" type="date" value="<?php echo date('Y-m-d',strtotime($user->dateofbirth)) ?>" name="dateofbirth" id="dateofbirth" required>
                    @if($errors->has('dateofbirth'))
                        <div class="invalid-feedback">
                            {{ $errors->first('dateofbirth') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="address">Address</label>
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="address" placeholder="Enter address" value="{{ old('address', $user->address) }}" name="address" id="address" required>
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-6" data-provide="datepicker">
                    <label for="joinedsacco">Date Joined Sacco</label>
                    <input class="form-control {{ $errors->has('joinedsacco') ? 'is-invalid' : '' }}" type="date" value="<?php echo date('Y-m-d',strtotime($user->joinedsacco)) ?>" name="joinedsacco" id="joinedsacco" required>
                    @if($errors->has('joinedsacco'))
                        <div class="invalid-feedback">
                            {{ $errors->first('joinedsacco') }}
                        </div>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="password">Account No</label>
                    <input class="form-control {{ $errors->has('idno') ? 'is-invalid' : '' }}" type="number" value="{{ old('idno', $user->idno) }}" placeholder="Enter 6 digits" name="idno" id="idno" required>
                    @if($errors->has('idno'))
                        <div class="invalid-feedback">
                            {{ $errors->first('idno') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label class="required" for="password">Profile Image</label>
                    <input class="form-control {{ $errors->has('avatar') ? 'is-invalid' : '' }}" type="file" value="{{ old('avatar', $user->avatar) }}" name="avatar" id="avatar">
                    @if($errors->has('avatar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('avatar') }}
                        </div>
                    @endif
                </div>
            </div>


            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>

    </div>
</div>

@endsection