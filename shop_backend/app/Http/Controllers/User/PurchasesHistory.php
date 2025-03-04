<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class PurchasesHistory extends Controller
{
    public function index(User $user){

        $result = Cart::where('user_id', $user->id)
            ->with('service')
            ->get();

        return response()->json($result);

    }
}
