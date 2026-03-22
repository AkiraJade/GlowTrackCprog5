<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\URL;

class EmailVerificationController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(Request $request)
    {
        $userId = $request->route('id');
        $hash = $request->route('hash');
        
        if (!$userId || !$hash) {
            return redirect()->route('login')
                ->with('error', 'Invalid verification link.');
        }

        $user = \App\Models\User::find($userId);
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'User not found.');
        }

        // Verify the hash
        if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            return redirect()->route('login')
                ->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('success', 'Email already verified. Please log in.');
        }

        // Direct database update
        try {
            $user->email_verified_at = now();
            $user->save();
            
            event(new Verified($user));
            
            return redirect()->route('login')
                ->with('success', 'Email verified successfully! Please log in.');
                
        } catch (\Exception $e) {
            \Log::error('Failed to verify email', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Verification failed. Please try again.');
        }
    }

    /**
     * Resend the email verification notification.
     */
    public function sendVerificationNotification(Request $request)
    {
        // Handle authenticated users
        if ($request->user()) {
            if ($request->user()->hasVerifiedEmail()) {
                return back()->with('success', 'Your email is already verified.');
            }

            // Generate simple verification URL (not signed)
            $verificationUrl = url('/email/verify/' . $request->user()->id . '/' . sha1($request->user()->getEmailForVerification()) . '?expires=' . (time() + 3600));

            Mail::to($request->user()->email)->send(new VerifyEmail($request->user(), $verificationUrl));

            return back()->with('success', 'Verification link sent! Please check your email.');
        }

        // Handle non-authenticated users (from verify-pending page)
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'Your email is already verified. Please log in.');
        }

        // Generate simple verification URL (not signed)
        $verificationUrl = url('/email/verify/' . $user->id . '/' . sha1($user->getEmailForVerification()) . '?expires=' . (time() + 3600));

        $rateLimiter->sendWithThrottle(
            $user->email,
            new VerifyEmail($user, $verificationUrl)
        );

        return back()->with('success', 'Verification link sent! Please check your email.');
    }
}
