<?php

namespace App\Http\Controllers;

use App\Models\CarWashSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarWashScheduleController extends Controller
{
    public function scheduleById(Request $request)
    {

        $washId = $request->input('id');
        if ($washId) {
            $schedule = CarWashSchedule::where('car_wash_id', $washId)
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date')
                ->get();

            if ($schedule->isEmpty()) {
                return response()->json(['message' => 'Нет доступных записей']);
            }
            return response()->json($schedule);
        } else {
            return CarWashSchedule::all();
        }

    }

    public function availableSlots(Request $request, $id)
    {

        $startTime = Carbon::createFromTime(8, 0);
        $endTime = Carbon::createFromTime(20, 0);
        $intervalMinutes = 30;

        $date = Carbon::now()->toDateString();

        $bookedTimes = CarWashSchedule::where('car_wash_id', $id)
            ->where('date', $date)
            ->pluck('time')
            ->toArray();

        $availableSlots = [];
        while ($startTime <= $endTime) {
            $formattedTime = $startTime->format('H:i');

            if(!in_array($formattedTime, $bookedTimes)) {
                $availableSlots[] = $formattedTime;
            }

            $startTime->addMinutes($intervalMinutes);
        }
        return response()->json($availableSlots);
    }
}
