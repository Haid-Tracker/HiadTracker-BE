<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('backend.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $role = $request->user()->getRoleNames()->first();

        if ($role === 'admin' || $role === 'super-admin') {
            return redirect()->to('admin');
        }

        Auth::logout();
        return redirect()->route('admin.login')
            ->withErrors(['email' => 'These credentials do not have admin access.']);
    }
}
