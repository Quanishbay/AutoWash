<?php

namespace App\Http\Controllers;

use App\Models\CarWash;
use App\Models\CarWashSchedule;
use App\Models\CategoryCarWash;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function services(){
        return Service::all();
    }

    public function servicesById(Request $request){

        $carWashId = auth()->user()['car_wash_id'];

        $serviceData = DB::table('car_wash_schedules')
            ->leftJoin('services', 'services.id', '=', 'car_wash_schedules.service_id')
            ->leftJoin('categories', 'categories.id', '=', 'services.category_id')
            ->where('car_wash_schedules.id', $carWashId)
            ->select(
                'services.name as service_name',
                'services.price',
                'services.image',
                'categories.name as category_name'
            )
            ->distinct()
            ->get();


        return $serviceData;
    }
}


