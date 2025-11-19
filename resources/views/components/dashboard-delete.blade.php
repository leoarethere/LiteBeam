{{-- DELETE CONFIRMATION MODAL --}}
<div x-show="deleteModal"
     x-cloak
     @click.self="deleteModal = false"
     class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-75 backdrop-blur-sm flex items-center justify-center p-4"
     style="display: none;">
    
    <div x-show="deleteModal"
         @click.away="deleteModal = false"
         class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 max-w-md w-full">
        
        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700 rounded-t">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Konfirmasi Hapus
            </h3>
            <button @click="deleteModal = false" 
                    type="button" 
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="p-6">
            <div class="flex items-start gap-4 mb-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white mb-1">
                        Apakah Anda yakin ingin menghapus postingan ini?
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium line-clamp-2" x-text="deletePostTitle"></p>
                </div>
            </div>
            <div class="p-3 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-900/50 rounded-lg">
                <p class="text-sm text-yellow-800 dark:text-yellow-500">
                    <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 dark:border-gray-700 rounded-b">
            <button @click="deleteModal = false" 
                    type="button" 
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-700">
                Batal
            </button>
            <form :action="`/dashboard/posts/${deletePostId}`" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- PASTIKAN ALPINE DATA DI PARENT ELEMENT --}}
{{-- ============================================ --}}
{{-- 
Contoh penggunaan di parent div:

<div x-data="{ 
    deleteModal: false, 
    deletePostId: null, 
    deletePostTitle: ''
}">
    
    <!-- Tombol Delete -->
    <button @click="deleteModal = true; deletePostId = {{ $post->id }}; deletePostTitle = '{{ addslashes($post->title) }}'">
        Hapus
    </button>
    
    <!-- Modal di atas -->
    
</div>
--}}

{{-- ============================================ --}}
{{-- CONTROLLER METHOD (PostController.php) --}}
{{-- ============================================ --}}
{{--
public function destroy(Post $post)
{
    // Authorization check
    if (auth()->user()->cannot('delete', $post)) {
        abort(403);
    }
    
    // Delete featured image jika ada
    if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
        Storage::disk('public')->delete($post->featured_image);
    }
    
    // Delete post
    $post->delete();
    
    // Redirect dengan pesan sukses
    return redirect()->route('dashboard.posts.index')
                     ->with('success', 'Postingan berhasil dihapus!');
}
--}}

{{-- ============================================ --}}
{{-- ROUTE (web.php) --}}
{{-- ============================================ --}}
{{--
Route::middleware(['auth'])->group(function () {
    Route::delete('/dashboard/posts/{post}', [PostController::class, 'destroy'])
         ->name('dashboard.posts.destroy');
});
--}}

{{-- ============================================ --}}
{{-- TROUBLESHOOTING --}}
{{-- ============================================ --}}
{{--
1. Jika modal tidak muncul:
   - Pastikan Alpine.js sudah loaded
   - Cek console browser untuk error
   - Pastikan x-data sudah di parent element

2. Jika form tidak submit:
   - Cek apakah @csrf token ada
   - Cek apakah @method('DELETE') ada
   - Cek route di web.php
   - Cek controller method ada

3. Jika 403 Forbidden:
   - Cek policy authorization
   - Pastikan user punya permission

4. Jika 404 Not Found:
   - Cek route name/path
   - Pastikan {post} parameter benar
   - Cek Route::delete ada di web.php

5. Jika 419 Session Expired:
   - Clear browser cache
   - Refresh page
   - Cek csrf token generate dengan benar

6. Untuk debugging, tambahkan:
   console.log('Delete ID:', deletePostId);
   console.log('Action:', `/dashboard/posts/${deletePostId}`);
--}}

{{-- ============================================ --}}
{{-- ALTERNATIF: Menggunakan JavaScript Confirm --}}
{{-- ============================================ --}}
{{--
Jika ingin lebih simple tanpa modal:

<form action="/dashboard/posts/{{ $post->id }}" method="POST" 
      onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:text-red-800">
        Hapus
    </button>
</form>
--}}

{{-- ============================================ --}}
{{-- BEST PRACTICE: Soft Delete --}}
{{-- ============================================ --}}
{{--
Gunakan soft delete untuk keamanan:

// Migration
$table->softDeletes();

// Model
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
}

// Controller
$post->delete(); // Soft delete, data masih ada di DB

// Restore jika perlu
$post->restore();

// Force delete (hapus permanent)
$post->forceDelete();
--}}