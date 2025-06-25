<section id="buku-terbaru" class="section-buku-terbaru">
    <div class="recent-data-card">
        <h2>Buku Terbaru</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bukuTerbaru)) : ?>
                    <?php foreach ($bukuTerbaru as $b): ?>
                        <tr>
                            <td><?= esc($b['judul_buku']); ?></td>
                            <td><?= esc($b['penulis']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2">Belum ada data buku.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
        <a href="<?= base_url('buku'); ?>" class="view-all-link">Lihat Semua &rarr;</a>
    </div>
</section>