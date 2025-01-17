@extends('admin.layouts.master')

@section('title')
    Update User
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 m-auto">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        {{-- <form action="" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="form-group">
                                <label for="InputEmail">Email address</label>
                                <input type="email" class="form-control" id="InputEmail" name="email"
                                    placeholder="Enter email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="InputUserName">User Name</label>
                                <input type="text" class="form-control" id="InputUserName" name="user_name"
                                    placeholder="Enter User Name" value="{{ old('user_name', $user->user_name) }}">
                                @error('user_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="InputPassword">Password</label>
                                <input type="password" class="form-control" id="InputPassword" name="password"
                                    placeholder="Leave blank if you don't want to change">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="InputFirstName">First Name</label>
                                <input type="text" class="form-control" id="InputFirstName" name="first_name"
                                    placeholder="Enter First Name" value="{{ old('first_name', $user->first_name) }}">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="InputLastName">Last Name</label>
                                <input type="text" class="form-control" id="InputLastName" name="last_name"
                                    placeholder="Enter Last Name" value="{{ old('last_name', $user->last_name) }}">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="birthday">Birthday:</label>
                                <div class="input-group date" id="birthday-datetimepicker">
                                    <div class="input-group-append" data-target="#birthday-datetimepicker"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" name="birthday"
                                        id="birthday" data-target="#birthday-datetimepicker"
                                        value="{{ old('birthday', $user->birthday->format('d/m/Y')) }}">
                                </div>
                                @error('birthday')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="customFile">Avatar</label>
                                <!-- Show current avatar -->
                                <div class="mb-3">
                                    <label>Current Avatar:</label>
                                    @if ($user->avatar)
                                        <img src="{{ $user->avatar ? Storage::url($user->avatar) : Storage::url('default/avatar.jpg') }}"
                                            alt="{{ $user->last_name }} {{ $user->first_name }}"
                                            class="img-fluid img-circle img-md elevation-2 float-none" width="35">
                                    @else
                                        <p>No avatar uploaded.</p>
                                    @endif
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="avatar"
                                        value="">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                @error('avatar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@push('scripts')
    @include('admin.layouts.partials.scripts-form')
@endpush
