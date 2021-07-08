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
            'dateofbirth'    => [
                'required',
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
}
