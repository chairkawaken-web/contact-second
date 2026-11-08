<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->validated();

        $adminEmail = config('admin.email');
        $adminPassword = config('admin.password');

        if (
            !hash_equals($adminEmail, $credentials['email']) ||
            !hash_equals($adminPassword, $credentials['password'])
        ) {
            return back()->withErrors([
                'email' => 'メールアドレスまたはパスワードが正しくありません。',
            ]);
        }

        session(['admin_logged_in' => true]);

        return redirect('/admin');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');

        return redirect('/admin/login');
    }
}
