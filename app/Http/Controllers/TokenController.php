<?php

namespace App\Http\Controllers;

use App\Services\TokenService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * @var TokenService $service
     */
    protected TokenService $service;

    /**
     * Конструктор класса
     *
     * @param TokenService $service
     * @return void
     */
    public function __construct(TokenService $service)
    {
        $this->service = $service;
    }

    /**
     * Вывести все токены текущего авторизованного пользователя
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        $result = ['status' => 200];

        try {
            $result['data'] = $this->service->getAll();
        } catch(Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }


    /**
     * Удалить токен с введенным id
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(Request $request, string $id): JsonResponse
    {

        $result = ['status' => 200];

        try {
            $result['message'] = $this->service->deleteByID($id);
        } catch(Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}
