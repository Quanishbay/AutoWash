<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryCarWash;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $car_wash_id = auth()->user()['car_wash_id'];

        return DB::table('categories')
            ->leftJoin('car_washes', 'car_washes.id', '=', 'categories.car_wash_id')
            ->where('car_wash_id', $car_wash_id)
            ->select([
                'categories.id',
                'car_washes.name',
                'categories.name as category_name',
                'categories.description',
                'car_washes.phone',
                'car_washes.whatsapp',
                'car_washes.instagram',
            ])
            ->get();

    }


    public function create(Request $request)
    {
        $car_wash_id = auth()->user()['car_wash_id'];

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $validated['car_wash_id'] = $car_wash_id;

        Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'status' => 201
        ]);
    }

    public function update(Request $request, Category $category, $id){

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $car_wash_id = auth()->user()['car_wash_id'];


        $foundedCategory = $category->find($id);

        if($foundedCategory['car_wash_id'] == $car_wash_id){
            $foundedCategory->update($validated);
        }else{
            return response()->json([
                'message' => 'Category not found',
            ]);
        }
        return response()->json([
            'message' => 'Category updated successfully'
        ]);
    }

    public function delete(Request $request, Category $category, $id)
    {
        $car_wash_id = auth()->user()['car_wash_id'];

        $foundedCategory = $category->find($id);

        if($foundedCategory['car_wash_id'] == $car_wash_id){
            $foundedCategory->delete($id);
        }else{
            return response()->json([
                'message' => 'You not have permission to delete this category',
            ]);
        }

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }

}
