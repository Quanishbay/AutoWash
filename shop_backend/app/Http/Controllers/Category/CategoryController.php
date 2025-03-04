<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Service;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }


    public function store(CategoryRequest $request){

        $category = $request->validated();

        $result = Category::create($category);

        return response()->json($result);
    }
    public function update(CategoryRequest $request , Category $category)
    {

        $item = $request->validated();


        $category->update($item);

        return response()->json($item, 201);

    }


    public function destroy(Category $category){

        $category->delete();

        return response()->json('Successfully deleted', 204);
    }

    public function show(Category $category){


        $services = Service::where('category_id', $category->id)->get();

        return response()->json(['category: ', $category,
        'services: ', $services]);
    }
}
