<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::latest()->paginate(10);
        return view('super_admin.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('super_admin.sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sections', 'public');
        }

        Section::create($data);

        return redirect()->route('sections.index')->with('success', 'Section created successfully.');
    }

    public function edit(Section $section)
    {
        return view('super_admin.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة لو موجودة
            if ($section->image && \Storage::disk('public')->exists($section->image)) {
                \Storage::disk('public')->delete($section->image);
            }

            $data['image'] = $request->file('image')->store('sections', 'public');
        }

        $section->update($data);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        if ($section->image && \Storage::disk('public')->exists($section->image)) {
            \Storage::disk('public')->delete($section->image);
        }

        $section->delete();

        return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
    }
}
