<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Mycontroller extends Controller
{
    public function index(Request $request)
    {
        dd($request);

        $data = [
            "erik",
            "sunday",
            "joy"
        ];
        return response()->json($request);
    }
}
