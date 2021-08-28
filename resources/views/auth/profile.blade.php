@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.update_profile') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.update.profile", [$user->id]) }}">
            @csrf

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="firstname">{{ trans('cruds.user.fields.firstname') }}</label>
                    <input class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" type="text" name="firstname" id="firstname" value="{{ old('firstname', auth()->user()->firstname) }}" required>
                    @if($errors->has('firstname'))
                        <div class="invalid-feedback">
                            {{ $errors->first('firstname') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.firstname_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="lastname">{{ trans('cruds.user.fields.lastname') }}</label>
                    <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', auth()->user()->lastname) }}" required>
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
                        <label class="required" for="address">Address</label>
                        <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="address" placeholder="Enter address" value="{{ old('address', auth()->user()->address) }}" name="address" id="address" required>
                        @if($errors->has('address'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-md-6" data-provide="datepicker">
                        <label class="required" for="dateofbirth">Date Of Birth</label>
                        <input class="form-control {{ $errors->has('dateofbirth') ? 'is-invalid' : '' }}" type="date" value="{{ old('dateofbirth', auth()->user()->dateofbirth) }}" name="dateofbirth" id="dateofbirth" required>
                        @if($errors->has('dateofbirth'))
                            <div class="invalid-feedback">
                                {{ $errors->first('dateofbirth') }}
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