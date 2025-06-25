<!DOCTYPE html>
<html lang="id">

<?= $this->include('homes/head'); ?>

<body>
  <!-- Header -->
  <?= $this->include('homes/header'); ?>

  <!-- Konten Profil -->
  <div class="profile-container">
    <form action="/profil/updateFoto" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="profile-card">
        <img src="/assets/img/profile/<?= esc($user['foto_profil'] ?? 'default.png') ?>" alt="Foto Profil" id="fotoPreview" />
        <br />
        <form class="form-upload-foto" method="post" enctype="multipart/form-data">
          <label for="fotoInput">Ganti Foto</label>
          <input type="file" id="fotoInput" name="foto_profil" accept="image/*" onchange="previewFoto(event)">
          <button type="submit">Simpan Foto</button>
        </form>
      </div>
    </form>

    <div class="user-info">
      <h2>Informasi Akun</h2>
      <div class="row"><span class="label">Nama Lengkap</span><span class="value"><?= esc($user['nama_lengkap']) ?></span></div>
      <div class="row"><span class="label">Email</span><span class="value"><?= esc($user['email']) ?></span></div>
      <div class="row"><span class="label">NPM</span><span class="value"><?= esc($user['npm']) ?></span></div>
      <div class="row"><span class="label">No. Telepon</span><span class="value"><?= esc($user['nomor_telepon']) ?></span></div>
      <div class="row"><span class="label">Alamat</span><span class="value"><?= esc($user['alamat']) ?></span></div>
      <div class="row">
        <span class="label">Status</span>
        <span class="value">
          <?php
          $statusClass = match (strtolower($user['status'])) {
            'aktif' => 'status-green',
            'tidak aktif' => 'status-red',
            'menunggu', 'sedang proses' => 'status-yellow',
            default => 'status-blue'
          };
          ?>
          <span class="status-badge <?= $statusClass ?>">
            <?= esc($user['status']) ?>
          </span>
        </span>
      </div>
      <div class="logout-container">
        <a href="/logout" class="logout-button">Logout</a>
      </div>
    </div>
  </div>

  <!-- Riwayat -->
  <div class="history-table">
    <h2>Riwayat Peminjaman Buku</h2>
    <table>
      <thead>
        <tr>
          <th>Judul Buku</th>
          <th>Tanggal Peminjaman</th>
          <th>Tanggal Pengembalian</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($riwayat)): ?>
          <?php foreach ($riwayat as $r): ?>
            <?php
            $status = strtolower($r['status']);
            $pinjamStatus = match ($status) {
              'telah dikembalikan', 'selesai' => 'status-green',
              'terlambat' => 'status-red',
              'sedang dipinjam' => 'status-yellow',
              default => 'status-blue'
            };
            ?>
            <tr>
              <td><?= esc($r['judul_buku']) ?></td>
              <td><?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?></td>
              <td><?= $r['tanggal_pengembalian'] ? date('d M Y', strtotime($r['tanggal_pengembalian'])) : '-' ?></td>
              <td>
                <span class="status-badge <?= $pinjamStatus ?>">
                  <?= esc(ucwords($r['status'])) ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-center">Belum ada riwayat peminjaman.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    <div class="pagination-container">
      <?= $pager->links('riwayat', 'default_full') ?>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    &copy; 2025 SIRUBA - Sistem Informasi Ruang Baca
  </footer>

  <!-- Script Ganti Foto -->
  <script>
    function previewFoto(event) {
      const reader = new FileReader();
      reader.onload = function() {
        const preview = document.getElementById('fotoPreview');
        preview.src = reader.result;

        // Jika ingin sinkron juga dengan gambar header (opsional)
        const headerImg = document.querySelector('.profile-img');
        if (headerImg) headerImg.src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>

</body>

</html>