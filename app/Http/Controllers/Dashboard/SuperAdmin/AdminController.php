<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Models\User;
use App\Models\Package;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('package')
            ->where('role', 'admin')
            ->orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('email', 'like', "%{$searchTerm}%")
                    ->orWhere('phone', 'like', "%{$searchTerm}%")
                    ->orWhere('store_name', 'like', "%{$searchTerm}%");
            });
        }

        // تصفية حسب الحالة
        if ($request->has('status') && $request->status !== null && $request->status !== 'all') {
            $status = $request->status == 'active' ? 1 : 0;
            $query->where('status', $status);
        }

        $admins = $query->paginate(10);

        // Statistics (Database Level)
        $totalAdmins = User::where('role', 'admin')->count();
        $activeAdmins = User::where('role', 'admin')->where('status', 1)->count();
        $inactiveAdmins = User::where('role', 'admin')->where('status', 0)->count();

        return view('super_admin.admins.index', compact('admins', 'totalAdmins', 'activeAdmins', 'inactiveAdmins'));
    }


    // فورم الإضافة
    public function create()
    {
        return view('super_admin.admins.create');
    }

    // تخزين المدير الجديد
    public function store(Request $request)
    {
        $request->validate([
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed|min:6',
            'phone'      => 'nullable|string|max:20|unique:users',
            'store_name' => 'required|string|max:255',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'     => 'required|in:0,1',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'store_name', 'status']);
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'admin';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('admins', 'public');
        }

        User::create($data);

        return redirect()->route('admins.index')->with('success', 'تم إضافة المدير بنجاح');
    }

    public function show($id)
    {
        $admin = User::with('package')->findOrFail($id);
        return view('super_admin.admins.show', compact('admin'));
    }

    // فورم التعديل
    public function edit($id)
    {
        $admin = User::where('role', '!=', 'super_admin')->findOrFail($id);
        $packages = Package::all();
        return view('super_admin.admins.edit', compact('admin', 'packages'));
    }

    // تحديث البيانات
    public function update(Request $request, $id)
    {
        $admin = User::where('role', '!=', 'super_admin')->findOrFail($id);

        $request->validate([
            'email'      => 'required|email|unique:users,email,' . $admin->id,
            'password'   => 'nullable|min:6',
            'phone'      => 'nullable|string|max:20',
            'store_name' => 'nullable|string|max:255',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'     => 'required|in:0,1',
            'package_id' => 'nullable|exists:packages,id',
            'subscription_start' => 'nullable|date',
        ]);

        $data = $request->only(['email', 'phone', 'store_name', 'status', 'package_id']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            if ($admin->image) {
                Storage::disk('public')->delete($admin->image);
            }
            $data['image'] = $request->file('image')->store('admins', 'public');
        }

        $package = Package::find($request->package_id);

        if ($request->filled('subscription_start') && $package) {
            $startDate = Carbon::parse($request->subscription_start);
            $endDate   = $startDate->copy()->addDays($package->duration);

            $data['subscription_start'] = $startDate;
            $data['subscription_end']   = $endDate;
        }

        if ($package && $package->price == 0) {
            $data['status'] = 1;

            if (empty($data['subscription_start'])) {
                $data['subscription_start'] = now();
                $data['subscription_end']   = now()->addDays($package->duration);
            }
        }

        $admin->update($data);

        return redirect()->route('admins.index')->with('success', 'تم تحديث بيانات المدير');
    }

    // الحذف
    public function destroy($id)
    {
        $admin = User::where('role', '!=', 'super_admin')->findOrFail($id);

        if ($admin->image) {
            Storage::disk('public')->delete($admin->image);
        }

        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'تم حذف المدير بنجاح');
    }

    public function deactivateAll()
    {
        // تحديث جميع المدراء باستثناء super_admin
        User::where('role', 'admin')->update(['status' => 0]);

        return redirect()->route('admins.index')->with('success', 'تم إيقاف جميع حسابات المدراء بنجاح');
    }
    public function toggleStatus($id)
    {
        $admin = User::findOrFail($id);
        $admin->status = $admin->status ? 0 : 1;
        $admin->save();

        return redirect()->back()->with('success', 'تم تحديث حالة المدير بنجاح');
    }
}
