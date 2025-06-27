<!DOCTYPE html>
<html lang="id">

<?= $this->include('admins/sections/head'); ?>

<body>
    <div class="container">
        <?= $this->include('admins/sections/sidebar'); ?>

        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <h1>Management Anggota</h1>
                </div>
                <div class="header-right">
                    <span>Hai, <?= esc(session('nama_admin') ?? 'Administrator') ?> 👋</span>
                </div>
            </header>

            <div class="content-wrapper">
                <div class="data-container">
                    <div class="data-header">
                        <h2>Daftar Anggota Ruang Baca</h2>
                        <div class="search-bar">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Cari Data">
                        </div>
                    </div>

                    <!-- Tombol Tambah Anggota -->
                    <div class="form-actions">
                        <button type="button" class="btn-tambah" id="openMemberCreateModal">Tambah Anggota</button>
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

                    <!-- Table Data Anggota -->
                    <table class="data-table" id="memberTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>NPM</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($anggota)) : ?>
                                <tr>
                                    <td colspan="7">Tidak ada data anggota.</td>
                                </tr>
                            <?php else : ?>
                                <?php
                                $currentPage = $pager->getCurrentPage('anggota');
                                $perPage = $pager->getPerPage('anggota');
                                $no = 1 + ($perPage * ($currentPage - 1));
                                ?>
                                <?php foreach ($anggota as $a) : ?>
                                    <tr
                                        data-id="<?= esc($a['id_anggota']); ?>"
                                        data-nama="<?= esc($a['nama_lengkap']); ?>"
                                        data-password="<?= esc($a['password']); ?>"
                                        data-npm="<?= esc($a['npm']); ?>"
                                        data-email="<?= esc($a['email']); ?>"
                                        data-telepon="<?= esc($a['nomor_telepon']); ?>"
                                        data-alamat="<?= esc($a['alamat']); ?>"
                                        data-foto="/assets/img/profil/<?= esc($a['foto_profil']); ?>">

                                        <td><?= $no++; ?></td>
                                        <td><img src="/assets/img/profile/<?= esc($a['foto_profil']); ?>" alt="Foto <?= esc($a['nama_lengkap']); ?>" class="table-photo"></td>
                                        <td><?= esc($a['nama_lengkap']); ?></td>
                                        <td><?= esc($a['npm']); ?></td>
                                        <td><?= esc($a['email']); ?></td>
                                        <td>
                                            <span class="status-badge <?= strtolower($a['status']) === 'aktif' ? 'status-blue' : 'status-red'; ?>">
                                                <?= esc($a['status']); ?>
                                            </span>
                                        </td>
                                        <td class="aksi-cell">
                                            <div class="aksi-wrapper">
                                                <!-- Tombol Hapus -->
                                                <form action="<?= base_url('anggota/delete/' . $a['id_anggota']); ?>" method="post"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="aksi-btn" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>

                                                <!-- Tombol Edit -->
                                                <a href="#" class="aksi-btn" title="Ubah"
                                                    onclick="openEditModal(this)"
                                                    data-id="<?= esc($a['id_anggota']); ?>"
                                                    data-nama="<?= esc($a['nama_lengkap']); ?>"
                                                    data-npm="<?= esc($a['npm']); ?>"
                                                    data-email="<?= esc($a['email']); ?>"
                                                    data-telepon="<?= esc($a['nomor_telepon']); ?>"
                                                    data-alamat="<?= esc($a['alamat']); ?>"
                                                    data-status="<?= esc($a['status']); ?>"
                                                    data-foto="/assets/img/profile/<?= esc($a['foto_profil']); ?>">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <!-- Tombol Lihat -->
                                                <a href="#" class="aksi-btn" title="Lihat"
                                                    onclick="openViewModal(this)"
                                                    data-nama="<?= esc($a['nama_lengkap']); ?>"
                                                    data-npm="<?= esc($a['npm']); ?>"
                                                    data-email="<?= esc($a['email']); ?>"
                                                    data-telepon="<?= esc($a['nomor_telepon']); ?>"
                                                    data-alamat="<?= esc($a['alamat']); ?>"
                                                    data-foto="/assets/img/profile/<?= esc($a['foto_profil']); ?>">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="pagination-container" style="margin-top: 20px; text-align: center;">
                        <?= $pager->links('anggota', 'default_full'); ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah Anggota -->
    <section id="memberCreateModal" class="custom-modal">
        <div class="modal-overlay" style="display: none;">
            <div class="modal modal-lg">
                <div class="modal-header">
                    <h2>Tambah Anggota</h2>
                    <button type="button" class="modal-close" id="closeMemberCreateModal">&times;</button>
                </div>

                <div class="modal-body modal-body-split">
                    <form id="memberCreateForm" action="<?= base_url('anggota/save') ?>" method="POST" enctype="multipart/form-data" novalidate>
                        <?= csrf_field(); ?>

                        <!-- Wrapper untuk 2 kolom -->
                        <div class="form-columns">
                            <!-- Kolom Kiri -->
                            <div class="form-left">
                                <div class="form-group">
                                    <label for="createNama">Nama Lengkap</label>
                                    <input type="text" id="createNama" name="nama_lengkap" value="<?= old('nama_lengkap'); ?>" required>
                                    <?php if (!empty($errors['nama_lengkap']) && session('modal') === 'create') : ?>
                                        <div class="text-danger"><?= esc($errors['nama_lengkap']); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="createNpm">NPM</label>
                                    <input type="text" id="createNpm" name="npm" value="<?= old('npm'); ?>" required>
                                    <?php if (!empty($errors['npm']) && session('modal') === 'create') : ?>
                                        <div class="text-danger"><?= esc($errors['npm']); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="createEmail">Email</label>
                                    <input type="email" id="createEmail" name="email" value="<?= old('email'); ?>" required>
                                    <?php if (!empty($errors['email']) && session('modal') === 'create') : ?>
                                        <div class="text-danger"><?= esc($errors['email']); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group-row">
                                    <div class="form-group">
                                        <label for="createPassword">Password</label>
                                        <input type="password" id="createPassword" name="password" required>
                                        <?php if (!empty($errors['password']) && session('modal') === 'create') : ?>
                                            <div class="text-danger"><?= esc($errors['password']); ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="createTelepon">No. Telepon</label>
                                        <input type="tel" id="createTelepon" name="nomor_telepon" value="<?= old('nomor_telepon'); ?>">
                                        <?php if (!empty($errors['nomor_telepon']) && session('modal') === 'create') : ?>
                                            <div class="text-danger"><?= esc($errors['nomor_telepon']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="createAlamat">Alamat</label>
                                    <textarea id="createAlamat" name="alamat" rows="3"><?= old('alamat'); ?></textarea>
                                    <?php if (!empty($errors['alamat']) && session('modal') === 'create') : ?>
                                        <div class="text-danger"><?= esc($errors['alamat']); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="createStatus">Status</label>
                                    <select id="createStatus" name="status" required>
                                        <option value="Aktif" <?= old('status') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="Tidak Aktif" <?= old('status') == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                                    </select>
                                    <?php if (!empty($errors['status']) && session('modal') === 'create') : ?>
                                        <div class="text-danger"><?= esc($errors['status']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="form-right">
                                <div class="profile-photo-container">
                                    <img id="preview-img-create" src="/assets/img/default-avatar.png" class="profile-photo-main" alt="Foto Profil">
                                </div>

                                <div class="form-group text-center">
                                    <label for="createFoto">Pilih Foto</label>
                                    <input type="file" id="createFoto" name="foto_profil" class="file-input" accept="image/*" onchange="previewImgCreate()">
                                    <?php if (!empty($errors['foto_profil']) && session('modal') === 'create') : ?>
                                        <div class="text-danger"><?= esc($errors['foto_profil']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="modal-footer">
                            <button type="submit" class="btn-modal">Simpan Anggota</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Edit Anggota -->
    <section id="memberEditModal" class="custom-modal">
        <div class="modal-overlay" style="display: none;">
            <div class="modal modal-lg">
                <div class="modal-header">
                    <h2>Ubah Anggota</h2>
                    <button type="button" class="modal-close" id="closeMemberEditModal">&times;</button>
                </div>

                <div class="modal-body modal-body-split">
                    <form id="memberEditForm" action="<?= base_url('anggota/update') ?>" method="POST" enctype="multipart/form-data" novalidate>
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id_anggota" id="editIdAnggota">

                        <div class="form-columns">
                            <!-- Kolom Kiri -->
                            <div class="form-left">
                                <div class="form-group">
                                    <label for="editNama">Nama Lengkap</label>
                                    <input type="text" id="editNama" name="nama_lengkap" required>
                                </div>

                                <div class="form-group">
                                    <label for="editNpm">NPM</label>
                                    <input type="text" id="editNpm" name="npm" required>
                                </div>

                                <div class="form-group">
                                    <label for="editEmail">Email</label>
                                    <input type="email" id="editEmail" name="email" required>
                                </div>

                                <div class="form-group-row">
                                    <div class="form-group">
                                        <label for="editPassword">Password</label>
                                        <input type="password" id="editPassword" name="password" placeholder="(Biarkan kosong jika tidak ingin mengubah)">
                                    </div>

                                    <div class="form-group">
                                        <label for="editTelepon">No. Telepon</label>
                                        <input type="tel" id="editTelepon" name="nomor_telepon">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="editAlamat">Alamat</label>
                                    <textarea id="editAlamat" name="alamat" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="editStatus">Status</label>
                                    <select id="editStatus" name="status" required>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="form-right">
                                <div class="form-group">
                                    <label for="editFoto">Unggah Foto Profil</label>

                                    <div class="preview-container" style="margin-bottom: 10px; text-align: center;">
                                        <?php
                                        $foto = isset($anggota['foto_profil']) && $anggota['foto_profil'] !== '' ? esc($anggota['foto_profil']) : 'default-avatar.png';
                                        ?>
                                        <img id="preview-img-edit" src="/assets/img/profile/<?= $foto; ?>" alt="Preview Foto Profil" style="max-height: 100px; border-radius: 50%; object-fit: cover; border: 1px solid #ccc;">
                                    </div>

                                    <input type="file" id="editFoto" name="foto_profil" class="file-input" accept="image/*" onchange="previewImgEdit()">

                                    <?php if (!empty($errors['foto_profil']) && session('modal') === 'edit') : ?>
                                        <div class="text-danger"><?= esc($errors['foto_profil']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn-modal">Perbarui Anggota</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Lihat Anggota -->
    <section id="memberDetailsModal">
        <div class="modal-overlay" style="display: none;">
            <div class="modal view-mode">
                <div class="modal-header">
                    <h2>Data Anggota</h2>
                    <button type="button" class="modal-close" id="closeMemberDetailsModal" title="Tutup">&times;</button>
                </div>
                <div class="modal-body center-view">
                    <div class="profile-photo-container">
                        <img id="viewFoto" src="/assets/img/default-avatar.png" alt="Foto Profil" class="profile-photo-main">
                    </div>
                    <div class="info-group">
                        <div class="info-item">
                            <span class="info-label">Nama:</span>
                            <p id="viewNama"></p>
                        </div>
                        <div class="info-item">
                            <span class="info-label">NPM:</span>
                            <p id="viewNpm"></p>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <p id="viewEmail"></p>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Telepon:</span>
                            <p id="viewTelepon"></p>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Alamat:</span>
                            <p id="viewAlamat"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (session('modal') === 'create') : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const overlay = document.querySelector('#memberCreateModal .modal-overlay');
                if (overlay) {
                    overlay.style.display = 'flex';
                }
            });
        </script>
    <?php elseif (session('modal') === 'edit') : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const overlay = document.querySelector('#memberEditModal .modal-overlay');
                if (overlay) {
                    overlay.style.display = 'flex';
                }
            });
        </script>
    <?php endif; ?>


    <script>
        // === Modal Tambah Anggota ===
        const openCreateModalBtn = document.getElementById('openMemberCreateModal');
        const createModalOverlay = document.querySelector('#memberCreateModal .modal-overlay');
        const closeCreateModalBtn = document.getElementById('closeMemberCreateModal');
        const memberCreateForm = document.getElementById('memberCreateForm');

        // Buka modal tambah
        openCreateModalBtn?.addEventListener('click', () => {
            memberCreateForm?.reset();
            document.getElementById('preview-img-create').src = '/assets/img/default-avatar.png';
            createModalOverlay.style.display = 'flex';
        });

        // Tutup modal tambah
        closeCreateModalBtn?.addEventListener('click', () => {
            createModalOverlay.style.display = 'none';
        });

        // Klik luar modal = tutup
        createModalOverlay?.addEventListener('click', (e) => {
            if (e.target === createModalOverlay) {
                createModalOverlay.style.display = 'none';
            }
        });

        // Preview gambar
        function previewImgCreate() {
            const input = document.getElementById('createFoto');
            const preview = document.getElementById('preview-img-create');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script>
        // === Modal Edit Anggota ===
        const editModalOverlay = document.querySelector('#memberEditModal .modal-overlay');
        const closeEditModalBtn = document.getElementById('closeMemberEditModal');

        function openEditModal(button) {
            const tr = button.closest('tr');

            document.getElementById('editIdAnggota').value = tr.dataset.id;
            document.getElementById('editNama').value = tr.dataset.nama;
            document.getElementById('editNpm').value = tr.dataset.npm;
            document.getElementById('editEmail').value = tr.dataset.email;
            document.getElementById('editTelepon').value = tr.dataset.telepon;
            document.getElementById('editAlamat').value = tr.dataset.alamat;
            document.getElementById('editPassword').value = '';

            // Status select
            const statusSelect = document.getElementById('editStatus');
            statusSelect.value = tr.querySelector('span.status-badge').textContent.trim();

            // Foto
            const foto = tr.dataset.foto;
            const preview = document.getElementById('preview-img-edit');

            // Path folder gambar profil
            const folderPath = '/assets/img/profile/';

            // Tampilkan foto jika ada, jika tidak gunakan default-avatar
            preview.src = foto && foto !== '' ? (folderPath + foto) : '/assets/img/default-avatar.png';


            editModalOverlay.style.display = 'flex';
        }

        // === Fungsi untuk buka modal ubah
        function openEditModal(button) {
            const id = button.dataset.id;
            const nama = button.dataset.nama;
            const npm = button.dataset.npm;
            const email = button.dataset.email;
            const telepon = button.dataset.telepon;
            const alamat = button.dataset.alamat;
            const status = button.dataset.status;
            const foto = button.dataset.foto;

            document.getElementById('editIdAnggota').value = id;
            document.getElementById('editNama').value = nama;
            document.getElementById('editNpm').value = npm;
            document.getElementById('editEmail').value = email;
            document.getElementById('editTelepon').value = telepon;
            document.getElementById('editAlamat').value = alamat;
            document.getElementById('editPassword').value = '';

            // Set status
            const statusSelect = document.getElementById('editStatus');
            if (statusSelect) statusSelect.value = status;

            // Set foto preview
            const preview = document.getElementById('preview-img-edit');
            preview.src = foto && foto !== '' ? foto : '/assets/img/profile/default-avatar.png';

            // Tampilkan modal
            editModalOverlay.style.display = 'flex';
        }


        closeEditModalBtn?.addEventListener('click', () => {
            editModalOverlay.style.display = 'none';
        });

        editModalOverlay?.addEventListener('click', (e) => {
            if (e.target === editModalOverlay) {
                editModalOverlay.style.display = 'none';
            }
        });

        function previewImgEdit() {
            const input = document.getElementById('editFoto');
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
    </script>
    <script>
        // === Modal Lihat Anggota ===
        const viewModalOverlay = document.querySelector('#memberDetailsModal .modal-overlay');
        const closeViewModalBtn = document.getElementById('closeMemberDetailsModal');

        function openViewModal(button) {
            const nama = button.dataset.nama;
            const npm = button.dataset.npm;
            const email = button.dataset.email;
            const telepon = button.dataset.telepon;
            const alamat = button.dataset.alamat;
            const foto = button.dataset.foto;

            document.getElementById('viewNama').textContent = nama;
            document.getElementById('viewNpm').textContent = npm;
            document.getElementById('viewEmail').textContent = email;
            document.getElementById('viewTelepon').textContent = telepon;
            document.getElementById('viewAlamat').textContent = alamat;

            const fotoView = document.getElementById('viewFoto');
            fotoView.src = foto && foto !== '' ? foto : '/assets/img/default-avatar.png';

            viewModalOverlay.style.display = 'flex';
        }

        closeViewModalBtn?.addEventListener('click', () => {
            viewModalOverlay.style.display = 'none';
        });

        viewModalOverlay?.addEventListener('click', (e) => {
            if (e.target === viewModalOverlay) {
                viewModalOverlay.style.display = 'none';
            }
        });
    </script>


    <script src="/assets/js/main.js"></script>
</body>

</html>