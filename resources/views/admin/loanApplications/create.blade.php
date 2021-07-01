@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.loanApplication.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loan-applications.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="loan_amount">{{ trans('cruds.loanApplication.fields.loan_amount') }}</label>
                <input class="form-control {{ $errors->has('loan_amount') ? 'is-invalid' : '' }}" type="number" name="loan_amount" id="loan_amount" value="{{ old('loan_amount', '') }}" step="0.01" required>
                @if($errors->has('loan_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('loan_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.loanApplication.fields.loan_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.loanApplication.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.loanApplication.fields.description_helper') }}</span>
            </div> 
            <div class="form-group">
                <!-- loan type -->
                <div class="form-group">
                <label class="required" for="loan_amount">Loan Type</label>
                    <select class="custom-select" name="loan_type" required>
                        <option value="" selected>Select Loan Type</option>
                        <option value="Emergency">Emergency</option>
                        <option value="School Fees">School Fess</option>
                        <option value="Develeopment">Development</option>
                        <option value="Top Up">Top Up</option>
                    </select>
                    <div class="invalid-feedback">Select Loan Type</div>
                </div>
            </div>
            <div class="form-group">
                <!-- loan duration -->
                <label class="required" for="duration">Loan Duration in months</label>
                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="number" name="duration" id="duration" value="{{ old('duration', '') }}" step="1" required>
                @if($errors->has('duration'))
                    <div class="invalid-feedback">
                        {{ $errors->first('duration') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <!-- loan gurantors -->
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
