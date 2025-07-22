<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function showLoginForm()
  {
    return view('auth.login');
  }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.events.index')->with('success', 'Đăng nhập thành công!');
        }
        // Nếu là client (user), redirect về trang sự kiện client
        return redirect()->route('client.index')->with('success', 'Đăng nhập thành công!');
    }

    return back()->withErrors([
        'email' => 'Email hoặc mật khẩu không đúng.',
    ])->onlyInput('email');
}
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login')->with('success', 'Đã đăng xuất!');
  }
}
