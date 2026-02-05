<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Unit::with('baseUnit');

        if ($request->has('type') && in_array($request->type, ['count', 'weight', 'volume'])) {
            $query->where('type', $request->type);
        }

        $units = $query->get();
        // Base units for dropdown - still get all base units regardless of filter
        // so user can see context, or filter this too if strictly enforcing siloed types
        $baseUnits = Unit::base()->get();
        
        return view('settings.units.index', compact('units', 'baseUnits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        Unit::create($request->validated());
        return redirect()->route('units.index')->with('success', 'تم إضافة وحدة القياس بنجاح');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return redirect()->route('units.index')->with('success', 'تم تحديث وحدة القياس بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        if ($unit->subUnits()->exists()) {
             return redirect()->route('units.index')->with('error', 'لا يمكن حذف هذه الوحدة لأنها مرتبطة بوحدات فرعية');
        }
        
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'تم حذف وحدة القياس بنجاح');
    }
}
