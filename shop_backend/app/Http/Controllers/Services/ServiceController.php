<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Service;
use App\Models\User;
use App\Services\LogService;
use Tymon\JWTAuth\Facades\JWTAuth;


//use App\Services\LogService;


class ServiceController extends Controller
{


    public function index()
    {
        $services = Service::all();

        return $services;
    }

    public function store(StoreServiceRequest $request){

        $validated = $request->validated();
        $new_service = Service::create($validated);

        return response()->json($new_service, 201);
    }

    public function show($id)
    {

        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function update(StoreServiceRequest $request, Service $service){
        $validated = $request->validated();
        $service->update($validated);

        $user = JWTAuth::user(); // Получаем текущего аутентифицированного пользователя


        return $service;
    }

    public function destroy(Service $service){
        $service->delete();

        $user = JWTAuth::user(); // Получаем текущего аутентифицированного пользователя

        return response()->json('Success deleted', 204);
    }
}
