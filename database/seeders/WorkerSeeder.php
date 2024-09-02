<?php

namespace Database\Seeders;

use App\Models\OrderType;
use App\Models\Worker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workers = Worker::factory(50)->create();

        $order_types = OrderType::pluck('id')->toArray();

        $workers->each(function ($worker) use ($order_types){
            $worker->excludedOrderTypes()->attach(
              Arr::random($order_types, rand(1,2))
            );
        });
    }
}
