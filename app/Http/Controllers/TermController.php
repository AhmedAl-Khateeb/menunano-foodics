<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term;

class TermController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => Term::all()
        ]);
    }

    // إرجاع شرط واحد فقط عبر ID
    public function show($id)
    {
        $term = Term::find($id);

        if (!$term) {
            return response()->json([
                'status' => false,
                'message' => 'Term not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $term
        ]);
    }
}
