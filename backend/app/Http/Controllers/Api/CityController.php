<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MoroccanCity;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = MoroccanCity::orderBy('name_fr')->get();
        return response()->json($cities);
    }
}
