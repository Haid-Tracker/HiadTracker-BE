<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function index()
    {
        $profiles = UserProfile::with('user')->get();
        return view('backend.user-profile.index', compact('profiles'));
    }

    public function create()
    {
        $users = User::all();
        return view('backend.user-profile.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'           => [
                'required',
                'exists:users,id',
                Rule::unique('profiles', 'user_id'),
            ],
            'birth_date'        => 'required|date',
            'weight'            => 'required|numeric',
            'height'            => 'required|numeric',
            'photo'             => 'nullable|image|max:2048',
            'cycle_length'      => 'required|integer',
            'last_period_date'  => 'required|date'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/assets/images/profile', $filename);
            $data['photo'] = $filename;
        }

        UserProfile::create($data);
        return redirect()->route('user-profiles.index')->with('status', 'Profile created successfully');
    }

    public function edit($id)
    {
        $profile = UserProfile::findOrFail($id);
        $users = User::all();
        return view('backend.user-profile.edit', compact('profile', 'users'));
    }

    public function update(Request $request, $id)
    {
        $profile = UserProfile::findOrFail($id);

        $request->validate([
            'user_id'           => [
                'required',
                'exists:users,id',
                Rule::unique('profiles', 'user_id')->ignore($profile->id),
            ],
            'birth_date'        => 'required|date',
            'weight'            => 'required|numeric',
            'height'            => 'required|numeric',
            'photo'             => 'nullable|image|max:2048',
            'cycle_length'      => 'required|integer',
            'last_period_date'  => 'required|date'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($profile->photo) {
                Storage::delete('public/assets/images/profile/' . $profile->photo);
            }

            $photo = $request->file('photo');
            $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/assets/images/profile', $filename);
            $data['photo'] = $filename;
        }

        $profile->update($data);
        return redirect()->route('user-profiles.index')->with('status', 'Profile updated successfully');
    }

    public function destroy($id)
    {
        $profile = UserProfile::findOrFail($id);
        if ($profile->photo) {
            Storage::delete('public/assets/images/profile/' . $profile->photo);
        }
        $profile->delete();
        return redirect()->route('user-profiles.index')->with('status', 'Profile deleted successfully');
    }
}
