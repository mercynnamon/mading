# Setup Database E-Mading Baknus

## 1. Buat Database MySQL

Jalankan script SQL berikut di MySQL:

```sql
-- Buka file database_mading.sql dan jalankan semua query
```

Atau import file `database_mading.sql` ke MySQL menggunakan:
```bash
mysql -u root -p < database_mading.sql
```

## 2. Konfigurasi Laravel (.env)

Update file `.env` dengan konfigurasi database:

```env
APP_NAME="E-Mading Baknus"
APP_ENV=local
APP_KEY=base64:your-app-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mading_baknus
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

SESSION_DRIVER=database
FILESYSTEM_DISK=public
```

## 3. Generate App Key

```bash
php artisan key:generate
```

## 4. Create Storage Link

```bash
php artisan storage:link
```

## 5. Default Login Credentials

### Admin
- Username: `admin`
- Password: `admin123`

### Guru  
- Username: `guru`
- Password: `guru123`

### Siswa
- Username: `siswa`
- Password: `siswa123`

## 6. Database Structure

### Tables:
- `users` - Data pengguna (admin, guru, siswa)
- `kategori` - Kategori artikel
- `artikel` - Data artikel/berita
- `like` - Data like artikel
- `komentars` - Data komentar artikel

### Default Categories:
- Berita Sekolah
- Prestasi
- Kegiatan
- Teknologi
- Olahraga
- Seni & Budaya

## 7. Run Application

```bash
php artisan serve
```

Akses aplikasi di: http://localhost:8000