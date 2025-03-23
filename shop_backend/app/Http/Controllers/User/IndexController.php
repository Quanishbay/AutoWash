<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\CarWash;
use App\Models\CarWashSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function getWashes() {

        $users = User::all();
        return response()->json($users);

    }

    public function show(Request $request) {
        $id = $request->input('user_id');

        $bookings = CarWashSchedule::select('car_wash_schedules.*', 'car_washes.category_id')
            ->join('car_washes', 'car_wash_schedules.car_wash_id', '=', 'car_washes.id') // Соединение с таблицей car_washes
            ->where('car_wash_schedules.user_id', $id)
            ->get();

        return response()->json($bookings);
    }

}
