<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{

    /**
     * Сохранить новый заказ
     *
     * @param array $data
     * @return mixed
     */
    public function save(array $data){

        $current_user = Auth::user();

        $data['user_id'] = Auth::id();
        $data['partnership_id'] = $current_user->partnership->id;
        $data['date'] = now();
        $data['status'] = 'Создан';

        return Order::create($data);
    }

    /**
     * Получить данные заказа по ID
     *
     * @param $id
     * @return mixed
     */
    public function getByID($id)
    {
        return Order::find($id);
    }
}
