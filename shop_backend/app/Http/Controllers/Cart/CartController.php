<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Services\LogService;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class CartController extends Controller
{

    public function index(Request $request)
    {

        $cartsItems = Cart::with('service')
            ->where('status', 'active')
            ->get();

        return response()->json($cartsItems, 200);

    }

    public function store(CartRequest $request)
    {

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        // Валидируем данные из запроса
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        $newCart = Cart::create($validated);

        // Возвращаем только что созданный элемент корзины
        return response()->json($newCart, 201);
    }

    public function show(Cart $cart)
    {
        return response()->json($cart, 200);
    }


    public function update(Cart $cart)
    {

        try {
            $validated = request()->validate([
                'quantity' => 'required|numeric|min:1',
                'total' => 'required|numeric|min:1'
            ]);

            $updated = $cart->update($validated);

            return response()->json($updated, 200);

        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 400);
        }

    }

    public function destroy(Cart $cart)
    {


        $cart->delete();

        return response()->json(['message' => 'successfully deleted'], 204);


    }

    public function submit(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            '*.id' => 'required|numeric|min:1',
            '*.user_id' => 'required|numeric|min:1',
            '*.quantity' => 'required|numeric|min:1',
            '*.total' => 'required|numeric|min:1',
            '*.status' => 'required|in:active,ordered'
        ]);

        foreach ($validated as $item) {
            $getId = $cart->find($item['id']);
            if ($getId) {
                $getId['status'] = 'ordered';
                $getId->save();
            }
        }
        return response()->json($cart, 200);
    }
}



