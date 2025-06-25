<section id="peminjaman-terbaru" class="section-transaksi-terbaru">
    <div class="recent-data-card">
        <h2>Transaksi Terbaru</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Buku Dipinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transaksiTerbaru)) : ?>
                    <?php foreach ($transaksiTerbaru as $t): ?>
                        <tr>
                            <td><?= esc($t['nama_lengkap']); ?></td>
                            <td><?= esc($t['judul_buku']); ?></td>
                            <td>
                                <?php
                                $statusClass = [
                                    'Sedang Dipinjam'     => 'status-yellow',
                                    'Telah Dikembalikan'  => 'status-green',
                                    'Terlambat'           => 'status-red'
                                ];
                                $class = $statusClass[$t['status']] ?? 'status-gray';
                                ?>
                                <span class="status-badge <?= $class; ?>">
                                    <?= esc($t['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">Belum ada transaksi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="<?= base_url('peminjaman'); ?>" class="view-all-link">Lihat Semua &rarr;</a>
    </div>
</section>