<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    protected $specialRoles = ['super-admin', 'admin'];
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo('admin-role-view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin): bool
    {
        return $admin->hasPermissionTo('admin-role-view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo('admin-role-create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin): bool
    {
        return $admin->hasPermissionTo('admin-permission-update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        return $admin->hasPermissionTo('admin-permission-delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(Admin $admin): bool
    // {
    //     return $admin->hasPermissionTo('admin-permission-restore');
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(Admin $admin): bool
    // {
    //     return $admin->hasPermissionTo('admin-permission-force-delete');
    // }

    /**
     * Determine whether the user can assign permissions to the model.
     */
    public function assign(Admin $admin)
    {
        return $admin->hasPermissionTo('admin-permission-assign');
    }
}
