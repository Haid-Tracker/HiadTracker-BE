<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit($id)
    {
        $user = User::with('profile')->findOrFail($id);

        return view('frontend.profile.edit', compact('user'));

    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'weight' => 'nullable|numeric',
        'birth_date' => 'nullable|date',
        'height' => 'nullable|numeric',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = User::findOrFail($id);

    if ($request->hasFile('photo')) {
        if ($user->profile && $user->profile->photo) {
            $oldPhotoPath = public_path('storage/' . $user->profile->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        $photoPath = $request->file('photo')->store('assets/images', 'public');
        $validated['photo'] = $photoPath;
    }

    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        [
            'weight' => $validated['weight'],
            'birth_date' => $validated['birth_date'],
            'height' => $validated['height'],
            'photo' => $validated['photo'] ?? $user->profile->photo,
        ]
    );

    return redirect()->route('home', $user->id)->with('success', 'Profil berhasil diperbarui!');
}

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
