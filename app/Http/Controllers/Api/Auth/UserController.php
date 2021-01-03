<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Repositories\Contracts\UserInterface;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(Request $request)
    {
        $user = $request->only([
            'email',
            'nickname',
            'full_name',
            'password',
            'birthday',
            'role',
            'status',
            'phone_number',
            'address',
            'avatar',
        ]);

        $this->doAction(function () use ($user) {
            $this->compacts['user'] = $this->userRepository->register($user);
        });
    }

    public function login(Request $request){
        //
    }

    public function show() {
        return 'User';
    }
}
