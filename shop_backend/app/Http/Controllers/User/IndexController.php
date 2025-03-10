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
    public function index() {

        $users = User::all();
        return response()->json($users);

    }

    public function show(Request $request) {
        $id = $request->input('user_id');
        $bookings = CarWashSchedule::where('user_id', $id)->get();
        return $bookings;
    }
}
