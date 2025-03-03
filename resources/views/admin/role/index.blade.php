@extends('admin.layouts.master')
@section('title')
    {{ __('List Roles') }}
@endsection
@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-shield mr-2"></i>
                            Role Management
                        </h3>
                        {{-- {{ dd(auth()->user()) }} --}}
                        @can('admin-role-create')
                            <div class="card-tools">
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus-circle mr-1"></i>Add New Role
                                </a>
                            </div>
                        @endcan
                    </div>

                    <div class="card-body">
                        <table class="table table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Role Name</th>
                                    <th width="45%">Permissions</th>
                                    <th width="15%">Users Count</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>
                                            <span class="font-weight-bold">{{ $role->name }}</span>
                                            @if ($role->name === 'super-admin')
                                                <i class="fas fa-star text-warning ml-1" title="Super Admin Role"></i>
                                            @endif
                                            @if ($role->name === 'admin')
                                                <i class="fas fa-shield-alt text-info ml-1" title="Admin Role"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $maxPermissionsToShow = 5; // Số lượng permission tối đa hiển thị
                                                $totalPermissions = count($role->permissions);
                                            @endphp

                                            @foreach ($role->permissions->take($maxPermissionsToShow) as $permission)
                                                <span class="badge badge-info">{{ $permission->name }}</span>
                                            @endforeach

                                            @if ($totalPermissions > $maxPermissionsToShow)
                                                <span class="badge badge-secondary">+
                                                    {{ $totalPermissions - $maxPermissionsToShow }} more</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $role->total_users ?? 0 }} users
                                            </span>
                                        </td>
                                        <td>
                                            @can('admin-role-update')
                                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('admin-role-delete')
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-role">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.delete-role').click(function(event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định
                    const roleId = $(this).data('role-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit delete form
                            $(this).closest('form').submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
