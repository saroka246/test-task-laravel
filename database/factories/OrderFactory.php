<?php

namespace Database\Factories;

use App\Models\OrderType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderTypes = OrderType::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();
        $user = $users[array_rand($users)];
        $partnership = User::find($user)->partnership->id;
        $status = ['Создан','Назначен Исполнитель','Завершен'];
        return [
            'type_id' => fake()->randomElement($orderTypes),
            'partnership_id' => $partnership,
            'user_id' => $user,
            'description' => fake()->paragraph(),
            'date' => now(),
            'address' => fake()->address(),
            'amount' => fake()->randomDigitNotNull(),
            'status' => $status[array_rand($status)],
        ];
    }
}
