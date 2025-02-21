<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User | Đặt lại mật khẩu</title>
    @include('admin.layouts.partials.styles')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a><b>User</b>LTE</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Đặt lại mật khẩu mới</p>

                <form action="{{ route('user.password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Xác nhận mật khẩu" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Đặt lại mật khẩu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.layouts.partials.scripts')
    <!-- Thêm vào phần cuối body, trước </body> -->
    <script>
        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: "{{ session('status') }}",
                timer: 3000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "{{ route('user.users.login') }}";
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: "{{ $errors->first() }}"
            });
        @endif
    </script>

</body>

</html>
