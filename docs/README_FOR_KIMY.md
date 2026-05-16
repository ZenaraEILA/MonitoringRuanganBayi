# 📚 DOKUMENTASI LENGKAP - UNTUK KIMY AI (Server Admin)

Halo Kimy! Berikut adalah dokumentasi lengkap untuk setup aplikasi monitoring suhu ruangan bayi di server. Silahkan ikuti step by step.

---

## 📖 FILE-FILE PENTING YANG HARUS DIBACA (dalam urutan):

### 1️⃣ **QUICK_SETUP_CHECKLIST.txt** ⭐ BACA INI DULU
   - Ringkasan singkat apa yang harus di-setup
   - 3 akun login yang harus dibuat
   - 1 device sensor yang harus di-register
   - Cara quick setup

### 2️⃣ **SERVER_SETUP_GUIDE_FOR_KIMY.md** - BACA INI UNTUK DETAIL
   - Penjelasan lengkap tabel database (users, devices, monitorings)
   - Struktur kolom setiap tabel
   - Data akun dengan detail lengkap
   - Data device dengan spesifikasi lengkap
   - SQL queries manual jika perlu

### 3️⃣ **SETUP_PRODUCTION_DATA.sql** - FILE SQL READY-TO-USE
   - Copy paste langsung ke MySQL terminal
   - Udah include 3 akun + 1 device
   - Tinggal paste dan jalankan

### 4️⃣ **ESP8266_PRODUCTION_CONFIG.md** - UNTUK HARDWARE SETUP
   - Konfigurasi ESP8266 agar connect ke server
   - API endpoint yang harus di-hit
   - Sample code Arduino
   - Debugging tips

### 5️⃣ **SEEDER_PRODUCTION_GUIDE.md** - ALTERNATIVE SETUP (Pakai Laravel)
   - Jika lebih nyaman pakai Artisan command
   - Lebih aman dari manual SQL

---

## 🚀 STEP-BY-STEP SETUP PROCEDURE:

### LANGKAH 1: Pastikan Database Server Sudah Ready
```bash
# Login ke MySQL server
mysql -u root -p

# Create database jika belum ada
CREATE DATABASE monitoring_bayi_rs;
USE monitoring_bayi_rs;

# Exit
exit;
```

### LANGKAH 2: Upload Aplikasi ke Server
```bash
# Copy project ke /home/seraviel/www/monitoring-suhu/
cd /home/seraviel/www/monitoring-suhu/

# Check struktur folder
ls -la
```

### LANGKAH 3: Setup Environment & Dependencies
```bash
# Copy environment file
cp .env.example .env

# Edit .env sesuai server
nano .env
# Isi:
# DB_HOST=localhost
# DB_DATABASE=monitoring_bayi_rs
# DB_USERNAME=root
# DB_PASSWORD=YOUR_PASSWORD

# Generate Laravel key
php artisan key:generate

# Install composer dependencies
composer install
```

### LANGKAH 4: Run Database Migrations
```bash
# Jalankan migrations (setup tabel database)
php artisan migrate

# Verify tabel sudah created
mysql -u root -p monitoring_bayi_rs -e "SHOW TABLES;"
```

### LANGKAH 5: Setup Data (PILIH SALAH SATU):

**OPSI A: Pakai Seeder Laravel (RECOMMENDED)**
```bash
php artisan db:seed --class=ProductionUserSeeder
php artisan db:seed --class=ProductionDeviceSeeder

# Verify
php artisan tinker
>>> App\Models\User::all();    # Harus ada 3 user
>>> App\Models\Device::all();  # Harus ada 1 device
>>> exit
```

**OPSI B: Pakai SQL Manual**
```bash
# Copy content SETUP_PRODUCTION_DATA.sql
nano setup.sql

# Paste content, save (Ctrl+X -> Y)

# Run SQL
mysql -u root -p monitoring_bayi_rs < setup.sql

# Verify
mysql -u root -p monitoring_bayi_rs -e "SELECT * FROM users; SELECT * FROM devices;"
```

### LANGKAH 6: Test Application
```bash
# Start development server
php artisan serve --host=0.0.0.0 --port=8000

# atau gunakan production server (nginx/apache)
# Ensure .env APP_URL sesuai dengan server IP

# Buka browser: http://192.168.137.67:8000/login
# Test login:
#   Username: admin
#   Password: Admin123!@#
```

### LANGKAH 7: Configure Web Server (Nginx/Apache)
```bash
# Untuk production, setup nginx/apache virtual host
# Pastikan pointing ke /public directory

# Contoh Nginx:
server {
    listen 80;
    server_name 192.168.137.67;
    root /home/seraviel/www/monitoring-suhu/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### LANGKAH 8: Configure ESP8266 Devices
- Baca file: **ESP8266_PRODUCTION_CONFIG.md**
- Update di ESP8266 code:
  - Device ID: `DEVICE-BAYI-001`
  - Server URL: `http://192.168.137.67/api/monitoring/store`
  - Update WiFi SSID & Password
  - Upload ke device menggunakan Arduino IDE

### LANGKAH 9: Verify Semuanya Jalan
```bash
# Check logs
tail -f storage/logs/laravel.log

# Monitor database queries (optional)
# Buka phpmyadmin atau MySQL client dan check:
# - users table (harus ada 3 record)
# - devices table (harus ada 1 record)
# - monitorings table (harus mulai terekam data dari ESP8266)
```

---

## 📊 VERIFIKASI CHECKLIST:

- [ ] Database `monitoring_bayi_rs` sudah created
- [ ] Semua migrations sudah berjalan
- [ ] Tabel `users` ada 3 record (admin, petugas, doctor)
- [ ] Tabel `devices` ada 1 record (DEVICE-BAYI-001)
- [ ] Login aplikasi berhasil dengan akun admin
- [ ] Dashboard tampil tanpa error
- [ ] ESP8266 connected dan mulai send data
- [ ] Data suhu mulai terekam di tabel `monitorings`
- [ ] Chart monitoring tempat menampilkan data real-time
- [ ] AC control API tested (manual test AC on/off command)

---

## ⚠️ IMPORTANT NOTES:

1. **Password Harus Di-Change**
   ```bash
   php artisan tinker
   >>> $user = App\Models\User::find(1);
   >>> $user->password = Hash::make('PASSWORD_BARU_YANG_KUAT');
   >>> $user->save();
   >>> exit
   ```

2. **Update AC Controller Configuration**
   - File: Database `devices` table
   - Update kolom `ac_api_url` & `ac_api_key` sesuai hardware Anda
   ```sql
   UPDATE devices SET 
   ac_api_url = 'http://192.168.1.100/api/control',
   ac_api_key = 'key-ac-001-secret-baru'
   WHERE device_id = 'DEVICE-BAYI-001';
   ```

3. **Backup Database Sebelum Production**
   ```bash
   mysqldump -u root -p monitoring_bayi_rs > backup_$(date +%Y%m%d_%H%M%S).sql
   ```

4. **Enable CORS jika Frontend Terpisah**
   - Edit `.env`: `FRONT_END_URL=http://frontend-ip/`
   - Edit `config/cors.php` sesuai kebutuhan

5. **Setup SSL Certificate (HTTPS)**
   ```bash
   # Gunakan Let's Encrypt
   sudo certbot certonly --standalone -d monitoring.rs-ip.local
   # Configurable di web server (nginx/apache)
   ```

---

## 🆘 TROUBLESHOOTING:

### Masalah: "Database connection failed"
```
Solusi: Check .env DB_HOST, DB_USERNAME, DB_PASSWORD
```

### Masalah: "Table not found"
```
Solusi: Jalankan: php artisan migrate
```

### Masalah: "Login gagal dengan akun admin"
```
Solusi: Verify users table ada data, check password hash dengan:
php artisan tinker
>>> App\Models\User::where('username', 'admin')->first();
```

### Masalah: "ESP8266 tidak bisa send data"
```
Solusi:
1. Cek WiFi connection di ESP8266
2. Cek IP server correct
3. Verify device_id sama dengan database
4. Test manual: curl -X POST http://192.168.137.67/api/monitoring/store ...
```

### Masalah: "AC control tidak bekerja"
```
Solusi:
1. Verify ac_api_url benar
2. Test API call ke AC controller manual
3. Check API key di database
```

---

## 📞 CONTACT FOR HELP:

Jika ada error atau masalah:
1. Check file `storage/logs/laravel.log` untuk error details
2. Check browser console (F12) untuk frontend errors
3. Test API endpoints dengan Postman
4. Hubungi developer dengan:
   - Error message lengkap
   - Screenshot
   - Step yang sudah dilakukan

---

**Semoga sukses setup server production! 🚀**

Setiap langkah sudah dijelaskan dengan detail. Mulai dari QUICK_SETUP_CHECKLIST.txt untuk overview, 
kemudian baca SERVER_SETUP_GUIDE_FOR_KIMY.md untuk detail lengkap. 

Good luck!
