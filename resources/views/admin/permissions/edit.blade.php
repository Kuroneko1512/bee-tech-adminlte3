@extends('admin.layouts.master')

@section('title')
    {{ __('Edit Permission') }}
@endsection

@section('contents')
    <div class="container-fluid">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Permission: {{ $permission->name }}</h3>
            </div>
            <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="permissionName">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="permissionName" placeholder="Enter permission name"
                            value="{{ old('name', $permission->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="guardName">Guard Name <span class="text-danger">*</span></label>
                        <select name="guard_name" class="form-control @error('guard_name') is-invalid @enderror"
                            id="guardSelect" required>
                            <option value="">Select Guard</option>
                            @foreach ($guards as $guard)
                                <option value="{{ $guard }}"
                                    {{ old('guard_name', $permission->guard_name) == $guard ? 'selected' : '' }}>
                                    {{ ucfirst($guard) }}
                                </option>
                            @endforeach
                        </select>
                        @error('guard_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
