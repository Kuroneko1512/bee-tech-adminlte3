<?php

namespace App\Policies;

use App\Models\Admin;
use App\Enums\PermissionsEnum;
use Illuminate\Auth\Access\Response;
use Barryvdh\Debugbar\Facades\Debugbar;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    protected $specialPermissions;

    public function __construct()
    {
        // Khởi tạo danh sách role đặc biệt
        $this->specialPermissions = [
            PermissionsEnum::AdminPermissionUpdate->value,
            PermissionsEnum::AdminPermissionDelete->value,
            PermissionsEnum::AdminPermissionView->value,
            PermissionsEnum::AdminPermissionCreate->value,
            PermissionsEnum::AdminPermissionAssign->value,
            PermissionsEnum::AdminRoleView->value,
            PermissionsEnum::AdminRoleCreate->value,
            PermissionsEnum::AdminRoleUpdate->value,
            PermissionsEnum::AdminRoleDelete->value,
            PermissionsEnum::AdminRoleAssign->value,
        ];
    }
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo(PermissionsEnum::AdminPermissionView->value);
    }

    // /**
    //  * Determine whether the admin can view the model. function show
    //  */
    // public function view(Admin $admin, Permission $permission): bool
    // {
    //     //
    // }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo(PermissionsEnum::AdminPermissionCreate->value);
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Permission $permission): bool
    {
        // Kiểm tra quyền cập nhật permission
        if (!$admin->hasPermissionTo(PermissionsEnum::AdminPermissionUpdate->value)) {
            Debugbar::info('Admin does not have permission to update.');
            throw new \Illuminate\Auth\Access\AuthorizationException('You do not have permission to update this permission.');
        }

        // Check permission đặc biệt
        if (in_array($permission->name, $this->specialPermissions)) {
            Debugbar::info('Permission is special and cannot be updated: ' . $permission->name);
            throw new \Illuminate\Auth\Access\AuthorizationException('This permission is special and cannot be updated.');
        }

        // Kiểm tra permission đang được sử dụng
        if ($permission->roles()->exists()) {
            Debugbar::info('This permission is currently in use and cannot be updated: ' . $permission->name);
            throw new \Illuminate\Auth\Access\AuthorizationException('This permission is currently in use and cannot be updated.');
        }

        return true;
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Permission $permission): bool
    {
        // Kiểm tra quyền xóa permission
        if (!$admin->hasPermissionTo(PermissionsEnum::AdminPermissionDelete->value)) {
            return false;
        }

        // Check permission đặc biệt
        if (in_array($permission->name, $this->specialPermissions)) {
            return false;
        }

        // Không thể xóa permission đang được sử dụng
        return !$permission->roles()->exists();
    }

    // /**
    //  * Determine whether the admin can restore the model.
    //  */
    // public function restore(Admin $admin, Permission $permission): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the admin can permanently delete the model.
    //  */
    // public function forceDelete(Admin $admin, Permission $permission): bool
    // {
    //     //
    // }
}
