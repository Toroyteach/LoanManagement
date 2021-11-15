<?php

namespace App\Http\Requests;

use App\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {

        if(request()->routeIs('admin.users.update')){

            $avatarRule = 'sometimes';

        }

        return [
            'firstname'     => [
                'required',
            ],
            'lastname'     => [
                'required',
            ],
            'nationalid'     => [
                'required', 'integer', 'unique:users,nationalid,'. request()->route('user')->id, 'digits_between:6,8',
            ],
            'number'     => [
                'required', 'integer', 'unique:users,number,'. request()->route('user')->id, 'digits:12', 'regex:/(254)[0-9]{9}/',
            ],
            'email'   => [
                'required', 'unique:users,email,' . request()->route('user')->id,
            ],
            'address'    => [
                'required',
            ],
            'dateofbirth'    => [
                'required', 'date', 'before:-18 years',
            ],
            'joinedsacco'    => [
                'required', 'date', 'after_or_equal:dateofbirth'
            ],
            'idno'    => [
                'required', 'digits:6', 'unique:users,idno,'. request()->route('user')->id,
            ],
            'avatar'  => [
                $avatarRule, 'image:jpeg,png,jpg,gif,svg|max:2048'
            ],
            'roles.*'  => [
                'integer',
            ],
            'roles'    => [
                'required',
                'array',
            ],
        ];
    }

    protected function prepareForValidation()
    {

        if($this->avatar == null){

            $this->request->remove('avatar');
            
        }

    }

    public function messages()
    {
        return [
            'idno.required'                              => 'Member number is required and must be 6 digits',
            'dateofbirth.before:-18 years'      => 'Date of Birth must be older than 18 years',
            'firstname.required'                => 'The firstname is required',
            'lastname.required'                          => 'The lastname is required',
            'nationalid.required'                        => 'National id is required',
            'number.required'                            => 'Phone number is required in format 254123456789',
            'email.required'                             => 'A valid Email is required',
            'password.required'                          => 'Password must be 6 or more characters',
            'address.required'                           => 'Address is required',
            'amount.required'                            => 'Registraion Amount is required and must be greater than 1000',
            'monthly_amount.required'                    => 'Monthly Contribution amount is required and must be greater than 1000',
            'dateofbirth.required'                       => 'Date of birth is required and must be 18 years and above',
            'joinedsacco.required'                       => 'Date joined sacco is required',
            'avatar.required'                            => 'Profile image is required',
            'roles.required'                             => 'Roles is required',
            'kin.required'                               => 'Please selecte your next of kin',
            'kin.*.name.required' => 'Next of kin name is required',
            'kin.*.number.required' => 'Next of kin number is required',
            'kin.*.type.required' => 'Next of kin Relationship type is required'
        ];
    }
}
