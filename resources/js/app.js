// Import SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// Import Lucide Icons
import lucide from 'lucide';
// Inisialisasi icon setiap halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});

// Import Alpine.js (Untuk interaksi dropdown/modal)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();