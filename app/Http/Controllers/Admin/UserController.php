<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Traits\UploadFileTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use UploadFileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest('id')->paginate(15);
        Debugbar::info('Users List:');
        Debugbar::info($users->items());
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Debugbar::info('Access Create User Form');
        return view('admin.users.create');
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

            User::create($data);

            Debugbar::info('Query Log:');
            Debugbar::info(DB::getQueryLog());

            return redirect()->route('users.index')
                ->with('success', 'Thêm người dùng thành công');
        } catch (\Throwable $e) {
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
        Debugbar::info('Edit User Data:');
        Debugbar::info($user->toArray());
        return view('admin.users.edit', compact('user'));
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
            foreach($data as $key => $value) {
                if($key === 'password') {
                    if(!$value) {
                        unset($data[$key]);
                    } else {
                        $data[$key] = Hash::make($value);
                    }
                    continue;
                }
                
                if($value === $user->$key) {
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

                Debugbar::info('Query executed:');
                Debugbar::info(DB::getQueryLog());

                return back()->with('success', 'Cập nhật thành công');
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
            Debugbar::error( $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Xóa người dùng thất bại'
            ]);
        }
    }
}
