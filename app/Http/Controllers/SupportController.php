<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Show the contact support form.
     */
    public function contact()
    {
        return view('support.contact');
    }

    /**
     * Show the knowledge base page.
     */
    public function knowledge()
    {
        return view('support.knowledge');
    }

    /**
     * Handle the support form submission.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string',
            'order_id' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // In a real application, you would:
        // 1. Save to database
        // 2. Send email notification to support team
        // 3. Send confirmation email to user
        // 4. Generate ticket number
        
        // For now, we'll just redirect back with a success message
        return redirect()->route('support.contact')
            ->with('success', 'Your support request has been submitted successfully! We\'ll get back to you within 24 hours.');
    }
}
