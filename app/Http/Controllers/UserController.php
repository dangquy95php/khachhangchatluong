<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
    }

    public function login(Request $request)
    {
        return view('account.login');
    }

    public function register(Request $request)
    {
        return view('account.register');
    }

    public function list(Request $request)
    {
        return view('account.list');
    }
}
