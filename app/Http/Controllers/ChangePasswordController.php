<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
{
    return view('frontend.profile.changePassword');
}

public function changePassword(Request $request)
{
    $validatedData = $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);
    $user = auth()->user();


    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
    }

    // Update password
    $user->update([
        'password' => bcrypt($validatedData['new_password']),
    ]);

    return redirect()->route('home')->with('success', 'Password berhasil diubah!');
}

}
