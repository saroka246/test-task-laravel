<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Partnership;
use App\Repositories\WorkerRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::factory(50)->create();
        $workerRepository = new WorkerRepository();

        $orders->each(function ($order) use ($workerRepository){
           if($order->status != "Создан"){
               $worker = $workerRepository->getWorkersByFilter([$order->type_id])->get()->random(1)->pluck('id')->toArray();
               $order->workers()->attach($worker);
           }
        });
    }
}
