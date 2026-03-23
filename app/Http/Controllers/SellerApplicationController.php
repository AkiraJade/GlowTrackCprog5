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
        // Check if user has a pending or approved application
        $activeApplication = SellerApplication::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($activeApplication) {
            return redirect()->route('seller.application.status')
                ->with('info', 'You already have a seller application under review or approved.');
        }

        // Check if user is already a seller
        if (auth()->user()->isSeller()) {
            return redirect()->route('seller.dashboard')
                ->with('info', 'You are already approved as a seller.');
        }

        // Check if this is a reapplication after rejection
        $rejectedApplication = SellerApplication::where('user_id', auth()->id())
            ->where('status', 'rejected')
            ->first();

        $categories = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];
        $isReapplication = $rejectedApplication ? true : false;

        return view('seller.application.create', compact('categories', 'isReapplication', 'rejectedApplication'));
    }

    /**
     * Store a new seller application or reapply after rejection.
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

        // Check if user has a pending or approved application
        $activeApplication = SellerApplication::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($activeApplication) {
            return redirect()->back()
                ->with('error', 'You already have a seller application under review or approved.');
        }

        // Check for rejected application to reapply
        $rejectedApplication = SellerApplication::where('user_id', auth()->id())
            ->where('status', 'rejected')
            ->first();

        if ($rejectedApplication) {
            // Update rejected application with new information and reset to pending
            $rejectedApplication->update([
                'brand_name' => $request->brand_name,
                'business_description' => $request->business_description,
                'business_license' => $request->business_license,
                'contact_person' => $request->contact_person,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'business_address' => $request->business_address,
                'website_url' => $request->website_url,
                'product_categories' => $request->product_categories,
                'status' => 'pending',
                'admin_notes' => null,
                'reviewed_at' => null,
                'reviewed_by' => null,
            ]);
        } else {
            // Create new application
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
        }

        // Create notification for all admins about new seller application
        $this->notifyAdmins(
            'new_seller_application',
            'New Seller Application',
            "New seller application submitted by {$request->brand_name}.",
            ['application_id' => $rejectedApplication ? $rejectedApplication->id : SellerApplication::latest()->first()->id, 'brand_name' => $request->brand_name, 'user_id' => auth()->id()]
        );

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

        // Create notification for the applicant
        \App\Http\Controllers\NotificationController::createNotification(
            $application->user_id,
            'seller_approved',
            'Seller Application Approved',
            'Congratulations! Your seller application has been approved. You can now start selling products.',
            ['application_id' => $application->id, 'admin_notes' => $request->admin_notes]
        );

        // Create notification for all admins
        $this->notifyAdmins(
            'admin_action',
            'Seller Application Approved',
            "Seller application for {$application->user->name} approved by admin.",
            ['application_id' => $application->id, 'user_id' => $application->user_id, 'admin_id' => auth()->id()]
        );

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

        // Create notification for the applicant
        \App\Http\Controllers\NotificationController::createNotification(
            $application->user_id,
            'seller_rejected',
            'Seller Application Rejected',
            "Your seller application has been rejected. Reason: {$request->admin_notes}",
            ['application_id' => $application->id, 'reason' => $request->admin_notes]
        );

        // Create notification for all admins
        $this->notifyAdmins(
            'admin_action',
            'Seller Application Rejected',
            "Seller application for {$application->user->name} rejected by admin.",
            ['application_id' => $application->id, 'user_id' => $application->user_id, 'admin_id' => auth()->id()]
        );

        return redirect()->route('admin.seller-applications')
            ->with('success', 'Seller application rejected.');
    }

    /**
     * Delete a seller application (hard delete).
     */
    public function destroy(SellerApplication $application)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $brandName = $application->brand_name;
            $userId    = $application->user_id;

            // Notify the applicant
            \App\Http\Controllers\NotificationController::createNotification(
                $userId,
                'seller_application_deleted',
                'Seller Application Removed',
                "Your seller application for \"{$brandName}\" has been removed by an administrator.",
                ['brand_name' => $brandName]
            );

            $application->delete();

            return redirect()->route('admin.seller-applications')
                ->with('success', "Seller application for \"{$brandName}\" has been deleted.");

        } catch (\Exception $e) {
            \Log::error('Error deleting seller application: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to delete the application. Please try again.');
        }
    }

    /**
     * Helper method to notify all admin users
     */
    private function notifyAdmins(string $type, string $title, string $message, array $data = []): void
    {
        $adminUsers = User::where('role', 'admin')->get();

        foreach ($adminUsers as $admin) {
            // Don't notify the admin who performed the action
            if ($admin->id !== auth()->id()) {
                \App\Http\Controllers\NotificationController::createNotification(
                    $admin->id,
                    $type,
                    $title,
                    $message,
                    $data
                );
            }
        }
    }
}
