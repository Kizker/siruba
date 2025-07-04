<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIRUBA | Sistem Administrasi Ruang Baca</title>
  <link rel="icon" href="/assets/img/favicon.ico" type="image/png">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-image: url('/assets/img/perpustakaan.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 40px 30px;
      border-radius: 20px;
      text-align: center;
      max-width: 380px;
      width: 90%;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      animation: fadeInUp 1s ease-out forwards;
      opacity: 0;
    }

    .login-container img {
      width: 220px;
      margin-bottom: 30px;
      animation: fadeIn 1.5s ease-out;
    }

    .btn {
      display: block;
      width: 100%;
      background-color: #2c2262;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      margin-top: 15px;
    }

    .btn:hover {
      background-color: #463a9b;
      transform: scale(1.02);
    }

    .btn.daftar {
      background-color: #dbdbdb;
      color: #2c2262;
    }

    .btn.daftar:hover {
      background-color: #c5c5c5;
    }

    @keyframes fadeInUp {
      from {
        transform: translateY(40px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 30px 20px;
      }

      .login-container img {
        width: 160px;
        margin-bottom: 20px;
      }

      .btn {
        font-size: 15px;
        padding: 10px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <img src="/assets/img/siruba.png" alt="Logo SIRUBA" />
    <a href="masuk" class="btn">Masuk</a>
    <a href="daftar" class="btn daftar">Daftar Akun</a>
  </div>
</body>

</html>