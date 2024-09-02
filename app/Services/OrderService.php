<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Worker;
use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class OrderService
{
    /**
     * @var OrderRepository $repository
     */
    protected OrderRepository $repository;

    /**
     * Конструктор класса
     *
     * @param OrderRepository $repository
     * @return void
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Создать новый заказ
     *
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function createOrder(array $data)
    {
        $validator = Validator::make($data,[
            'type_id' => 'required',
            'description' => 'nullable',
            'address' => 'nullable',
            'amount' => 'nullable'
        ]);

        if($validator->fails()){
            throw new Exception($validator->errors()->first());
        }

        $order = $this->repository->save($data);

        return $order;
    }

    /**
     * Назначить исполнителя на заказ
     *
     * @param array $data
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function attachWorker(array $data, string $id)
    {
        $validator = Validator::make($data,[
            'worker_id' => ['required', 'exists:workers,id'],
        ]);

        if($validator->fails()){
            throw new Exception($validator->errors()->first());
        }

        $order = $this->repository->getByID($id);

        if($order === null){
            throw new Exception('Order not found');
        }

        $order_type = $order->type_id;
        $worker = Worker::find($data['worker_id']);

        if($worker->excludedOrderTypes()->where('id',$order_type)->exists()){
            throw new Exception('Chosen worker doesn`t work with this type of orders');
        }

        if($order->workers()->exists()){
            throw new Exception('Order already has attached worker');
        }

        $order->workers()->attach($worker);
        $order->status = 'Назначен Исполнитель';

        return $order;
    }

}
