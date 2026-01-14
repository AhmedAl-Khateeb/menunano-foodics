<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\ApiResponse;
use App\Facades\FileHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderStoreRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::where('user_id', auth()->id())->get();
        return view('sliders.index', compact('sliders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderStoreRequest $request)
    {
        try {

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => auth()->id(),
            ];
            if ($request->hasFile('image')) {
               
                $data['image'] = $request->file('image')->store('sliders', 'public');
            }

            $slider = Slider::create($data);
            Alert::success('success', 'slider created successfully');
            return redirect()->route('sliders.index');
        } catch (\Exception $exception) {
            Alert::toast('slider not created','error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderUpdateRequest $request, Slider $slider)
    {
        if ($slider->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        try {

            $data = [
                'title' => $request->title ?? $slider->title,
                'description' => $request->description ?? $slider->description,
            ];

            if ($request->hasFile('image')) {
               
                if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                    Storage::disk('public')->delete($slider->image);
                }

                // نخزن الصورة الجديدة
                $data['image'] = $request->file('image')->store('sliders', 'public');
            }
            $slider->update($data);
            Alert::success('success', 'slider updated successfully');
            return redirect()->route('sliders.index');
        } catch (\Exception $exception) {
            Alert::toast('slider not updated','error');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        try {
            if ($slider->cover) {
                FileHandler::deleteFile($slider->image);
            }
            $slider->delete();
            Alert::success('success', 'slider deleted successfully');
            return redirect()->route('sliders.index');
        } catch (\Exception $exception) {
            Alert::toast('slider not deleted','error');
            return redirect()->back();
        }
    }
}
