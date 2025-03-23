<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class FilterServices extends Controller
{
    public function filterServices(Request $request){

        $name = $request->query('name');

        return Service::where('name', 'like', '%'.$name.'%')->get();

    }
}
