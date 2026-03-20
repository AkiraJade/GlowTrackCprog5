<?php

namespace App\Http\Controllers;

use App\Models\IngredientConflict;
use App\Models\RoutineConflictWarning;
use App\Models\SkincareRoutine;
use App\Models\RoutineStep;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class IngredientConflictController extends Controller
{
    /**
     * Check for ingredient conflicts in a routine.
     */
    public function checkConflicts(Request $request): JsonResponse
    {
        $request->validate([
            'routine_id' => 'nullable|exists:skincare_routines,id',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'string',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $ingredients = $this->collectIngredients($request);

        if ($ingredients->count() < 2) {
            return response()->json([
                'conflicts' => [],
                'message' => 'Need at least 2 ingredients to check for conflicts',
            ]);
        }

        $conflicts = $this->findConflicts($ingredients);

        // Save warnings if we have a routine ID
        if ($request->filled('routine_id') && $conflicts->isNotEmpty()) {
            $this->saveConflictWarnings($request->routine_id, $conflicts);
        }

        return response()->json([
            'conflicts' => $conflicts->values(),
            'total_conflicts' => $conflicts->count(),
            'severity_breakdown' => $this->getSeverityBreakdown($conflicts),
        ]);
    }

    /**
     * Get all active ingredient conflicts for admin management.
     */
    public function index(Request $request): JsonResponse
    {
        $conflicts = IngredientConflict::active()
            ->with('routineConflictWarnings')
            ->when($request->filled('severity'), function ($query) use ($request) {
                $query->bySeverity($request->severity);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('ingredient_1', 'like', "%{$search}%")
                      ->orWhere('ingredient_2', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('severity', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($conflicts);
    }

    /**
     * Store a new ingredient conflict.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'ingredient_1' => 'required|string|max:255',
            'ingredient_2' => 'required|string|max:255',
            'severity' => 'required|in:low,moderate,high,severe',
            'description' => 'required|string',
            'recommendation' => 'required|string',
            'alternatives' => 'nullable|array',
            'alternatives.*' => 'string',
            'is_active' => 'boolean',
        ]);

        $conflict = IngredientConflict::create($request->all());

        return response()->json([
            'message' => 'Ingredient conflict created successfully',
            'conflict' => $conflict,
        ], 201);
    }

    /**
     * Update an ingredient conflict.
     */
    public function update(Request $request, IngredientConflict $conflict): JsonResponse
    {
        $request->validate([
            'ingredient_1' => 'sometimes|required|string|max:255',
            'ingredient_2' => 'sometimes|required|string|max:255',
            'severity' => 'sometimes|required|in:low,moderate,high,severe',
            'description' => 'sometimes|required|string',
            'recommendation' => 'sometimes|required|string',
            'alternatives' => 'nullable|array',
            'alternatives.*' => 'string',
            'is_active' => 'sometimes|boolean',
        ]);

        $conflict->update($request->all());

        return response()->json([
            'message' => 'Ingredient conflict updated successfully',
            'conflict' => $conflict,
        ]);
    }

    /**
     * Delete an ingredient conflict.
     */
    public function destroy(IngredientConflict $conflict): JsonResponse
    {
        $conflict->delete();

        return response()->json([
            'message' => 'Ingredient conflict deleted successfully',
        ]);
    }

    /**
     * Get conflict warnings for a user's routines.
     */
    public function getUserWarnings(Request $request): JsonResponse
    {
        $warnings = RoutineConflictWarning::where('user_id', Auth::id())
            ->with(['skincareRoutine', 'ingredientConflict'])
            ->when($request->filled('acknowledged'), function ($query) use ($request) {
                if ($request->acknowledged === 'true') {
                    $query->acknowledged();
                } else {
                    $query->unacknowledged();
                }
            })
            ->latest()
            ->paginate($request->get('per_page', 10));

        return response()->json($warnings);
    }

    /**
     * Acknowledge a conflict warning.
     */
    public function acknowledgeWarning(RoutineConflictWarning $warning): JsonResponse
    {
        if ($warning->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $warning->acknowledge();

        return response()->json([
            'message' => 'Warning acknowledged successfully',
            'warning' => $warning,
        ]);
    }

    /**
     * Acknowledge all warnings for a user.
     */
    public function acknowledgeAllWarnings(): JsonResponse
    {
        RoutineConflictWarning::where('user_id', Auth::id())
            ->unacknowledged()
            ->update([
                'is_acknowledged' => true,
                'acknowledged_at' => now(),
            ]);

        return response()->json([
            'message' => 'All warnings acknowledged successfully',
        ]);
    }

    /**
     * Collect ingredients from various sources.
     */
    private function collectIngredients(Request $request): Collection
    {
        $ingredients = collect();

        // Direct ingredients from request
        if ($request->filled('ingredients')) {
            $ingredients = $ingredients->merge($request->ingredients);
        }

        // Extract ingredients from products
        if ($request->filled('product_ids')) {
            $products = Product::whereIn('id', $request->product_ids)->get();
            
            foreach ($products as $product) {
                if ($product->active_ingredients) {
                    $ingredients = $ingredients->merge($product->active_ingredients);
                }
            }
        }

        // Extract ingredients from routine steps
        if ($request->filled('routine_id')) {
            $routine = SkincareRoutine::with('routineSteps')->find($request->routine_id);
            
            if ($routine) {
                foreach ($routine->routineSteps as $step) {
                    // Get ingredients from product if linked
                    if ($step->product_id) {
                        $product = Product::find($step->product_id);
                        if ($product && $product->active_ingredients) {
                            $ingredients = $ingredients->merge($product->active_ingredients);
                        }
                    }
                    
                    // Get ingredients from custom product name
                    if ($step->custom_product_name && !empty($step->ingredients)) {
                        $ingredients = $ingredients->merge($step->ingredients);
                    }
                }
            }
        }

        // Clean and normalize ingredients
        return $ingredients
            ->filter(fn($ingredient) => !empty($ingredient))
            ->map(fn($ingredient) => trim(strtolower($ingredient)))
            ->unique()
            ->values();
    }

    /**
     * Find conflicts between ingredients.
     */
    private function findConflicts(Collection $ingredients): Collection
    {
        $conflicts = collect();
        $checkedPairs = [];

        foreach ($ingredients as $ingredient1) {
            foreach ($ingredients as $ingredient2) {
                if ($ingredient1 === $ingredient2) {
                    continue;
                }

                // Create a unique pair key to avoid duplicate checks
                $pairKey = [$ingredient1, $ingredient2];
                sort($pairKey);
                $pairKey = implode('-', $pairKey);

                if (in_array($pairKey, $checkedPairs)) {
                    continue;
                }
                $checkedPairs[] = $pairKey;

                // Check for conflict in both directions
                $conflict = IngredientConflict::active()
                    ->where(function ($query) use ($ingredient1, $ingredient2) {
                        $query->where('ingredient_1', $ingredient1)
                              ->where('ingredient_2', $ingredient2);
                    })
                    ->orWhere(function ($query) use ($ingredient1, $ingredient2) {
                        $query->where('ingredient_1', $ingredient2)
                              ->where('ingredient_2', $ingredient1);
                    })
                    ->first();

                if ($conflict) {
                    $conflicts->push([
                        'conflict' => $conflict,
                        'ingredient_1' => $ingredient1,
                        'ingredient_2' => $ingredient2,
                        'severity' => $conflict->severity,
                        'severity_color' => $conflict->severity_color,
                        'severity_icon' => $conflict->severity_icon,
                        'severity_label' => $conflict->severity_label,
                        'description' => $conflict->description,
                        'recommendation' => $conflict->recommendation,
                        'alternatives' => $conflict->alternatives,
                    ]);
                }
            }
        }

        return $conflicts->sortByDesc(function ($conflict) {
            $severityOrder = ['severe' => 4, 'high' => 3, 'moderate' => 2, 'low' => 1];
            return $severityOrder[$conflict['severity']] ?? 0;
        });
    }

    /**
     * Save conflict warnings for a routine.
     */
    private function saveConflictWarnings(int $routineId, Collection $conflicts): void
    {
        $routine = SkincareRoutine::find($routineId);
        
        if (!$routine) {
            return;
        }

        // Clear existing warnings for this routine
        RoutineConflictWarning::where('skincare_routine_id', $routineId)->delete();

        foreach ($conflicts as $conflictData) {
            RoutineConflictWarning::create([
                'user_id' => $routine->user_id,
                'skincare_routine_id' => $routineId,
                'ingredient_conflict_id' => $conflictData['conflict']->id,
                'conflicting_ingredients' => [$conflictData['ingredient_1'], $conflictData['ingredient_2']],
            ]);
        }
    }

    /**
     * Get severity breakdown of conflicts.
     */
    private function getSeverityBreakdown(Collection $conflicts): array
    {
        $breakdown = [
            'low' => 0,
            'moderate' => 0,
            'high' => 0,
            'severe' => 0,
        ];

        foreach ($conflicts as $conflict) {
            $severity = $conflict['severity'];
            if (isset($breakdown[$severity])) {
                $breakdown[$severity]++;
            }
        }

        return $breakdown;
    }

    /**
     * Get ingredient suggestions based on conflicts.
     */
    public function getIngredientSuggestions(Request $request): JsonResponse
    {
        $request->validate([
            'ingredient' => 'required|string',
            'exclude_ingredients' => 'nullable|array',
            'exclude_ingredients.*' => 'string',
        ]);

        $ingredient = strtolower($request->ingredient);
        $excludeIngredients = collect($request->get('exclude_ingredients', []))
            ->map(fn($ing) => strtolower($ing))
            ->push($ingredient)
            ->unique()
            ->values();

        // Get ingredients that have conflicts with the given ingredient
        $conflictingIngredients = IngredientConflict::active()
            ->where(function ($query) use ($ingredient) {
                $query->where('ingredient_1', $ingredient)
                      ->orWhere('ingredient_2', $ingredient);
            })
            ->get()
            ->map(function ($conflict) use ($ingredient) {
                return $conflict->getOtherIngredient($ingredient);
            })
            ->merge($excludeIngredients)
            ->unique()
            ->values();

        // Get all active conflicts to find safe alternatives
        $allConflicts = IngredientConflict::active()->get();
        $safeIngredients = collect();

        // This is a simplified approach - in a real system, you might have
        // a separate table of safe ingredient combinations
        $commonSafeIngredients = [
            'hyaluronic acid',
            'niacinamide',
            'vitamin c',
            'peptides',
            'ceramides',
            'squalane',
            'glycerin',
            'aloe vera',
            'green tea',
            'chamomile',
        ];

        foreach ($commonSafeIngredients as $safeIngredient) {
            if (!$conflictingIngredients->contains(strtolower($safeIngredient))) {
                $safeIngredients->push($safeIngredient);
            }
        }

        return response()->json([
            'safe_ingredients' => $safeIngredients->take(10),
            'conflicting_ingredients' => $conflictingIngredients,
        ]);
    }
}
