@extends('layouts.email')

@section('content')
<div class="email-header">
    <h2>Cập nhật tài khoản</h2>
</div>

<div class="email-content">
    <h3>Xin chào {{ $user->first_name }} {{ $user->last_name }},</h3>
    
    <p>Tài khoản của bạn vừa được cập nhật thông tin.</p>
    
    <div style="margin: 20px 0;">
        <h4>Thông tin mới:</h4>
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

    <p>Nếu bạn không thực hiện thay đổi này, vui lòng liên hệ với chúng tôi ngay.</p>
</div>
@endsection