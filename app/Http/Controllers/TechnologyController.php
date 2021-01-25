<?php

namespace App\Http\Controllers;

use App\Models\Technology;

class TechnologyController extends Controller
{
    public function getAll() {
        return response()->json(['data' => Technology::all()]);
    }
}
