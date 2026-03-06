<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DeliveryMan;

class DeliveryManController extends Controller
{
    public function index()
    {
        $deliveryMen = DeliveryMan::where('user_id', auth()->id())->latest()->get();
        return view('dashboard.delivery_men.index', compact('deliveryMen'));
    }

    public function create()
    {
        return view('dashboard.delivery_men.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'commission_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        DeliveryMan::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'commission_percent' => $request->commission_percent ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('delivery_men.index')->with('success', 'تم إضافة عامل التوصيل بنجاح');
    }

    public function edit(DeliveryMan $deliveryMan)
    {
        if ($deliveryMan->user_id !== auth()->id()) abort(403);
        return view('dashboard.delivery_men.edit', compact('deliveryMan'));
    }

    public function update(Request $request, DeliveryMan $deliveryMan)
    {
        if ($deliveryMan->user_id !== auth()->id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'commission_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        $deliveryMan->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'commission_percent' => $request->commission_percent ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('delivery_men.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(DeliveryMan $deliveryMan)
    {
        if ($deliveryMan->user_id !== auth()->id()) abort(403);
        $deliveryMan->delete();
        return redirect()->route('delivery_men.index')->with('success', 'تم الحذف بنجاح');
    }
}
