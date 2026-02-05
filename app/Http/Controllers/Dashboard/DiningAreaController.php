<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DiningArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DiningAreaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DiningArea::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        Alert::success('Success', 'Dining Area created successfully');
        return redirect()->back();
    }

    public function update(Request $request, DiningArea $diningArea)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        if($diningArea->user_id != Auth::id()){
             abort(403);
        }

        $diningArea->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        Alert::success('Success', 'Dining Area updated successfully');
        return redirect()->back();
    }

    public function destroy(DiningArea $diningArea)
    {
        if($diningArea->store_id != Auth::id()){
             abort(403);
        }
        $diningArea->delete();
        Alert::success('Success', 'Dining Area deleted successfully');
        return redirect()->back();
    }
}
