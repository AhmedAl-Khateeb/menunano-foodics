<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()
            ->where('created_by', auth()->id())
            ->with('creator')->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'super_admin') {
            $roles = \Spatie\Permission\Models\Role::where('created_by', auth()->id())->get();
        } else {
            // Static roles for Store Admin
            $roles = collect([
                (object)['id' => 'cashier', 'name' => 'cashier']
            ]);
        }
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // 'role' => 'required|in:admin,super_admin,user', // Removed as we force 'user'
            // 'role_id' => 'required|exists:roles,id', // Modified to allow static 'cashier'
             'role_id' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Force role column to be 'user' for created staff
            'created_by' => auth()->id(),
        ]);

        // Store Admin logic: update role if user is admin
        if ($request->filled('role_id') && auth()->user()->role == 'admin') {
            $user->role = $request->role_id;
            $user->save();
        }
        // Super Admin logic: sync roles if user is super admin
        else if ($request->filled('role_id') && auth()->user()->role == 'super_admin') {
            $role = \Spatie\Permission\Models\Role::find($request->role_id);
            if ($role) {
                $user->assignRole($role);
            }
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (auth()->user()->role === 'super_admin') {
            $roles = \Spatie\Permission\Models\Role::where('created_by', auth()->id())->get();
        } else {
            $roles = collect([
                (object)['id' => 'cashier', 'name' => 'cashier']
            ]);
        }
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // 'role' => 'required|in:admin,super_admin,user',
            // 'role_id' => 'required|exists:roles,id',
            'role_id' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Store Admin logic: update role if user is admin
        if ($request->filled('role_id') && auth()->user()->role == 'admin') {
            $user->update(['role' => $request->role_id]);
        }
        // Super Admin logic: sync roles if user is super admin
        else if ($request->filled('role_id') && auth()->user()->role == 'super_admin') {
            $role = \Spatie\Permission\Models\Role::find($request->role_id);
            if ($role) {
                $user->syncRoles([$role]);
            }
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
