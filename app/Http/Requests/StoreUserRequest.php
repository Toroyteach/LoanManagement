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
            'dateofbirth'    => [
                'required', 'before:-18 years',
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
        ];
    }

    public function messages()
    {
        return [
            'idno.digits:6'                  => 'My custom error',
            'dateofbirth.before:-18 years'   => 'Date of Birth must be older than 18 years'
        ];
    }
}
