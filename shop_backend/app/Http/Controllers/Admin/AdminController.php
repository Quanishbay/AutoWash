<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use http\Env\Request;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $adminId = $request->input('admin_id');

    }
}
