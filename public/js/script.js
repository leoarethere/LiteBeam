// Fungsi untuk menjalankan carousel
function initCarousel() {
    // Hancurkan dulu jika sudah ada (mencegah duplikasi saat navigasi balik)
    $(".owl-carousel").trigger('destroy.owl.carousel'); 

    $(".owl-carousel").owlCarousel({
        // ... masukkan opsi-opsi Anda di sini ...
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
            0: { items: 1 },
            600: { items: 3 },
            1000: { items: 5 }
        }
    });
}

// Jalankan saat halaman pertama kali dimuat
$(document).ready(function() {
    initCarousel();
});

// Jalankan SETIAP KALI Turbo selesai memuat halaman baru
document.addEventListener("turbo:load", function() {
    initCarousel();
});