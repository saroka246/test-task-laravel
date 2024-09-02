<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @var OrderService $service
     */
    protected OrderService $service;

    /**
     * Конструктор класса
     *
     * @param OrderService $service
     * @return void
     */
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Создать новый заказ
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->all();

        $result = ['status' => 200];

        try {
            $result['data'] = $this->service->createOrder($data);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Прикрепить исполнителя к заказу
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $data = $request->all();

        $result = ['status' => 200];

        try {
            $result['data'] = $this->service->attachWorker($data, $id);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}
