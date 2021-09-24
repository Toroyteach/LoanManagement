<?php

namespace App\Http\Requests;

use App\LoanApplication;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreLoanApplicationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('loan_application_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'loan_amount' => [ 'required', 'gt:1000', ],
            'description' => ['required'],
            'duration' => ['required', 'gt:0',],
            'loan_type' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'loan_amount.gt:1000'    => 'Service amount must be more than 1000',
            'description.required.'   => 'You must declare decription of your application',
            'duration.required.'   => 'Duration of payment must be declared',
            'loan_type.required'   => 'You must select the type of service'
        ];
    }
}
