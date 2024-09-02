<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Repositories\WorkerRepository;
use App\Services\WorkerService;

class WorkerController extends Controller
{

    /**
     * @var WorkerService $service
     */
    protected WorkerService $service;

    /**
     * Конструктор класса
     *
     * @param WorkerService $service
     * @return void
     */
    public function __construct(WorkerService $service)
    {
        $this->service = $service;
    }

    /**
     * @param FilterRequest $filterRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(FilterRequest $filterRequest)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->service->getAll($filterRequest);
        } catch(Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}
