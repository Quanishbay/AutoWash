<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CarWashSchedule;

class PurchasesHistory extends Controller
{
    public function index()
    {

        $userId = auth()->user();

        $result = CarWashSchedule::select('users.name as user_name', 'date', 'time', 'car_washes.name as car_wash_name')
            ->where('user_id', $userId['id'])
            ->leftJoin('users', 'users.id', '=', 'car_wash_schedules.user_id')
            ->leftJoin('car_washes', 'car_washes.id', '=', 'car_wash_schedules.car_wash_id')
            ->get();

        return response()->json($result);

    }
}
