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
                                                <span class="ml-2">{{ $user->last_name }} {{ $user->first_name }}</span>
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
                                            <a href="#" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                                    <th>First Name</th>
                                    {{-- <th>Last Name</th> --}}
                                    <th>Status</th>
                                    <th>Create Date</th>
                                    <th>Update Date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
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
