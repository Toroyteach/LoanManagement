@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', [$user->id]) }}" enctype="multipart/form-data" id="memberEdit">
        @method('PUT')    
        @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="firstname">{{ trans('cruds.user.fields.firstname') }}</label>
                    <input class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" type="text" name="firstname" id="firstname" value="{{ old('firstname', $user->firstname) }}">
                    @if($errors->has('firstname'))
                        <div class="invalid-feedback">
                            {{ $errors->first('firstname') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.firstname_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="lastname">{{ trans('cruds.user.fields.lastname') }}</label>
                    <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', $user->lastname) }}">
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
                    <input class="form-control {{ $errors->has('middlename') ? 'is-invalid' : '' }}" type="text" name="middlename" id="middlename" value="{{ old('middlename', $user->middlename) }}">
                    @if($errors->has('middlename'))
                        <div class="invalid-feedback">
                            {{ $errors->first('middlename') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.middlename_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="nationalid">{{ trans('cruds.user.fields.nationalid') }}</label>
                    <input class="form-control {{ $errors->has('nationalid') ? 'is-invalid' : '' }}" type="number" name="nationalid" id="nationalid" value="{{ old('nationalid', $user->nationalid) }}">
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
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>
                <div class="form-group col-md-6">
                    <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
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
                    <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="number" placeholder="254..." value="{{ old('number', $user->number) }}" name="number" id="number" >
                    @if($errors->has('number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('number') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-6" data-provide="datepicker">
                    <label class="required" for="dateofbirth">Date Of Birth</label>
                    <input class="form-control {{ $errors->has('dateofbirth') ? 'is-invalid' : '' }}" type="date" value="{{ old('dateofbirth', $user->dateofbirth) }}" name="dateofbirth" id="dateofbirth">
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
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="address" placeholder="Enter address" value="{{ old('address', $user->address) }}" name="address" id="address">
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="amount">Registration Amount</label>
                    <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" placeholder="Enter amount" value="{{ $user->monthlySavings->monthly_amount }}" name="{{ old('amount', $user->amount)}}" id="amount" disabled>
                    @if($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label class="required" for="monthly_amount">Monthly Contribution Amount</label>
                    <input class="form-control {{ $errors->has('monthly_amount') ? 'is-invalid' : '' }}" type="number" placeholder="Enter monthly contribution amount" value="{{ $user->monthlySavings->monthly_amount }}" name="monthly_amount" id="monthly_amount" disabled>
                    @if($errors->has('monthly_amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('monthly_amount') }}
                        </div>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="password">Account No</label>
                    <input class="form-control {{ $errors->has('idno') ? 'is-invalid' : '' }}" type="number" value="{{ old('idno', $user->idno) }}" placeholder="Enter 6 digits" name="idno" id="idno" >
                    @if($errors->has('idno'))
                        <div class="invalid-feedback">
                            {{ $errors->first('idno') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label class="required" for="password">Profile Image</label>
                    <input class="form-control {{ $errors->has('avatar') ? 'is-invalid' : '' }}" type="file" value="{{ old('avatar', '') }}" name="avatar" id="avatar">
                    @if($errors->has('avatar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('avatar') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                        @foreach($roles as $id => $roles)
                            <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('roles'))
                        <div class="invalid-feedback">
                            {{ $errors->first('roles') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                </div>
                <div class="form-group col-md-6" data-provide="datepicker">
                    <label for="joinedsacco">Date Joined Sacco</label>
                    <input class="form-control {{ $errors->has('joinedsacco') ? 'is-invalid' : '' }}" type="date" value="{{ old('joinedsacco', $user->joinedsacco) }}" name="joinedsacco" id="joinedsacco">
                    @if($errors->has('joinedsacco'))
                        <div class="invalid-feedback">
                            {{ $errors->first('joinedsacco') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-header">
                Next Of Kin
            </div><br><br>
                    @if($errors->has('kin[*]'))
                        <div class="invalid-feedback">
                            Next of kin is required
                        </div>
                    @endif
            <div class="table-responsive">  

                <table class="table table-bordered" id="dynamic_field">  

                <div class="row">
                    <tr id="">  
                        
                    @forelse($user->nextKin as $id => $kin)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <td><input type="text" name="kin[0][name]" value="{{ $kin->name }}" placeholder="Enter There Name" class="{{ $errors->has('kin[0][name]') ? 'is-invalid' : '' }} form-control name_list" disabled></td> 
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <td><input type="number" name="kin[0][number]" value="{{ $kin->phone }}" placeholder="Enter There Active Number" class="{{ $errors->has('kinphone') ? 'is-invalid' : '' }} form-control name_list" disabled></td>  
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <td><input type="text" name="kin[0][type]" value="{{ $kin->relationship }}" placeholder="Enter type of Relationship" class="{{ $errors->has('kinrelationship') ? 'is-invalid' : '' }} form-control name_list" disabled></td>  
                        </div>
                    @empty
                        <div class="alert alert-warning">This user doesn't have Next of Kin </div>
                    @endforelse


                    </tr>  
                </div>

                </table>

            </div>

            <div class="form-group">
                <button class="btn btn-danger" id="submited">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){     

    var i = 1;  


    $('#add').click(function(){  

        i++;  

        $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="kin['+i+'][name]" placeholder="Enter your Name" class="form-control name_list" /></td><td><input type="number" name="kin['+i+'][number]" placeholder="Enter your Number" class="form-control name_list" /></td><td><input type="text" name="kin['+i+'][type]" placeholder="Enter your Type" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  

    });  


    $(document).on('click', '.btn_remove', function(){  

        var button_id = $(this).attr("id");   

        $('#row'+button_id+'').remove();  

    });  

    $('#submited').click(function(e) {

        e.preventDefault(e);

    let fullScreenLoader = document.getElementById("fullLoader");

    swal.fire({
            title: "Update Member",
            icon: 'question',
            text: "Your are about to Update member details. Please check details, then confirm!",
            showCancelButton: !0,
            confirmButtonText: "Yes, Submit",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {

            if (e.value === true) {

                fullScreenLoader.style.display = "block";
                $('#memberEdit').submit()  

            } else {

                e.dismiss;
                
            }

        }, function (dismiss) {
            return false;
        })

    });

});  
</script>


@endsection