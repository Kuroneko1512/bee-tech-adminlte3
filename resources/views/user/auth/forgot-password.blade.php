<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User | Quên mật khẩu</title>
    @include('admin.layouts.partials.styles')
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a><b>User</b>LTE</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Nhập email để lấy lại mật khẩu</p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form id="resetForm" action="{{ route('user.password.email') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-block">
                                Gửi link đặt lại mật khẩu
                            </button>
                        </div>
                    </div>
                </form>


                <p class="mt-3 mb-1">
                    <a href="{{ route('user.users.login') }}">Quay lại đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
    @include('admin.layouts.partials.scripts')
    <script>
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const button = document.getElementById('submitBtn');
            let timeLeft = 30;

            fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: data.message,
                        timer: 5000,
                        showConfirmButton: false
                    });

                    button.disabled = true;
                    const timer = setInterval(() => {
                        button.innerHTML = `Vui lòng đợi ${timeLeft} giây`;
                        timeLeft--;

                        if (timeLeft < 0) {
                            clearInterval(timer);
                            button.disabled = false;
                            button.innerHTML = 'Gửi link đặt lại mật khẩu';
                        }
                    }, 1000);
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra, vui lòng thử lại'
                    });
                });
        });
    </script>
</body>

</html>
