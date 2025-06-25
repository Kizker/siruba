<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIRUBA | Sistem Administrasi Ruang Baca</title>
  <link rel="icon" href="/assets/img/favicon.ico" type="image/png">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('/assets/img/perpustakaan.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.95);
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 420px;
      animation: fadeIn 0.9s ease-out;
      text-align: center;
    }

    .form-container img {
      width: 85px;
      margin-bottom: 10px;
    }

    .form-container h2 {
      color: #1f2d5a;
      font-size: 26px;
      margin-bottom: 5px;
    }

    .form-container p {
      font-size: 14px;
      color: #555;
      margin-bottom: 25px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    input {
      padding: 12px 15px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    input:focus {
      border-color: #1f2d5a;
      outline: none;
      box-shadow: 0 0 0 3px rgba(31, 45, 90, 0.1);
    }

    button {
      background-color: #1f2d5a;
      color: white;
      padding: 13px;
      font-size: 15px;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #2e4180;
    }

    .back-link {
      margin-top: 18px;
      font-size: 14px;
      color: #1f2d5a;
      text-decoration: none;
      transition: color 0.3s ease;
      display: inline-block;
    }

    .back-link:hover {
      color: #f59e0b;
    }

    .alert {
      padding: 12px 15px;
      margin-bottom: 18px;
      border-radius: 8px;
      font-size: 14px;
      text-align: left;
    }

    .alert-error {
      background-color: #ffe5e5;
      color: #cc0000;
    }

    .alert-success {
      background-color: #e7fbe7;
      color: #2e7d32;
    }

    @keyframes fadeIn {
      from {
        transform: translateY(40px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @media (max-width: 480px) {
      .form-container {
        padding: 30px 20px;
      }

      .form-container h2 {
        font-size: 22px;
      }

      input,
      button {
        font-size: 14px;
      }
    }

    textarea {
      padding: 12px 15px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 10px;
      transition: all 0.3s ease;
      resize: vertical;
      min-height: 80px;
      font-family: 'Poppins', sans-serif;
    }

    textarea:focus {
      border-color: #1f2d5a;
      outline: none;
      box-shadow: 0 0 0 3px rgba(31, 45, 90, 0.1);
    }
  </style>
</head>

<body>
  <div class="form-container">
    <img src="/assets/img/siruba.png" alt="Logo SIRUBA" />
    <h2>Daftar Akun</h2>
    <p>Buat akun untuk mengakses SIRUBA</p>

    <!-- Flash Success -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <!-- Flash Error -->
    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert-error">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
          <div><?= esc($error) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Form Pendaftaran -->
    <form action="<?= site_url('/daftar') ?>" method="POST">
      <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= old('nama_lengkap') ?>" required />
      <input type="email" name="email" placeholder="Email" value="<?= old('email') ?>" required />
      <input type="text" name="npm" placeholder="NPM" value="<?= old('npm') ?>" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="password" name="confirm_password" placeholder="Ulangi Password" required />
      <input type="text" name="nomor_telepon" placeholder="Nomor Telepon">
      <textarea name="alamat" placeholder="Alamat" rows="3"></textarea>
      <button type="submit">Daftar</button>
    </form>


    <a href="<?= site_url('/masuk') ?>" class="back-link">Sudah punya akun? Masuk di sini</a>
  </div>
</body>

</html>