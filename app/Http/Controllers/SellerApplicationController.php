<?php

namespace App\Http\Controllers;

use App\Models\SellerApplication;
use App\Models\User;
use Illuminate\Http\Request;

class SellerApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the seller application form.
     */
    public function create()
    {
        // Check if user already has an application
        $existingApplication = SellerApplication::where('user_id', auth()->id())->first();
        
        if ($existingApplication) {
            return redirect()->route('seller.application.status')
                ->with('info', 'You already have a seller application on file.');
        }

        // Check if user is already a seller
        if (auth()->user()->isSeller()) {
            return redirect()->route('products.my')
                ->with('info', 'You are already approved as a seller.');
        }

        $categories = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];
        
        return view('seller.application.create', compact('categories'));
    }

    /**
     * Store a new seller application.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'business_description' => 'required|string|max:2000',
            'business_license' => 'nullable|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'business_address' => 'required|string|max:500',
            'website_url' => 'nullable|url|max:255',
            'product_categories' => 'required|array|min:1',
            'product_categories.*' => 'in:Cleanser,Moisturizer,Serum,Toner,Sunscreen,Mask,Exfoliant,Treatment',
        ]);

        // Check if user already has an application
        $existingApplication = SellerApplication::where('user_id', auth()->id())->first();
        if ($existingApplication) {
            return redirect()->back()
                ->with('error', 'You already have a seller application on file.');
        }

        SellerApplication::create([
            'user_id' => auth()->id(),
            'brand_name' => $request->brand_name,
            'business_description' => $request->business_description,
            'business_license' => $request->business_license,
            'contact_person' => $request->contact_person,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'business_address' => $request->business_address,
            'website_url' => $request->website_url,
            'product_categories' => $request->product_categories,
        ]);

        return redirect()->route('seller.application.status')
            ->with('success', 'Your seller application has been submitted successfully! We will review it within 2-3 business days.');
    }

    /**
     * Show the application status.
     */
    public function status()
    {
        $application = SellerApplication::where('user_id', auth()->id())->first();
        
        if (!$application) {
            return redirect()->route('seller.application.create');
        }

        return view('seller.application.status', compact('application'));
    }

    /**
     * Display all seller applications for admins.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $query = SellerApplication::with(['user', 'reviewer']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(10);

        return view('admin.seller-applications', compact('applications'));
    }

    /**
     * Show a specific seller application.
     */
    public function show(SellerApplication $application)
    {
        if (!auth()->user()->isAdmin() && auth()->id() !== $application->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $application->load(['user', 'reviewer']);

        if (auth()->user()->isAdmin()) {
            return view('admin.seller-application-details', compact('application'));
        }

        return view('seller.application.details', compact('application'));
    }

    /**
     * Approve a seller application.
     */
    public function approve(Request $request, SellerApplication $application)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        // Update application
        $application->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        // Update user role to seller
        $application->user->update(['role' => 'seller']);

        return redirect()->route('admin.seller-applications')
            ->with('success', 'Seller application approved successfully!');
    }

    /**
     * Reject a seller application.
     */
    public function reject(Request $request, SellerApplication $application)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $application->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->route('admin.seller-applications')
            ->with('success', 'Seller application rejected.');
    }
}
