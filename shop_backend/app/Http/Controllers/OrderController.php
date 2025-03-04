<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        // Валидация данных
        $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'date' => 'required|date',
            'time' => 'required',
            'car_type' => 'required|string',
        ]);

        // Данные заказа
        $order = [
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'date' => $request->date,
            'time' => $request->time,
            'car_type' => $request->car_type,
        ];

        // Отправляем письмо
        Mail::to($order['customer_email'])->send(new OrderConfirmation($order));

        return response()->json(['message' => 'Запись создана, письмо отправлено!']);
    }
}
