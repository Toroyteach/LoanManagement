<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'address'    => [
                'required',
            ],
            'dateofbirth'    => [
                'required', 'date', 'before:-18 years',
            ],
        ];
    }

    public function messages()
    {
        return[
            'firstname.required' => "First name is required",
            'lastname.required' => 'Lastname is required',
            'dateofbirth.required' => 'Please enter correct Date format',
            'address.required' => 'Address is required',
        ];
    }
}
