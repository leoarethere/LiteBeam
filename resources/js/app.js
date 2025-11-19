// ============================================
// FILE: resources/js/app.js (FIXED VERSION)
// ============================================

import * as Turbo from '@hotwired/turbo';
import Alpine from 'alpinejs';
import './bootstrap';
import 'flowbite';
import Cropper from 'cropperjs';

// Global variables
window.Alpine = Alpine;
window.Cropper = Cropper;

// Track initialization state
window.appInitialized = false;
window.alpineStarted = false;

// Theme setup (harus dijalankan SEBELUM Alpine)
// if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
//   document.documentElement.classList.add('dark');
// } else {
//   document.documentElement.classList.remove('dark');
// }

// ============================================
// TURBO EVENT HANDLERS - SINGLE SOURCE
// ============================================

// Initialize everything on first load
document.addEventListener('DOMContentLoaded', function() {
    if (window.appInitialized) return;
    
    console.log('🚀 Initializing app...');
    initializeAlpine();
    initializeFlowbite();
    window.appInitialized = true;
});

// Handle Turbo navigations
document.addEventListener('turbo:load', function() {
    console.log('🔄 Turbo page loaded');
    
    // Re-initialize Flowbite for new DOM elements
    initializeFlowbite();
    
    // Re-initialize Cropper if needed
    initializeCropper();
});

// Cleanup before Turbo caches pages
document.addEventListener('turbo:before-cache', function() {
    console.log('🗑️ Turbo caching page - cleaning up');
    cleanupBeforeCache();
});

// Handle form submissions
document.addEventListener('turbo:submit-start', function(event) {
    console.log('📤 Form submission started');
    showLoadingState(event.target);
});

document.addEventListener('turbo:submit-end', function(event) {
    console.log('✅ Form submission ended');
    hideLoadingState(event.target);
});

// Handle Turbo errors
document.addEventListener('turbo:fetch-request-error', function(event) {
    console.error('❌ Turbo fetch error:', event.detail);
    showErrorMessage('Network error occurred');
});

// ============================================
// INITIALIZATION FUNCTIONS
// ============================================

function initializeAlpine() {
    if (window.alpineStarted) {
        console.log('⚠️ Alpine.js already started, skipping...');
        return;
    }
    
    try {
        Alpine.start();
        window.alpineStarted = true;
        console.log('✅ Alpine.js initialized successfully');
    } catch (error) {
        console.error('❌ Alpine.js initialization failed:', error);
    }
}

function initializeFlowbite() {
    if (typeof initFlowbite === 'function') {
        try {
            initFlowbite();
            console.log('✅ Flowbite re-initialized');
        } catch (error) {
            console.error('❌ Flowbite initialization failed:', error);
        }
    } else {
        console.log('⚠️ Flowbite not available');
    }
}

function initializeCropper() {
    // Initialize Cropper.js instances if any exist
    const cropperElements = document.querySelectorAll('[data-cropper]');
    if (cropperElements.length > 0) {
        console.log('✅ Cropper.js elements found:', cropperElements.length);
    }
}

function cleanupBeforeCache() {
    // Close any open modals, dropdowns, etc.
    const openModals = document.querySelectorAll('[data-modal-toggle]');
    openModals.forEach(modal => {
        // Trigger close event if available
        const event = new Event('hide.flowbite.modal');
        modal.dispatchEvent(event);
    });
}

function showLoadingState(form) {
    const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        
        // Add loading text or spinner
        const originalText = submitButton.innerHTML;
        submitButton.setAttribute('data-original-text', originalText);
        submitButton.innerHTML = 'Loading...';
    }
}

function hideLoadingState(form) {
    const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
    if (submitButton && submitButton.hasAttribute('data-original-text')) {
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        submitButton.innerHTML = submitButton.getAttribute('data-original-text');
    }
}

function showErrorMessage(message) {
    // Simple error notification
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50';
    errorDiv.textContent = message;
    document.body.appendChild(errorDiv);
    
    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
}

// ============================================
// TURBO CONFIGURATION
// ============================================

// Configure Turbo
Turbo.setProgressBarDelay(500); // Show progress bar after 500ms

// Optional: Disable Turbo for specific links
document.addEventListener('turbo:click', function(event) {
    const target = event.target;
    if (target.matches('[data-turbo="false"]')) {
        event.preventDefault();
        window.location.href = target.href;
    }
});

// ============================================
// EXPORT FOR VITE (if needed)
// ============================================

export { Turbo, Alpine, Cropper };