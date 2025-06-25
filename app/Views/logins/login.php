<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIRUBA | Sistem Administrasi Ruang Baca</title>
  <link rel="icon" href="/assets/img/favicon.ico" type="image/png">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-image: url('/assets/img/perpustakaan.jpg');
      background-size: cover;
      background-position: center;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      max-width: 400px;
      width: 90%;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      animation: fadeInUp 1s ease-out;
      opacity: 0;
      animation-fill-mode: forwards;
    }

    .login-container img {
      width: 400px;
      margin-bottom: 40px;
      animation: fadeIn 1.5s ease-out;
    }

    .login-container h1 {
      font-size: 26px;
      color: #2c2262;
      margin-bottom: 5px;
    }

    .login-container p {
      font-size: 14px;
      color: #555;
      margin-bottom: 25px;
    }

    .btn {
      display: block;
      width: 100%;
      background-color: #2c2262;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 7px;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .btn:hover {
      background-color: #463a9b;
      transform: scale(1.03);
    }

    .btn.daftar {
      background-color: #dbdbdb;
      color: #2c2262;
    }

    .btn.daftar:hover {
      background-color: #c5c5c5;
      transform: scale(1.03);
    }

    @keyframes fadeInUp {
      0% {
        transform: translateY(30px);
        opacity: 0;
      }

      100% {
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
      }

      .login-container h1 {
        font-size: 22px;
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