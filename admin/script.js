/**
 * Admin Panel JavaScript
 * Handles interactive features like confirmations and sidebar toggle
 */

// Toggle sidebar on mobile
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}

// Confirmation for blocking users/employers
function confirmBlock() {
    return confirm('Are you sure you want to block this account?\n\nBlocking will:\n- Prevent login access\n- Restrict platform usage\n- Preserve all data for potential restoration\n\nThis action can be reversed by unblocking.');
}

// Confirmation for unblocking users/employers
function confirmUnblock() {
    return confirm('Are you sure you want to unblock this account?\n\nUnblocking will:\n- Restore login access\n- Allow full platform usage\n- Reactivate all account features');
}

// Confirmation for deleting records
function confirmDelete() {
    return confirm('Are you sure you want to DELETE this record?\n\n⚠️ WARNING: This action is PERMANENT and cannot be undone!\n\nDeleting will:\n- Remove all associated data\n- Delete related applications/bookmarks\n- Cannot be reversed\n\nPlease confirm deletion.');
}

// Confirmation for toggling job status
function confirmToggle() {
    return confirm('Are you sure you want to change the status of this job?\n\nThis will affect its visibility to users.');
}

// Close alerts automatically after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});

// Add loading state to forms
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Processing...';
            }
        });
    });
});

// Highlight active navigation
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop();
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        if (item.getAttribute('href') === currentPage) {
            item.classList.add('active');
        }
    });
});

