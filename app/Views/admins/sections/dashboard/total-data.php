<section id="total-data">
    <div class="card-container">
        <div class="card">
            <div class="card-icon red"><i class="fas fa-book-open"></i></div>
            <div class="card-info">
                <span class="card-value"><?= $totalBuku; ?></span>
                <span class="card-label">Buku Tersedia</span>
            </div>
        </div>
        <div class="card">
            <div class="card-icon blue"><i class="fas fa-users"></i></div>
            <div class="card-info">
                <span class="card-value"><?= $totalAnggota; ?></span>
                <span class="card-label">Anggota</span>
            </div>
        </div>
        <div class="card">
            <div class="card-icon green"><i class="fas fa-retweet"></i></div>
            <div class="card-info">
                <span class="card-value"><?= $totalPeminjaman; ?></span>
                <span class="card-label">Buku Terpinjam</span>
            </div>
        </div>
    </div>
</section>