<?php

namespace App\Repositories;

use App\Repositories\EloquentRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Hash;
use JWTAuth;
use Illuminate\Http\Request;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    const ROLE_USER            =   1;
    const ROLE_MANAGER_USER    =   2;
    const ROLE_ADMIN           =   3;

    const ROLE_LIST = [
        self::ROLE_USER => 'user',
        self::ROLE_MANAGER_USER => 'manager',
        self::ROLE_ADMIN => 'admin'
    ];

    const STASTUS_DISABLE = 0;
    const STASTUS_ENABLE = 1;

    const STATUS_LIST = [
        self::STASTUS_DISABLE => 'chưa kích hoạt',
        self::STASTUS_ENABLE => 'đã kích hoạt',
    ];

    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function createRepository($request)
    {
        $data = [
            'email'         => $request->input('email'),
            'first_name'    => $request->input('first_name'),
            'last_name'     => $request->input('last_name'),
            'password'      => Hash::make($request->input('password')),
            'status'        => self::STASTUS_DISABLE,
        ];

        return $this->create($data);
    }

    public function login($request)
    {   
        $option = $request->only('email', 'password');

        return JWTAuth::attempt($option);
    }
}