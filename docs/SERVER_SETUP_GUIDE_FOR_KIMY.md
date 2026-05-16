# 📋 Struktur Database & Data yang Harus Di-Setup di Server

## 1️⃣ TABEL DATABASE (Schema)

### A. Tabel `users`
**Fungsi**: Menyimpan data akun login sistem

**Struktur Kolom**:
```
id                    | BigInt (Primary Key)
name                  | String (Nama lengkap user)
username              | String Unique (Username login)
email                 | String Unique (Email user)
password              | String (Password ter-hash bcrypt)
role                  | Enum('admin', 'petugas', 'doctor') - Tipe akun
phone                 | String (Nomor telpon)
hospital_id           | String Unique (ID Rumah Sakit)
security_code         | String (Kode keamanan)
is_active             | Boolean (Status aktif/non-aktif)
profile_photo_path    | String (Path foto profil)
email_verified_at     | Timestamp (Email verification)
last_login_at         | Timestamp (Terakhir login)
remember_token        | String (Token remember me)
created_at            | Timestamp (Dibuat tanggal)
updated_at            | Timestamp (Diupdate tanggal)
```

---

### B. Tabel `devices`
**Fungsi**: Menyimpan data sensor IoT/ESP8266 yang monitoring suhu ruangan

**Struktur Kolom**:
```
id                        | BigInt (Primary Key)
device_name               | String (Nama sensor, mis: "Sensor Ruangan Bayi Unit 1")
location                  | String (Lokasi sensor, mis: "Ruang Perawatan Bayi - Bed 1")
device_id                 | String Unique (ID unik device, mis: "DEVICE-BAYI-001")
stability_status          | String (Status: stable/unstable/warning)
stability_score           | Integer (Skor 0-100)
early_warning_patterns    | JSON (Pola peringatan dini)
last_stability_check      | Timestamp (Pengecekan terakhir)
ac_enabled                | Boolean (AC kontrol aktif?)
ac_set_point              | Decimal (Suhu set point AC, default 24°C)
ac_status                 | Boolean (Status AC on/off)
ac_min_temp               | Decimal (Suhu minimum AC range)
ac_max_temp               | Decimal (Suhu maksimum AC range)
ac_api_url                | String (URL API kontroler AC)
ac_api_key                | String (API Key untuk kontrol AC)
created_at                | Timestamp (Dibuat tanggal)
updated_at                | Timestamp (Diupdate tanggal)
```

---

### C. Tabel `monitorings`
**Fungsi**: Menyimpan data real-time pembacaan sensor

**Struktur Kolom**:
```
id              | BigInt (Primary Key)
device_id       | BigInt (Foreign Key ke devices table)
temperature     | Decimal (Suhu dalam °C)
humidity        | Decimal (Kelembaban dalam %)
pressure        | Decimal (Tekanan udara)
recorded_at     | Timestamp (Waktu pembacaan)
created_at      | Timestamp
updated_at      | Timestamp
```

---

## 2️⃣ DATA AKUN (Users) yang Harus Dibuat

### Setup 3 Akun Login:

```
┌─────────────────────────────────────────────────────────────────┐
│                     AKUN 1: ADMIN                              │
├─────────────────────────────────────────────────────────────────┤
│ Nama Lengkap      : Administrator                              │
│ Username          : admin                                       │
│ Email             : admin@rs-monitoring.local                  │
│ Password          : Admin123!@#                                │
│ Role              : admin                                       │
│ Phone             : 08123456789                                │
│ Hospital ID       : RS-001                                     │
│ Security Code     : SEC-ADMIN-001                              │
│ Status            : Aktif (is_active = true)                   │
│ Fungsi            : Akses penuh sistem, bisa edit semua user   │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                   AKUN 2: PETUGAS/OPERATOR                      │
├─────────────────────────────────────────────────────────────────┤
│ Nama Lengkap      : Petugas Monitoring                          │
│ Username          : petugas                                     │
│ Email             : petugas@rs-monitoring.local                │
│ Password          : Petugas123!@#                              │
│ Role              : petugas                                     │
│ Phone             : 08123456790                                │
│ Hospital ID       : RS-001                                     │
│ Security Code     : SEC-PETUGAS-001                            │
│ Status            : Aktif (is_active = true)                   │
│ Fungsi            : Monitor suhu, bisa lihat laporan, edit AC  │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                    AKUN 3: DOKTER/CLINICAL                      │
├─────────────────────────────────────────────────────────────────┤
│ Nama Lengkap      : Dr. Monitoring                              │
│ Username          : doctor                                      │
│ Email             : doctor@rs-monitoring.local                 │
│ Password          : Doctor123!@#                               │
│ Role              : doctor                                      │
│ Phone             : 08123456791                                │
│ Hospital ID       : RS-001                                     │
│ Security Code     : SEC-DOCTOR-001                             │
│ Status            : Aktif (is_active = true)                   │
│ Fungsi            : Lihat laporan monitoring, buat note klinis │
└─────────────────────────────────────────────────────────────────┘
```

---

## 3️⃣ DATA DEVICE (Sensor) yang Harus Dibuat

### Setup 1 Device Default:

```
┌──────────────────────────────────────────────────────────────────┐
│              DEVICE 1: RUANGAN BAYI UNIT 1                       │
├──────────────────────────────────────────────────────────────────┤
│ Nama Device       : Sensor Ruangan Bayi Unit 1                  │
│ Device ID         : DEVICE-BAYI-001                             │
│ Lokasi            : Ruang Perawatan Bayi - Bed 1               │
│                                                                  │
│ STATUS MONITORING:                                               │
│ ├─ Stability Status : stable                                    │
│ ├─ Stability Score  : 100 (0-100)                              │
│ └─ Last Check       : [Current DateTime]                        │
│                                                                  │
│ KONFIGURASI AC KONTROL:                                          │
│ ├─ AC Enabled       : true (AC kontrol aktif)                  │
│ ├─ AC Set Point     : 24°C (Suhu target)                       │
│ ├─ AC Status        : true (AC sedang on)                      │
│ ├─ AC Min Temp      : 22°C (Batas minimum)                     │
│ ├─ AC Max Temp      : 26°C (Batas maksimum)                    │
│ ├─ AC API URL       : http://192.168.1.100/api/control         │
│ └─ AC API Key       : key-ac-001-secret                         │
│                                                                  │
│ Early Warning       : [] (JSON kosong, akan update otomatis)    │
└──────────────────────────────────────────────────────────────────┘
```

⚠️ **CATATAN PENTING untuk Device:**
- `device_id` harus UNIK dan tidak boleh duplikasi
- `ac_api_url` harus sesuai IP/hostname AC controller di RS
- `ac_api_key` harus di-generate dari AC controller Anda
- Jika ada device baru, tinggal tambah dengan DEVICE-BAYI-002, 003, dst

---

## 4️⃣ SQL QUERIES untuk Setup Manual di Server

Jika Kimy perlu setup manual via SQL (tidak pakai Laravel artisan):

### Insert Akun Users:
```sql
INSERT INTO users (name, username, email, password, role, phone, hospital_id, security_code, is_active, created_at, updated_at) VALUES
('Administrator', 'admin', 'admin@rs-monitoring.local', '$2y$12$...[bcrypt hash]...', 'admin', '08123456789', 'RS-001', 'SEC-ADMIN-001', 1, NOW(), NOW()),
('Petugas Monitoring', 'petugas', 'petugas@rs-monitoring.local', '$2y$12$...[bcrypt hash]...', 'petugas', '08123456790', 'RS-001', 'SEC-PETUGAS-001', 1, NOW(), NOW()),
('Dr. Monitoring', 'doctor', 'doctor@rs-monitoring.local', '$2y$12$...[bcrypt hash]...', 'doctor', '08123456791', 'RS-001', 'SEC-DOCTOR-001', 1, NOW(), NOW());
```

### Insert Device:
```sql
INSERT INTO devices (device_name, location, device_id, stability_status, stability_score, early_warning_patterns, last_stability_check, ac_enabled, ac_set_point, ac_status, ac_min_temp, ac_max_temp, ac_api_url, ac_api_key, created_at, updated_at) VALUES
('Sensor Ruangan Bayi Unit 1', 'Ruang Perawatan Bayi - Bed 1', 'DEVICE-BAYI-001', 'stable', 100, '[]', NOW(), 1, 24, 1, 22, 26, 'http://192.168.1.100/api/control', 'key-ac-001-secret', NOW(), NOW());
```

---

## 5️⃣ INSTRUKSI untuk KIMY (Server Admin)

**Opsi 1: Pakai Laravel Artisan (Recommended - Lebih Aman)**
```bash
# Pastikan di folder project
cd /home/seraviel/www/monitoring-suhu

# Setup database migrations
php artisan migrate

# Run production seeder
php artisan db:seed --class=ProductionUserSeeder
php artisan db:seed --class=ProductionDeviceSeeder

# Verify
php artisan tinker
>>> App\Models\User::all();      # Harus tampil 3 user
>>> App\Models\Device::all();    # Harus tampil 1 device
```

**Opsi 2: Manual SQL di Database**
- Backup database dulu: `mysqldump -u root -p db_name > backup.sql`
- Copy SQL queries di atas ke file `setup.sql`
- Run: `mysql -u root -p db_name < setup.sql`
- Verify: `mysql -u root -p db_name -e "SELECT * FROM users; SELECT * FROM devices;"`

---

## 6️⃣ TEST AKUN SETELAH SETUP

Login ke aplikasi dengan:
- **Admin**: username: `admin` | password: `Admin123!@#`
- **Petugas**: username: `petugas` | password: `Petugas123!@#`
- **Dokter**: username: `doctor` | password: `Doctor123!@#`

Setiap user harus bisa akses dashboard dengan permissions yang berbeda.

---

## 📝 CHECKLIST SETUP di SERVER

- [ ] Database sudah created
- [ ] Migrations sudah run (`php artisan migrate`)
- [ ] Table `users` sudah ada dengan struktur lengkap
- [ ] Table `devices` sudah ada dengan struktur lengkap
- [ ] 3 akun user sudah di-insert
- [ ] 1 device sudah di-insert
- [ ] Login test dengan ketiga akun berhasil
- [ ] Dashboard tampil dengan baik
- [ ] Monitoring data mulai terekam dari ESP8266

---

**Hubungi developer jika ada error atau database structure tidak sesuai!**
