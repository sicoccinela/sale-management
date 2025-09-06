<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website SALE.IT</title>
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to bottom, #ffffff, #f4f6fb);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      overflow: hidden;
      position: relative;
    }

    /* Efek bokeh background */
    body::before {
      content: "";
      position: absolute;
      top: -50px;
      left: -50px;
      width: 200%;
      height: 200%;
      background: url('https://www.transparenttextures.com/patterns/circles.png');
      opacity: 0.2;
      z-index: 0;
    }

    .container {
      text-align: center;
      z-index: 1;
      max-width: 600px;
      padding: 20px;
    }

    .logo {
      width: 80px;
      height: 80px;
      margin: 0 auto 15px auto;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo img {
      width: 80px;
    }

    h1 {
      font-size: 28px;
      font-weight: bold;
      color: #333;
    }

    h1 span {
      color: #0d47a1;
      font-weight: 800;
    }

    p {
      font-size: 14px;
      color: #555;
      margin: 15px 0 25px 0;
      line-height: 1.6;
    }

    .btn {
      background: linear-gradient(90deg, #ff7b38, #ff914d);
      color: white;
      font-size: 14px;
      padding: 12px 25px;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .btn:hover {
      background: linear-gradient(90deg, #ff914d, #ff7b38);
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(255, 123, 56, 0.5);
    }

    /* Elemen dekorasi bulat biru */
    .circle-left, .circle-right {
      position: absolute;
      top: 40%;
      width: 80px;
      height: 160px;
      background: #0d47a1;
      border-radius: 50px;
      z-index: 0;
    }

    .circle-left {
      left: -40px;
    }

    .circle-right {
      right: -40px;
    }
  </style>
</head>
<body>
  <!-- Dekorasi -->
  <div class="circle-left"></div>
  <div class="circle-right"></div>

  <!-- Konten Utama -->
  <div class="container">
    <div class="logo">
      <img src="{{ asset('logo/logo.png') }}" alt="Logo">
    </div>
    <h1>WEBSITE <span>SALE.IT</span></h1>
    <p>
      Selamat datang di Home Dashboard sale.it yang didesain untuk memudahkan manajemen <br>
      pemesanan barang antara Sales dan Admin Perusahaan
    </p>
    <a href="{{ route('filament.sales.auth.login') }}" class="btn">LOGIN SALES</a>
  </div>
</body>
</html>