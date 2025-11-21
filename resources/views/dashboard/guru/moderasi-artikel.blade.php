<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi Artikel - e-Mading Baknus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #1a5276;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 120px;
            object-fit: cover;
        }
        .btn-acc {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .btn-acc:hover {
            background-color: #218838;
        }
        .btn-reject {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        .btn-reject:hover {
            background-color: #c82333;
        }
        .btn-detail {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-detail:hover {
            background-color: #0056b3;
        }
        .section-title {
            color: #1a5276;
            border-bottom: 2px solid #1a5276;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 10px;
        }
        .status-draft {
            background-color: #ffc107;
            color: #212529;
        }
        .status-published {
            background-color: #28a745;
            color: white;
        }
        .status-rejected {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-newspaper me-2"></i>e-Mading Skolal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Moderasi Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Moderasi Komentar</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->nama }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h4 class="section-title">Moderasi Artikel</h4>
        <p class="text-muted mb-4">Berikut adalah artikel yang menunggu persetujuan Anda.</p>

        @if ($artikels->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fas fa-inbox me-2"></i> Tidak ada artikel yang menunggu moderasi.
            </div>
        @else
            <div class="row">
                @foreach ($artikels as $artikel)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <img src="https://via.placeholder.com/40?text={{ substr($artikel->penulis->nama, 0, 1) }}" 
                                         class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                    <div>
                                        <h6 class="card-title mb-0">{{ Str::limit($artikel->judul, 25) }}</h6>
                                        <p class="card-text text-muted small mb-0">
                                            Oleh: {{ $artikel->penulis->nama ?? 'Admin' }}
                                        </p>
                                        <small class="text-muted">{{ $artikel->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('artikel.detail', $artikel->id_artikel) }}" class="btn btn-detail btn-sm">
                                        <i class="fas fa-eye me-1"></i> Lihat Detail
                                    </a>
                                    <form method="POST" action="{{ route('guru.setujui', $artikel->id_artikel) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-acc btn-sm">
                                            <i class="fas fa-check me-1"></i> Setuju
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('guru.tolak', $artikel->id_artikel) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-reject btn-sm">
                                            <i class="fas fa-times me-1"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $artikels->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">© 2025 e-Mading Skolal. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-decoration-none me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-decoration-none me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-decoration-none"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Form Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>