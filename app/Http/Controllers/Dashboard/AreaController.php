<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AreaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Area::create([
            'name' => $request->name,
            'store_id' => Auth::id(),
            'is_active' => true,
        ]);

        Alert::success('Success', 'Area created successfully');
        return redirect()->back();
    }

    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        if($area->store_id != Auth::id()){
             abort(403);
        }

        $area->update([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Area updated successfully');
        return redirect()->back();
    }

    public function destroy(Area $area)
    {
        if($area->store_id != Auth::id()){
             abort(403);
        }
        $area->delete();
        Alert::success('Success', 'Area deleted successfully');
        return redirect()->back();
    }
}
