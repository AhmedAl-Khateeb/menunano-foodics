<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Facades\FileHandler;
use App\Http\Requests\SliderStoreRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use App\Traits\StoreHelper;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use StoreHelper;
    public function index($storeName)
    {
        $user = $this->getUserByStoreName($storeName);

        $sliders = Slider::where('user_id', $user->id)->get();

        return ApiResponse::success(SliderResource::collection($sliders));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderStoreRequest $request)
    {
        $slider = DB::transaction(function () use ($request) {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
            ];
            $data['image'] = FileHandler::storeFile($request->file('image'), null, $request->file('image')->getClientOriginalExtension());

            $slider = Slider::create($data);
            return $slider;
        });

        return ApiResponse::created(new SliderResource($slider));
    }

    /**
     * Display the specified resource.
     */
    public function show($storeName, string $id)
    {
        $user = $this->getUserByStoreName($storeName);

        $slider = Slider::where('user_id', $user->id)
            ->findOrFail($id);

        return ApiResponse::success(new SliderResource($slider));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderUpdateRequest $request, string $id)
    {
        $slider = DB::transaction(function () use ($request, $id) {
            $slider = Slider::findOrFail($id);

            $data = [
                'title' => $request->title ?? $slider->title,
                'description' => $request->description ?? $slider->description,
            ];

            if ($request->hasFile('image')) {
                $data['image'] = FileHandler::updateFile($request->file('image'), $slider->iamge, 'null', $request->file('image')->getClientOriginalExtension());
            }
            $slider->update($data);

            return $slider;
        });

        return ApiResponse::updated(new SliderResource($slider));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $slider = Slider::findOrFail($id);
            FileHandler::deleteFile($slider->image);
            $slider->delete();
        });
        return ApiResponse::deleted();
    }
}
