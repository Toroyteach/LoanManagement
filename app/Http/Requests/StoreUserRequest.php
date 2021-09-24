<?php

namespace App\Http\Requests;

use App\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'firstname'     => [
                'required',
            ],
            'lastname'     => [
                'required',
            ],
            'nationalid'     => [
                'required', 'integer', 'unique:users', 'digits_between:6,8',
            ],
            'number'     => [
                'required', 'integer', 'unique:users', 'digits:12', 'regex:/(254)[0-9]{9}/',
            ],
            'email'    => [
                'required',
                'unique:users',
            ],
            'address'    => [
                'required',
            ],
            'amount'    => [
                'required', 'integer', 'gt:1000',
            ],
            'monthly_amount'    => [
                'required', 'integer', 'gt:1000',
            ],
            'dateofbirth'    => [
                'required', 'date', 'before:-18 years',
            ],
            'joinedsacco'    => [
                'required', 'date', 'after_or_equal:dateofbirth'
            ],
            'idno'    => [
                'required',
                'unique:users', 'digits:6',
            ],
            'password' => [
                'required',
            ],
            'avatar'  => [
                'required',
                'image:jpeg,png,jpg,gif,svg|max:2048',
            ],
            'roles.*'  => [
                'integer',
            ],
            'roles'    => [
                'required',
                'array',
            ],
            'kin' => [
                'required', 'array', 'min:1', 'max:10'
            ],
            'kin.*.name' => [
                'required'
            ],
            'kin.*.number' => [
                'required', 'integer'
            ],
            'kin.*.type' => [
                'required'
            ],
        ];
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
