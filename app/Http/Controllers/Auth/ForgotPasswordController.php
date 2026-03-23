<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a password reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We cannot find a user with that email address.',
        ]);

        // We will send the password reset link to this user.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        // If the password reset link was sent successfully, we will redirect back to
        // the application's home authenticated view and send a success message.
        if ($response == Password::RESET_LINK_SENT) {
            return back()
                ->with('status', 'We have emailed your password reset link!')
                ->with('success', 'Please check your email for the password reset link.');
        }

        // If an error occurred, we will return back with an error message.
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Unable to send password reset link. Please try again.']);
    }

    /**
     * Get the broker to be used during password reset.
     */
    public function broker()
    {
        return Password::broker();
    }
}
