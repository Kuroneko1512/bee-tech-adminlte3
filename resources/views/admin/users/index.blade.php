@extends('admin.layouts.master')

@section('title')
    List Users
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Users</h3>
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
                                    <a href="{{ route(getRouteName('users.create')) }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add Product
                                    </a>
                                    {{-- <a href="{{ route(getRouteName('products.download'), ['type' => 'excel']) }}"
                                        class="btn btn-success">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </a>
                                    <a href="{{ route(getRouteName('products.download'), ['type' => 'csv']) }}"
                                        class="btn btn-info">
                                        <i class="fas fa-file-csv"></i> CSV
                                    </a>
                                    <a href="{{ route(getRouteName('products.download'), ['type' => 'pdf']) }}"
                                        class="btn btn-danger">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                    <button type="button" class="btn btn-secondary" onclick="window.print()">
                                        <i class="fas fa-print"></i> Print
                                    </button> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Thêm form tìm kiếm -->
                                <form method="GET" action="{{ route(getRouteName('users.index')) }}" class="mb-4">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="keyword" class="form-control"
                                            placeholder="Tìm kiếm theo tên, username hoặc email..."
                                            value="{{ request('keyword') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i> Tìm kiếm
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <table id="example1" class="table table-bordered table-striped table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Birthday</th>
                                        <th>Name</th>
                                        {{-- <th>Last Name</th> --}}
                                        <th>Status</th>
                                        <th>Create Date</th>
                                        <th>Update Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->user_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->birthday->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="#" class="d-flex align-items-center text-secondary">
                                                    <img src="{{ $user->avatar ? Storage::url($user->avatar) : Storage::url('default/avatar.jpg') }}"
                                                        alt="{{ $user->last_name }} {{ $user->first_name }}"
                                                        class="img-fluid img-circle img-md elevation-2" width="35">
                                                    <span class="ml-2">{{ $user->last_name }}
                                                        {{ $user->first_name }}</span>
                                                </a>
                                            </td>

                                            {{-- <td>
                                        <a href="#" class="d-flex align-items-center text-secondary">
                                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/default/avatar.jpg') }}"
                                                alt="{{ $user->last_name }} {{ $user->first_name }}"
                                                class="img-fluid img-circle img-md elevation-2" width="35">
                                            <span class="ml-2">{{ $user->last_name }} {{ $user->first_name }}</span>
                                        </a>
                                    </td> --}}
                                            {{-- <td>Last Name</td> --}}
                                            <td>
                                                @if ($user->status == 'active')
                                                    <span class="badge badge-pill badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                                            <td>
                                                {{-- <a href="#" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a> --}}
                                                <a href="{{ route(getRouteName('users.edit'), $user->id) }}"
                                                    class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                <button class="btn btn-danger delete-user" data-id="{{ $user->id }}"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Birthday</th>
                                        <th>Name</th>
                                        {{-- <th>Last Name</th> --}}
                                        <th>Status</th>
                                        <th>Create Date</th>
                                        <th>Update Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{ $users->links() }}
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
        window.deleteUrl = "{{ route(getRouteName('users.index')) }}/";

        $(function() {
            $('.delete-user').on('click', function(e) {
                e.preventDefault();

                const userId = $(this).data('id'); // Lấy ID người dùng từ nút
                const rowElement = $(this).closest('tr'); // Xác định hàng tương ứng

                // deleteRow('/admin/users/', rowElement, userId);
                deleteRow(window.deleteUrl, rowElement, userId);
            });

            // Tự động ẩn alert sau 3 giây
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@endpush
