<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarWashSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendPromotions(Request $request)
    {
        $carWashId = auth()->user()['car_wash_id'];

        $emails = DB::table('car_wash_schedules')
            ->leftJoin('users', 'users.id', '=', 'car_wash_schedules.user_id')
            ->where('car_wash_schedules.car_wash_id', $carWashId)
            ->groupBy('car_wash_schedules.user_id')
            ->selectRaw('MAX(users.email) as email') // Используем агрегатную функцию для соответствия GROUP BY
            ->pluck('email'); // Извлекаем email'ы


        $subject = $request->input('subject', 'Новая акция!');
        $message = $request->input('message', 'Получите скидку 20% на все услуги!');

        foreach ($emails as $email) {
            Mail::raw($message, function ($mail) use ($email, $subject) {
                $mail->to($email)
                    ->subject($subject)
                    ->from('alikua.0004@gmail.com', 'AutoWash Team');
            });
        }

        return response()->json(['message' => 'Сообщения с акцией успешно отправлены!'], 200);
    }
}
