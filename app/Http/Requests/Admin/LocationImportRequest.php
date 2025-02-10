<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LocationImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'provinces' => 'required|file|mimes:csv,txt|max:10240', // Max 10MB
            'districts' => 'required|file|mimes:csv,txt|max:10240',
            'communes'  => 'required|file|mimes:csv,txt|max:10240'
        ];
    }

    /**
     * Custom message lỗi
     */
    public function messages()
    {
        return [
            'provinces.required'    => 'File tỉnh/thành phố là bắt buộc',
            'districts.required'    => 'File quận/huyện là bắt buộc',
            'communes.required'     => 'File xã/phường là bắt buộc',
            'provinces.mimes'       => 'File tỉnh/thành phố phải là định dạng CSV',
            'districts.mimes'       => 'File quận/huyện phải là định dạng CSV',
            'communes.mimes'        => 'File xã/phường phải là định dạng CSV',
        ];
    }
}
