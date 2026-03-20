<!-- Ingredient Conflict Warning Component -->
<div id="conflict-warnings" class="mb-6">
    <!-- Conflict warnings will be displayed here -->
</div>

<!-- Conflict Summary (for header/overview) -->
<div id="conflict-summary" class="mb-4">
    <!-- Conflict summary will be displayed here -->
</div>

<!-- Alternatives Modal Container -->
<div id="alternatives-modal">
    <!-- Alternatives modal will be displayed here -->
</div>

<!-- Real-time Conflict Checker for Routine Builder -->
<script>
// Auto-check conflicts when products are added/removed
document.addEventListener('DOMContentLoaded', function() {
    // Listen for product selection changes
    document.addEventListener('change', function(e) {
        if (e.target.matches('[data-product-select]') || e.target.matches('[data-ingredient-input]')) {
            if (window.conflictDetector) {
                setTimeout(() => {
                    window.conflictDetector.checkRoutineBuilderConflicts();
                }, 100);
            }
        }
    });
    
    // Listen for dynamic content additions
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                const hasRelevantChanges = Array.from(mutation.addedNodes).some(node => {
                    return node.nodeType === 1 && (
                        node.matches('[data-product-select]') ||
                        node.matches('[data-ingredient-input]') ||
                        node.querySelector('[data-product-select], [data-ingredient-input]')
                    );
                });
                
                if (hasRelevantChanges && window.conflictDetector) {
                    setTimeout(() => {
                        window.conflictDetector.checkRoutineBuilderConflicts();
                    }, 100);
                }
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
</script>
