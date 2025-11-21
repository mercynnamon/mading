<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Mading baknus - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-wrapper {
            max-width: 900px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }
        .login-image {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9)), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 60px 40px;
        }
        .login-form {
            padding: 60px 50px;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo h3 {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
            font-size: 2rem;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: bold;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .welcome-text {
            color: #495057;
            font-weight: 600;
        }
        .subtitle {
            color: #6c757d;
        }
        .links a {
            color: #667eea;
            transition: color 0.3s ease;
        }
        .links a:hover {
            color: #764ba2;
        }
        .form-select, .form-control {
            padding-left: 50px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="row g-0 h-100">
            <!-- Image Section -->
            <div class="col-md-6">
                <div class="login-image h-100">
                    <div>
                        <div class="mb-4">
                            <i class="fas fa-graduation-cap" style="font-size: 4rem; margin-bottom: 20px;"></i>
                        </div>
                        <h2 class="fw-bold mb-3">E-Mading Baknus</h2>
                        <p class="fs-5 mb-4">Platform Digital Magazine SMK Bakti Nusantara 666</p>
                        <div class="d-flex justify-content-center gap-4">

                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Section -->
            <div class="col-md-6">
                <div class="login-form">
                    <div class="text-center mb-4">
                        <h3 class="welcome-text mb-2">Selamat Datang!</h3>
                        <p class="subtitle">Masuk untuk Berbagi & Berkreasi</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <div class="position-relative">
                                <i class="fas fa-user position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #667eea; z-index: 10;"></i>
                                <input type="text" id="username" name="username" class="form-control ps-5" placeholder="Masukkan username" value="{{ old('username') }}" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="position-relative">
                                <i class="fas fa-lock position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #667eea; z-index: 10;"></i>
                                <input type="password" id="password" name="password" class="form-control ps-5" placeholder="Masukkan password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-login mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>LOGIN
                        </button>
                    </form>

                    <div class="text-center links">
                        <div class="mb-2">
                            <a href="#" class="text-decoration-none">Lupa Password?</a>
                        </div>
                        <div>
                            Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>