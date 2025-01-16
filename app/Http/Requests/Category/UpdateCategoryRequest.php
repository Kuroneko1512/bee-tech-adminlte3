<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
            'name'          => 'required|string|max:255',
            'parent_id'     => [
                                'nullable',
                                'integer',
                                Rule::exists('product_categories', 'id')
                                    ->whereNot('id', $this->category->id)
                            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Tên danh mục là bắt buộc',
            'name.max'              => 'Tên danh mục không được quá 255 ký tự',

            'parent_id.integer'     => 'Danh mục cha không hợp lệ',
            'parent_id.exists'      => 'Danh mục cha không tồn tại'
        ];
    }
}
