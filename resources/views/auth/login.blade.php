<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Pocket BMT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            /* Background Gambar Gedung BMT */
            background: url('/images/gedung-bmt.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        /* Overlay Gelap agar Card Pop-out */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 0;
        }

        /* MAIN CARD BESAR */
        .main-card {
            position: relative;
            z-index: 1;
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 520px;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* BAGIAN KIRI (Teks Modern) - WARNA DIUBAH KE #15803d */
        .left-panel {
            flex: 1.2;
            background: linear-gradient(135deg, #14532d 0%, #15803d 100%);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi Abstract di Kiri */
        .left-panel::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(40px);
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -40px;
            width: 250px;
            height: 250px;
            background: rgba(21, 128, 61, 0.4); /* Warna #15803d dengan opacity */
            border-radius: 50%;
            filter: blur(60px);
        }

        .brand-top {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .brand-top i {
            font-size: 24px;
            background: rgba(255,255,255,0.2);
            padding: 10px;
            border-radius: 12px;
        }

        .brand-top h1 {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .hero-text {
            position: relative;
            z-index: 2;
        }

        .hero-text h2 {
            font-size: 36px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -1px;
        }

        .hero-text p {
            font-size: 15px;
            line-height: 1.6;
            opacity: 0.9;
            font-weight: 300;
            max-width: 90%;
        }

        .footer-quote {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            opacity: 0.8;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 20px;
        }

        /* BAGIAN KANAN (Login Kecil) */
        .right-panel {
            flex: 1;
            background: #ffffff;
            padding: 50px 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-small {
            width: 100%;
            max-width: 280px;
        }

        .login-header {
            margin-bottom: 28px;
        }

        .login-header h3 {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            font-size: 13px;
            color: #6b7280;
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13px;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            background: #f9fafb;
        }

        /* Focus State Warna Hijau #15803d */
        .input-group input:focus {
            outline: none;
            border-color: #15803d;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 12px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #6b7280;
            cursor: pointer;
        }

        .remember-me input {
            accent-color: #15803d; /* Checkbox hijau */
        }

        .forgot-pass {
            color: #15803d; /* Link hijau */
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-pass:hover {
            text-decoration: underline;
        }

        /* Tombol Submit Warna Hijau #15803d */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #15803d;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-submit:hover {
            background: #14532d; /* Hijau lebih gelap saat hover */
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(21, 128, 61, 0.2);
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #6b7280;
        }

        .signup-link a {
            color: #15803d; /* Link daftar hijau */
            text-decoration: none;
            font-weight: 700;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .main-card {
                flex-direction: column;
                max-width: 400px;
            }
            .left-panel {
                padding: 40px 30px;
                min-height: 250px;
            }
            .hero-text h2 {
                font-size: 28px;
            }
            .right-panel {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

    <!-- MAIN CARD -->
    <div class="main-card">
        
        <!-- BAGIAN KIRI: Teks Modern & Branding -->
        <div class="left-panel">
            <div class="brand-top">
                <i class="fas fa-wallet"></i>
                <h1>Smart Pocket</h1>
            </div>

            <div class="hero-text">
                <h2>Masa Depan Dimulai dari Tabungan Hari Ini.</h2>
                <p>Smart Pocket menghadirkan pengalaman perbankan digital yang aman, cepat, dan transparan khusus untuk warga SMKN 11 Bandung.</p>
            </div>

            <div class="footer-quote">
                <i class="fas fa-quote-left"></i>
                <span>"Menabung bukan tentang seberapa banyak, tapi seberapa konsisten."</span>
            </div>
        </div>

        <!-- BAGIAN KANAN: Form Login Kecil -->
        <div class="right-panel">
            <div class="login-small">
                <div class="login-header">
                    <h3>Welcome Back</h3>
                    <p>Silakan masuk ke akun Anda</p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="cth: siswa123" required autofocus>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            Ingat saya
                        </label>
                        <a href="#" class="forgot-pass">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn-submit">Masuk Sekarang</button>
                </form>

                <p class="signup-link">
                    Belum punya akun? <a href="#">Daftar di sini</a>
                </p>
            </div>
        </div>

    </div>

</body>
</html>