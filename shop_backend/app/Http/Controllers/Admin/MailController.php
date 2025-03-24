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
        $request->validate([
            'emails' => 'required|array|min:1',
            'emails.*' => 'email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $emails = $request->input('emails');
        $subject = $request->input('subject', 'Новая акция!');
        $message = $request->input('message');

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
