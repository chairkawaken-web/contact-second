<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $adminEmail = config('admin.email');
        $adminPassword = config('admin.password');

        if (
            hash_equals($adminEmail, $credentials['email']) &&
            hash_equals($adminPassword, $credentials['password'])
        ) {
            session(['admin_logged_in' => true]);

            return redirect('/admin');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');

        return redirect('/admin/login');
    }
}
