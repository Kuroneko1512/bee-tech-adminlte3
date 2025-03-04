@extends('admin.layouts.master')

@section('title')
    Update User
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route(getRouteName('users.update'), $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        {{-- <form action="" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <!-- Basic Information -->
                            <h5 class="mb-3">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="InputUserName">User Name</label>
                                        <input type="text" class="form-control" id="InputUserName" name="user_name"
                                            placeholder="Enter User Name" value="{{ old('user_name', $user->user_name) }}">
                                        @error('user_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="InputEmail">Email address</label>
                                        <input type="email" class="form-control" id="InputEmail" name="email"
                                            placeholder="Enter email" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="InputPassword">Password</label>
                                        <input type="password" class="form-control" id="InputPassword" name="password"
                                            placeholder="Leave blank if you don't want to change">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <h5 class="mt-4 mb-3">Personal Information</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="InputLastName">Last Name</label>
                                        <input type="text" class="form-control" id="InputLastName" name="last_name"
                                            placeholder="Enter Last Name" value="{{ old('last_name', $user->last_name) }}">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="InputFirstName">First Name</label>
                                        <input type="text" class="form-control" id="InputFirstName" name="first_name"
                                            placeholder="Enter First Name"
                                            value="{{ old('first_name', $user->first_name) }}">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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
                            </div>

                            <!-- Location Information -->
                            <h5 class="mt-4 mb-3">Location Information</h5>

                            <div class="row">
                                <div class="col ">
                                    <div class="form-group">
                                        <label for="InputAddress">Address</label>
                                        <input type="text" class="form-control" id="InputAddress" name="address"
                                            placeholder="Enter Address" value="{{ old('address', $user->address) }}">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="province_id">Province</label>
                                        <select name="province_id" id="province" class="form-control select2 select2-blue"
                                            data-dropdown-css-class="select2-navy" style="width: 100%;">
                                            <option value="">Chọn tỉnh/thành </option>
                                        </select>
                                        @error('province_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district_id">District</label>
                                        <select name="district_id" id="district"
                                            class="form-control select2 select2-blue"
                                            data-dropdown-css-class="select2-navy" style="width: 100%;">
                                            <option value="">Chọn quận/huyện</option>
                                        </select>
                                        @error('district_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="commune_id">Commune</label>
                                        <select name="commune_id" id="commune"
                                            class="form-control select2 select2-blue"
                                            data-dropdown-css-class="select2-navy" style="width: 100%;">
                                            <option value="">Chọn xã/phường</option>
                                        </select>
                                        @error('commune_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 mb-3">Role Information</h5>
                            <!-- Role selection section -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Roles</label>
                                        <div class="select2-purple">
                                            <select name="roles[]" class="select2" multiple="multiple"
                                                data-placeholder="Select roles" style="width: 100%;"
                                                {{ Auth::guard('admin')->user()->hasPermissionTo('admin-role-assign') ? '' : 'disabled' }}>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ in_array($role->name, $userRoles) ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('roles')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <!-- Profile Picture -->
                            <h5 class="mt-4 mb-3">Profile Picture</h5>
                            <div class="form-group">
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
                            <a href="{{ route(getRouteName('users.index')) }}"
                                class="btn btn-secondary float-right">Cancel</a>
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

    @include('admin.layouts.partials.scripts-drop-down-locationVN', [
        'selectedProvince' => old('province_id', $user->province_id ?? ''),
        'selectedDistrict' => old('district_id', $user->district_id ?? ''),
        'selectedCommune' => old('commune_id', $user->commune_id ?? ''),
    ])
@endpush
