<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirstTimeLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'    => [
                'required','unique:users',
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
            'password' => [
                'required_with:password_confirmation',
            ],
            'avatar'  => [
                'required','image:jpeg,png,jpg,gif,svg|max:2048',
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
            'dateofbirth.before:-18 years'               => 'Date of Birth must be older than 18 years',
            'password.required'                          => 'Password must be 6 or more characters',
            'address.required'                           => 'Address is required',
            'dateofbirth.required'                       => 'Date of birth is required and must be 18 years and above',
            'joinedsacco.required'                       => 'Date joined sacco is required',
            'avatar.required'                            => 'Profile image is required',
            'kin.required'                               => 'Please select your next of kin',
            'kin.*.name.required'                        => 'Next of kin name is required',
            'kin.*.number.required'                      => 'Next of kin number is required',
            'kin.*.type.required'                        => 'Next of kin Relationship type is required'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'dateofbirth'    => 'Date of Birth',
            'password'       => 'Password',
            'address'        => 'Address',
            'joinedsacco'    => 'Date Joined Sacco',
            'avatar'         => 'Member Image',
            'kin' => 'Next of Kin',
        ];
    }
}
