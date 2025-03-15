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

        if (!$washId) {
            return response()->json(['message' => 'ID автомойки не указан'], 400);
        }

        // Получаем все уже забронированные слоты
        $bookedSlots = CarWashSchedule::where('car_wash_id', $washId)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->pluck('time', 'date'); // Достаем дату и время

        // Генерируем список всех возможных слотов (с 10:00 до 22:00, шаг 30 минут)
        $startTime = Carbon::createFromTime(10, 0);
        $endTime = Carbon::createFromTime(22, 0);

        $availableSlots = [];

        for ($date = now(); $date <= now()->addDays(7); $date->addDay()) { // На 7 дней вперед
            $day = $date->toDateString();
            $slots = [];

            for ($time = clone $startTime; $time < $endTime; $time->addMinutes(30)) {
                $timeSlot = $time->format('H:i');

                // Проверяем, занят ли слот
                if (!isset($bookedSlots[$day]) || $bookedSlots[$day] !== $timeSlot) {
                    $slots[] = $timeSlot;
                }
            }

            if (!empty($slots)) {
                $availableSlots[$day] = $slots;
            }
        }

        if (empty($availableSlots)) {
            return response()->json(['message' => 'Нет свободных слотов']);
        }

        return response()->json($availableSlots);
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

    public function bookSlot(Request $request)
    {
        $request -> validate([
            'car_wash_id' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $carWashId = $request->car_wash_id;
        $date = $request->date;
        $time = $request->time;

        $userId = auth()->id();

        $isBooked = CarWashSchedule::where('car_wash_id', $carWashId)
            ->where('date', $date)
            ->where('time', $time)
            ->exists();

        if ($isBooked) {
            return response()->json(['message' => 'Это время уже забронировано'], 400);
        }

        CarWashSchedule::create([
            'car_wash_id' => $carWashId,
            'date' => $date,
            'time' => $time,
            'user_id' => $userId,
        ]);

        return response()->json(['message' => 'Запись успешно создана']);
    }
}
