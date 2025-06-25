document.addEventListener('DOMContentLoaded', function () {

    // Fungsi untuk menandai menu sidebar yang aktif
    const setActiveSidebarLink = () => {
        const currentPage = window.location.pathname.split("/").pop() || "index.html";
        const navLinks = document.querySelectorAll('.sidebar-nav .nav-item a');
        navLinks.forEach(link => {
            const linkPage = link.getAttribute('href');
            link.parentElement.classList.remove('active');
            if (linkPage === currentPage) {
                link.parentElement.classList.add('active');
            }
        });
    };
    setActiveSidebarLink();

    // ===================================================
    // LOGIKA MODAL UNTUK HALAMAN MANAJEMEN BUKU
    // ===================================================
    // === Modal Tambah Buku ===
    const openCreateModalBtn = document.getElementById('openBookModal');
    const createModalOverlay = document.querySelector('#bookCreateModal .modal-overlay');
    const closeCreateModalBtn = document.getElementById('closeBookCreateModal');
    const bookCreateForm = document.getElementById('bookCreateForm');

    // Buka modal tambah
    openCreateModalBtn?.addEventListener('click', () => {
        bookCreateForm?.reset();
        createModalOverlay.style.display = 'flex';
    });

    // Tutup modal tambah
    closeCreateModalBtn?.addEventListener('click', () => {
        createModalOverlay.style.display = 'none';
    });

    // Klik luar modal tambah = tutup
    createModalOverlay?.addEventListener('click', (e) => {
        if (e.target === createModalOverlay) {
            createModalOverlay.style.display = 'none';
        }
    });

    // ===================================================
    // LOGIKA MODAL UNTUK HALAMAN MANAJEMEN ANGGOTA
    // ===================================================
    const memberTable = document.getElementById('memberTable');
    if (memberTable) {
        // Selektor Modal
        const modalOverlay = document.querySelector('#memberMasterModal .modal-overlay');
        const modal = modalOverlay.querySelector('.modal'); // Target elemen modal utama
        const openModalBtn = document.getElementById('openMemberModal');
        const closeModalBtn = document.getElementById('closeMemberModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalActionBtn = document.getElementById('modalActionBtn');

        // Selektor Form & View
        const memberForm = document.getElementById('memberForm');
        const memberInfoView = document.getElementById('memberInfoView');
        const viewFoto = document.getElementById('viewFoto');
        const modalFotoInput = document.getElementById('modalFoto');

        const defaultAvatar = '/assets/img/default-avatar.png';
        let currentRowBeingEdited = null;

        // Fungsi utilitas modal
        const openModal = () => modalOverlay.style.display = 'flex';
        const closeModal = () => {
            modalOverlay.style.display = 'none';
            currentRowBeingEdited = null;
            modalFotoInput.value = '';
            // Reset class saat modal ditutup
            modal.classList.remove('view-mode');
        };

        // Pratinjau gambar (tetap sama)
        modalFotoInput.addEventListener('change', () => {
            const file = modalFotoInput.files[0];
            if (file) { viewFoto.src = URL.createObjectURL(file); }
        });

        // Buka modal untuk 'Tambah Anggota'
        openModalBtn.addEventListener('click', () => {
            currentRowBeingEdited = null;
            memberForm.reset();

            // Atur modal untuk mode Tambah/Ubah
            modal.classList.add('modal-lg');
            modal.classList.remove('view-mode');
            modalActionBtn.style.display = 'block';

            modalTitle.textContent = 'Tambah Data Anggota';
            modalActionBtn.textContent = 'Tambahkan';
            viewFoto.src = defaultAvatar;

            openModal();
        });

        // Event listener pada tabel anggota
        memberTable.addEventListener('click', (e) => {
            const actionLink = e.target.closest('a');
            if (!actionLink) return;

            e.preventDefault();
            const row = actionLink.closest('tr');

            if (actionLink.classList.contains('edit')) {
                currentRowBeingEdited = row;
                memberForm.reset();

                // Atur modal untuk mode Tambah/Ubah
                modal.classList.add('modal-lg');
                modal.classList.remove('view-mode');
                modalActionBtn.style.display = 'block';

                modalTitle.textContent = 'Ubah Data Anggota';
                modalActionBtn.textContent = 'Simpan Perubahan';

                // Isi form dari data-* attributes
                document.getElementById('modalNama').value = row.dataset.nama;
                document.getElementById('modalNpm').value = row.dataset.npm;
                document.getElementById('modalEmail').value = row.dataset.email;
                document.getElementById('modalTelepon').value = row.dataset.telepon;
                document.getElementById('modalAlamat').value = row.dataset.alamat;
                viewFoto.src = row.dataset.foto || defaultAvatar;

                openModal();

            } else if (actionLink.classList.contains('view')) {
                // Atur modal untuk mode Lihat
                modal.classList.remove('modal-lg');
                modal.classList.add('view-mode');
                modalActionBtn.style.display = 'none';

                modalTitle.textContent = 'Detail Data Anggota';

                // Isi detail view dari data-* attributes
                document.getElementById('viewNama').textContent = row.dataset.nama;
                document.getElementById('viewNpm').textContent = row.dataset.npm;
                document.getElementById('viewEmail').textContent = row.dataset.email;
                document.getElementById('viewTelepon').textContent = row.dataset.telepon || '-';
                // Alamat tidak ada di desain, jadi kita abaikan atau Anda bisa menambahkannya di HTML jika perlu
                viewFoto.src = row.dataset.foto || defaultAvatar;

                openModal();

            } else if (actionLink.classList.contains('delete')) {
                if (confirm(`Apakah Anda yakin ingin menghapus anggota "${row.dataset.nama}"?`)) {
                    row.remove();
                    alert('Anggota berhasil dihapus.');
                }
            }
        });

        // Logika submit form (tetap sama)
        memberForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // ... Logika simpan data Anda ...
            alert('Aksi berhasil dijalankan!');
            closeModal();
        });

        // Event listener untuk menutup modal (tetap sama)
        closeModalBtn.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-overlay')) {
                closeModal();
            }
        });
    }
});