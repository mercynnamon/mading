<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Guru - E-Mading</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 600;
        }
        .profile-card {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 3rem;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 15px;
        }
        .dropdown-menu {
            z-index: 9999 !important;
        }
        .navbar .dropdown {
            z-index: 1050;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('guru.dashboard') }}">
                <i class="fas fa-user me-2"></i>Guru - Profil
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('guru.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('guru.profil') }}">Profil</a></li>
                </ul>
                <div class="d-flex align-items-center ms-3">
                    <span class="text-white me-3">{{ Auth::user()->nama }}</span>
                    <a href="{{ route('guru.profil') }}" class="btn btn-outline-light btn-sm me-2">
                        <i class="fas fa-user"></i>
                    </a>
                    <button onclick="document.getElementById('logout-form').submit();" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="mb-0"><i class="fas fa-user me-2"></i>Profil Guru</h4>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="profile-avatar">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4>{{ Auth::user()->nama }}</h4>
                    <p class="mb-2">Guru</p>
                    <small>Bergabung: {{ Auth::user()->created_at->format('d M Y') }}</small>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Profil</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('guru.profil.update') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="{{ Auth::user()->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="{{ Auth::user()->username }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <input type="text" class="form-control" value="Guru" readonly>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Saya</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <h3 class="text-primary">{{ \App\Models\Artikel::where('id_user', auth()->user()->id_user)->count() }}</h3>
                                <p class="text-muted">Artikel Saya</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-success">{{ \App\Models\Artikel::where('id_user', auth()->user()->id_user)->where('status', 'publish')->count() }}</h3>
                                <p class="text-muted">Published</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-danger">{{ \App\Models\Artikel::whereHas('likes', function($q) { $q->where('id_user', auth()->user()->id_user); })->count() }}</h3>
                                <p class="text-muted">Artikel Disukai</p>
                            </div>
                            <div class="col-md-3">
                                <h3 class="text-warning">{{ \App\Models\Komentar::where('id_user', auth()->user()->id_user)->count() }}</h3>
                                <p class="text-muted">Komentar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>