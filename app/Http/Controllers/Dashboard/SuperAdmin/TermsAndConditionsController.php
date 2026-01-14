<?php

namespace App\Http\Controllers\Dashboard\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermsAndConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = Term::latest()->get();
        return view('super_admin.terms.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Term::create([
            'title'      => $request->title,
            'content'    => $request->content,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('terms.index')->with('success', 'تمت إضافة الشروط والأحكام بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $term = Term::findOrFail($id);
        return view('super_admin.terms.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $term = Term::findOrFail($id);
        $term->update($request->only(['title', 'content']));

        return redirect()->route('terms.index')->with('success', 'تم تحديث الشروط والأحكام بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $term = Term::findOrFail($id);
        $term->delete();

        return redirect()->route('terms.index')->with('success', 'تم حذف الشرط بنجاح');
    }
}
