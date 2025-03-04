<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterServices extends Controller
{
    public function filterServices(Request $request){

        $names = $request->query('name');

        dd($names);
    }
}
