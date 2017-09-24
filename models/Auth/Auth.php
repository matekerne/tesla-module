<?php

namespace Auth;

use \models\Model as Model;

class Auth extends Model
{
    public function login(array $data, array $user): bool
    {
        $data = $this->validate($data, [
            'login' => 'Логин|empty|length',
        ]);

        if ($data['login'] != $user['login']) {
            return false;
        }

        if (password_verify($data['password'], $user['password'])) {
            return true;
        } else {
            return false;
        }
    }
}