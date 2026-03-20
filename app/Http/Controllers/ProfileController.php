<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the profile settings page
     */
    public function show()
    {
        $user = auth()->user();
        return view('profile.settings', compact('user'));
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable', // Remove file validation temporarily
        ]);

        // Handle photo upload
        $photoPath = $user->photo; // Keep existing photo
        
        // Check if user wants to remove photo
        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            // Delete old photo if exists
            if ($user->photo) {
                \Storage::disk('public')->delete('user_photos/' . $user->photo);
            }
            $photoPath = null;
        } elseif ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                \Storage::disk('public')->delete('user_photos/' . $user->photo);
            }
            
            $photo = $request->file('photo');
            
            // Validate file manually
            if ($photo) {
                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                $fileMime = $photo->getMimeType();
                
                if (!in_array($fileMime, $allowedMimes) || $photo->getSize() > 2048 * 1024) {
                    return back()->withErrors(['photo' => 'The photo must be a valid image file (JPEG, PNG, JPG, GIF, WebP) and less than 2MB.'])->withInput();
                }
                
                $photoPath = basename($photo->store('user_photos', 'public'));
            }
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $photoPath,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
