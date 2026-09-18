<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('view-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'status' => 'nullable|in:aktif,nonaktif',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:min_width=100,min_height=100',
        ]);

        if ($request->hasFile('profile_photo')) {
            $oldPath = ltrim((string) $user->profile_photo, '/');

            if ($oldPath !== '' && !Str::startsWith($oldPath, ['http://', 'https://'])) {
                if (Str::startsWith($oldPath, 'storage/')) {
                    $oldPath = Str::after($oldPath, 'storage/');
                }

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                } elseif (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('uploads/profiles', $filename, 'public');
            $validated['profile_photo'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
