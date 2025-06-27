<!DOCTYPE html>
<html lang="id">

<?= $this->include('admins/sections/head'); ?>

<body>
    <div class="container">

        <?= $this->include('admins/sections/sidebar'); ?>

        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <h1>Dashboard</h1>
                </div>
                <div class="header-right">
                    <span>Hai, <?= esc(session('nama_admin') ?? 'Administrator') ?> 👋</span>
                </div>
            </header>

            <div class="content-wrapper">

                <?= $this->include('admins/sections/dashboard/total-data'); ?>

                <div class="recent-data-container">

                    <?= $this->include('admins/sections/dashboard/buku-terbaru'); ?>
                    <?= $this->include('admins/sections/dashboard/anggota-terbaru'); ?>
                    <?= $this->include('admins/sections/dashboard/peminjaman-terbaru'); ?>

                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/main.js"></script>
</body>

</html>