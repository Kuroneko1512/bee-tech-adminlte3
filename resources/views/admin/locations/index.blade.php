@extends('admin.layouts.master')

@section('title')
    Quản lý địa chỉ
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <!-- Form Import -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Import dữ liệu</h3>
                    </div>
                    <div class="card-body">
                        <form id="form-import" action="{{ route('admin.locations.import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>File Tỉnh/Thành phố (CSV)</label>
                                <input type="file" name="provinces" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>File Quận/Huyện (CSV)</label>
                                <input type="file" name="districts" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>File Xã/Phường (CSV)</label>
                                <input type="file" name="communes" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Danh sách địa chỉ -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách địa chỉ</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tỉnh/Thành phố</th>
                                    <th>Số quận/huyện</th>
                                    <th>Số xã/phường</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($provinces as $province)
                                    <tr>
                                        <td>{{ $province->name }}</td>
                                        <td>{{ $province->districts_count }}</td>
                                        <td>{{ $province->communes_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $provinces->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // Xử lý submit form import
            $('#form-import').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                // Hiển thị loading
                Swal.fire({
                    title: 'Đang xử lý import',
                    html: 'Vui lòng đợi trong giây lát...<br/><b>Tiến độ: <span id="progress">0%</span></b>',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Gửi request import
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Bắt đầu check progress
                        checkProgress();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi import',
                            text: xhr.responseJSON.message || 'Có lỗi xảy ra'
                        });
                    }
                });
            });

            // Kiểm tra tiến độ import
            function checkProgress() {
                let timer = setInterval(function() {
                    $.ajax({
                        url: '{{ route('admin.locations.import.progress') }}',
                        type: 'GET',
                        success: function(response) {
                            // Cập nhật tiến độ
                            $('#progress').text(response.percent + '%');

                            // Kiểm tra lỗi
                            if (response.failed > 0) {
                                clearInterval(timer);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Import thất bại',
                                    text: `Có ${response.failed} jobs bị lỗi. ${response.error || ''}`
                                });
                                return;
                            }

                            // Kiểm tra hoàn thành
                            if (response.processed >= response.total) {
                                clearInterval(timer);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Import thành công',
                                    text: `Đã import ${response.processed} bản ghi`
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            clearInterval(timer);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi kết nối',
                                text: 'Không thể kiểm tra tiến độ import'
                            });
                        }
                    });
                }, 2000);
            }
        });
    </script>
@endpush
