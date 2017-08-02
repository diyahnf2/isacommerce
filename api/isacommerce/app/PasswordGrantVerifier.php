<?php

namespace App;

use App\User;

class PasswordGrantVerifier
{

    public function verify($username, $password)
    {
        $user = User::where('email', $username)->first();
        if ($user && app()['hash']->check($password, $user->password)) {
            return $user;
        }

        return false;
    }

}