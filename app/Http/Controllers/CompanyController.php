<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
//        return response()->json(['dd' => $request->file('file')], 200);
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Perform some validation on the file if needed
            $file->store('nuxt3');

            return response()->json(['message' => 'File uploaded successfully']);
        }

        return response()->json(['error' => 'No file provided'], 400);
    }
}
