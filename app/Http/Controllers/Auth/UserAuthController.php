<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Jobs\ProcessEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\UserResetPasswordEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.users.dashboard');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.users.login');
    }


    // Hiển thị form quên mật khẩu
    public function showForgotForm()
    {
        return view('user.auth.forgot-password');
    }

    // Xử lý gửi link reset password
    public function sendResetLink(Request $request)
    {
        // Validate email input
        $request->validate([
            'email' => 'required|email'
        ]);

        // Tìm user với email được nhập
        $user = User::where('email', $request->email)->first();

        // Nếu tìm thấy user
        if ($user) {
            // Tạo token ngẫu nhiên 64 ký tự
            $token = Str::random(64);

            // Lưu hoặc cập nhật token vào bảng password_reset_tokens
            // updateOrInsert: Nếu email đã tồn tại thì update, không thì insert mới
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $token,
                    'created_at' => Carbon::now() // Lưu thời điểm tạo token
                ]
            );

            // Gửi email chứa link reset password qua queue
            UserResetPasswordEmail::dispatch(
                new ResetPasswordMail($token, $user),
                $user->email
            )->onQueue('user-notifications');
        }

        // Luôn trả về thông báo thành công để bảo mật (không cho biết email có tồn tại hay không)
        return response()->json([
            'message' => 'Link đặt lại mật khẩu đã được gửi vào email của bạn.'
        ]);
        
    }

    // Hiển thị form đặt lại mật khẩu
    public function showResetForm(Request $request)
    {
        return view('user.auth.reset-password', ['token' => $request->token]);
    }

    // Xử lý đặt lại mật khẩu
    public function reset(Request $request)
    {
        // Validate input
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed', // password_confirmation field required
        ]);

        // Kiểm tra token có hợp lệ và chưa hết hạn (3 giờ)
        $tokenData = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->where('created_at', '>', Carbon::now()->subHours(3))
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['token' => 'Token không hợp lệ hoặc đã hết hạn']);
        }

        // Cập nhật mật khẩu mới
        $user = User::where('email', $tokenData->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        // Xóa token đã sử dụng
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        // Chuyển hướng về trang đăng nhập
        return redirect()->route('user.users.login')->with('status', 'Mật khẩu đã được đặt lại thành công!');
    }
}
