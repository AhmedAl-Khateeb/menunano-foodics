<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBusinessTypeRequest;
use App\Http\Requests\UpdateBusinessTypeRequest;
use App\Models\BusinessType;
use App\Services\BusinessTypeService;

class BusinessTypeController extends Controller
{
    public function __construct(private readonly BusinessTypeService $businessTypeService)
    {
    }

    public function index()
    {
        $businessTypes = $this->businessTypeService->index(request()->only('name'));

        return view('businessType.index', compact('businessTypes'));
    }

    public function create()
    {
        return view('businessType.create');
    }

    public function store(CreateBusinessTypeRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->businessTypeService->store($data);

        return redirect()->route('business-types.index')->with('success', 'Business type created successfully.');
    }

    public function edit($id)
    {
        $businessType = BusinessType::findOrFail($id);

        return view('businessType.edit', compact('businessType'));
    }

    public function update(UpdateBusinessTypeRequest $request, $id)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->businessTypeService->update($data, $id);

        return redirect()->route('business-types.index')->with('success', 'Business type updated successfully.');
    }

    public function destroy($id)
    {
        $this->businessTypeService->delete($id);

        return redirect()->route('business-types.index')->with('success', 'Business type deleted successfully.');
    }
}
