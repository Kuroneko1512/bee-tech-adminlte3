@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Role') }}
@endsection
@section('contents')
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Role: {{ $role->name }}</h3>
            </div>
            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="roleName">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="roleName"
                                    placeholder="Enter role name" value="{{ old('name', $role->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="guardName">Guard Name <span class="text-danger">*</span></label>
                                <select name="guard_name" class="form-control @error('guard_name') is-invalid @enderror"
                                    required>
                                    <option value="">Select Guard</option>
                                    @foreach ($guards as $guard)
                                        <option value="{{ $guard }}"
                                            {{ old('guard_name', $role->guard_name) == $guard ? 'selected' : '' }}>
                                            {{ ucfirst($guard) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guard_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Permissions</label>
                        <div class="card">
                            <div class="card-body">
                                @foreach ($permissions as $guard => $groupPermissions)
                                    <h5 class="border-bottom pb-2">{{ ucfirst($guard) }} Permissions</h5>
                                    <div class="row">
                                        @foreach ($groupPermissions as $group => $permissions)
                                            <div class="col-md-2">
                                                <div class="permission-group mb-4">
                                                    <h6 class="font-weight-bold">{{ ucfirst($group) }}</h6>
                                                    @foreach ($permissions as $permission)
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $permission->value }}"
                                                                class="custom-control-input"
                                                                id="perm_{{ $permission->value }}"
                                                                {{ in_array($permission->value, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                                            <label class="custom-control-label text-sm"
                                                                for="perm_{{ $permission->value }}">
                                                                {{ ucwords(str_replace([$guard . '-', '-'], ['', ' '], $permission->value)) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update and Back
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
