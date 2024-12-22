<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('frontend.auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $role = $request->user()->getRoleNames()->first();
        $profile = $request->user()->profile;

        // dd($role);
        $userId = Auth::id();
        if ($role === 'user') {
            if ($profile->height == null || $profile->weight == null || $profile->birth_date == null) {
                return redirect()->to('profile/fill/' .  $userId);
            } else {
                return redirect()->route('home');
            }
        }

        Auth::logout();
        return redirect()->route('login')
            ->withErrors(['email' => 'Please use admin login page.']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $role = $request->user()->getRoleNames()->first();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($role === 'admin' || $role === 'super-admin') {
            return redirect('/admin/login');
        }

        return redirect('/');
    }
}
