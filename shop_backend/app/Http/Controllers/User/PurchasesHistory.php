<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class PurchasesHistory extends Controller
{
    public function index(){

        $userId = input('user_id');

        $result = Cart::where('user_id', $userId)
            ->with('service')
            ->get();

        return response()->json($result);

    }
}
