<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarWashSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getWashes(Request $request)
    {
        $name = $request->input('name');
        $last = $request->input('last');
        $popular = $request->input('popular');
        $order = $request->input('order');
        $customers = $request->input('customers');
        $revenue = $request->input('revenue');

        if ($name) {
            return CarWashSchedule::select('user_id')
                ->distinct()
                ->get();
        }

        if ($last) {
            return DB::table('car_wash_schedules')
                ->leftJoin('car_washes', 'car_washes.id', '=', 'car_wash_schedules.car_wash_id')
                ->leftJoin('services', 'services.id', '=', 'car_wash_schedules.service_id')
                ->select('car_wash_schedules.*', 'car_washes.name', 'services.image', 'services.name')
                ->orderBy('car_wash_schedules.created_at')
                ->limit(5)
                ->get();
        }

        if ($popular) {
            return DB::table('car_wash_schedules')
                ->join('services', 'services.id', '=', 'car_wash_schedules.service_id') // join таблиц
                ->select('services.name', DB::raw('COUNT(car_wash_schedules.service_id) as service_count'), 'services.image') // выбор полей и COUNT
                ->groupBy('car_wash_schedules.service_id', 'services.name', 'services.image')
                ->orderBy('service_count', 'desc')
                ->limit(5)
                ->get();
        }

        if($order){
            return CarWashSchedule::count('id');
        }

        if($customers){
            return DB::table('car_wash_schedules')
                ->leftJoin('users', 'users.id', '=', 'car_wash_schedules.user_id')
                ->distinct('users.id')
                ->count('users.id');
        }



    }


}
