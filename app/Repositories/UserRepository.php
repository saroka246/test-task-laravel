<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    /**
     * Сохранить данные нового пользователя
     *
     * @param array $data
     * @return User
     */
    public function save(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        $user = User::firstOrCreate($data);

        return $user;
    }
}
