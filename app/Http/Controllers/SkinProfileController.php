<?php

namespace App\Http\Controllers;

use App\Models\SkinProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SkinProfileController extends Controller
{
    public function index(): View
    {
        $profile = auth()->user()->skinProfile;
        
        return view('skin-profile.index', compact('profile'));
    }

    public function create(): View
    {
        $skinProfile = new SkinProfile();
        $availableTypes = $skinProfile->getAvailableSkinTypes();
        $availableConcerns = $skinProfile->getAvailableConcerns();
        $availableAllergies = $skinProfile->getAvailableAllergies();

        return view('skin-profile.create', compact(
            'skinProfile',
            'availableTypes',
            'availableConcerns',
            'availableAllergies'
        ));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'skin_type' => 'required|in:Oily,Dry,Combination,Sensitive,Normal',
            'skin_concerns' => 'nullable|array',
            'ingredient_allergies' => 'nullable|array',
            'notes' => 'nullable|string|max:1000',
        ]);

        $profile = auth()->user()->skinProfile()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Skin profile created successfully!',
            'profile' => $profile
        ]);
    }

    public function edit(SkinProfile $skinProfile): View
    {
        $this->authorize('update', $skinProfile);
        
        $availableTypes = $skinProfile->getAvailableSkinTypes();
        $availableConcerns = $skinProfile->getAvailableConcerns();
        $availableAllergies = $skinProfile->getAvailableAllergies();

        return view('skin-profile.edit', compact(
            'skinProfile',
            'availableTypes',
            'availableConcerns',
            'availableAllergies'
        ));
    }

    public function update(Request $request, SkinProfile $skinProfile): JsonResponse
    {
        $this->authorize('update', $skinProfile);

        $validated = $request->validate([
            'skin_type' => 'required|in:Oily,Dry,Combination,Sensitive,Normal',
            'skin_concerns' => 'nullable|array',
            'ingredient_allergies' => 'nullable|array',
            'notes' => 'nullable|string|max:1000',
        ]);

        $skinProfile->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Skin profile updated successfully!',
            'profile' => $skinProfile->fresh()
        ]);
    }

    public function timeline(): View
    {
        $journals = auth()->user()->skinJournals()
            ->with('user')
            ->orderBy('entry_date', 'desc')
            ->paginate(10);

        return view('skin-profile.timeline', compact('journals'));
    }
}
