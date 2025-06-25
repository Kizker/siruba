<header class="main-header">
    <div class="header-inner">
        <!-- Logo -->
        <div class="logo">
            <a href="/">
                <img src="/assets/img/siruba-putih.png" alt="Logo SIRUBA" class="logo-img" />
            </a>
        </div>

        <!-- Navigasi Tengah -->
        <nav class="nav-menu center-nav">
            <ul>
                <li><a href="/">Beranda</a></li>
                <li><a href="/buku">Buku</a></li>
                <li><a href="/profil">Profil</a></li>
            </ul>
        </nav>

        <!-- Info Akun Kanan -->
        <div class="account-info">
            <?php if (session()->get('isLoggedIn')): ?>
                <span class="user-name">Hai, <?= esc(session('user_nama')) ?></span>
                <img src="/assets/img/profile/<?= esc(session('user_foto')) ?>"
                    alt="Foto Profil"
                    title="<?= esc(session('user_nama')) ?>"
                    class="profile-img" />
            <?php endif; ?>
        </div>
    </div>
</header>