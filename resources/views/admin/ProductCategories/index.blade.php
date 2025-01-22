@extends('admin.layouts.master')

@section('title')
    Product Categories
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Product Categories</h3>
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
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    {{-- <th>Last Name</th> --}}
                                    <th>Create Date</th>
                                    <th>Update Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productCategories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->parent ? $category->parent->name : '' }}</td>
                                        {{-- <td>Last Name</td> --}}
                                        <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $category->updated_at->format('d/m/Y H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            <button class="btn btn-danger delete-category" data-id="{{ $category->id }}"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    {{-- <th>Last Name</th> --}}
                                    <th>Create Date</th>
                                    <th>Update Date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $productCategories->links() }}
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
            $('.delete-category').on('click', function(e) {
                e.preventDefault();

                const categoryId = $(this).data('id'); // Lấy ID người dùng từ nút
                const rowElement = $(this).closest('tr'); // Xác định hàng tương ứng

                deleteRow('/admin/categories/', rowElement, categoryId);
            });

            // Tự động ẩn alert sau 3 giây
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@endpush
