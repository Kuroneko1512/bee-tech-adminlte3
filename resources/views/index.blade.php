@extends('admin.layouts.master')
@push('styles')
    {{-- @include('admin.layouts.partials.styles-table') --}}
@endpush


@section('title')
    Trang Chủ
@endsection

@section('contents')
    <h1>Trang Chủ</h1>
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List Users</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-responsive table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Birthday</th>
                                <th>First Name</th>
                                {{-- <th>Last Name</th> --}}
                                <th>Status</th>
                                <th>Create Date</th>
                                <th>Update Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->user_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->birthday }}</td>
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-secondary">
                                            <img src="" alt="User Image" class="mr-2">
                                            <span>{{ $user->last_name }} {{ $user->first_name }}</span>
                                        </a>
                                    </td> --}}
                            {{-- <td>Last Name</td> --}}
                            {{-- <td>{{ $user->status }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach --}}
                            <tr>
                                <td>ID</td>
                                <td>User Name</td>
                                <td>Email</td>
                                <td>Birthday</td>
                                <td>First Name</td>
                                {{-- <td>Last Name</td> --}}
                                <th>Status</th>
                                <td>Create Date</td>
                                <td>Update Date</td>
                                <td>Action</td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Birthday</th>
                                <th>First Name</th>
                                {{-- <th>Last Name</th> --}}
                                <th>Status</th>
                                <th>Create Date</th>
                                <th>Update Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection

@push('scripts')
    {{-- @include('admin.layouts.partials.scripts-table') --}}
@endpush
