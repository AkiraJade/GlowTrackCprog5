<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomEmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:users,id',
            'hash' => 'required|string',
            'expires' => 'required|integer',
        ];
    }

    /**
     * Get the user that owns the verification request.
     */
    public function user($guard = null)
    {
        // Validate URL parameters first
        if (!$this->validateUrl()) {
            return null;
        }

        $userId = $this->route('id');
        
        if (!$userId) {
            return null;
        }
        
        return \App\Models\User::find($userId);
    }

    /**
     * Validate the verification URL
     */
    private function validateUrl(): bool
    {
        $userId = $this->route('id');
        $hash = $this->route('hash');
        $expires = $this->route('expires');
        
        \Log::info('Validating verification URL', [
            'user_id' => $userId,
            'hash' => $hash,
            'expires' => $expires,
            'current_time' => time(),
            'time_remaining' => $expires ? $expires - time() : 'null'
        ]);
        
        if (!$userId || !$hash || !$expires) {
            \Log::error('Missing URL parameters');
            return false;
        }

        // Check if expired
        if (time() > $expires) {
            \Log::error('Verification link expired');
            return false;
        }

        // Find user
        $user = \App\Models\User::find($userId);
        if (!$user) {
            \Log::error('User not found for ID: ' . $userId);
            return false;
        }

        // Verify hash
        $userEmail = $user->getEmailForVerification();
        $expectedHash = sha1($userEmail);
        
        \Log::info('Hash verification', [
            'user_email' => $userEmail,
            'expected_hash' => $expectedHash,
            'provided_hash' => $hash,
            'hash_match' => hash_equals($expectedHash, $hash)
        ]);
        
        if (!hash_equals($expectedHash, $hash)) {
            \Log::error('Hash mismatch');
            return false;
        }

        \Log::info('URL validation passed');
        return true;
    }

    /**
     * Get the user's email for verification.
     */
    protected function getEmailForVerification()
    {
        $user = $this->user();
        
        if (!$user) {
            return null;
        }
        
        return $user->getEmailForVerification();
    }

    /**
     * Check if the user has verified their email address.
     */
    public function hasVerifiedEmail()
    {
        $user = $this->user();
        
        if (!$user) {
            return false;
        }
        
        return $user->hasVerifiedEmail();
    }

    /**
     * Mark the user's email address as verified.
     */
    public function markEmailAsVerified()
    {
        $user = $this->user();
        
        if (!$user) {
            return false;
        }
        
        return $user->markEmailAsVerified();
    }
}
