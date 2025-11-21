<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel - Admin E-Mading</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .navbar-brand, .nav-link { color: white !important; }
        .card { border: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 15px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-newspaper me-2"></i>Kelola Artikel
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('admin.users') }}">Users</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h4><i class="fas fa-newspaper me-2"></i>Semua Artikel</h4>
            </div>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.artikel') }}" class="btn btn-outline-primary {{ !request('filter') ? 'active' : '' }}">Semua</a>
                <a href="{{ route('admin.artikel') }}?filter=guru" class="btn btn-outline-success {{ request('filter') == 'guru' ? 'active' : '' }}">Guru</a>
                <a href="{{ route('admin.artikel') }}?filter=siswa" class="btn btn-outline-info {{ request('filter') == 'siswa' ? 'active' : '' }}">Siswa</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artikel as $item)
                                <tr>
                                    <td>{{ Str::limit($item->judul, 50) }}</td>
                                    <td>
                                        {{ $item->penulis->nama }}
                                        <br><small class="badge bg-{{ $item->penulis->role == 'guru' ? 'success' : 'info' }}">{{ ucfirst($item->penulis->role) }}</small>
                                    </td>
                                    <td>{{ $item->kategori->nama_kategori }}</td>
                                    <td>
                                        @if($item->status == 'publish')
                                            <span class="badge bg-success">Publish</span>
                                        @elseif($item->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.artikel.detail', $item->id_artikel) }}?back={{ urlencode(request()->fullUrl()) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($item->status == 'pending')
                                            <form method="POST" action="{{ route('artikel.approve', $item->id_artikel) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('artikel.reject', $item->id_artikel) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>