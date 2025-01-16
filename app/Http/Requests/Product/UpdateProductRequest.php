<?php

namespace App\Http\Requests\Product;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'stock'         => 'required|integer|min:0|max:10000',
            'expired_at'    => [
                                'nullable',
                                'date',
                                'after:' . Carbon::today()->format('Y-m-d')
                            ],
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'sku'           => [
                                'required',
                                'min:10',
                                'max:20',
                                'regex:/^[a-zA-Z0-9]+$/',
                                Rule::unique('products')->ignore($this->product->id)
                            ],
            'category_id'   => 'required|exists:product_categories,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Tên sản phẩm là bắt buộc',
            'name.max'              => 'Tên sản phẩm không được quá 255 ký tự',

            'stock.required'        => 'Số lượng là bắt buộc',
            'stock.integer'         => 'Số lượng phải là số nguyên',
            'stock.min'             => 'Số lượng tối thiểu là 0',
            'stock.max'             => 'Số lượng tối đa là 10000',

            'expired_at.date'       => 'Ngày hết hạn không hợp lệ',
            'expired_at.after'      => 'Ngày hết hạn phải lớn hơn thời gian hiện tại',

            'avatar.image'          => 'File phải là hình ảnh',
            'avatar.mimes'          => 'Ảnh phải có định dạng: jpg, jpeg, png',
            'avatar.max'            => 'Kích thước ảnh tối đa 3MB',

            'sku.required'          => 'Mã SKU là bắt buộc',
            'sku.unique'            => 'Mã SKU đã tồn tại',
            'sku.min'               => 'Mã SKU tối thiểu 10 ký tự',
            'sku.max'               => 'Mã SKU tối đa 20 ký tự',
            'sku.regex'             => 'Mã SKU chỉ được chứa chữ và số',

            'category_id.required'  => 'Danh mục sản phẩm là bắt buộc',
            'category_id.exists'    => 'Danh mục sản phẩm không tồn tại'
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->expired_at) {
            $this->merge([
                'expired_at' => Carbon::createFromFormat('d/m/Y', $this->expired_at)->format('Y-m-d')
            ]);
        }
    }
}
