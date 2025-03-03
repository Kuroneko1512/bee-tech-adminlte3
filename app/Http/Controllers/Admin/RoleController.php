<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    // Cách 1 dùng trong controller 
    protected $specialRoles;

    public function __construct()
    {
        $this->specialRoles = [
            RolesEnum::SuperAdmin->value,
            RolesEnum::Admin->value
        ];

        $this->middleware('permission:admin-role-view')->only(['index', 'show']);
        $this->middleware('permission:admin-role-create')->only(['create', 'store']);
        $this->middleware('permission:admin-role-update')->only(['edit', 'update']);
        $this->middleware('permission:admin-role-delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy danh sách roles kèm số lượng users và permissions
        $roles = Role::select('roles.*')
            ->selectRaw('(SELECT COUNT(*) FROM model_has_roles WHERE model_has_roles.role_id = roles.id) as total_users')
            ->with(['permissions' => function ($query) {
                $query->select('permissions.id', 'permissions.name');
            }])
            ->get();

        // dd($roles);
        // Kiểm tra roles và permissions
        // $user = Auth::guard('admin')->user();
        // dd($user->roles->first()->permissions()->pluck('name')->toArray());

        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy tự động các guard từ config auth.php, bỏ sanctum vì dùng passport( customer )
        $guards = collect(config('auth.guards'))
            ->reject(function ($guard) {
                return $guard['driver'] === 'sanctum'; // Loại bỏ sanctum guard
            })
            ->keys()
            ->toArray();

        // Nhóm permissions theo guard name
        $permissions = collect(PermissionsEnum::cases())->groupBy(function ($permission) {
            return explode('-', $permission->value)[0]; // Lấy phần đầu tiên làm guard name
        })->map(function ($guardPermissions) {
            return $guardPermissions->groupBy(function ($permission) {
                $parts = explode('-', $permission->value);
                // Get the feature group (user, product, order etc)
                return isset($parts[1]) ? $parts[1] : 'other';
            });
        });

        return view('admin.role.create', compact('guards', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'required|string|in:' . implode(',', array_keys(config('auth.guards'))),
            'permissions' => 'required|array',
            'permissions.*' => 'string'
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name']
        ]);

        $role->syncPermissions($validated['permissions']);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // cách 1
        // Lấy user hiện tại từ guard admin
        $admin = Auth::guard('admin')->user();
        // Kiểm tra nếu là super-admin
        if ($admin->roles->contains('name', RolesEnum::SuperAdmin->value)) {
            // Super admin không thể sửa chính role super-admin
            if ($role->name === RolesEnum::SuperAdmin->value) {
                abort(403, 'Không thể sửa role super-admin');
            }
        } else {
            // Admin thường không thể sửa các role đặc biệt
            if (in_array($role->name, $this->specialRoles)) {
                abort(403, 'Không thể sửa các role đặc biệt');
            }
        }

        // Logic lấy data cho form edit
        $guards = collect(config('auth.guards'))
            ->reject(function ($guard) {
                return $guard['driver'] === 'sanctum';
            })
            ->keys()
            ->toArray();

        $permissions = collect(PermissionsEnum::cases())
            ->groupBy(function ($permission) {
                return explode('-', $permission->value)[0];
            })
            ->map(function ($guardPermissions) {
                return $guardPermissions->groupBy(function ($permission) {
                    $parts = explode('-', $permission->value);
                    return isset($parts[1]) ? $parts[1] : 'other';
                });
            });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.role.edit', compact('guards', 'permissions', 'role', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // cách 1
        // Lấy user hiện tại từ guard admin
        $admin = Auth::guard('admin')->user();
        // Kiểm tra nếu là super-admin
        if ($admin->roles->contains('name', RolesEnum::SuperAdmin->value)) {
            // Super admin không thể sửa chính role super-admin
            if ($role->name === RolesEnum::SuperAdmin->value) {
                abort(403, 'Không thể sửa role super-admin');
            }
        } else {
            // Admin thường không thể sửa các role đặc biệt
            if (in_array($role->name, $this->specialRoles)) {
                abort(403, 'Không thể sửa các role đặc biệt');
            }
        }


        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'guard_name' => 'required|string|in:' . implode(',', array_keys(config('auth.guards'))),
            'permissions' => 'required|array',
            'permissions.*' => 'string'
        ]);

        $role->update([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name']
        ]);

        $role->syncPermissions($validated['permissions']);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // cách 1
        // Lấy user hiện tại từ guard admin
        $admin = Auth::guard('admin')->user();
        // Kiểm tra nếu là super-admin
        if ($admin->roles->contains('name', RolesEnum::SuperAdmin->value)) {
            // Super admin không thể sửa chính role super-admin
            if ($role->name === RolesEnum::SuperAdmin->value) {
                abort(403, 'Không thể sửa role super-admin');
            }
        } else {
            // Admin thường không thể sửa các role đặc biệt
            if (in_array($role->name, $this->specialRoles)) {
                abort(403, 'Không thể sửa các role đặc biệt');
            }
        }

        // Kiểm tra role có đang được sử dụng không
        if ($role->users()->exists()) {
            abort(403, 'Không thể xóa role đang được gán cho user');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
