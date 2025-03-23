<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function exportClients()
    {
        $carWashId = auth()->user();

        $clients = DB::table('car_wash_schedules')
            ->leftJoin('users', 'users.id', '=', 'car_wash_schedules.user_id')
            ->select('users.name', 'users.email',
                DB::raw('MAX(car_wash_schedules.created_at) as last_attention'),
                DB::raw('COUNT(car_wash_schedules.user_id) as total_visits'))
            ->where('car_wash_schedules.car_wash_id', $carWashId['car_wash_id'])
            ->groupBy('users.id', 'users.name', 'users.email')
            ->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->setCellValue('A1', 'Имя клиента');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('B1', 'Последнее посещение');
        $sheet->setCellValue('D1', 'Количество визитов');

        // Заполнение Excel данными о клиентах
        $row = 2;
        foreach ($clients as $client) {
            $sheet->setCellValue("a{$row}", $client->name);
            $sheet->setCellValue("C{$row}", $client->email);
            $sheet->setCellValue("B{$row}", $client->last_attention);
            $sheet->setCellValue("D{$row}", $client->total_visits);
            $row++;
        }

        // Генерация и отправка Excel-файла пользователю
        $writer = new Xlsx($spreadsheet);
        $fileName = 'clients_data.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$fileName}\"");
        $writer->save('php://output');
    }
}
