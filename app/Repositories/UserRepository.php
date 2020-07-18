<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository {

    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($email, $password, $remember)
    {
        $user = $this->user->where('email', '=', $email)->first();
        if (!empty($user)) {
            if (Hash::check($password, $user->password)) {
                Auth::login($user, $remember);
                return $user;
            }
        }
        return false;
    }

}
