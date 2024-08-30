<?php

namespace Database\Seeders;

use App\Models\OrderType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderTypes = [
            'Погрузка/Разгрузка',
            'Такелажные работы',
            'Уборка',
            'Услуги водителя',
            'Сборка/Разборка',
            'Монтаж'
        ];

        foreach($orderTypes as $item) {
            OrderType::firstOrCreate(['name' => $item]);
        }
    }
}
