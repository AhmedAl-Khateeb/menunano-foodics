<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $query = PaymentMethod::query();

        if (auth()->user()->role === 'super_admin') {
            $query->whereNull('created_by');
        } else {
            $query->where('created_by', auth()->id());
        }

        $methods = $query->orderByDesc('id')->paginate(15);

        return view('super_admin.payment_methods.index', compact('methods'));
    }

    public function create()
    {
        return view('super_admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:payment_methods,name',
            'description' => 'nullable|string',
            'phone'       => 'required|string|max:50',
            'is_active'   => 'nullable|boolean',
        ]);

        PaymentMethod::create([
            'name'        => $request->name,
            'description' => $request->description,
            'phone'       => $request->phone,
            'is_active'   => $request->has('is_active') ? 1 : 0,
            'created_by'  => auth()->user()->role === 'super_admin' ? null : auth()->id(),
        ]);

        return redirect()
            ->route('super.payment-methods.index')
            ->with('success', 'تمت إضافة وسيلة الدفع بنجاح');
    }

    public function edit(PaymentMethod $payment_method)
    {
        return view('super_admin.payment_methods.edit', ['method' => $payment_method]);
    }

    public function update(Request $request, PaymentMethod $payment_method)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:payment_methods,name,' . $payment_method->id,
            'description' => 'nullable|string',
            'phone'       => 'required|string|max:50',
            'is_active'   => 'nullable|boolean',
        ]);

        $payment_method->update([
            'name'        => $request->name,
            'description' => $request->description,
            'phone'       => $request->phone,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('super.payment-methods.index')
            ->with('success', 'تم تعديل وسيلة الدفع بنجاح');
    }

    public function destroy(PaymentMethod $payment_method)
    {
        $payment_method->delete();

        return redirect()
            ->route('super.payment-methods.index')
            ->with('success', 'تم حذف وسيلة الدفع بنجاح');
    }

    public function toggle($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->is_active = !$method->is_active;
        $method->save();

        return redirect()
            ->route('super.payment-methods.index')
            ->with('success', 'تم تحديث الحالة');
    }
}