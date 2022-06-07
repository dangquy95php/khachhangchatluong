<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

class UserController extends Controller
{
    const USER_ROLE = 1;
    const ADMIN_ROLE = 2;

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        } else {
            if (Auth::user()->role == self::USER_ROLE) {
                return view('index');
            } else {
                return redirect()->route('admin');
            }
        }
    }

    public function admin(Request $request)
    {
        return view('dashboard');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('account.login');
    }

    public function postLogin(LoginUserRequest $request)
    {
        $data = [
            'username' => $request->get('username'),
            'password' => urldecode($request->get('password')),
        ];

        if (Auth::attempt($data, $request->get('remember'))) {
            Toastr::success('Đăng nhập vào hệ thống thành công!');
            if (Auth::user()->role == self::USER_ROLE) {
                return redirect()->route('home');
            } else {
                return redirect()->route('admin');
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
        $data = User::select('id', 'name', 'email', 'username', 'role', 'status', 'created_at')->get();

        return view('account.list', compact('data'));
    }
}
