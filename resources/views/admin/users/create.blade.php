@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="firstname">{{ trans('cruds.user.fields.firstname') }}</label>
                    <input class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" type="text" name="firstname" id="firstname" value="{{ old('firstname', '') }}" required>
                    @if($errors->has('firstname'))
                        <div class="invalid-feedback">
                            {{ $errors->first('firstname') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.firstname_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="lastname">{{ trans('cruds.user.fields.lastname') }}</label>
                    <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', '') }}" required>
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
                    <input class="form-control {{ $errors->has('middlename') ? 'is-invalid' : '' }}" type="text" name="middlename" id="middlename" value="{{ old('middlename', '') }}">
                    @if($errors->has('middlename'))
                        <div class="invalid-feedback">
                            {{ $errors->first('middlename') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.middlename_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="nationalid">{{ trans('cruds.user.fields.nationalid') }}</label>
                    <input class="form-control {{ $errors->has('nationalid') ? 'is-invalid' : '' }}" type="number" name="nationalid" id="nationalid" value="{{ old('nationalid', '') }}" required>
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
                    <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', '') }}" required>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                    @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="number">Phone Number</label>
                    <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" placeholder="254..." value="{{ old('number', '') }}" name="number" id="number" required>
                    @if($errors->has('number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('number') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-6" data-provide="datepicker">
                    <label class="required" for="dateofbirth">Date Of Birth</label>
                    <input class="form-control {{ $errors->has('dateofbirth') ? 'is-invalid' : '' }}" type="date" value="{{ old('dateofbirth', '') }}" name="dateofbirth" id="dateofbirth" required>
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
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="address" placeholder="Enter address" value="{{ old('address', '') }}" name="address" id="address" required>
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="amount">Registration Amount</label>
                    <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" placeholder="Enter amount" value="" name="amount" id="amount" required>
                    @if($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="password">Account No</label>
                    <input class="form-control {{ $errors->has('idno') ? 'is-invalid' : '' }}" type="number" value="{{ old('idno', '') }}" placeholder="enter 6 digits" name="idno" id="idno" required>
                    @if($errors->has('idno'))
                        <div class="invalid-feedback">
                            {{ $errors->first('idno') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label class="required" for="password">Profile Image</label>
                    <input class="form-control {{ $errors->has('avatar') ? 'is-invalid' : '' }}" type="file" value="{{ old('avatar', '') }}" name="avatar" id="avatar" required>
                    @if($errors->has('avatar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('avatar') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
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