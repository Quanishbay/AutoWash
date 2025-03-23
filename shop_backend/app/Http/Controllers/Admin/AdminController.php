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
        $user = $request->input('user');
        $last = $request->input('last');
        $popular = $request->input('popular');


        if ($user) {
            return CarWashSchedule::select('user_id')
                ->distinct()
                ->get();
        }

        if ($last) {
            return CarWashSchedule::orderBy('created_at')
                ->limit(5)
                ->get();
        }

        if ($popular) {
            return DB::table('car_wash_schedules')
                ->join('services', 'services.id', '=', 'car_wash_schedules.service_id') // join таблиц
                ->select('services.name', DB::raw('COUNT(car_wash_schedules.service_id) as service_count')) // выбор полей и COUNT
                ->groupBy('car_wash_schedules.service_id', 'services.name')
                ->orderBy('service_count', 'desc')
                ->limit(5)
                ->get();
        }
    }


}
