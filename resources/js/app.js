// FILE: resources/js/app.js

import * as Turbo from '@hotwired/turbo';
Turbo.start(); // Memastikan Turbo aktif
import Alpine from 'alpinejs';
import './bootstrap';
import 'flowbite';

// ✅ JQUERY & OWL CAROUSEL - DIPERBAIKI
import jQuery from 'jquery';
import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel/dist/assets/owl.theme.default.css';

// Pasang jQuery ke Window
window.$ = window.jQuery = jQuery;

// Import Owl Carousel dengan dynamic import
import('owl.carousel').then(() => {
    console.log('🦉 Owl Carousel Loaded');
    document.dispatchEvent(new Event('owl-loaded'));
}).catch((err) => console.error('Owl loading failed', err));

// ✅ ALPINE.JS SETUP
window.Alpine = Alpine;
window.appInitialized = false;
window.alpineStarted = false;

// ============================================
// ✅ TURBO CONFIGURATION - DIPERBAIKI
// ============================================
Turbo.config.drive.progressBarDelay = 500; // ✅ API baru (bukan setProgressBarDelay)
Turbo.config.forms.confirm = true; // Konfirmasi untuk form
Turbo.session.drive = true; // Enable Turbo Drive

// ============================================
// INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    if (window.appInitialized) return;
    
    console.log('🚀 App initializing...');
    initializeAlpine();
    initializeFlowbite();
    window.appInitialized = true;
});

// ============================================
// TURBO EVENT HANDLERS
// ============================================

// ✅ Turbo Load - Re-initialize components
document.addEventListener('turbo:load', function() {
    console.log('🔄 Turbo:load');
    initializeFlowbite();
});

// ✅ Turbo Before Cache - Cleanup
document.addEventListener('turbo:before-cache', function() {
    console.log('💾 Turbo:before-cache - Cleaning up');
    cleanupBeforeCache();
});

// ✅ Turbo Form Submit
document.addEventListener('turbo:submit-start', function(event) {
    console.log('📤 Form submission started');
    showLoadingState(event.target);
});

document.addEventListener('turbo:submit-end', function(event) {
    console.log('✅ Form submission ended');
    hideLoadingState(event.target);
});

// ✅ Turbo Error Handling
document.addEventListener('turbo:fetch-request-error', function(event) {
    console.error('❌ Turbo fetch error:', event.detail);
    showErrorMessage('Network error occurred. Please try again.');
});

// ============================================
// HELPER FUNCTIONS
// ============================================

function initializeAlpine() {
    if (window.alpineStarted) {
        console.log('⚠️ Alpine.js already started');
        return;
    }
    
    try {
        Alpine.start();
        window.alpineStarted = true;
        console.log('✅ Alpine.js initialized');
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
    }
}

function cleanupBeforeCache() {
    // Close modals
    const openModals = document.querySelectorAll('[data-modal-show="true"]');
    openModals.forEach(modal => {
        const closeBtn = modal.querySelector('[data-modal-hide]');
        if (closeBtn) closeBtn.click();
    });
    
    // Close dropdowns
    const openDropdowns = document.querySelectorAll('[data-dropdown-show="true"]');
    openDropdowns.forEach(dropdown => {
        dropdown.classList.add('hidden');
    });
}

function showLoadingState(form) {
    const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        
        const originalText = submitButton.innerHTML;
        submitButton.setAttribute('data-original-text', originalText);
        submitButton.innerHTML = '<svg class="animate-spin h-5 w-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
    }
}

function hideLoadingState(form) {
    const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
    if (submitButton && submitButton.hasAttribute('data-original-text')) {
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        submitButton.innerHTML = submitButton.getAttribute('data-original-text');
        submitButton.removeAttribute('data-original-text');
    }
}

function showErrorMessage(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-[9999] max-w-md';
    errorDiv.innerHTML = `
        <div class="flex items-start">
            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <p class="font-medium">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    `;
    document.body.appendChild(errorDiv);
    
    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
}

// ============================================
// DISABLE TURBO UNTUK LINK TERTENTU
// ============================================
document.addEventListener('turbo:click', function(event) {
    const target = event.target.closest('a');
    if (target && target.hasAttribute('data-turbo-false')) {
        event.preventDefault();
        window.location.href = target.href;
    }
});

// ============================================
// EXPORT
// ============================================
export { Turbo, Alpine };