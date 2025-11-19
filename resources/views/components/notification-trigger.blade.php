{{-- File: resources/views/components/notification-trigger.blade.php --}}
@if(session()->hasAny(['post_success', 'post_error', 'broadcast_success', 'broadcast_error', 'category_success', 'category_error']))
    <div id="notification-trigger"
         data-message="{{ session('post_success') ?? session('post_error') ?? session('broadcast_success') ?? session('broadcast_error') ?? session('category_success') ?? session('category_error') }}"
         data-type="{{ session()->has('post_success') || session()->has('broadcast_success') || session()->has('category_success') ? 'success' : 'error' }}"
         style="display: none;">
    </div>
@endif