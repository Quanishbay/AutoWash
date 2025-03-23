<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail(Request $request)
    {
        // Валидация email из запроса
        $request->validate([
            'email' => 'required|email',
        ]);

        // Отправка письма напрямую с текстом
        Mail::raw('Мы рады сообщить, что наша автомойка AutoWash открылась! Заходите к нам и получите скидку 10% на первое посещение!', function ($message) use ($request) {
            $message->to($request->email)
                ->subject('AutoWash - Добро пожаловать! 🚗💦');
        });

        // Ответ после отправки
        return response()->json(['message' => 'Письмо отправлено на ' . $request->email]);
    }
}
