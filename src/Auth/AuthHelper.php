<?php

namespace Esolutions\Laravel\Auth;

use Illuminate\Support\Facades\Hash;

class AuthHelper
{
    public static function checkPassword(string $password): bool
    {
        $user = auth()->user();
        return $user && Hash::check($password, $user->password);
    }
}
