@extends('layouts.email')

@section('content')
<div class="email-header">
    <h2>Chào mừng thành viên mới</h2>
</div>

<div class="email-content">
    <h3>Xin chào {{ $user->first_name }} {{ $user->last_name }},</h3>
    
    <p>Chúc mừng bạn đã đăng ký thành công tài khoản tại {{ config('app.name') }}.</p>
    
    <div style="margin: 20px 0;">
        <h4>Thông tin tài khoản:</h4>
        <table class="table">
            <tr>
                <td><strong>Tên đăng nhập:</strong></td>
                <td>{{ $user->user_name }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $user->email }}</td>
            </tr>
        </table>
    </div>

    <p>Vui lòng đăng nhập để bắt đầu sử dụng dịch vụ của chúng tôi.</p>
    
    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ config('app.url') }}/user/login" class="btn">Đăng nhập ngay</a>
    </div>
</div>
@endsection