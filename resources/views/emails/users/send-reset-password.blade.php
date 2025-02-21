
@extends('layouts.email')

@section('content')
<div class="email-header">
    <h2>Đặt lại mật khẩu</h2>
</div>

<div class="email-content">
    <h2>Xin chào  {{ $user->last_name }} {{ $user->first_name }},</h2>
        
    <div>
        <h3>Yêu cầu đặt lại mật khẩu</h3>
        
        <p>Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
        
        <p>Link đặt lại mật khẩu này sẽ hết hạn sau {{ $validHours }} giờ.</p>
        
        <a href="{{ $resetUrl }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
            Đặt lại mật khẩu
        </a>
        
        <p>Nếu bạn không yêu cầu đặt lại mật khẩu, bạn có thể bỏ qua email này.</p>
    </div>

    <p>Nếu bạn không thực hiện thay đổi này, vui lòng liên hệ với chúng tôi ngay.</p>
</div>
@endsection