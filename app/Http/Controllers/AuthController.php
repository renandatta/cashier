<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function login_process(LoginRequest $request)
    {
        $user = $this->userRepository->login(
            $request->input('email'), $request->input('password'), $request->has('remember')
        );
        if ($user == false) return redirect()->back()->withErrors(['msg', __('auth.failed')]);
        return redirect()->route('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('/');
    }
}
