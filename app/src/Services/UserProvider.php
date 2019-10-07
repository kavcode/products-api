<?php declare(strict_types=1);

namespace App\Services;

use App\Entities\User;

class UserProvider
{
    public function getCurrentUser(): User
    {
        static $user;
        if (!$user) {
            $user = new User(1, 'admin');
        }
        return $user;
    }
}