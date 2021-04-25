<?php

namespace App\Models;

use Database\Factories\UserFactory;

class User extends \Tipoff\Authorization\Models\User
{
    protected $guard = 'web';

    public static function newFactory()
    {
        return new UserFactory();
    }
}
