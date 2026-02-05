<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Http\Requests\StoreChargeRequest;
use App\Http\Requests\UpdateChargeRequest;

class ChargeController extends Controller
{
    public function index()
    {
        $charges = Charge::latest()->get();
        return view('settings.charges.index', compact('charges'));
    }

    public function store(StoreChargeRequest $request)
    {
        Charge::create($request->validated());
        return redirect()->route('charges.index')->with('success', 'تم إضافة السجل بنجاح');
    }

    public function update(UpdateChargeRequest $request, Charge $charge)
    {
        $charge->update($request->validated());
        return redirect()->route('charges.index')->with('success', 'تم تحديث السجل بنجاح');
    }

    public function destroy(Charge $charge)
    {
        $charge->delete();
        return redirect()->route('charges.index')->with('success', 'تم حذف السجل بنجاح');
    }
}
