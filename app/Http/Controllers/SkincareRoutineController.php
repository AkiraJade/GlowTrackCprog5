<?php

namespace App\Http\Controllers;

use App\Models\SkincareRoutine;
use App\Models\RoutineStep;
use App\Models\Product;
use App\Models\RoutineFavorite;
use App\Models\RoutineRating;
use App\Models\RoutineReview;
use App\Http\Controllers\IngredientConflictController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SkincareRoutineController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Get user's own routines
        $ownedRoutines = $user->skincareRoutines()
            ->with(['steps.product', 'ratings', 'favorites', 'reviews'])
            ->withCount(['ratings', 'favorites', 'reviews'])
            ->get()
            ->map(function ($routine) {
                $routine->is_owned = true;
                $routine->is_favorited = false;
                return $routine;
            });

        // Get favorited routines (excluding user's own routines)
        $favoritedRoutines = SkincareRoutine::whereHas('favorites', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('user_id', '!=', $user->id) // Exclude user's own routines
            ->with(['steps.product', 'ratings', 'favorites', 'reviews', 'user'])
            ->withCount(['ratings', 'favorites', 'reviews'])
            ->get()
            ->map(function ($routine) {
                $routine->is_owned = false;
                $routine->is_favorited = true;
                return $routine;
            });

        // Combine and sort routines (owned first, then favorited)
        $routines = $ownedRoutines->concat($favoritedRoutines)->sort(function ($a, $b) {
            // Owned routines first
            if ($a->is_owned && !$b->is_owned) return -1;
            if (!$a->is_owned && $b->is_owned) return 1;

            // Then sort by schedule
            $scheduleOrder = ['AM' => 1, 'PM' => 2];
            $aSchedule = $scheduleOrder[$a->schedule] ?? 3;
            $bSchedule = $scheduleOrder[$b->schedule] ?? 3;

            if ($aSchedule !== $bSchedule) {
                return $aSchedule - $bSchedule;
            }

            // Finally by creation date (newest first)
            return $b->created_at <=> $a->created_at;
        })->values();

        return view('skincare-routines.index', compact('routines'));
    }

    public function create(): View
    {
        $routine = new SkincareRoutine();
        $availableSteps = $routine->getAvailableSteps();
        $products = Product::where('status', 'approved')->get();

        return view('skincare-routines.create', compact('routine', 'availableSteps', 'products'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        // Normalize steps before validation (custom product uses marker value "custom")
        $steps = collect($request->input('steps', []))->map(function ($step) {
            if (isset($step['product_id']) && $step['product_id'] === 'custom') {
                $step['product_id'] = null;
            }

            if (isset($step['product_id']) && $step['product_id'] === '') {
                $step['product_id'] = null;
            }

            if (!isset($step['product_name']) || trim($step['product_name']) === '') {
                $step['product_name'] = null;
            }

            return $step;
        })->toArray();

        $request->merge(['steps' => $steps]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'schedule' => 'required|in:AM,PM',
            'is_public' => 'boolean',
            'steps' => 'required|array|min:1',
            'steps.*.step_type' => 'required|in:Cleanser,Toner,Serum,Moisturizer,SPF,Other',
            'steps.*.product_name' => 'nullable|string|max:255',
            'steps.*.product_id' => 'nullable|integer|exists:products,id',
            'steps.*.step_order' => 'required|integer|min:1',
        ]);

        $routine = auth()->user()->skincareRoutines()->create([
            'name' => $validated['name'],
            'schedule' => $validated['schedule'],
            'is_public' => $validated['is_public'] ?? false,
        ]);

        foreach ($validated['steps'] as $stepData) {
            $routine->steps()->create([
                'step_type' => $stepData['step_type'],
                'product_name' => $stepData['product_name'],
                'product_id' => $stepData['product_id'],
                'step_order' => $stepData['step_order'],
            ]);
        }

        // Check for ingredient conflicts
        $conflictController = new IngredientConflictController();
        $conflictCheck = $conflictController->checkConflicts(new Request([
            'routine_id' => $routine->id,
        ]));

        $conflicts = $conflictCheck->getData()->conflicts ?? [];

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Skincare routine created successfully!',
                'routine' => $routine->load('steps'),
                'conflicts' => $conflicts,
                'conflict_count' => count($conflicts),
            ]);
        }

        return redirect()->route('skincare-routines.index')
            ->with('success', 'Skincare routine created successfully!')
            ->with('conflicts', $conflicts)
            ->with('conflict_count', count($conflicts));
    }

    protected function authorizeOwner(SkincareRoutine $routine): void
    {
        if ($routine->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function show(SkincareRoutine $skincareRoutine): View
    {
        // Allow viewing if the routine is public OR if the current user is the owner
        if (!$skincareRoutine->is_public && $skincareRoutine->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $routine = $skincareRoutine->load([
            'steps.product',
            'favorites',
            'ratings',
            'reviews.user'
        ]);

        return view('skincare-routines.show', compact('routine'));
    }

    public function edit(SkincareRoutine $skincareRoutine): View
    {
        $this->authorizeOwner($skincareRoutine);

        $routine = $skincareRoutine->load('steps');
        $availableSteps = $routine->getAvailableSteps();
        $products = Product::where('status', 'approved')->get();

        return view('skincare-routines.edit', compact('routine', 'availableSteps', 'products'));
    }

    public function update(Request $request, SkincareRoutine $skincareRoutine): JsonResponse|RedirectResponse
    {
        $this->authorizeOwner($skincareRoutine);

        $steps = collect($request->input('steps', []))->map(function ($step) {
            if (isset($step['product_id']) && $step['product_id'] === 'custom') {
                $step['product_id'] = null;
            }

            if (isset($step['product_id']) && $step['product_id'] === '') {
                $step['product_id'] = null;
            }

            if (!isset($step['product_name']) || trim($step['product_name']) === '') {
                $step['product_name'] = null;
            }

            return $step;
        })->toArray();

        $request->merge(['steps' => $steps]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'schedule' => 'required|in:AM,PM',
            'is_public' => 'boolean',
            'steps' => 'required|array|min:1',
            'steps.*.step_type' => 'required|in:Cleanser,Toner,Serum,Moisturizer,SPF,Other',
            'steps.*.product_name' => 'nullable|string|max:255',
            'steps.*.product_id' => 'nullable|integer|exists:products,id',
            'steps.*.step_order' => 'required|integer|min:1',
        ]);

        $skincareRoutine->update([
            'name' => $validated['name'],
            'schedule' => $validated['schedule'],
            'is_public' => $validated['is_public'] ?? false,
        ]);

        // Remove existing steps
        $skincareRoutine->steps()->delete();

        // Create new steps
        foreach ($validated['steps'] as $stepData) {
            $skincareRoutine->steps()->create([
                'step_type' => $stepData['step_type'],
                'product_name' => $stepData['product_name'],
                'product_id' => $stepData['product_id'],
                'step_order' => $stepData['step_order'],
            ]);
        }

        // Check for ingredient conflicts
        $conflictController = new IngredientConflictController();
        $conflictCheck = $conflictController->checkConflicts(new Request([
            'routine_id' => $skincareRoutine->id,
        ]));

        $conflicts = $conflictCheck->getData()->conflicts ?? [];

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Skincare routine updated successfully!',
                'routine' => $skincareRoutine->fresh()->load('steps'),
                'conflicts' => $conflicts,
                'conflict_count' => count($conflicts),
            ]);
        }

        return redirect()->route('skincare-routines.index')
            ->with('success', 'Skincare routine updated successfully!')
            ->with('conflicts', $conflicts)
            ->with('conflict_count', count($conflicts));
    }

    public function destroy(SkincareRoutine $skincareRoutine): JsonResponse|RedirectResponse
    {
        $this->authorizeOwner($skincareRoutine);

        $skincareRoutine->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Skincare routine deleted successfully!'
            ]);
        }

        return redirect()->route('skincare-routines.index')
            ->with('success', 'Skincare routine deleted successfully!');
    }

    public function public (): View
    {
        $routines = SkincareRoutine::where('is_public', true)
            ->with(['user', 'steps.product', 'ratings', 'favorites'])
            ->withCount(['ratings', 'favorites', 'reviews'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('skincare-routines.public', compact('routines'));
    }

    public function toggleFavorite(SkincareRoutine $skincareRoutine): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $favorite = RoutineFavorite::where('user_id', $user->id)
            ->where('skincare_routine_id', $skincareRoutine->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['favorited' => false, 'message' => 'Removed from favorites']);
        } else {
            RoutineFavorite::create([
                'user_id' => $user->id,
                'skincare_routine_id' => $skincareRoutine->id,
            ]);
            return response()->json(['favorited' => true, 'message' => 'Added to favorites']);
        }
    }

    public function rate(Request $request, SkincareRoutine $skincareRoutine): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        RoutineRating::updateOrCreate(
            [
                'user_id' => $user->id,
                'skincare_routine_id' => $skincareRoutine->id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        $averageRating = $skincareRoutine->getAverageRating();
        $ratingCount = $skincareRoutine->getRatingCount();

        return response()->json([
            'success' => true,
            'average_rating' => $averageRating,
            'rating_count' => $ratingCount,
            'user_rating' => $request->rating,
        ]);
    }

    public function review(Request $request, SkincareRoutine $skincareRoutine): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'skin_type' => 'nullable|string|in:Oily,Dry,Combination,Sensitive,Normal',
            'results_observed' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $review = RoutineReview::updateOrCreate(
            [
                'user_id' => $user->id,
                'skincare_routine_id' => $skincareRoutine->id,
            ],
            [
                'comment' => $request->comment,
                'skin_type' => $request->skin_type,
                'results_observed' => $request->results_observed,
            ]
        );

        return response()->json([
            'success' => true,
            'review' => $review->load('user'),
            'message' => 'Review submitted successfully',
        ]);
    }

    public function deleteReview(SkincareRoutine $skincareRoutine): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $review = RoutineReview::where('user_id', $user->id)
            ->where('skincare_routine_id', $skincareRoutine->id)
            ->first();

        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully',
        ]);
    }
}
