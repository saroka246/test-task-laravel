<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Auth;

class TokenService
{

    /**
     * Вывести все токены текущего авторизованного пользователя
     *
     * @return mixed
     */
    public function getAll()
    {
        $user = Auth::user();

        return $user->tokens;
    }


    /**
     * Удалить токен, если он не совпадает с текущим
     *
     * @param string $id
     * @return string
     * @throws Exception
     */
    public function deleteByID(string $id)
    {
        if(Auth::user()->token()->id != $id){

            $token = Auth::user()->tokens->where('id', $id)->first();

            if($token){
                $token->delete();
            } else {
                throw new Exception('Wrong token ID');
            }

            return "Token removed succefully!";
        } else {
            throw new Exception("you're try to delete current session token, don't do that!!!");
        }

    }
}
