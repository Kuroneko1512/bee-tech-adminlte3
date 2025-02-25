@extends('admin.layouts.master')

@section('title')
    Quản lý địa chỉ
@endsection

@push('styles')
    <style>
        @media print {

            .btn-group,
            .pagination {
                display: none !important;
            }

            .card {
                border: none !important;
            }

            .card-header {
                display: none !important;
            }
        }
    </style>
@endpush

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách địa chỉ</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="#" class="btn btn-success btn-download" data-type="excel">
                                    <i class="fas fa-file-excel"></i> Excel
                                </a>
                                <a href="#" class="btn btn-info btn-download" data-type="csv">
                                    <i class="fas fa-file-csv"></i> CSV
                                </a>
                                <button type="button" class="btn btn-secondary" onclick="window.print()">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select class="form-control" id="per-page" onchange="changePerPage(this.value)">
                                    <option value="25" {{ request('per_page') == 5 ? 'selected' : '' }}>5 dòng
                                    </option>
                                    <option value="50" {{ request('per_page') == 10 ? 'selected' : '' }}>10 dòng
                                    </option>
                                    <option value="100" {{ request('per_page') == 15 ? 'selected' : '' }}>15 dòng
                                    </option>
                                </select>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Mã Tỉnh/Thành phố</th>
                                    <th>Tên Tỉnh/Thành phố</th>
                                    <th>Mã Quận/Huyện</th>
                                    <th>Tên Quận/Huyện</th>
                                    <th>Mã Phường/Xã</th>
                                    <th>Tên Phường/Xã</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentProvince = '';
                                    $currentDistrict = '';
                                    $provinceRowspan = 0;
                                    $districtRowspan = 0;
                                @endphp

                                @foreach ($provinces as $province)
                                    @foreach ($province->districts as $district)
                                        @foreach ($district->communes as $commune)
                                            <tr>
                                                @if ($province->code !== $currentProvince)
                                                    @php
                                                        $provinceRowspan = $province->communes->count();
                                                        $currentProvince = $province->code;
                                                    @endphp
                                                    <td rowspan="{{ $provinceRowspan }}">{{ $province->code }}</td>
                                                    <td rowspan="{{ $provinceRowspan }}">{{ $province->type }}
                                                        {{ $province->name }}</td>
                                                @endif

                                                @if ($district->code !== $currentDistrict)
                                                    @php
                                                        $districtRowspan = $district->communes->count();
                                                        $currentDistrict = $district->code;
                                                    @endphp
                                                    <td rowspan="{{ $districtRowspan }}">{{ $district->code }}</td>
                                                    <td rowspan="{{ $districtRowspan }}">{{ $district->type }}
                                                        {{ $district->name }}</td>
                                                @endif

                                                <td>{{ $commune->code }}</td>
                                                <td>{{ $commune->type }} {{ $commune->name }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>

                        {{ $provinces->appends(['per_page' => request('per_page')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function changePerPage(value) {
            window.location.href = `${window.location.pathname}?per_page=${value}`;
        }
        //
        $(function() {
            $('.btn-download').on('click', function(e) {
                e.preventDefault();
                let exportType = $(this).data('type');

                Swal.fire({
                    title: 'Đang xử lý export',
                    html: 'Vui lòng đợi trong giây lát...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('location.export') }}",
                    type: 'GET',
                    data: {
                        format: exportType
                    },
                    success: function(response) {
                        let downloadUrl = response.download_url;
                        checkFileReady(downloadUrl);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi export',
                            text: xhr.responseJSON.message || 'Có lỗi xảy ra.'
                        });
                    }
                });
            });

            function checkFileReady(downloadUrl) {
                let polling = setInterval(function() {
                    $.ajax({
                        url: downloadUrl,
                        type: 'HEAD',
                        success: function() {
                            clearInterval(polling);
                            window.location.href = downloadUrl;
                            Swal.fire({
                                icon: 'success',
                                title: 'Export hoàn thành',
                                text: 'File export đã sẵn sàng để tải về!'
                            });
                        },
                        error: function() {
                            console.log('File chưa sẵn sàng, thử lại sau 5 giây...');
                        }
                    });
                }, 5000);
            }
        });
    </script>
@endpush
