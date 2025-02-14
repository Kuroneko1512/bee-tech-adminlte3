<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'required|regex:/^0[0-9]{9}$/|exists:customers,phone',
            'password' => 'required|string|min:8|max:20'
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'Số điện thoại không đúng định dạng Việt Nam',
            'exists' => 'Số điện thoại chưa được đăng ký'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422));
    }
}