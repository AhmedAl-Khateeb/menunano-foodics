<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Branch;
use App\Models\User;
use App\Services\UserService;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function index()
    {
        $users = $this->userService->index();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (auth()->user()->role === 'super_admin') {
            $roles = Role::where('created_by', auth()->id())->get();
        } else {
            $roles = collect([
                (object) ['id' => 'cashier', 'name' => 'cashier'],
            ]);
        }

        $branches = Branch::where('created_by', auth()->id())
            ->where('is_active', true)
            ->get();

        return view('users.create', compact('roles', 'branches'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->store($request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role === 'super_admin') {
            $roles = Role::where('created_by', auth()->id())->get();
        } else {
            $roles = collect([
                (object) ['id' => 'cashier', 'name' => 'cashier'],
            ]);
        }

        $branches = Branch::where('created_by', auth()->id())->get();

        return view('users.edit', compact('user', 'roles', 'branches'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($user, $request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        try {
            $this->userService->delete($user);

            return redirect()
                ->route('users.index')
                ->with('success', 'تم حذف المستخدم بنجاح');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage() ?: 'حدث خطأ أثناء الحذف');
        }
    }
}
