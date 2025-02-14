<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
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
     * API đăng nhập cho khách hàng
     */
    /**
     * Đăng nhập cho customer.
     *
     * Yêu cầu request gồm:
     * - phone: số điện thoại
     * - password: mật khẩu
     *
     * Nếu hợp lệ, tạo access token cho customer.
     */
    public function login(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validated = $request->validate([
            'phone' => 'required|string|exists:customers,phone',
            'password' => 'required|string|min:6'
        ]);

        try {
            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            DB::beginTransaction();

            // Tìm và kiểm tra thông tin khách hàng
            $customer = Customer::where('phone', $validated['phone'])
                ->firstOrFail();

            // Kiểm tra mật khẩu
            if (!Hash::check($validated['password'], $customer->password)) {
                // Ghi log các lần đăng nhập thất bại
                Log::warning('Đăng nhập thất bại', [
                    'phone' => $validated['phone'],
                    'ip' => $request->ip()
                ]);
                return $this->responseJson(false, 'Thông tin đăng nhập không chính xác', [], 401);
            }

            // Tạo và lưu token cá nhân với quyền customer
            $tokenResult = $customer->createToken('Customer Access Token');
            $token       = $tokenResult->accessToken;
            // Chuẩn bị dữ liệu trả về
            $data = [
                'access_token' => $token ,
                'token_type' => 'Bearer',
                // 'expires_at' => now()->addDays(1)->toDateTimeString(),
                'expires_at' => $tokenResult->token->expires_at->toDateTimeString(),
                'customer' => $customer->only(['id', 'phone', 'email', 'full_name'])
            ];

            // Ghi log đăng nhập thành công
            Log::info('Khách hàng đăng nhập', [
                'customer_id' => $customer->id,
                'ip' => $request->ip()
            ]);

            // Commit transaction
            DB::commit();
            return $this->responseJson(true, 'Đăng nhập thành công', $data);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi xảy ra
            DB::rollBack();
            // Ghi log lỗi để debug và theo dõi hệ thống
            Log::error('Lỗi đăng nhập', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->responseJson(false, 'Hệ thống đang bảo trì', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    /**
     * API đăng xuất khách hàng
     */
    public function logout(Request $request)
    {
        try {
            DB::beginTransaction();

            // Thu hồi token hiện tại
            $request->user()->token()->revoke();

            // Ghi log đăng xuất
            Log::info('Khách hàng đăng xuất', [
                'customer_id' => $request->user()->id
            ]);

            DB::commit();
            return $this->responseJson(true, 'Đăng xuất thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi đăng xuất', [
                'message' => $e->getMessage()
            ]);
            return $this->responseJson(false, 'Đăng xuất thất bại', [], 500);
        }
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
        $validated = $request->validate([
            'email' => 'nullable|email|unique:customers,email,' . $request->user()->id,
            'phone' => 'required|string|unique:customers,phone,' . $request->user()->id,
            'birthday' => 'required|date',
            'full_name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'province_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'commune_id' => 'nullable|integer',
            'status' => 'required|string',
            'flag_delete' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $customer = $request->user();
            $customer->update($validated);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin thành công',
                'data' => $customer
            ], 200);
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
