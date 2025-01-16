@extends('admin.layouts.master')

@section('title')
    Create User
@endsection

@section('contents')
    <div class="row">
        <div class="col-6 m-auto">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label for="InputEmail">Email address</label>
                            <input type="email" class="form-control" id="InputEmail" name="email"
                                placeholder="Enter email" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="InputUserName">User Name</label>
                            <input type="text" class="form-control" id="InputUserName" name="user_name"
                                placeholder="Enter User Name" value="{{ old('user_name') }}">
                            @error('user_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="InputPassword">Password</label>
                            <input type="password" class="form-control" id="InputPassword" name="password"
                                placeholder="Password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="InputFirstName">First Name</label>
                            <input type="text" class="form-control" id="InputFirstName" name="first_name"
                                placeholder="Enter First Name" value="{{ old('first_name') }}">
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="InputLastName">Last Name</label>
                            <input type="text" class="form-control" id="InputLastName" name="last_name"
                                placeholder="Enter Last Name" value="{{ old('last_name') }}">
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
                                    id="birthday" data-target="#birthday-datetimepicker" value="{{ old('birthday') }}">
                            </div>
                            @error('birthday')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="customFile">Avatar</label>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="avatar" value="">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            @error('avatar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
