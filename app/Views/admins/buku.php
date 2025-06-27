<!DOCTYPE html>
<html lang="id">

<?= $this->include('admins/sections/head'); ?>

<body>
    <div class="container">
        <?= $this->include('admins/sections/sidebar'); ?>

        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <h1>Manajemen Buku</h1>
                </div>
                <div class="header-right">
                    <span>Hai, <?= esc(session('nama_admin') ?? 'Administrator') ?> 👋</span>
                </div>
            </header>

            <div class="content-wrapper">
                <div class="data-container">
                    <div class="data-header">
                        <h2>Daftar Buku</h2>
                        <form action="/buku-buku" method="get">
                            <div class="search-bar">
                                <i class="fas fa-search"></i>
                                <input type="text" name="keyword" placeholder="Cari Data" value="<?= esc($_GET['keyword'] ?? '') ?>">
                            </div>
                        </form>

                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-tambah" id="openBookModal">Tambah Buku</button>
                    </div>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div style="background: #d4edda; padding: 10px; color: #155724; margin-bottom: 10px; border-left: 5px solid green;">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div style="background: #f8d7da; padding: 10px; color: #721c24; margin-bottom: 10px; border-left: 5px solid red;">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>


                    <!-- Modal Tambah Buku -->
                    <section id="bookCreateModal">
                        <div class="modal-overlay" style="display: none;">
                            <div class="modal">
                                <div class="modal-header">
                                    <h2>Tambah Buku</h2>
                                    <button type="button" class="modal-close" id="closeBookCreateModal" title="Tutup">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <form id="bookCreateForm" action="<?= base_url('buku-buku/save') ?>" method="POST" enctype="multipart/form-data" novalidate>
                                        <?= csrf_field(); ?>

                                        <div class="form-group">
                                            <label for="createJudul">Masukan Judul Buku</label>
                                            <input type="text" name="judul_buku" id="createJudul" value="<?= old('judul_buku') ?>" required>
                                            <?php if (!empty($errors['judul_buku']) && session('modal') === 'create') : ?>
                                                <div class="text-danger"><?= esc($errors['judul_buku']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="createPenulis">Masukan Penulis</label>
                                            <input type="text" id="createPenulis" name="penulis" value="<?= old('penulis') ?>" required>
                                            <?php if (!empty($errors['penulis']) && session('modal') === 'create') : ?>
                                                <div class="text-danger"><?= esc($errors['penulis']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="createKategori">Masukan Kategori</label>
                                            <input type="text" id="createKategori" name="kategori" value="<?= old('kategori') ?>" required>
                                            <?php if (!empty($errors['kategori']) && session('modal') === 'create') : ?>
                                                <div class="text-danger"><?= esc($errors['kategori']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="createDeskripsi">Masukan Deskripsi Buku</label>
                                            <textarea id="createDeskripsi" name="deskripsi" rows="4" required><?= old('deskripsi') ?></textarea>
                                            <?php if (!empty($errors['deskripsi']) && session('modal') === 'create') : ?>
                                                <div class="text-danger"><?= esc($errors['deskripsi']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="createGambar">Unggah Gambar Sampul</label>
                                            <input type="file" id="createGambar" name="gambar_sampul" class="file-input" accept="image/*">
                                            <?php if (!empty($errors['gambar_sampul']) && session('modal') === 'create') : ?>
                                                <div class="text-danger"><?= esc($errors['gambar_sampul']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn-modal">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Modal Ubah Buku -->
                    <section id="bookEditModal">
                        <div class="modal-overlay" style="display: none;">
                            <div class="modal">
                                <div class="modal-header">
                                    <h2>Ubah Buku</h2>
                                    <button type="button" class="modal-close" id="closeBookEditModal" title="Tutup">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form id="bookEditForm" enctype="multipart/form-data" method="post" action="<?= base_url('buku-buku/update') ?>">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="id_buku" id="editIdBuku">
                                        <input type="hidden" name="gambarLama" id="editGambarLama">

                                        <div class="form-group">
                                            <label for="editJudul">Judul</label>
                                            <input type="text" name="judul_buku" id="editJudul" value="<?= old('judul_buku') ?>" required>
                                            <?php if (!empty($errors['judul_buku']) && session('modal') === 'edit') : ?>
                                                <div class="text-danger"><?= esc($errors['judul_buku']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="editPenulis">Penulis</label>
                                            <input type="text" id="editPenulis" name="penulis" value="<?= old('penulis') ?>" required>
                                            <?php if (!empty($errors['penulis']) && session('modal') === 'edit') : ?>
                                                <div class="text-danger"><?= esc($errors['penulis']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="editKategori">Kategori</label>
                                            <input type="text" id="editKategori" name="kategori" value="<?= old('kategori') ?>" required>
                                            <?php if (!empty($errors['kategori']) && session('modal') === 'edit') : ?>
                                                <div class="text-danger"><?= esc($errors['kategori']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="editDeskripsi">Deskripsi</label>
                                            <textarea id="editDeskripsi" name="deskripsi" rows="4" required><?= old('deskripsi') ?></textarea>
                                            <?php if (!empty($errors['deskripsi']) && session('modal') === 'edit') : ?>
                                                <div class="text-danger"><?= esc($errors['deskripsi']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="editGambar">Unggah Gambar Sampul</label>
                                            <div class="preview-container" style="margin-bottom: 10px;">
                                                <?php $gambar = isset($buku['sampul_gambar']) ? esc($buku['sampul_gambar']) : 'default.jpg'; ?>
                                                <img id="preview-img-edit" src="/assets/img/<?= $gambar; ?>" alt="Preview Gambar" style="max-height: 100px;">
                                            </div>
                                            <input type="file" id="editGambar" name="gambar_sampul" accept="image/*" onchange="previewImgEdit()">
                                            <?php if (!empty($errors['gambar_sampul']) && session('modal') === 'edit') : ?>
                                                <div class="text-danger"><?= esc($errors['gambar_sampul']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn-modal">Simpan</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Modal Lihat Buku -->
                    <section id="bookDetailsModal">
                        <div class="modal-overlay" style="display: none;">
                            <div class="modal view-mode">
                                <div class="modal-header">
                                    <h2>Data Buku</h2>
                                    <button type="button" class="modal-close" id="closeBookDetailsModal" title="Tutup">&times;</button>
                                </div>
                                <div class="modal-body center-view">
                                    <div class="book-cover center">
                                        <img id="viewCover" src="/assets/img/default.png" alt="Sampul Buku">
                                    </div>
                                    <div class="info-group">
                                        <div class="info-item">
                                            <span class="info-label">Judul Buku</span>
                                            <p id="viewJudul" class="info-data"></p>
                                        </div>
                                        <hr>
                                        <div class="info-item">
                                            <span class="info-label">Penulis</span>
                                            <p id="viewPenulis" class="info-data"></p>
                                        </div>
                                        <hr>
                                        <div class="info-item">
                                            <span class="info-label">Kategori</span>
                                            <p id="viewKategori" class="info-data"></p>
                                        </div>
                                        <hr>
                                        <div class="info-item">
                                            <span class="info-label">Deskripsi</span>
                                            <p id="viewDeskripsi" class="info-data"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Tabel Buku -->
                    <table class="data-table" id="bookTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Tombol Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($buku)) : ?>
                                <tr>
                                    <td colspan="5">Tidak ada data buku.</td>
                                </tr>
                            <?php else : ?>
                                <?php
                                $currentPage = $pager->getCurrentPage('buku');
                                $perPage = $pager->getPerPage('buku');
                                $no = 1 + ($perPage * ($currentPage - 1));
                                ?>
                                <?php foreach ($buku as $b) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($b['judul_buku']); ?></td>
                                        <td><?= esc($b['penulis']); ?></td>
                                        <td><?= esc($b['kategori']); ?></td>
                                        <td class="action-buttons">
                                            <!-- Tombol Hapus -->
                                            <form action="<?= base_url('buku-buku/delete/' . $b['id_buku']); ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="delete" title="Hapus" style="background: none; border: none; padding: 0;">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>

                                            <!-- Tombol Ubah (dengan trigger modal atau aksi lainnya) -->
                                            <button type="button"
                                                class="edit"
                                                title="Ubah"
                                                data-id="<?= $b['id_buku']; ?>"
                                                data-judul="<?= htmlspecialchars($b['judul_buku']); ?>"
                                                data-penulis="<?= htmlspecialchars($b['penulis']); ?>"
                                                data-kategori="<?= htmlspecialchars($b['kategori']); ?>"
                                                data-deskripsi="<?= htmlspecialchars($b['deskripsi']); ?>"
                                                data-gambar="<?= $b['gambar_sampul']; ?>"
                                                onclick="openEditModal(this)">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>

                                            <!-- Tombol Lihat -->
                                            <button type="button"
                                                class="view"
                                                title="Lihat"
                                                data-judul="<?= htmlspecialchars($b['judul_buku']); ?>"
                                                data-penulis="<?= htmlspecialchars($b['penulis']); ?>"
                                                data-kategori="<?= htmlspecialchars($b['kategori']); ?>"
                                                data-deskripsi="<?= htmlspecialchars($b['deskripsi']); ?>"
                                                data-gambar="<?= $b['gambar_sampul']; ?>"
                                                onclick="openViewModal(this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="pagination-container" style="margin-top: 20px; text-align: center;">
                        <?= $pager->links('buku', 'default_full'); ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php if (session('modal') === 'create') : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const overlay = document.querySelector('#bookCreateModal .modal-overlay');
                if (overlay) {
                    overlay.style.display = 'flex';
                }
            });
        </script>
    <?php elseif (session('modal') === 'edit') : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const overlay = document.querySelector('#bookEditModal .modal-overlay');
                if (overlay) {
                    overlay.style.display = 'flex';
                }
            });
        </script>
    <?php endif; ?>
    <script>
        // === Deklarasi elemen modal ubah
        const editModalOverlay = document.querySelector('#bookEditModal .modal-overlay');
        const bookEditForm = document.getElementById('bookEditForm');
        const closeEditModalBtn = document.getElementById('closeBookEditModal');

        // === Fungsi untuk buka modal ubah
        function openEditModal(button) {
            const id = button.dataset.id;
            const judul = button.dataset.judul;
            const penulis = button.dataset.penulis;
            const kategori = button.dataset.kategori;
            const deskripsi = button.dataset.deskripsi;
            const gambar = button.dataset.gambar;

            bookEditForm?.reset();

            document.getElementById('editIdBuku').value = id;
            document.getElementById('editJudul').value = judul;
            document.getElementById('editPenulis').value = penulis;
            document.getElementById('editKategori').value = kategori;
            document.getElementById('editDeskripsi').value = deskripsi;
            document.getElementById('editGambarLama').value = gambar;

            const preview = document.getElementById('preview-img-edit');
            if (preview) {
                preview.src = '/assets/img/' + gambar;
            }

            editModalOverlay.style.display = 'flex';
        }

        // === Tutup modal ubah
        closeEditModalBtn?.addEventListener('click', () => {
            editModalOverlay.style.display = 'none';
        });

        // Klik luar modal = tutup
        editModalOverlay?.addEventListener('click', (e) => {
            if (e.target === editModalOverlay) {
                editModalOverlay.style.display = 'none';
            }
        });

        function previewImgEdit() {
            const input = document.getElementById('editGambar');
            const preview = document.getElementById('preview-img-edit');

            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Modal Lihat Buku

        const bookDetailsOverlay = document.querySelector('#bookDetailsModal .modal-overlay');
        const closeBookDetailsBtn = document.getElementById('closeBookDetailsModal');

        function openViewModal(button) {
            document.getElementById('viewJudul').textContent = button.dataset.judul;
            document.getElementById('viewPenulis').textContent = button.dataset.penulis;
            document.getElementById('viewKategori').textContent = button.dataset.kategori;
            document.getElementById('viewDeskripsi').textContent = button.dataset.deskripsi;
            document.getElementById('viewCover').src = '/assets/img/' + button.dataset.gambar;

            bookDetailsOverlay.style.display = 'flex';
        }

        closeBookDetailsBtn?.addEventListener('click', () => {
            bookDetailsOverlay.style.display = 'none';
        });

        bookDetailsOverlay?.addEventListener('click', (e) => {
            if (e.target === bookDetailsOverlay) {
                bookDetailsOverlay.style.display = 'none';
            }
        });
    </script>

    <script src="/assets/js/main.js"></script>
</body>

</html>