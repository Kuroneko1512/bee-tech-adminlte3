<?php

namespace App\Policies;

use App\Models\Admin;
use App\Enums\RolesEnum;
use App\Enums\PermissionsEnum;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    protected $specialRoles;

    public function __construct()
    {
        // Khởi tạo danh sách role đặc biệt
        $this->specialRoles = [
            RolesEnum::SuperAdmin->value,
            RolesEnum::Admin->value
        ];
    }

    /**
     * Determine whether the admin can view any roles.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo(PermissionsEnum::AdminRoleView->value);
    }

    /**
     * Determine whether the admin can view the role.
     */
    public function view(Admin $admin, Role $role): bool
    {
        return $admin->hasPermissionTo(PermissionsEnum::AdminRoleView->value);
    }

    /**
     * Determine whether the admin can create roles.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo(PermissionsEnum::AdminRoleCreate->value);
    }

    /**
     * Determine whether the admin can update the role.
     */
    public function update(Admin $admin, Role $role): bool
    {
        // Check quyền update role
        if (!$admin->hasPermissionTo(PermissionsEnum::AdminRoleUpdate->value)) {
            return false;
        }

        // Super admin không thể sửa role super-admin
        if ($admin->hasRole(RolesEnum::SuperAdmin->value)) {
            return $role->name !== RolesEnum::SuperAdmin->value;
        }

        // Admin thường không thể sửa các role đặc biệt
        return !in_array($role->name, $this->specialRoles);
    }

    /**
     * Determine whether the admin can delete the role.
     */
    public function delete(Admin $admin, Role $role): bool
    {
        // Check quyền xóa role
        if (!$admin->hasPermissionTo(PermissionsEnum::AdminRoleDelete->value)) {
            return false;
        }

        // Check role đặc biệt
        if ($admin->hasRole(RolesEnum::SuperAdmin->value)) {
            if ($role->name === RolesEnum::SuperAdmin->value) {
                return false;
            }
        } else {
            if (in_array($role->name, $this->specialRoles)) {
                return false;
            }
        }

        // Không thể xóa role đang được sử dụng
        return !$role->users()->exists();
    }

    /**
     * Determine whether the admin can assign permissions to roles
     */
    public function assignRoles(Admin $admin): bool
    {
        return $admin->hasPermissionTo(PermissionsEnum::AdminRoleAssign->value);
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

}
