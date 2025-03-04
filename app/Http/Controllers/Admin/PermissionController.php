<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Permission::class);
        $permissions = Permission::latest('id')->paginate(15);
        Debugbar::info('Permissions List:');
        Debugbar::info($permissions->items());
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Permission::class);

        // Lấy tự động các guard từ config auth.php, bỏ sanctum vì dùng passport( customer )
        $guards = collect(config('auth.guards'))
            ->reject(function ($guard) {
                return $guard['driver'] === 'sanctum'; // Loại bỏ sanctum guard
            })
            ->keys()
            ->toArray();

        return view('admin.permissions.create', compact('guards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|in:' . implode(',', array_keys(config('auth.guards'))),
        ]);

        $permission = Permission::create($validated);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        try {
            $this->authorize('update', $permission);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }

        // Lấy tự động các guard từ config auth.php, bỏ sanctum vì dùng passport( customer )
        $guards = collect(config('auth.guards'))
            ->reject(function ($guard) {
                return $guard['driver'] === 'sanctum'; // Loại bỏ sanctum guard
            })
            ->keys()
            ->toArray();

        $permission = Permission::findOrFail($permission->id);
        return view('admin.permissions.edit', compact('permission', 'guards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
