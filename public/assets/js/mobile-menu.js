// Dedicated mobile menu script - EXPERT SOLUTION
console.log('Mobile menu script loaded - EXPERT MODE');

// Simple fallback function
function mobileToggleFallback() {
    console.log('Fallback toggle called');
    const sidebar = document.getElementById('sidebar');
    const checkbox = document.getElementById('mobile-menu-toggle');
    
    if (sidebar && checkbox) {
        // Toggle the checkbox to trigger CSS
        checkbox.checked = !checkbox.checked;
        console.log('Checkbox state:', checkbox.checked);
        
        // Also add class for extra fallback
        if (checkbox.checked) {
            sidebar.classList.add('mobile-open');
        } else {
            sidebar.classList.remove('mobile-open');
        }
    }
}

// Make function globally available
window.mobileToggleFallback = mobileToggleFallback;

// Wait for DOM and setup everything
document.addEventListener('DOMContentLoaded', function() {
    console.log('Mobile menu DOM ready - EXPERT MODE');
    
    // Find the toggle button (label)
    const toggleLabel = document.querySelector('label[for="mobile-menu-toggle"]');
    const checkbox = document.getElementById('mobile-menu-toggle');
    const sidebar = document.getElementById('sidebar');
    
    console.log('Elements found:', {
        toggleLabel: !!toggleLabel,
        checkbox: !!checkbox,
        sidebar: !!sidebar
    });
    
    if (toggleLabel && checkbox && sidebar) {
        console.log('All elements found, adding event listeners');
        
        // Add multiple event handlers for maximum compatibility
        toggleLabel.addEventListener('click', function(e) {
            console.log('Label clicked');
            // Let default checkbox behavior work, but add logging
            setTimeout(() => {
                console.log('Checkbox state after click:', checkbox.checked);
            }, 10);
        });
        
        toggleLabel.addEventListener('touchstart', function(e) {
            console.log('Label touched');
            // Add visual feedback
            this.style.opacity = '0.8';
        });
        
        toggleLabel.addEventListener('touchend', function(e) {
            this.style.opacity = '1';
        });
        
        // Listen to checkbox changes
        checkbox.addEventListener('change', function() {
            console.log('Checkbox changed to:', this.checked);
            
            // Add fallback class-based toggle
            if (this.checked) {
                sidebar.classList.add('mobile-open');
                console.log('Added mobile-open class');
            } else {
                sidebar.classList.remove('mobile-open');
                console.log('Removed mobile-open class');
            }
        });
        
        // Add click handler directly to the label as well
        toggleLabel.onclick = function(e) {
            console.log('Label onclick triggered');
            // Allow default behavior but add logging
        };
        
    } else {
        console.error('Some elements not found!');
        
        // Debug: List all elements to see what's available
        console.log('All labels:', document.querySelectorAll('label'));
        console.log('All checkboxes:', document.querySelectorAll('input[type="checkbox"]'));
        console.log('Sidebar element:', document.getElementById('sidebar'));
    }
});
