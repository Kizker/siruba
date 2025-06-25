<!DOCTYPE html>
<html lang="id">

<?= $this->include('homes/head'); ?>

<body>
    <?= $this->include('homes/header'); ?>

    <div class="content">
        <section class="section-buku-terbaru">
            <div class="container">
                <h2 class="section-title">Daftar Buku</h2>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success flash-msg">
                        <i class="fas fa-check-circle"></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger flash-msg">
                        <i class="fas fa-times-circle"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="books-container" id="book-list">
                    <?php foreach ($buku as $b):
                        $idBuku = $b['id_buku'];
                        $isDipinjam = isset($peminjamanAktif[$idBuku]);
                        $tanggal_pinjam = $isDipinjam ? $peminjamanAktif[$idBuku]['tanggal_pinjam'] : '';
                        $tanggal_kembali = $isDipinjam ? $peminjamanAktif[$idBuku]['tanggal_pengembalian'] : '';
                        $id_peminjaman = $isDipinjam ? $peminjamanAktif[$idBuku]['id_peminjaman'] : '';
                    ?>
                        <div class="book-card"
                            data-id="<?= htmlspecialchars($idBuku) ?>"
                            data-id-peminjaman="<?= htmlspecialchars($id_peminjaman) ?>"
                            data-judul="<?= htmlspecialchars($b['judul_buku']) ?>"
                            data-penulis="<?= htmlspecialchars($b['penulis']) ?>"
                            data-kategori="<?= htmlspecialchars($b['kategori']) ?>"
                            data-deskripsi="<?= htmlspecialchars($b['deskripsi']) ?>"
                            data-img="/assets/img/<?= htmlspecialchars($b['gambar_sampul']) ?>"
                            data-tanggal-pinjam="<?= htmlspecialchars($tanggal_pinjam) ?>"
                            data-tanggal-kembali="<?= htmlspecialchars($tanggal_kembali) ?>"
                            onclick="showBookDetail(this)">
                            <img src="/assets/img/<?= htmlspecialchars($b['gambar_sampul']) ?>" alt="<?= htmlspecialchars($b['judul_buku']) ?>">
                            <div class="title"><?= htmlspecialchars($b['judul_buku']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="pagination-container">
                    <?= $pager->links('buku', 'default_full') ?>
                </div>
            </div>
        </section>

        <!-- Modal Detail Buku -->
        <div id="bookModal" class="modal">
            <div class="modal-content">
                <div class="close-btn" onclick="closeModal()">✖</div>
                <div class="modal-body">
                    <div class="modal-left">
                        <img id="modalImage" src="" alt="Cover Buku" />
                    </div>
                    <div class="modal-right">
                        <h2 id="modalTitle">Judul Buku</h2>
                        <p id="modalDesc" class="book-description">Deskripsi buku ditampilkan di sini.</p>
                        <div class="book-info-grid">
                            <div><strong>Penulis</strong><br><span id="modalAuthor">-</span></div>
                            <div><strong>Kategori</strong><br><span id="modalKategori">-</span></div>
                        </div>

                        <div class="modal-btn-group">
                            <button class="pinjam-btn" onclick="openPinjamModal()" id="btnPinjam">Pinjam Buku</button>
                            <button class="kembali-btn" onclick="openKembaliModal()">Kembalikan Buku</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Peminjaman Buku -->
        <div id="pinjamModal" class="modal">
            <div class="modal-content">
                <div class="close-btn" onclick="closeModal()">✖</div>
                <h2>Peminjaman Buku</h2>
                <form action="/pinjam" method="post">
                    <input type="hidden" name="id_buku" id="pinjam_id_buku">
                    <input type="hidden" name="from" value="/buku"> <!-- Ini penting -->
                    <label>Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" readonly required>
                    <label>Tanggal Pengembalian</label>
                    <input type="date" name="tanggal_pengembalian" required>
                    <button type="submit" class="pinjam-btn">Submit Peminjaman</button>
                </form>
            </div>
        </div>

        <!-- Modal Pengembalian Buku -->
        <div id="kembaliModal" class="modal">
            <div class="modal-content">
                <div class="close-btn" onclick="closeModal()">✖</div>
                <h2>Pengembalian Buku</h2>

                <div id="pengembalian-info" style="display: none;">
                    <p><strong>Judul:</strong> <span id="kembaliJudul"></span></p>
                    <p><strong>Tanggal Pinjam:</strong> <span id="kembaliTanggalPinjam"></span></p>
                    <p><strong>Tanggal Kembali:</strong> <span id="kembaliTanggalKembali"></span></p>

                    <form action="/kembali" method="post">
                        <input type="hidden" name="id_peminjaman" id="kembali_id_peminjaman">
                        <input type="hidden" name="from" value="/buku"> <!-- Ini penting -->
                        <button type="submit" class="kembali-btn">Submit Pengembalian</button>
                    </form>
                </div>

                <div id="tidakMeminjamInfo" style="display: none;">
                    <p class="text-danger">Anda tidak sedang meminjam buku ini.</p>
                </div>
            </div>
        </div>

        <footer class="footer">&copy; 2025 SIRUBA - Sistem Informasi Ruang Baca</footer>

        <script>
            function showBookDetail(el) {
                if (!el) return;

                window.lastSelectedBook = el;

                const id = el.dataset.id || '';
                const idPeminjaman = el.dataset.idPeminjaman || '';
                const title = el.dataset.judul || 'Judul tidak tersedia';
                const image = el.dataset.img || '/assets/img/default-book.png';
                const author = el.dataset.penulis || 'Penulis tidak diketahui';
                const kategori = el.dataset.kategori || 'Kategori tidak tersedia';
                const description = el.dataset.deskripsi || 'Deskripsi tidak tersedia';
                const tglPinjam = el.dataset.tanggalPinjam || '';
                const tglKembali = el.dataset.tanggalKembali || '';

                document.getElementById('modalImage').src = image;
                document.getElementById('modalTitle').textContent = title;
                document.getElementById('modalDesc').textContent = description;
                document.getElementById('modalAuthor').textContent = author;
                document.getElementById('modalKategori').textContent = kategori;

                document.getElementById('pinjam_id_buku').value = id;

                const btnPinjam = document.getElementById('btnPinjam');
                if (tglPinjam && tglKembali) {
                    btnPinjam.disabled = true;
                    btnPinjam.textContent = 'Sedang Dipinjam';
                    btnPinjam.classList.add('btn-secondary');
                    btnPinjam.classList.remove('btn-primary');
                } else {
                    btnPinjam.disabled = false;
                    btnPinjam.textContent = 'Pinjam Buku';
                    btnPinjam.classList.add('btn-primary');
                    btnPinjam.classList.remove('btn-secondary');
                }

                document.getElementById('bookModal').style.display = 'flex';
            }


            function closeModal() {
                ['bookModal', 'pinjamModal', 'kembaliModal'].forEach(id => {
                    document.getElementById(id).style.display = 'none';
                });
            }

            function openPinjamModal() {
                closeModal();
                document.getElementById('pinjamModal').style.display = 'flex';
            }

            function openKembaliModal() {
                closeModal();

                const el = window.lastSelectedBook;
                if (!el) return;

                const idPeminjaman = el.dataset.idPeminjaman;
                const judul = el.dataset.judul;
                const tglPinjam = el.dataset.tanggalPinjam;
                const tglKembali = el.dataset.tanggalKembali;

                document.getElementById('kembali_id_peminjaman').value = idPeminjaman || '';
                document.getElementById('kembaliJudul').textContent = judul || '-';
                document.getElementById('kembaliTanggalPinjam').textContent = tglPinjam || '-';
                document.getElementById('kembaliTanggalKembali').textContent = tglKembali || '-';

                if (tglPinjam && tglKembali) {
                    document.getElementById('pengembalian-info').style.display = 'block';
                    document.getElementById('tidakMeminjamInfo').style.display = 'none';
                } else {
                    document.getElementById('pengembalian-info').style.display = 'none';
                    document.getElementById('tidakMeminjamInfo').style.display = 'block';
                }

                document.getElementById('kembaliModal').style.display = 'flex';
            }

            window.onclick = function(e) {
                ['bookModal', 'pinjamModal', 'kembaliModal'].forEach(id => {
                    const modal = document.getElementById(id);
                    if (e.target === modal) {
                        modal.style.display = 'none';
                    }
                });
            };

            document.addEventListener('DOMContentLoaded', function() {
                ['bookModal', 'pinjamModal', 'kembaliModal'].forEach(id => {
                    const modal = document.getElementById(id);
                    if (modal && modal.style.display !== 'none') {
                        modal.style.display = 'none';
                    }
                });
            });
        </script>
</body>

</html>