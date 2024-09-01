<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @var UserService $service
     */
    protected UserService $service;

    /**
     * Конструктор класса
     *
     * @param UserService $service
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Сохранить данные нового пользователя и выдать токен
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->all();

        $result = ['status' => 200];

        try {
            $result['data'] = $this->service->saveUser($data);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Авторизовать пользователя и выдать токен
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $data = $request->all();

        $result = ['status' => 200];

        try {
            $result['data'] = $this->service->authorizeUser($data);
        } catch(Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Закончить текущюю сессию и уничтожить токен
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {

        $result = ['status' => 200];

        try {
            $result['message'] = $this->service->unauthorizeUser();
        } catch(Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

}
