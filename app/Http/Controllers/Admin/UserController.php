<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Mail\UserMail;
use Illuminate\Http\Request;
use App\Traits\UploadFileTrait;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Jobs\ProcessCreateUpdateEmail;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    use UploadFileTrait;

    public function __construct()
    {
        // Quyền quản lý user cơ bản
        $this->middleware('permission:admin-user-view')->only(['index', 'show']);
        $this->middleware('permission:admin-user-create')->only(['create', 'store']);
        $this->middleware('permission:admin-user-update')->only(['edit', 'update']);
        $this->middleware('permission:admin-user-delete')->only('destroy');

        // Quyền gán role cho user
        $this->middleware('permission:admin-role-assign')->only(['create', 'store', 'edit', 'update']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $users = User::latest('id')->paginate(15);
        // $query = User::query();
        $query = User::with('roles');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('user_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        $users = $query->latest('id')->paginate(15);
        Debugbar::info('Users List:');
        Debugbar::info($users->items());
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy danh sách roles có guard_name là 'web'
        $roles = Role::where('guard_name', 'web')->get();
        Debugbar::info('Access Create User Form');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {

            $data = $request->all();

            Debugbar::info('Request Data:');
            Debugbar::info($data);

            $data['status'] = 'active';
            $data['flag_delete'] = 0;
            $data['avatar'] = $this->handleUploadFile($request, 'avatar', 'users');

            Debugbar::info('Data before create:');
            Debugbar::info($data);

            DB::enableQueryLog();
            DB::beginTransaction();
            $user = User::create($data);

            // Gán role nếu có trong request
            if ($request->has('roles')) {
                $user->assignRole($request->roles);
            }
            DB::commit();
            Debugbar::info('Query Log:');
            Debugbar::info(DB::getQueryLog());

            // Dispatch email job
            ProcessCreateUpdateEmail::dispatch(
                new UserMail($user, 'created'),
                $user->email
            )->delay(now()->addSeconds(30))->onQueue('user-notifications');

            return redirect()->route(getRouteName('users.index'))
                ->with('success', 'Thêm người dùng thành công');
        } catch (\Throwable $e) {
            DB::rollBack();
            Debugbar::error('Store User Error:');
            Debugbar::error($e->getMessage());

            return back()->withInput()
                ->with('error', 'Thêm người dùng thất bại');
            // throw $e; // Throw lại exception để xem chi tiết lỗi
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Lấy roles với guard web
        $roles = Role::where('guard_name', 'web')->get();

        // Lấy roles hiện tại của user
        $userRoles = $user->roles->pluck('name')->toArray();

        Debugbar::info('Edit User Data:');
        Debugbar::info($user->toArray());
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $data = $request->all();

            Debugbar::info('Request Data:');
            Debugbar::info($data);

            // So sánh và chỉ giữ lại các trường có thay đổi
            foreach ($data as $key => $value) {
                if ($key === 'password') {
                    if (!$value) {
                        unset($data[$key]);
                    } else {
                        $data[$key] = Hash::make($value);
                    }
                    continue;
                }

                if ($value === $user->$key) {
                    unset($data[$key]);
                }
            }

            // Xử lý riêng cho avatar
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $this->handleUploadFile($request, 'avatar', 'users', $user->avatar);
            } else {
                unset($data['avatar']);
            }

            Debugbar::info('Changed Data:');
            Debugbar::info($data);

            if (!empty($data)) {
                DB::enableQueryLog();

                $user->update($data);

                // Update roles if has permission
                if ($request->has('roles')) {
                    $user->syncRoles($request->roles);
                }

                Debugbar::info('Query executed:');
                Debugbar::info(DB::getQueryLog());
                // dd($user->province->name); 

                ProcessCreateUpdateEmail::dispatch(
                    new UserMail($user, 'updated'),
                    $user->email
                )->delay(now()->addSeconds(10))->onQueue('user-notifications');

                // return dd([
                //     'request_all' => $request->all(),
                //     'data' => $data, 
                //     'files' => $request->allFiles(),
                //     'old_user' => $user->toArray(),
                //     'province'   => gettype($user->province->name),
                // ]);
                // return back();
                return redirect()->route(getRouteName('users.index'))
                    ->with('success', 'Cập nhật thành công');
            }

            return back()->with('info', 'Không có thông tin nào được thay đổi');
        } catch (\Throwable $e) {
            Debugbar::error('Update User Error:');
            Debugbar::error($e->getMessage());
            // throw $e;
            return back()->withInput()
                ->with('error', 'Cập nhật thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            Debugbar::info('Deleting User:');
            Debugbar::info($user->toArray());

            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
                Debugbar::info('Deleted Avatar:');
                Debugbar::info($user->avatar);
            }

            $user->delete();
            Debugbar::info('User Deleted Successfully');

            return response()->json([
                'success' => true,
                'message' => 'Xóa người dùng thành công'
            ]);
        } catch (\Throwable $e) {
            Debugbar::error('Delete User Error:');
            Debugbar::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Xóa người dùng thất bại'
            ]);
        }
    }
}
