<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Buat Artikel Baru - e-Mading Baknus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .form-container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>') repeat;
            animation: float 20s infinite linear;
        }
        .form-header h4 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
        }
        .form-header p {
            opacity: 0.95;
            margin-bottom: 0;
            font-size: 0.95rem;
            position: relative;
            z-index: 2;
        }
        .header-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            opacity: 0.8;
            position: relative;
            z-index: 2;
        }
        @keyframes float {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(100px); }
        }
        .form-body {
            padding: 40px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-control[type="file"] {
            padding: 12px 20px;
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }
        .btn-back {
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 50px;
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 3;
        }
        .btn-back:hover {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
            color: white;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .upload-area {
            border: 2px dashed #667eea;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            background: #f8f9ff;
            transition: all 0.3s ease;
        }
        .upload-area:hover {
            border-color: #764ba2;
            background: #f0f2ff;
        }
        .upload-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 15px;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .section-title {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f2ff;
        }
        .char-counter {
            font-size: 0.85rem;
            color: #6c757d;
            text-align: right;
            margin-top: 5px;
        }
        .preview-container {
            display: none;
            margin-top: 15px;
        }
        .preview-image {
            max-width: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-feather-alt me-2"></i>
                <span>Buat</span>
                <span style="color: #ffd700;">Artikel</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @php
                        $dashboardUrl = match(Auth::user()->role) {
                            'admin' => route('admin.dashboard'),
                            'guru' => route('guru.dashboard'),
                            'siswa' => route('siswa.dashboard'),
                            default => route('login')
                        };
                    @endphp
                    <li class="nav-item"><a class="nav-link" href="{{ $dashboardUrl }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('siswa.artikel-saya') }}">Artikel Saya</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Buat Artikel</a></li>
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

    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <div class="position-absolute" style="top: 20px; left: 20px; z-index: 3;">
                    @php
                        $backUrl = match(Auth::user()->role) {
                            'admin' => route('admin.dashboard'),
                            'guru' => route('guru.dashboard'),
                            'siswa' => route('siswa.dashboard'),
                            default => route('login')
                        };
                    @endphp
                    <a href="{{ $backUrl }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <h4>Buat Artikel Baru</h4>
                <p>Bagikan ide dan kreativitas Anda dengan dunia</p>
            </div>

            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ match(Auth::user()->role) { 'admin' => route('admin.artikel.store'), 'guru' => route('guru.artikel.store'), 'siswa' => route('siswa.artikel.store'), default => route('artikel.store') } }}" enctype="multipart/form-data" id="articleForm">
                    @csrf

                    <div class="form-section">
                        <h6 class="section-title"><i class="fas fa-heading me-2"></i>Informasi Dasar</h6>
                        
                        <div class="mb-4">
                            <label for="judul" class="form-label">Judul Artikel</label>
                            <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul') }}" 
                                   placeholder="Masukkan judul artikel yang menarik..." maxlength="255" required>
                            <div class="char-counter">
                                <span id="judulCount">0</span>/255 karakter
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select id="id_kategori" name="id_kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori Artikel --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-section">
                        <h6 class="section-title"><i class="fas fa-edit me-2"></i>Konten Artikel</h6>
                        
                        <div class="mb-4">
                            <label for="isi" class="form-label">Isi Artikel</label>
                            <textarea id="isi" name="isi" class="form-control" rows="12" 
                                      placeholder="Tulis artikel Anda di sini... Ceritakan dengan detail dan menarik!" required>{{ old('isi') }}</textarea>
                            <div class="char-counter">
                                <span id="isiCount">0</span> karakter
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h6 class="section-title"><i class="fas fa-image me-2"></i>Media Pendukung</h6>
                        
                        <div class="mb-4">
                            <label for="foto" class="form-label">Upload Foto Artikel (Opsional)</label>
                            <div class="upload-area" onclick="document.getElementById('foto').click()">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h6>Klik untuk upload foto</h6>
                                <p class="text-muted mb-0">Maksimal 2MB • Format: JPEG, PNG, WebP</p>
                                <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
                            </div>
                            <div class="preview-container" id="previewContainer">
                                <img id="previewImage" class="preview-image" alt="Preview">
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>Publikasikan Artikel
                        </button>
                        <p class="text-muted mt-3 mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Artikel akan direview oleh guru sebelum dipublikasi
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Character counter for title
        document.getElementById('judul').addEventListener('input', function() {
            const count = this.value.length;
            document.getElementById('judulCount').textContent = count;
        });
        
        // Character counter for content
        document.getElementById('isi').addEventListener('input', function() {
            const count = this.value.length;
            document.getElementById('isiCount').textContent = count;
        });
        
        // Image preview
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('previewContainer').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Initialize character counters
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('judulCount').textContent = document.getElementById('judul').value.length;
            document.getElementById('isiCount').textContent = document.getElementById('isi').value.length;
            
            // Handle browser back button
            window.addEventListener('popstate', function(event) {
                // Redirect to appropriate dashboard based on user role
                const userRole = '{{ Auth::user()->role }}';
                let redirectUrl;
                
                switch(userRole) {
                    case 'admin':
                        redirectUrl = '{{ route("admin.dashboard") }}';
                        break;
                    case 'guru':
                        redirectUrl = '{{ route("guru.dashboard") }}';
                        break;
                    case 'siswa':
                        redirectUrl = '{{ route("siswa.dashboard") }}';
                        break;
                    default:
                        redirectUrl = '{{ route("login") }}';
                }
                
                window.location.href = redirectUrl;
            });
            
            // Push state to handle back button properly
            history.pushState(null, null, window.location.href);
        });
    </script>
</body>
</html>