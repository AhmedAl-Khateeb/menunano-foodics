<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DiningArea;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TableController extends Controller
{
    public function index()
    {
        $diningAreas = DiningArea::where('user_id', Auth::id())->with('tables')->get();
        $tables = Table::where('user_id', Auth::id())->with('diningArea')->get();
        
        return view('settings.tables.index', compact('diningAreas', 'tables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dining_area_id' => 'required|exists:dining_areas,id',
            'capacity' => 'nullable|integer|min:1',
        ]);

        Table::create([
            'name' => $request->name,
            'dining_area_id' => $request->dining_area_id,
            'capacity' => $request->capacity,
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        Alert::success('Success', 'Table created successfully');
        return redirect()->back();
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dining_area_id' => 'required|exists:dining_areas,id',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $table->update([
            'name' => $request->name,
            'dining_area_id' => $request->dining_area_id,
            'capacity' => $request->capacity,
        ]);

        Alert::success('Success', 'Table updated successfully');
        return redirect()->back();
    }

    public function destroy(Table $table)
    {
        $table->delete();
        Alert::success('Success', 'Table deleted successfully');
        return redirect()->back();
    }
}
