@extends('layouts.app')

@section('title', 'Create Skincare Routine - GlowTrack')

@section('content')
<!-- Create Routine Container -->
<section class="min-h-screen bg-gradient-to-br from-mint-cream via-pastel-green to-light-sage py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-soft-brown font-playfair mb-4">Create Skincare Routine</h1>
                <p class="text-gray-600 text-lg">Build your personalized skincare routine step by step</p>
            </div>
            
            <form method="POST" action="{{ route('skincare-routines.store') }}" id="routineForm">
                @csrf
                
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Routine Name</label>
                        <input type="text" name="name" required
                               placeholder="e.g., Morning Glow Routine"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Schedule</label>
                        <select name="schedule" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                            <option value="AM">☀️ AM Routine</option>
                            <option value="PM">🌙 PM Routine</option>
                        </select>
                    </div>
                </div>
                
                <!-- Public Toggle -->
                <div class="mb-8">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="is_public" value="1"
                               class="form-checkbox h-5 w-5 text-jade-green rounded focus:ring-jade-green">
                        <span class="text-sm font-medium text-gray-700">Make this routine public (others can see and use it)</span>
                    </label>
                </div>

                <!-- Ingredient Conflict Warnings -->
                @include('partials.conflict-warnings')
                
                <!-- Routine Steps -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-soft-brown">Routine Steps</h3>
                        <button type="button" onclick="addStep()" 
                                class="px-4 py-2 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-semibold text-sm">
                            + Add Step
                        </button>
                    </div>
                    
                    <div id="stepsContainer" class="space-y-4">
                        <!-- Initial Step -->
                        <div class="step-item bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-semibold text-soft-brown">Step 1</span>
                                <button type="button" onclick="removeStep(this)" 
                                        class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Step Type</label>
                                    <select name="steps[0][step_type]" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                                        @foreach($availableSteps as $step)
                                            <option value="{{ $step }}">{{ $step }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product (Optional)</label>
                                    <select name="steps[0][product_id]" 
                                            onchange="toggleCustomProduct(this, 0)"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                                        <option value="">Select a product...</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                        <option value="custom">Custom Product</option>
                                    </select>
                                </div>
                                
                                <div id="customProductContainer_0" style="display: none;">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Custom Product Name</label>
                                    <input type="text" name="steps[0][product_name]" 
                                           placeholder="Enter custom product name"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                                </div>
                            </div>
                            
                            <input type="hidden" name="steps[0][step_order]" value="1">
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="text-center pt-8">
                    <button type="submit" 
                            class="px-8 py-4 bg-jade-green text-white rounded-full hover:bg-jade-green/80 transition font-bold text-lg shadow-xl transform hover:scale-105">
                        ✨ Create Routine
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
let stepCount = 1;

function addStep() {
    const container = document.getElementById('stepsContainer');
    const stepDiv = document.createElement('div');
    stepDiv.className = 'step-item bg-gray-50 rounded-lg p-4';
    
    stepDiv.innerHTML = `
        <div class="flex items-center justify-between mb-3">
            <span class="font-semibold text-soft-brown">Step ${stepCount + 1}</span>
            <button type="button" onclick="removeStep(this)" 
                    class="text-red-500 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Step Type</label>
                <select name="steps[${stepCount}][step_type]" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                    @foreach($availableSteps as $step)
                        <option value="{{ $step }}">{{ $step }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product (Optional)</label>
                <select name="steps[${stepCount}][product_id]" 
                        onchange="toggleCustomProduct(this, ${stepCount})"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
                    <option value="">Select a product...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                    <option value="custom">Custom Product</option>
                </select>
            </div>
            
            <div id="customProductContainer_${stepCount}" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mb-2">Custom Product Name</label>
                <input type="text" name="steps[${stepCount}][product_name]" 
                       placeholder="Enter custom product name"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-jade-green focus:border-transparent">
            </div>
        </div>
        
        <input type="hidden" name="steps[${stepCount}][step_order]" value="${stepCount + 1}">
    `;
    
    container.appendChild(stepDiv);
    stepCount++;
}

function removeStep(button) {
    const stepItem = button.closest('.step-item');
    stepItem.remove();
    updateStepNumbers();
}

function updateStepNumbers() {
    const steps = document.querySelectorAll('.step-item');
    steps.forEach((step, index) => {
        const stepNumberSpan = step.querySelector('.font-semibold');
        stepNumberSpan.textContent = `Step ${index + 1}`;
        
        const stepOrderInput = step.querySelector('input[name$="[step_order]"]');
        stepOrderInput.value = index + 1;
    });
}

function toggleCustomProduct(select, stepIndex) {
    const customContainer = document.getElementById(`customProductContainer_${stepIndex}`);
    const customInput = customContainer.querySelector('input');
    
    if (select.value === 'custom') {
        customContainer.style.display = 'block';
        customInput.required = true;
    } else {
        customContainer.style.display = 'none';
        customInput.required = false;
        customInput.value = '';
    }
    
    // Check for conflicts when product selection changes
    if (window.conflictDetector) {
        setTimeout(() => {
            window.conflictDetector.checkRoutineBuilderConflicts();
        }, 100);
    }
}
</script>
@endsection
