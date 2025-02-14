<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Format response chuẩn cho API
     */
    private function responseJson($success, $message = '', $data = [], $code = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * API lấy thông tin khách hàng
     */
    public function profile(Request $request)
    {
        // return response()->json($request->user());
        try {
            $customer = $request->user();
            return $this->responseJson(true, 'Thông tin khách hàng', $customer);
            // return response()->json([
            //     'success' => true,
            //     'data' => $customer
            // ], 200);
        } catch (\Exception $e) {
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Lỗi lấy thông tin khách hàng',
            //     'error' => $e->getMessage()
            // ], 500);
            $error = $e->getMessage();
            return $this->responseJson(false, 'Lỗi lấy thông tin khách hàng', $error, 500);
        }
    }

    /**
     * API cập nhật thông tin khách hàng
     */
    public function updateProfile(Request $request)
    {
        // $validated = $request->validate([
        //     'email'       => 'nullable|email|unique:customers,email,' . $request->user()->id,
        //     'phone'       => 'required|string|unique:customers,phone,' . $request->user()->id,
        //     'birthday'    => 'required|date',
        //     'full_name'   => 'required|string|max:100',
        //     'address'     => 'nullable|string|max:255',
        //     'province_id' => 'nullable|integer',
        //     'district_id' => 'nullable|integer',
        //     'commune_id'  => 'nullable|integer',
        //     'status'      => 'required|string',
        //     'flag_delete' => 'boolean'
        // ]);
        // Kiểm tra phương thức của request để thiết lập rules khác nhau
        if ($request->isMethod('put')) {
            // Full update: yêu cầu client gửi đầy đủ các trường dữ liệu
            $rules = [
                'email'       => 'nullable|email|unique:customers,email,' . $request->user()->id,
                'phone'       => 'required|string|unique:customers,phone,' . $request->user()->id,
                'birthday'    => 'required|date',
                'full_name'   => 'required|string|max:100',
                'address'     => 'nullable|string|max:255',
                'province_id' => 'nullable|integer',
                'district_id' => 'nullable|integer',
                'commune_id'  => 'nullable|integer',
                'status'      => 'required|string'
                // Nếu bạn không muốn cập nhật flag_delete qua API, có thể không bao gồm nó
            ];
        } else { // PATCH – cập nhật từng phần
            $rules = [
                'email'       => 'sometimes|nullable|email|unique:customers,email,' . $request->user()->id,
                'phone'       => 'sometimes|required|string|unique:customers,phone,' . $request->user()->id,
                'birthday'    => 'sometimes|required|date',
                'full_name'   => 'sometimes|required|string|max:100',
                'address'     => 'sometimes|nullable|string|max:255',
                'province_id' => 'sometimes|nullable|integer',
                'district_id' => 'sometimes|nullable|integer',
                'commune_id'  => 'sometimes|nullable|integer',
                'status'      => 'sometimes|required|string'
            ];
        }

        // Validate dữ liệu theo rules trên
        $validated = $request->validate($rules);

        try {
            // Sử dụng DB::transaction giúp code ngắn gọn hơn:
            $customer = DB::transaction(function () use ($request, $validated) {
                $customer = $request->user();
                $customer->update($validated);
                // Làm mới model để đảm bảo dữ liệu cập nhật được nạp lại
                $customer->refresh();
                return $customer;
            });
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Cập nhật thông tin thành công',
            //     'data' => $customer
            // ], 200);
            return $this->responseJson(true, 'Cập nhật thông tin thành công', $customer);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật thông tin thất bại',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API đổi mật khẩu khách hàng
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed'
        ]);

        try {
            DB::beginTransaction();

            $customer = $request->user();
            if (!Hash::check($validated['old_password'], $customer->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mật khẩu cũ không chính xác'
                ], 400);
            }

            $customer->password = Hash::make($validated['new_password']);
            $customer->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đổi mật khẩu thành công'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Đổi mật khẩu thất bại',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
