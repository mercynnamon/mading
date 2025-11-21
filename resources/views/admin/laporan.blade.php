<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Detail - Admin E-Mading</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            padding: 15px 0;
        }
        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 3s infinite;
        }
        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
        }
        .navbar-brand i {
            animation: pulse 2s infinite;
        }
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }
        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }
        .nav-link.active {
            color: white !important;
            font-weight: 600;
        }
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>') repeat;
            animation: float 20s infinite linear;
        }
        @keyframes float {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(100px); }
        }
        .hero-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }
        .hero-subtitle {
            opacity: 0.9;
            margin-bottom: 0;
            position: relative;
            z-index: 2;
        }
        .btn-outline-light {
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }
        .btn-outline-light:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-chart-line me-2"></i>
                <span>Laporan</span>
                <span style="color: #ffd700;">Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.laporan') }}">Laporan</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="text-white me-2 small">{{ Auth::user()->nama }}</span>
                    <a href="{{ route('admin.profil') }}" class="btn btn-outline-light btn-sm me-1" title="Profil">
                        <i class="fas fa-user"></i>
                    </a>
                    <button onclick="document.getElementById('logout-form').submit();" class="btn btn-outline-light btn-sm" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="mb-0"><i class="fas fa-chart-line me-2"></i>Laporan Detail</h4>
        </div>
        
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="hero-title"><i class="fas fa-chart-bar me-3"></i>Laporan Sistem E-Mading</h1>
                    <p class="hero-subtitle">Analisis lengkap aktivitas dan statistik platform</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="hero-stats">
                        <button class="btn btn-outline-light" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i>Artikel Published per Hari (7 Hari Terakhir)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-chart-area me-2"></i>Artikel Published per Bulan (6 Bulan Terakhir)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Artikel per Kategori</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">Artikel per Hari</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($artikelPerHari as $data)
                                    <tr>
                                        <td>{{ $data['tanggal'] }}</td>
                                        <td class="text-center">{{ $data['jumlah'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">Artikel per Bulan</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bulan</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($artikelPerBulan as $data)
                                    <tr>
                                        <td>{{ $data['bulan'] }}</td>
                                        <td class="text-center">{{ $data['jumlah'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h6 class="mb-0">Artikel per Kategori</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kategori</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($artikelPerKategori as $kategori)
                                    <tr>
                                        <td>{{ $kategori->nama_kategori }}</td>
                                        <td class="text-center">{{ $kategori->artikel_count }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">© 2025 E-Mading Baknus. cindyyuliani091@gmail.com All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="https://www.facebook.com/Smkbn666/?locale=id_ID" class="text-decoration-none me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@smkbaktinusantara666" class="text-decoration-none me-3"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.instagram.com/smkbaktinusantara666/" class="text-decoration-none"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Daily Chart
        const dailyCtx = document.getElementById('dailyChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($artikelPerHari, 'tanggal')) !!},
                datasets: [{
                    label: 'Artikel Published',
                    data: {!! json_encode(array_column($artikelPerHari, 'jumlah')) !!},
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Monthly Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($artikelPerBulan, 'bulan')) !!},
                datasets: [{
                    label: 'Artikel Published',
                    data: {!! json_encode(array_column($artikelPerBulan, 'jumlah')) !!},
                    backgroundColor: '#28a745'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($artikelPerKategori->pluck('nama_kategori')) !!},
                datasets: [{
                    data: {!! json_encode($artikelPerKategori->pluck('artikel_count')) !!},
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>