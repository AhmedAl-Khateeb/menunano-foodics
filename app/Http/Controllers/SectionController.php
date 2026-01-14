<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    // جلب كل الأقسام
    public function index()
    {
        $sections = Section::all();

        return response()->json([
            'status' => true,
            'data'   => $sections
        ]);
    }

    // جلب قسم واحد بالـ ID
    public function show($id)
    {
        $section = Section::find($id);

        if (!$section) {
            return response()->json([
                'status'  => false,
                'message' => 'Section not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $section
        ]);
    }
}
