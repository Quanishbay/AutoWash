<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\CarWash;
use App\Models\CarWashSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function getWashes() {

        $users = User::all();
        return response()->json($users);

    }

    public function show(Request $request) {

        $id = auth()->user();


        $bookings = DB::table('car_wash_schedules as c')
            ->leftJoin('services', 'services.id', '=', 'c.service_id')
            ->where('c.user_id', '=', $id['id'])
            ->select('c.date', 'c.time', 'c.status', 'services.name')
            ->get();

        return response()->json($bookings);
    }

}
