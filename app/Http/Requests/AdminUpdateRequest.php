<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;


class AdminUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //check if user is member then abort
        abort_if(Gate::denies('admin_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname'     => [
                'required',
            ],
            'lastname'     => [
                'required',
            ],
            'middlename'     => [
                'required',
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
            'nationalid'     => [
                'required', 'integer', 'unique:users,nationalid,' . request()->route('user')->id, 'digits_between:6,8',
            ],
            'number'     => [
                'required', 'integer', 'unique:users,number,' . request()->route('user')->id, 'digits:12', 'regex:/(254)[0-9]{9}/',
            ],
            'idno'    => [
                'required',
                'unique:users,idno,' . request()->route('user')->id, 'digits:6',
            ],
            // 'avatar'  => [
            //     'image:jpeg,png,jpg,gif,svg|max:2048',
            // ],
        ];
    }
}
