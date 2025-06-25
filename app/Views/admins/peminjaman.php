<!DOCTYPE html>
<html lang="id">

<?= $this->include('admins/sections/head'); ?>

<body>
    <div class="container">
        <?= $this->include('admins/sections/sidebar'); ?>

        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <h1>Transaksi Peminjaman</h1>
                </div>
                <div class="header-right">
                    <span>Hai, <?= session('user_nama') ?? 'Administrator' ?> 👋</span>
                </div>
            </header>

            <div class="content-wrapper">
                <div class="data-container">
                    <div class="data-header">
                        <h2>Daftar Transaksi Peminjaman</h2>
                        <div class="search-bar"><i class="fas fa-search"></i><input type="text" placeholder="Cari Data"></div>
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

                    <section id="transactionMasterModal">
                        <div class="modal-overlay" style="display: none;">
                            <div class="modal">
                                <div class="modal-header">
                                    <h2 id="modalTitle">Ubah Data Transaksi</h2>
                                    <button type="button" class="modal-close" id="closeTransactionModal" title="Tutup">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form id="transactionForm" action="<?= site_url('peminjaman/update') ?>" method="post">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="id_peminjaman" id="modalIdPeminjaman">

                                        <div class="form-group">
                                            <label for="modalPeminjam">Nama Peminjam</label>
                                            <select id="modalPeminjam" name="id_anggota" required>
                                                <option value="">-- Pilih Peminjam --</option>
                                                <?php foreach ($anggota as $a): ?>
                                                    <option value="<?= $a['id_anggota']; ?>"><?= esc($a['nama_lengkap']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="modalBuku">Judul Buku</label>
                                            <select id="modalBuku" name="id_buku" required>
                                                <option value="">-- Pilih Buku --</option>
                                                <?php foreach ($buku as $b): ?>
                                                    <option value="<?= $b['id_buku']; ?>"><?= esc($b['judul_buku']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="modalTglPinjam">Tanggal Pinjam</label>
                                            <input type="date" id="modalTglPinjam" name="tanggal_pinjam" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="modalTglKembali">Tanggal Pengembalian</label>
                                            <input type="date" id="modalTglKembali" name="tanggal_pengembalian">
                                        </div>

                                        <div class="form-group">
                                            <label for="modalStatus">Status Peminjaman</label>
                                            <select id="modalStatus" name="status" required>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="Sedang Dipinjam">Sedang Dipinjam</option>
                                                <option value="Telah Dikembalikan">Telah Dikembalikan</option>
                                                <option value="Terlambat">Terlambat</option>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn-modal">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>

                    <table class="data-table" id="transactionTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $currentPage = $pager->getCurrentPage('peminjaman');
                            $perPage = $pager->getPerPage('peminjaman');
                            $no = 1 + ($perPage * ($currentPage - 1)); // urutan berlanjut antar halaman
                            ?>
                            <?php foreach ($peminjaman as $p) : ?>
                                <tr
                                    data-id="<?= $p['id_peminjaman']; ?>"
                                    data-id-anggota="<?= $p['id_anggota']; ?>"
                                    data-id-buku="<?= $p['id_buku']; ?>"
                                    data-tgl-pinjam="<?= $p['tanggal_pinjam']; ?>"
                                    data-tgl-kembali="<?= $p['tanggal_pengembalian']; ?>"
                                    data-status="<?= esc($p['status']); ?>">
                                    <td><?= $no++; ?></td> <!-- nomor terus naik -->
                                    <td><?= esc($p['nama_lengkap']); ?></td>
                                    <td><?= esc($p['judul_buku']); ?></td>
                                    <td><?= date('d/m/Y', strtotime($p['tanggal_pinjam'])); ?></td>
                                    <td><?= $p['tanggal_pengembalian'] ? date('d/m/Y', strtotime($p['tanggal_pengembalian'])) : '-'; ?></td>
                                    <td>
                                        <?php
                                        $statusClass = [
                                            'Sedang Dipinjam' => 'status-yellow',
                                            'Telah Dikembalikan' => 'status-green',
                                            'Terlambat' => 'status-red'
                                        ];
                                        $class = $statusClass[$p['status']] ?? 'status-gray';
                                        ?>
                                        <span class="status-badge <?= $class; ?>"><?= $p['status']; ?></span>
                                    </td>
                                    <td class="action-buttons">
                                        <form action="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']); ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?');">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="aksi-btn" title="Hapus" style="background: none; border: none; padding: 0;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        <button
                                            class="aksi-btn btn-edit"
                                            title="Ubah"
                                            data-id="<?= $p['id_peminjaman']; ?>"
                                            data-id-anggota="<?= $p['id_anggota']; ?>"
                                            data-id-buku="<?= $p['id_buku']; ?>"
                                            data-tgl-pinjam="<?= $p['tanggal_pinjam']; ?>"
                                            data-tgl-kembali="<?= $p['tanggal_pengembalian']; ?>"
                                            data-status="<?= esc($p['status']); ?>"
                                            onclick="openEditModal(this)">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="pagination-container" style="margin-top: 20px; text-align: center;">
                        <?= $pager->links('peminjaman', 'default_full'); ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php if (session('modal') === 'edit') : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const overlay = document.querySelector('#transactionMasterModal .modal-overlay');
                if (overlay) {
                    overlay.style.display = 'flex';
                }
            });
        </script>
    <?php endif; ?>

    <script>
        const pinjamEditModalOverlay = document.querySelector('#transactionMasterModal .modal-overlay');
        const pinjamEditForm = document.getElementById('transactionForm');
        const closePinjamEditModalBtn = document.getElementById('closeTransactionModal');

        function openEditModal(button) {
            const id = button.dataset.id;
            const idAnggota = button.dataset.idAnggota;
            const idBuku = button.dataset.idBuku;
            const tglPinjam = button.dataset.tglPinjam;
            const tglKembali = button.dataset.tglKembali || ''; // kosongkan jika null
            const status = button.dataset.status;

            pinjamEditForm.reset();

            document.getElementById('modalIdPeminjaman').value = id;
            document.getElementById('modalPeminjam').value = idAnggota;
            document.getElementById('modalBuku').value = idBuku;
            document.getElementById('modalTglPinjam').value = tglPinjam;
            document.getElementById('modalTglKembali').value = tglKembali;
            document.getElementById('modalStatus').value = status;

            pinjamEditModalOverlay.style.display = 'flex';
        }

        closePinjamEditModalBtn?.addEventListener('click', () => {
            pinjamEditModalOverlay.style.display = 'none';
        });

        pinjamEditModalOverlay?.addEventListener('click', (e) => {
            if (e.target === pinjamEditModalOverlay) {
                pinjamEditModalOverlay.style.display = 'none';
            }
        });
    </script>

    <script src="/assets/js/main.js"></script>
</body>

</html>