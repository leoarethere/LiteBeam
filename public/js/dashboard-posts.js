/**
 * Logika Alpine.js untuk halaman Manajemen Postingan.
 * * File ini mendefinisikan 'postManagement' Alpine component,
 * yang menerima konfigurasi (seperti route) dari Blade.
 */
document.addEventListener('alpine:init', () => {
    /**
     * @param {object} config - Objek konfigurasi yang dilewatkan dari Blade.
     * @param {object} config.routes - Kumpulan URL route yang dibutuhkan oleh JS.
     */
    Alpine.data('postManagement', (config) => ({
        
        // Konfigurasi route dari Blade
        config: config,

        // State untuk modal hapus postingan
        deleteModal: false, 
        deletePostId: null, 
        deletePostTitle: '',
        
        // State untuk modal kategori
        isCategoryModalOpen: false,
        modalMode: 'create',
        modalTitle: 'Tambah Kategori Baru',
        modalAction: config.routes.categoryStore, // Default action
        
        categoryData: {
            id: null,
            name: '',
            slug: '',
            color: 'blue'
        },

        // State untuk modal hapus kategori
        deleteCategoryModal: false,
        deleteCategoryId: null,
        deleteCategoryName: '',
        deleteCategoryError: '',

        // State untuk loading indicator
        isSubmitting: false,

        // ===================================================
        // FUNGSI-FUNGSI
        // ===================================================

        /**
         * Membuat slug otomatis dari nama kategori.
         */
        generateSlug() {
            this.categoryData.slug = this.categoryData.name
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Hapus karakter non-alfanumerik
                .replace(/\s+/g, '-')         // Ganti spasi dengan strip
                .replace(/-+/g, '-')          // Hapus strip ganda
                .trim();
        },

        /**
         * Membuka modal kategori dalam mode 'create'.
         */
        openCreateModal() {
            this.modalMode = 'create';
            this.modalTitle = 'Tambah Kategori Baru';
            this.modalAction = this.config.routes.categoryStore;
            this.categoryData = { id: null, name: '', slug: '', color: 'blue' };
            this.isCategoryModalOpen = true;
            document.body.style.overflow = 'hidden';
        },

        /**
         * Membuka modal kategori dalam mode 'edit'.
         * @param {object} category - Objek kategori dari Blade.
         */
        openEditModal(category) {
            this.modalMode = 'edit';
            this.modalTitle = 'Edit Kategori';
            // Ganti ':id' dengan ID kategori yang sebenarnya
            this.modalAction = this.config.routes.categoryUpdate.replace(':id', category.id);
            this.categoryData = {
                id: category.id,
                name: category.name,
                slug: category.slug,
                color: category.color // Ambil warna dari data
            };
            this.isCategoryModalOpen = true;
            document.body.style.overflow = 'hidden';
        },

        /**
         * Menutup modal kategori.
         */
        closeCategoryModal() {
            if (this.isSubmitting) return; // Cegah tutup saat loading
            this.isCategoryModalOpen = false;
            document.body.style.overflow = '';
        },

        /**
         * Membuka modal konfirmasi hapus kategori.
         * @param {object} category - Objek kategori dari Blade.
         */
        openDeleteCategoryModal(category) {
            this.deleteCategoryId = category.id;
            this.deleteCategoryName = category.name;
            this.deleteCategoryError = '';
            this.deleteCategoryModal = true;
            document.body.style.overflow = 'hidden';
        },

        /**
         * Menutup modal konfirmasi hapus kategori.
         */
        closeDeleteCategoryModal() {
            if (this.isSubmitting) return; // Cegah tutup saat loading
            this.deleteCategoryModal = false;
            this.deleteCategoryError = '';
            document.body.style.overflow = '';
        },

        /**
         * Membuka modal konfirmasi hapus postingan.
         * @param {number} postId - ID postingan.
         * @param {string} postTitle - Judul postingan.
         */
        openDeleteModal(postId, postTitle) {
            this.deletePostId = postId;
            this.deletePostTitle = postTitle;
            this.deleteModal = true;
            document.body.style.overflow = 'hidden';
        },
        
        /**
         * Menutup modal konfirmasi hapus postingan.
         */
        closeDeleteModal() {
            if (this.isSubmitting) return; // Cegah tutup saat loading
            this.deleteModal = false;
            document.body.style.overflow = '';
        },

        /**
         * Menangani submit form standar (Hapus Postingan, Hapus Kategori).
         * @param {Event} event - Event submit form.
         */
        submitForm(event) {
            this.isSubmitting = true;
            // Biarkan form submit secara normal.
            // Page reload akan me-reset state 'isSubmitting'.
            event.target.submit();
        },

        /**
         * Menangani submit form kategori (Create/Edit).
         * Ini lebih kompleks karena perlu method spoofing (PUT).
         * @param {Event} event - Event submit form.
         */
        submitCategoryForm(event) {
            this.isSubmitting = true;
            
            // Handle method spoofing untuk 'edit'
            if(this.modalMode === 'edit') {
                // Cari input _method di dalam form dan set nilainya ke 'PUT'
                const methodInput = event.target.querySelector('[name=_method]');
                if (methodInput) {
                    methodInput.value = 'PUT';
                }
            }
            
            event.target.submit();
        }
    }));
});
