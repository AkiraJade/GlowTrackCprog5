// Ingredient Conflict Detection System
class ConflictDetector {
    constructor() {
        this.currentConflicts = [];
        this.isChecking = false;
        this.debounceTimer = null;
    }

    // Check conflicts for current routine
    async checkConflicts(routineId = null, ingredients = [], productIds = []) {
        if (this.isChecking) return;
        
        this.isChecking = true;
        
        try {
            const response = await fetch('/api/ingredient-conflicts/check', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    routine_id: routineId,
                    ingredients: ingredients,
                    product_ids: productIds
                })
            });

            if (response.ok) {
                const data = await response.json();
                this.currentConflicts = data.conflicts || [];
                this.displayConflicts(data);
                this.updateConflictSummary(data);
            }
        } catch (error) {
            console.error('Error checking conflicts:', error);
            this.showError('Unable to check ingredient conflicts');
        } finally {
            this.isChecking = false;
        }
    }

    // Debounced conflict checking
    debouncedCheck(routineId, ingredients, productIds, delay = 1000) {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(() => {
            this.checkConflicts(routineId, ingredients, productIds);
        }, delay);
    }

    // Display conflicts in the UI
    displayConflicts(data) {
        const container = document.getElementById('conflict-warnings');
        if (!container) return;

        if (data.conflicts.length === 0) {
            container.innerHTML = this.getNoConflictsHTML();
            return;
        }

        container.innerHTML = this.getConflictsHTML(data.conflicts);
        this.attachConflictEventListeners();
    }

    // Get HTML for no conflicts
    getNoConflictsHTML() {
        return `
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">No Ingredient Conflicts Detected</h3>
                        <p class="text-sm text-green-700 mt-1">Your skincare routine looks safe to use!</p>
                    </div>
                </div>
            </div>
        `;
    }

    // Get HTML for conflicts display
    getConflictsHTML(conflicts) {
        const severityOrder = ['severe', 'high', 'moderate', 'low'];
        const sortedConflicts = conflicts.sort((a, b) => 
            severityOrder.indexOf(a.severity) - severityOrder.indexOf(b.severity)
        );

        return `
            <div class="space-y-4">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                ${conflicts.length} Ingredient Conflict${conflicts.length > 1 ? 's' : ''} Detected
                            </h3>
                            <p class="text-sm text-yellow-700 mt-1">Please review the conflicts below before using this routine.</p>
                        </div>
                    </div>
                </div>
                
                ${sortedConflicts.map((conflict, index) => this.getConflictHTML(conflict, index)).join('')}
            </div>
        `;
    }

    // Get HTML for individual conflict
    getConflictHTML(conflict, index) {
        const severityColors = {
            low: 'yellow',
            moderate: 'orange',
            high: 'red',
            severe: 'purple'
        };

        const color = severityColors[conflict.severity] || 'yellow';
        const bgClass = `bg-${color}-50`;
        const borderClass = `border-${color}-200`;
        const textClass = `text-${color}-800`;
        const iconClass = `text-${color}-400`;

        return `
            <div class="conflict-item ${bgClass} border ${borderClass} rounded-lg p-4" data-conflict-index="${index}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <span class="text-2xl">${conflict.severity_icon}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <h4 class="text-sm font-semibold ${textClass}">
                                    ${conflict.ingredient_1} + ${conflict.ingredient_2}
                                </h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${bgClass} ${textClass}">
                                    ${conflict.severity_label}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-700 mt-2">${conflict.description}</p>
                            
                            <div class="mt-3">
                                <h5 class="text-sm font-medium text-gray-900 mb-1">Recommendation:</h5>
                                <p class="text-sm text-gray-600">${conflict.recommendation}</p>
                            </div>
                            
                            ${conflict.alternatives && conflict.alternatives.length > 0 ? `
                                <div class="mt-3">
                                    <h5 class="text-sm font-medium text-gray-900 mb-1">Alternative Ingredients:</h5>
                                    <div class="flex flex-wrap gap-1">
                                        ${conflict.alternatives.map(alt => `
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                ${alt}
                                            </span>
                                        `).join('')}
                                    </div>
                                </div>
                            ` : ''}
                            
                            <div class="mt-3 flex items-center space-x-3">
                                <button onclick="conflictDetector.acknowledgeConflict(${index})" 
                                        class="text-xs text-gray-500 hover:text-gray-700 font-medium">
                                    Acknowledge
                                </button>
                                <button onclick="conflictDetector.getSafeAlternatives('${conflict.ingredient_1}', '${conflict.ingredient_2}')" 
                                        class="text-xs text-jade-green hover:text-jade-green-dark font-medium">
                                    Find Safe Alternatives
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button onclick="conflictDetector.dismissConflict(${index})" 
                            class="flex-shrink-0 ml-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    }

    // Update conflict summary
    updateConflictSummary(data) {
        const summary = document.getElementById('conflict-summary');
        if (!summary) return;

        if (data.conflicts.length === 0) {
            summary.innerHTML = `
                <div class="flex items-center space-x-2 text-green-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">Safe Routine</span>
                </div>
            `;
            return;
        }

        const breakdown = data.severity_breakdown || {};
        const hasHighSeverity = (breakdown.high || 0) > 0 || (breakdown.severe || 0) > 0;
        const summaryColor = hasHighSeverity ? 'red' : 'yellow';
        const summaryText = hasHighSeverity ? 'High Risk Conflicts' : 'Conflicts Detected';

        summary.innerHTML = `
            <div class="flex items-center space-x-2 text-${summaryColor}-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">${data.conflicts.length} ${summaryText}</span>
            </div>
        `;
    }

    // Attach event listeners to conflict items
    attachConflictEventListeners() {
        // Add any additional event listeners here
    }

    // Acknowledge a conflict
    async acknowledgeConflict(index) {
        const conflict = this.currentConflicts[index];
        if (!conflict) return;

        try {
            // This would typically call an API to acknowledge the warning
            console.log('Acknowledging conflict:', conflict);
            
            // Remove from display
            const conflictElement = document.querySelector(`[data-conflict-index="${index}"]`);
            if (conflictElement) {
                conflictElement.style.opacity = '0.5';
                conflictElement.style.pointerEvents = 'none';
            }
        } catch (error) {
            console.error('Error acknowledging conflict:', error);
        }
    }

    // Dismiss a conflict from display
    dismissConflict(index) {
        const conflictElement = document.querySelector(`[data-conflict-index="${index}"]`);
        if (conflictElement) {
            conflictElement.remove();
        }
        
        // Check if any conflicts remain
        const remainingConflicts = document.querySelectorAll('.conflict-item');
        if (remainingConflicts.length === 0) {
            this.displayConflicts({ conflicts: [] });
        }
    }

    // Get safe alternatives for conflicting ingredients
    async getSafeAlternatives(ingredient1, ingredient2) {
        try {
            const response = await fetch(`/api/ingredient-conflicts/suggestions`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ingredient: ingredient1,
                    exclude_ingredients: [ingredient2]
                })
            });

            if (response.ok) {
                const data = await response.json();
                this.showAlternativesModal(ingredient1, ingredient2, data.safe_ingredients);
            }
        } catch (error) {
            console.error('Error getting alternatives:', error);
        }
    }

    // Show alternatives modal
    showAlternativesModal(ingredient1, ingredient2, alternatives) {
        const modal = document.getElementById('alternatives-modal');
        if (!modal) return;

        modal.innerHTML = `
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" onclick="conflictDetector.closeAlternativesModal()">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white" onclick="event.stopPropagation()">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Safe Alternatives for ${ingredient1}
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            These ingredients don't conflict with ${ingredient2}:
                        </p>
                        <div class="space-y-2 max-h-60 overflow-y-auto">
                            ${alternatives.map(alt => `
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                    <span class="text-sm font-medium text-gray-900">${alt}</span>
                                    <button onclick="conflictDetector.selectAlternative('${alt}')" 
                                            class="text-xs text-jade-green hover:text-jade-green-dark font-medium">
                                        Select
                                    </button>
                                </div>
                            `).join('')}
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button onclick="conflictDetector.closeAlternativesModal()" 
                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Close alternatives modal
    closeAlternativesModal() {
        const modal = document.getElementById('alternatives-modal');
        if (modal) {
            modal.innerHTML = '';
        }
    }

    // Select an alternative ingredient
    selectAlternative(alternative) {
        console.log('Selected alternative:', alternative);
        this.closeAlternativesModal();
        // This would typically update the form/routine with the selected alternative
    }

    // Show error message
    showError(message) {
        const container = document.getElementById('conflict-warnings');
        if (container) {
            container.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Error</h3>
                            <p class="text-sm text-red-700 mt-1">${message}</p>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    // Check conflicts for routine builder (real-time)
    checkRoutineBuilderConflicts() {
        const steps = this.getRoutineSteps();
        const productIds = steps
            .filter(step => step.productId)
            .map(step => step.productId);
        
        const ingredients = steps
            .filter(step => step.customIngredients && step.customIngredients.length > 0)
            .flatMap(step => step.customIngredients);

        this.debouncedCheck(null, ingredients, productIds);
    }

    // Get current routine steps from the form
    getRoutineSteps() {
        const steps = [];
        const stepElements = document.querySelectorAll('[data-step-order]');
        
        stepElements.forEach(element => {
            const productId = element.querySelector('[data-product-id]')?.dataset.productId;
            const customIngredients = element.querySelector('[data-custom-ingredients]')?.dataset.customIngredients?.split(',') || [];
            
            steps.push({
                productId: productId ? parseInt(productId) : null,
                customIngredients: customIngredients.filter(i => i.trim())
            });
        });
        
        return steps;
    }
}

// Initialize the conflict detector
let conflictDetector;
document.addEventListener('DOMContentLoaded', function() {
    conflictDetector = new ConflictDetector();
    
    // Auto-check conflicts when routine changes
    const routineBuilder = document.getElementById('routine-builder');
    if (routineBuilder) {
        // Listen for changes in product selections or custom ingredients
        routineBuilder.addEventListener('change', () => {
            conflictDetector.checkRoutineBuilderConflicts();
        });
        
        // Listen for dynamic content changes
        const observer = new MutationObserver(() => {
            conflictDetector.checkRoutineBuilderConflicts();
        });
        
        observer.observe(routineBuilder, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['data-product-id', 'data-custom-ingredients']
        });
    }
});

// Global function for external access
window.checkIngredientConflicts = function(routineId, ingredients, productIds) {
    if (conflictDetector) {
        conflictDetector.checkConflicts(routineId, ingredients, productIds);
    }
};
