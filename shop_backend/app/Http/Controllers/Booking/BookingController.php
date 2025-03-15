<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\CarWashSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;


class BookingController extends Controller
{
    public function index()
    {
        return Booking::all();
    }
    public function userBookings(Request $request)
    {
        $userId = $request->input('user_id');
        return Booking::where('user_id', $userId)->get();
    }

    public function create(Request $request){
        $validated = $request->validate([
            'car_wash_id' => 'required|exists:car_washes,id',
            'appointment_time' => 'required|date|after:now',
        ]);
        $user_id = auth()->user();

        Booking::create([
            'user_id' => $user_id['id'],
            'car_wash_id' => $validated['car_wash_id'],
            'appointment_time' => $validated['appointment_time'],
            'status' => 'pending',
        ]);

        return response()->json("New booking has been added");
    }

    public function bookingConfirm($id){
        $booking = Booking::find($id);
        $booking->status = 'confirmed';
        $booking->save();
        return $booking;
    }

    public function bookingCancel(Request $request, $id){
        $booking = Booking::find($id);
        $booking->status = 'canceled';
        $booking->save();
        return $booking;
    }


    public function edit() {
        $userData = auth()->user();

        $now = Carbon::now();
        $date = Carbon::today();


        $booking = CarWashSchedule::where('user_id', $userData['id'])
            ->where('date', '=', $date)
            ->where('time', '>', $now->addHour())
            ->get();

        return response()->json($booking);
    }

}
