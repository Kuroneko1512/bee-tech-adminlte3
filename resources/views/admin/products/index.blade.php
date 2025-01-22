@extends('admin.layouts.master')

@section('title')
    List Products
@endsection
@push('styles')
    <style>
        @media print {

            .btn-group,
            .input-group,
            .pagination,
            .actions-column {
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
                        <h3 class="card-title">List Products</h3>
                    </div>

                    <!-- Thêm thông báo ở trên danh sách người dùng -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>{{ session('info') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add Product
                                    </a>
                                    <a href="{{ route('products.download', ['type' => 'excel']) }}" class="btn btn-success">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </a>
                                    <a href="{{ route('products.download', ['type' => 'csv']) }}" class="btn btn-info">
                                        <i class="fas fa-file-csv"></i> CSV
                                    </a>
                                    <a href="{{ route('products.download', ['type' => 'pdf']) }}" class="btn btn-danger">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                    <button type="button" class="btn btn-secondary" onclick="window.print()">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('products.index') }}" method="GET">
                                    @csrf
                                    <div class="input-group mb-2">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search by product or category name..."
                                            value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <select name="stock_range" class="form-control" onchange="this.form.submit()">
                                        <option value="">-- Select Stock Range --</option>
                                        <option value="less_10" {{ request('stock_range') == 'less_10' ? 'selected' : '' }}>
                                            Less than 10</option>
                                        <option value="10_100" {{ request('stock_range') == '10_100' ? 'selected' : '' }}>
                                            10 - 100</option>
                                        <option value="100_200"
                                            {{ request('stock_range') == '100_200' ? 'selected' : '' }}>100 - 200</option>
                                        <option value="more_200"
                                            {{ request('stock_range') == 'more_200' ? 'selected' : '' }}>More than 200
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <table id="example1" class="table table-bordered table-striped table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Product</th>
                                        <th width="10%">SKU</th>
                                        {{-- <th>Avatar</th> --}}
                                        <th width="10%">Category</th>
                                        <th width="4%">Stock</th>
                                        <th width="10%">Expired Date</th>
                                        <th width="13%">Create Date</th>
                                        <th width="13%">Update Date</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td> {{ $product->id }}</td>
                                            {{-- <td> {{ $product->name }}</td> --}}
                                            <td>
                                                <a href="#" class="d-flex align-items-center text-secondary">
                                                    <img src="{{ $product->avatar ? Storage::url($product->avatar) : Storage::url('/default/ComingSoon.jpg') }}"
                                                        alt="{{ $product->name }}"
                                                        class="img-fluid img-rounded img-md elevation-2">
                                                    <span class="ml-2">{{ $product->name }}</span>
                                                </a>
                                            </td>
                                            <td> {{ $product->sku }}</td>
                                            <td> {{ optional($product->category)->name }} </td>
                                            <td> {{ $product->stock }} </td>
                                            {{-- <td> {{ $product->expired_at ? $product->expired_at->format('d/m/Y') : '' }}</td> --}}
                                            <td> {{ optional($product->expired_at)->format('d/m/Y') }}</td>
                                            <td> {{ $product->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td> {{ $product->updated_at->format('d/m/Y H:i:s') }}</td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                <button data-id="{{ $product->id }}"
                                                    class="btn btn-danger delete-product"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Product</th>
                                        <th width="10%">SKU</th>
                                        {{-- <th>Avatar</th> --}}
                                        <th width="10%">Category</th>
                                        <th width="4%">Stock</th>
                                        <th width="10%">Expired Date</th>
                                        <th width="13%">Create Date</th>
                                        <th width="13%">Update Date</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{ $products->links() }}

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@push('scripts')
    @include('admin.layouts.partials.scripts-delete-ajax')
    <script>
        $(function() {
            $('.delete-product').on('click', function(e) {
                e.preventDefault();

                const productId = $(this).data('id'); // Lấy ID người dùng từ nút
                const rowElement = $(this).closest('tr'); // Xác định hàng tương ứng

                deleteRow('/admin/products/', rowElement, productId);
            });

            // Tự động ẩn alert sau 3 giây
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 15000);
        });
    </script>
@endpush
