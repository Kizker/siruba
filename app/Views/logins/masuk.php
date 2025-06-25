<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIRUBA | Sistem Administrasi Ruang Baca</title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="icon" href="/assets/img/favicon.ico" type="image/png">

  <!-- Google Fonts -->
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
  </style>
</head>

<body>
  <div class="form-container">
    <img src="/assets/img/siruba.png" alt="Logo Siruba" />

    <!-- Tampilkan error jika ada -->
    <?php if (session('error')): ?>
      <div style="color: red; margin-bottom: 10px;"><?= session('error') ?></div>
    <?php endif; ?>

    <form action="/login/cek" method="POST">
      <div style="margin-bottom: 10px;">
        <label for="username">Email atau NPM</label><br>
        <input type="text" id="username" name="username" placeholder="Masukkan Email atau NPM" required />
      </div>

      <div style="margin-bottom: 10px;">
        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" placeholder="Masukkan Password" required />
      </div>

      <button type="submit">Masuk</button>
    </form>
  </div>
</body>

</html>