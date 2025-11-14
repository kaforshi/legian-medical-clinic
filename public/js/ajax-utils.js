/**
 * AJAX Utilities untuk Legian Medical Clinic
 * Fungsi-fungsi helper untuk AJAX operations
 */

// Setup CSRF token untuk semua AJAX requests
if (typeof axios !== 'undefined') {
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    }
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}

/**
 * Show toast notification
 */
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
    const toastId = 'toast-' + Date.now();
    const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white ${bgColor} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 3000 });
    toast.show();
    
    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
}

/**
 * Create toast container if it doesn't exist
 */
function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'toast-container position-fixed top-0 end-0 p-3';
    container.style.zIndex = '9999';
    document.body.appendChild(container);
    return container;
}

/**
 * Show loading spinner
 */
function showLoading(element) {
    if (typeof element === 'string') {
        element = document.querySelector(element);
    }
    if (element) {
        element.disabled = true;
        const originalHTML = element.innerHTML;
        element.dataset.originalHTML = originalHTML;
        element.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
    }
}

/**
 * Hide loading spinner
 */
function hideLoading(element) {
    if (typeof element === 'string') {
        element = document.querySelector(element);
    }
    if (element && element.dataset.originalHTML) {
        element.disabled = false;
        element.innerHTML = element.dataset.originalHTML;
        delete element.dataset.originalHTML;
    }
}

/**
 * Handle AJAX form submission
 */
function submitFormAjax(form, options = {}) {
    const formElement = typeof form === 'string' ? document.querySelector(form) : form;
    if (!formElement) return;
    
    // Prevent multiple event listeners
    if (formElement.dataset.ajaxInitialized === 'true') {
        return;
    }
    formElement.dataset.ajaxInitialized = 'true';
    
    const submitButton = formElement.querySelector('button[type="submit"]') || 
                        formElement.querySelector('input[type="submit"]');
    
    formElement.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (submitButton) {
            showLoading(submitButton);
        }
        
        const formData = new FormData(formElement);
        const url = formElement.action || options.url;
        const method = formElement.method || options.method || 'POST';
        
        // Add _method for PUT/PATCH/DELETE if needed
        if (method.toUpperCase() !== 'POST' && method.toUpperCase() !== 'GET') {
            formData.append('_method', method.toUpperCase());
        }
        
        try {
            const response = await axios({
                method: 'POST', // Always use POST for form data
                url: url,
                data: formData,
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.data.success) {
                showToast(response.data.message || 'Operasi berhasil!', 'success');
                
                if (options.onSuccess) {
                    options.onSuccess(response.data);
                } else {
                    // Default: redirect after 1 second
                    setTimeout(() => {
                        if (response.data.redirect) {
                            window.location.href = response.data.redirect;
                        } else {
                            window.location.reload();
                        }
                    }, 1000);
                }
            } else {
                showToast(response.data.message || 'Terjadi kesalahan!', 'error');
                if (options.onError) {
                    options.onError(response.data);
                }
            }
        } catch (error) {
            console.error('AJAX Error:', error);
            
            let errorMessage = 'Terjadi kesalahan saat memproses permintaan.';
            
            if (error.response) {
                // Server responded with error
                if (error.response.data && error.response.data.message) {
                    errorMessage = error.response.data.message;
                } else if (error.response.data && error.response.data.errors) {
                    // Validation errors
                    const errors = error.response.data.errors;
                    const firstError = Object.values(errors)[0][0];
                    errorMessage = firstError;
                    
                    // Show validation errors in form
                    showValidationErrors(errors);
                }
            }
            
            showToast(errorMessage, 'error');
            
            if (options.onError) {
                options.onError(error.response?.data || { message: errorMessage });
            }
        } finally {
            if (submitButton) {
                hideLoading(submitButton);
            }
        }
    });
}

/**
 * Show validation errors in form
 */
function showValidationErrors(errors) {
    // Remove old error messages
    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    // Add new error messages
    Object.keys(errors).forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = errors[field][0];
            input.parentNode.appendChild(errorDiv);
        }
    });
}

/**
 * Delete item with AJAX
 */
function deleteItemAjax(url, options = {}) {
    const confirmMessage = options.confirmMessage || 'Apakah Anda yakin ingin menghapus item ini?';
    
    if (!confirm(confirmMessage)) {
        return;
    }
    
    const deleteButton = options.button;
    if (deleteButton) {
        showLoading(deleteButton);
    }
    
    axios.delete(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.data.success) {
            showToast(response.data.message || 'Item berhasil dihapus!', 'success');
            
            if (options.onSuccess) {
                options.onSuccess(response.data);
            } else {
                // Default: reload page after 1 second
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } else {
            showToast(response.data.message || 'Gagal menghapus item!', 'error');
        }
    })
    .catch(error => {
        console.error('Delete Error:', error);
        let errorMessage = 'Terjadi kesalahan saat menghapus item.';
        
        if (error.response && error.response.data && error.response.data.message) {
            errorMessage = error.response.data.message;
        }
        
        showToast(errorMessage, 'error');
    })
    .finally(() => {
        if (deleteButton) {
            hideLoading(deleteButton);
        }
    });
}

/**
 * Toggle status with AJAX
 */
function toggleStatusAjax(url, options = {}) {
    const toggleButton = options.button;
    if (toggleButton) {
        showLoading(toggleButton);
    }
    
    axios.patch(url, {}, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.data.success) {
            showToast(response.data.message || 'Status berhasil diubah!', 'success');
            
            if (options.onSuccess) {
                options.onSuccess(response.data);
            } else {
                // Default: reload page after 1 second
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } else {
            showToast(response.data.message || 'Gagal mengubah status!', 'error');
        }
    })
    .catch(error => {
        console.error('Toggle Status Error:', error);
        let errorMessage = 'Terjadi kesalahan saat mengubah status.';
        
        if (error.response && error.response.data && error.response.data.message) {
            errorMessage = error.response.data.message;
        }
        
        showToast(errorMessage, 'error');
    })
    .finally(() => {
        if (toggleButton) {
            hideLoading(toggleButton);
        }
    });
}

// Export functions for use in other scripts
window.AjaxUtils = {
    showToast,
    showLoading,
    hideLoading,
    submitFormAjax,
    showValidationErrors,
    deleteItemAjax,
    toggleStatusAjax
};

