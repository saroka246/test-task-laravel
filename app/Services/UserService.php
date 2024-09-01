<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserService

{
    /**
     * @var UserRepository $repository
     */
    public UserRepository $repository;

    /**
     * Конструктор класса
     *
     * @param UserRepository $repository
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Валидировать данные пользователя и создать токен
     *
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function saveUser(array $data): array
    {
        $validator = Validator::make($data,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'partnership_id' => 'required'
        ]);

        if($validator->fails()){
            throw new Exception($validator->errors()->first());
        }
        $user = $this->repository->save($data);

        $success = [
            'token' => $user->createToken($user->name.'Token')->accessToken,
            'name' => $user->name,
        ];

        return $success;
    }

    /**
     * Валидировать данные пользователя, при успехе авторизовать его и создать токен
     *
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function authorizeUser(array $data): array
    {
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            $user = Auth::user();

            $token = $user->createToken($user->name.'Token')->accessToken;

            return [
                'token' => $token,
                'name' => $user->name,
            ];

        } else {
            throw new Exception("Validation error");
        }
    }

    /**
     * Закрыть сессию, удалив токен
     *
     * @return string
     */
    public function unauthorizeUser(): string
    {
        Auth::user()->token()->delete();

        return "Successfully";
    }
}
