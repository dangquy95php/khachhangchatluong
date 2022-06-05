<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

class AdminController extends Controller
{
    const USER_ROLE = 1;
    const ADMIN_ROLE = 2;

    public function admin(Request $request)
    {
        return view('dashboard');
    }
    
    public function dashboard(Request $request)
    {
        
    }

    public function login(Request $request)
    {
        return view('account.login');
    }

    public function postLogin(LoginUserRequest $request)
    {
        $data = [
            'username' => $request->get('username'),
            'password' => urldecode($request->get('password')),
        ];
        if (Auth::attempt($data)) {
            Toastr::success('Đăng nhập vào hệ thống thành công!');
            if (Auth::user()->role == self::USER_ROLE) {
                return redirect()->route('home');
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            Toastr::error('Tên người dùng hoặc mật khẩu không chính xác!');
        }
        return redirect()->back()->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Toastr::success('Đăng xuất thành công!');
        return redirect()->route('login');
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
