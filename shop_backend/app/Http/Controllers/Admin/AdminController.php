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

        $washId = auth()->user()['car_wash_id'];

        // Базовый запрос с фильтром car_wash_id
        $result = DB::table('car_wash_schedules')
            ->join('services', 'services.id', '=', 'car_wash_schedules.service_id')
            ->where('car_wash_schedules.car_wash_id', $washId);

        // Если передан фильтр "user", группируем по user_id и возвращаем последний визит каждого пользователя
        if ($user) {
            $result->select('car_wash_schedules.user_id', DB::raw('MAX(car_wash_schedules.created_at) as last_wash'))
                ->groupBy('car_wash_schedules.user_id');
        }

        // Если передан фильтр "last", выводим последние 5 записей
        elseif ($last) { // используем elseif, чтобы избежать пересечения фильтров с user
            $result->select('car_wash_schedules.*', 'services.price')
                ->orderBy('car_wash_schedules.created_at', 'desc')
                ->take(5);
        }

        // Если передан фильтр "popular", выводим популярные сервисы по количеству записей
        elseif ($popular) {
            $result->select('car_wash_schedules.service_id', DB::raw('COUNT(car_wash_schedules.id) as total_count'))
                ->groupBy('car_wash_schedules.service_id')
                ->orderBy('total_count', 'desc');
        }

        return $result->get(); // Получение результата
    }


}
