<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $carWashes = CarWash::all();

        if ($carWashes->count() < 5) {
            $this->command->warn("Недостаточно данных в car_washes. Запусти CarWashSeeder.");
            return;
        }

        $appointments = [
            [
                'user_name' => 'Алексей Смирнов',
                'phone' => '+7 777 111 2222',
                'date_time' => now()->addDays(1),
                'car_wash_id' => $carWashes->random()->id
            ],
            [
                'user_name' => 'Елена Иванова',
                'phone' => '+7 701 333 4444',
                'date_time' => now()->addDays(2),
                'car_wash_id' => $carWashes->random()->id
            ],
            [
                'user_name' => 'Владимир Петров',
                'phone' => '+7 702 555 6666',
                'date_time' => now()->addDays(3),
                'car_wash_id' => $carWashes->random()->id
            ],
            [
                'user_name' => 'Мария Кузнецова',
                'phone' => '+7 707 777 8888',
                'date_time' => now()->addDays(4),
                'car_wash_id' => $carWashes->random()->id
            ],
            [
                'user_name' => 'Дмитрий Орлов',
                'phone' => '+7 705 999 0000',
                'date_time' => now()->addDays(5),
                'car_wash_id' => $carWashes->random()->id
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
    }
}
