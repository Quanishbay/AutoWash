<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\CarWash;


class CarWashSeeder extends Seeder
{
    public function run()
    {
        $carWashes = [
            [
                'name' => 'Автомойка Lux',
                'description' => 'Премиум-качество мойки автомобилей.',
                'phone' => '+7 777 123 4567',
                'whatsapp' => '+7 777 123 4567',
                'instagram' => 'luxcarwash',
                'latitude' => 43.238293,
                'longitude' => 76.945465
            ],
            [
                'name' => 'Автомойка Express',
                'description' => 'Быстрая и качественная мойка.',
                'phone' => '+7 777 765 4321',
                'whatsapp' => '+7 777 765 4321',
                'instagram' => 'expresswash',
                'latitude' => 43.250973,
                'longitude' => 76.920546
            ],
            [
                'name' => 'ЧистоАвто',
                'description' => 'Мойка с экологичными средствами.',
                'phone' => '+7 701 987 6543',
                'whatsapp' => '+7 701 987 6543',
                'instagram' => 'chisto_auto',
                'latitude' => 43.230192,
                'longitude' => 76.890123
            ],
            [
                'name' => 'Premium Wash',
                'description' => 'Детейлинг и глубокая чистка авто.',
                'phone' => '+7 702 456 7890',
                'whatsapp' => '+7 702 456 7890',
                'instagram' => 'premium_wash',
                'latitude' => 43.217654,
                'longitude' => 76.860987
            ],
            [
                'name' => 'Мойка 24/7',
                'description' => 'Круглосуточная автомойка.',
                'phone' => '+7 707 654 3210',
                'whatsapp' => '+7 707 654 3210',
                'instagram' => 'wash_247',
                'latitude' => 43.245678,
                'longitude' => 76.935678
            ],
        ];

        foreach ($carWashes as $wash) {
            CarWash::create($wash);
        }
    }
}
