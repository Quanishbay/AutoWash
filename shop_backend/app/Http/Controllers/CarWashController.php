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

        return response()->json(CarWash::paginate(10), 200);
    }


    public function getByCategory(Request $request)
    {
        $categories = explode(',', $request->query('category_id', ''));

        if (empty($categories) || $categories[0] === '') {
            return CarWash::all();
        }

        return CategoryCarWash::leftJoin('car_washes', 'car_washes.id', '=', 'category_car_washes.car_wash_id')
            ->whereIn('category_car_washes.category_id', $categories)
            ->get();
    }
    }


