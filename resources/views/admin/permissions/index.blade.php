@extends('admin.layouts.master')

@section('title')
    {{ __('List Permissions') }}
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Permission Management
                        </h3>
                        @can('admin-permission-create')
                            <div class="card-tools">
                                <a href="{{ route('admin.permissions.create') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus-circle mr-1"></i>Add New Permission
                                </a>
                            </div>
                        @endcan
                    </div>

                    <div class="card-body">
                        <table class="table table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="10%">ID</th>
                                    <th width="45%">Permission Name</th>
                                    <th width="30%">Guard Name</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->id }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                        <td>
                                            @can('admin-permission-update')
                                                <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('admin-permission-delete')
                                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-permission">
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
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.delete-permission').click(function(event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định
                    const permissionId = $(this).data('permission-id');
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
