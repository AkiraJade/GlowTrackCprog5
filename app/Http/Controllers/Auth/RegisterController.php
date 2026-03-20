<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable'], // Remove file validation temporarily
        ]);

        // Handle photo upload
        $photoPath = null;
        
        \Log::info('Registration request received', [
            'has_file' => $request->hasFile('photo'),
            'all_files' => $request->allFiles(),
            'photo_field' => $request->input('photo')
        ]);
        
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            
            \Log::info('Photo upload detected:', [
                'original_name' => $photo->getClientOriginalName(),
                'mime_type' => $photo->getMimeType(),
                'size' => $photo->getSize(),
                'extension' => $photo->getClientOriginalExtension(),
                'tmp_name' => $photo->getFilename(),
                'tmp_path' => $photo->getPathname()
            ]);
            
            // Validate file manually
            if ($photo) {
                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                $fileMime = $photo->getMimeType();
                
                \Log::info('Validating photo', ['mime' => $fileMime, 'allowed' => $allowedMimes]);
                
                if (!in_array($fileMime, $allowedMimes) || $photo->getSize() > 2048 * 1024) {
                    \Log::error('Photo validation failed', ['mime' => $fileMime, 'size' => $photo->getSize()]);
                    return back()->withErrors(['photo' => 'The photo must be a valid image file (JPEG, PNG, JPG, GIF, WebP) and less than 2MB.'])->withInput();
                }
                
                try {
                    $storedPath = $photo->store('user_photos', 'public');
                    $photoPath = basename($storedPath);
                    
                    \Log::info('Photo stored successfully', ['path' => $storedPath]);
                    
                    // Verify file was actually stored
                    if (\Storage::disk('public')->exists($storedPath)) {
                        \Log::info('File exists after storage: YES');
                    } else {
                        \Log::error('File does not exist after storage: ' . $storedPath);
                    }
                } catch (\Exception $e) {
                    \Log::error('Photo storage failed: ' . $e->getMessage());
                    return back()->withErrors(['photo' => 'Failed to upload photo. Please try again.'])->withInput();
                }
            }
        } else {
            \Log::info('No photo file detected in request');
        }

        \Log::info('Creating user with photo path', ['photo_path' => $photoPath]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'role' => 'customer', // FR7.1: Assign Buyer role by default
                'password' => Hash::make($validated['password']),
                'photo' => $photoPath,
            ]);

            \Log::info('User created successfully', [
                'user_id' => $user->id,
                'photo' => $user->photo,
                'photo_url' => $user->photo_url
            ]);
        } catch (\Exception $e) {
            \Log::error('User creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }

        event(new Registered($user));

        // Auto-login after successful registration
        \Illuminate\Support\Facades\Auth::login($user);

        return redirect('/')->with('success', 'Your account has been created successfully!');
    }
}
