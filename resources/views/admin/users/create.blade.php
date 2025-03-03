@extends('admin.layouts.master')

@section('title')
    Create User
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            {{-- old view --}}
            {{-- <div class="col-6 m-auto">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route(getRouteName('users.store')) }}" method="POST" enctype="multipart/form-data">
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
                                        id="birthday" data-target="#birthday-datetimepicker"
                                        value="{{ old('birthday') }}">
                                </div>
                                @error('birthday')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="customFile">Avatar</label>

                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="avatar"
                                        value="">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                @error('avatar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Select boxes địa chỉ -->
                            <div class="form-group">
                                <label>Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <select name="province_id" id="province" class="form-control" required>
                                    <option value="">Chọn tỉnh/thành</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quận/Huyện <span class="text-danger">*</span></label>
                                <select name="district_id" id="district" class="form-control" required>
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Xã/Phường <span class="text-danger">*</span></label>
                                <select name="commune_id" id="commune" class="form-control" required>
                                    <option value="">Chọn xã/phường</option>
                                </select>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div> --}}

            {{-- new view --}}
            <div class="col-md-8 offset-md-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New User</h3>
                    </div>
                    <form method="POST" action="{{ route(getRouteName('users.store')) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Basic Information -->
                            <h5 class="mb-3">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="InputUserName">User Name</label>
                                        <input type="text" class="form-control" id="InputUserName" name="user_name"
                                            placeholder="Enter User Name" value="{{ old('user_name') }}">
                                        @error('user_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="InputEmail">Email address</label>
                                        <input type="email" class="form-control" id="InputEmail" name="email"
                                            placeholder="Enter email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="InputPassword">Password</label>
                                        <input type="password" class="form-control" id="InputPassword" name="password"
                                            placeholder="Password">
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
                                            placeholder="Enter Last Name" value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="InputFirstName">First Name</label>
                                        <input type="text" class="form-control" id="InputFirstName" name="first_name"
                                            placeholder="Enter First Name" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="birthday">Birthday:</label>
                                        <div class="input-group date" id="birthday-datetimepicker">
                                            <div class="input-group-append" data-target="#birthday-datetimepicker"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="birthday"
                                                id="birthday" data-target="#birthday-datetimepicker"
                                                value="{{ old('birthday') }}">
                                        </div>
                                        @error('birthday')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Location Information -->
                            <h5 class="mt-4 mb-3">Location Information</h5>

                            <div class="row">
                                <div class="col ">
                                    <div class="form-group">
                                        <label for="InputAddress">Address</label>
                                        <input type="text" class="form-control" id="InputAddress" name="address"
                                            placeholder="Enter Address" value="{{ old('address') }}">
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
                                            <option value="">Chọn tỉnh/thành</option>
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
                            <!-- Thêm field roles -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Roles</label>
                                        <div class="select2-purple">
                                            <select name="roles[]" class="select2" multiple="multiple"
                                                data-placeholder="Select roles" style="width: 100%;">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">
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
                            <button type="submit" class="btn btn-primary">Create User</button>
                            <a href="{{ route(getRouteName('users.index')) }}"
                                class="btn btn-secondary float-right">Cancel</a>
                        </div>
                    </form>
                </div>
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
