{{-- 1. LOGIKA TOAST (Notifikasi Kecil) --}}
@if(session()->hasAny(['post_success', 'post_error', 'broadcast_success', 'broadcast_error', 'category_success', 'category_error']))
    <div id="notification-trigger"
         data-message="{{ session('post_success') ?? session('post_error') ?? session('broadcast_success') ?? session('broadcast_error') ?? session('category_success') ?? session('category_error') }}"
         data-type="{{ session()->has('post_success') || session()->has('broadcast_success') || session()->has('category_success') ? 'success' : 'error' }}"
         style="display: none;">
    </div>
@endif

{{-- [BARU] 2. LOGIKA MODAL POPUP (Notifikasi Besar) --}}
@if(session()->hasAny(['modal_success', 'modal_error']))
    <div id="modal-trigger"
         data-title="{{ session()->has('modal_success') ? 'Berhasil!' : 'Terjadi Kesalahan' }}"
         data-message="{{ session('modal_success') ?? session('modal_error') }}"
         data-type="{{ session()->has('modal_success') ? 'success' : 'error' }}"
         style="display: none;">
    </div>
@endif