<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'         => [
                                'required',
                                'email',
                                'max:100',
                                Rule::unique('users')->ignore($this->user->id)
                            ],
            'first_name'    => 'required|string|max:50',
            'last_name'     => 'required|string|max:50',
            'birthday'      => [
                                'required',
                                'date',
                                'before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                            ],
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ];
    }

    public function messages()
    {
        return [
            'email.required'        => 'Email là bắt buộc',
            'email.email'           => 'Email không đúng định dạng',
            'email.max'             => 'Email không được quá 100 ký tự',
            'email.unique'          => 'Email đã tồn tại trong hệ thống',
            
            'first_name.required'   => 'Họ là bắt buộc',
            'first_name.max'        => 'Họ không được quá 50 ký tự',
            
            'last_name.required'    => 'Tên là bắt buộc',
            'last_name.max'         => 'Tên không được quá 50 ký tự',
            
            'birthday.required'     => 'Ngày sinh là bắt buộc',
            'birthday.date'         => 'Ngày sinh không đúng định dạng',
            'birthday.before'       => 'Bạn phải đủ 18 tuổi',
            
            'avatar.image'          => 'File phải là hình ảnh',
            'avatar.mimes'          => 'Ảnh phải có định dạng: jpg, jpeg, png',
            'avatar.max'            => 'Kích thước ảnh tối đa 3MB',
        ];
    }
    
    protected function prepareForValidation()
    {
        if ($this->birthday) {
            $this->merge([
                'birthday' => Carbon::createFromFormat('d/m/Y', $this->birthday)->format('Y-m-d')
            ]);
        }
    }

}
