<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        // Валидация файла
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2 MB максимум
        ]);

        // Сохранение файла и получение пути
        $fileName = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
        $path = $request->file('photo')->storeAs('uploads', $fileName, 'public');

        // Получаем текущего пользователя (допустим, он аутентифицирован)
        $user = Auth::user();
        $user->photo = $path; // Сохраняем путь в поле 'photo'
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Photo uploaded and saved to database successfully!',
            'photo_url' => asset("storage/{$path}"),
        ]);
    }
}
