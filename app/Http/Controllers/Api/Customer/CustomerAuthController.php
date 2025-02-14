<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
     * Đăng nhập cho customer.
     *
     * Yêu cầu request gồm:
     * - phone: số điện thoại
     * - password: mật khẩu
     *
     * Nếu hợp lệ, tạo access token cho customer.
     */
    /**
     * API đăng nhập cho khách hàng
     */
    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào; nếu không hợp lệ, Laravel sẽ tự throw ValidationException.
        $validated = $request->validate([
            'phone'    => 'required|string|exists:customers,phone',
            'password' => 'required|string|min:6',
        ]);

        try {
            // Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
            $customer = DB::transaction(function () use ($validated, $request) {
                $customer = Customer::where('phone', $validated['phone'])->firstOrFail();

                // Kiểm tra mật khẩu
                if (!Hash::check($validated['password'], $customer->password)) {
                    Log::warning('Đăng nhập thất bại', [
                        'phone' => $validated['phone'],
                        'ip'    => $request->ip(),
                    ]);
                    return $this->responseJson(false, 'Thông tin đăng nhập không chính xác', [], 401);
                    // Sử dụng abort để throw HttpException với mã 401
                    // abort(401, 'Thông tin đăng nhập không chính xác');
                }

                return $customer;
            });

            // Tạo token cho customer (Personal Access Token, dựa trên Passport)
            $tokenResult = $customer->createToken('Customer Access Token');
            $data = [
                'access_token' => $tokenResult->accessToken,
                'token_type'   => 'Bearer',
                'expires_at'   => $tokenResult->token->expires_at->toDateTimeString(),
                'customer'     => $customer->only(['id', 'phone', 'email', 'full_name']),
            ];

            Log::info('Khách hàng đăng nhập', [
                'customer_id' => $customer->id,
                'ip'          => $request->ip(),
            ]);

            return $this->responseJson(true, 'Đăng nhập thành công', $data);
        } catch (\Exception $e) {
            // Nếu có lỗi khác ngoài lỗi validate, rollback đã tự động xảy ra với DB::transaction
            Log::error('Lỗi đăng nhập', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return $this->responseJson(false, 'Hệ thống đang bảo trì', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
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
}
