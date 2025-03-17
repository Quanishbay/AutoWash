<?php

namespace App\Http\Controllers;

use App\Models\CarWash;
use App\Models\CategoryCarWash;
use Illuminate\Http\Request;

class CarWashController extends Controller
{
    public function index(Request $request)
    {
        $getID = $request->query('id');
        $getName = $request->query('name');

        if ($getID) {
            $carWash = CarWash::find($getID);
            if (!$carWash) {
                return response()->json(['message' => 'Car wash not found']);
            }
            return response()->json($carWash, 200);
        }

        if ($getName) {
            $carWashNames = CarWash::where('name', 'LIKE', '%' . $getName . '%')->get();
            if ($carWashNames->isEmpty()) {
                return response()->json(['message' => 'Car wash not found']);
            }
            return response()->json($carWashNames, 200);
        }
    }


    public function getByCategory(Request $request)
    {
        $category = $request->input('category_id');

        return CategoryCarWash::where('category_id', $category)->get();
    }
}


