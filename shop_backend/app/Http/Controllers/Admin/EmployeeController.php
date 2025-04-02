<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {

        $carWashId = auth()->user();

        return Employee::where('car_wash_id', $carWashId['car_wash_id'])->get();
    }

    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|string',
            'position' => 'required|string|max:100',
            'hired_at' => 'required|date',
            'shift' => 'required|string',
        ]);

        $validatedData['car_wash_id'] = auth()->user()['car_wash_id'];

        $result = Employee::create($validatedData);

        return response()->json($result);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,  // Исключение текущего email
            'phone_number' => 'required|regex:/^\d{10,15}$/',
            'position' => 'required|string|max:100',
            'hired_at' => 'required|date',
            'shift' => 'required|in:дневная,ночная',
        ]);

        $validatedData['car_wash_id'] = auth()->user()['car_wash_id'];

        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Сотрудник не найден']);
        }

        $employee->update($validatedData);

        return response()->json(['message' => 'Данные сотрудника успешно обновлены', 'employee' => $employee]);
    }

    public function delete($id)
    {
        Employee::find($id)->delete();

        return response()->json([
            'message' => "Successfully deleted employee!"
        ]);

    }

}
