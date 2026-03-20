<?php

namespace App\Http\Controllers;

use App\Models\SkincareRoutine;
use App\Models\RoutineStep;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SkincareRoutineController extends Controller
{
    public function index(): View
    {
        $routines = auth()->user()->skincareRoutines()
            ->with('steps.product')
            ->orderBy('schedule')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('skincare-routines.index', compact('routines'));
    }

    public function create(): View
    {
        $routine = new SkincareRoutine();
        $availableSteps = $routine->getAvailableSteps();
        $products = Product::where('status', 'approved')->get();

        return view('skincare-routines.create', compact('routine', 'availableSteps', 'products'));
    }

    public function store(Request $request): JsonResponse
    {
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

        return response()->json([
            'success' => true,
            'message' => 'Skincare routine created successfully!',
            'routine' => $routine->load('steps')
        ]);
    }

    public function show(SkincareRoutine $skincareRoutine): View
    {
        $this->authorize('view', $skincareRoutine);
        
        $routine = $skincareRoutine->load('steps.product');

        return view('skincare-routines.show', compact('routine'));
    }

    public function edit(SkincareRoutine $skincareRoutine): View
    {
        $this->authorize('update', $skincareRoutine);
        
        $routine = $skincareRoutine->load('steps');
        $availableSteps = $routine->getAvailableSteps();
        $products = Product::where('status', 'approved')->get();

        return view('skincare-routines.edit', compact('routine', 'availableSteps', 'products'));
    }

    public function update(Request $request, SkincareRoutine $skincareRoutine): JsonResponse
    {
        $this->authorize('update', $skincareRoutine);

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

        return response()->json([
            'success' => true,
            'message' => 'Skincare routine updated successfully!',
            'routine' => $skincareRoutine->fresh()->load('steps')
        ]);
    }

    public function destroy(SkincareRoutine $skincareRoutine): JsonResponse
    {
        $this->authorize('delete', $skincareRoutine);

        $skincareRoutine->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skincare routine deleted successfully!'
        ]);
    }

    public function public(): View
    {
        $routines = SkincareRoutine::where('is_public', true)
            ->with(['user', 'steps.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('skincare-routines.public', compact('routines'));
    }
}
