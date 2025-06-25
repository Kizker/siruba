<section id="anggota-terbaru">
    <div class="recent-data-card">
        <h2>Anggota Terbaru</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($anggotaTerbaru)) : ?>
                    <?php foreach ($anggotaTerbaru as $a): ?>
                        <tr>
                            <td><?= esc($a['nama_lengkap']); ?></td>
                            <td>
                                <span class="status-badge <?= strtolower($a['status']) === 'aktif' ? 'status-blue' : 'status-red'; ?>">
                                    <?= esc($a['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2">Belum ada data anggota.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="<?= base_url('anggota'); ?>" class="view-all-link">Lihat Semua &rarr;</a>
    </div>
</section>