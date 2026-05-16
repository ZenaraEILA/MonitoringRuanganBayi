# Petunjuk Seeder Production untuk Server

## 📋 Daftar Seeder yang Tersedia

### 1. **ProductionUserSeeder**
Membuat 3 akun user untuk production:

| Username | Email | Password | Role | Purpose |
|----------|-------|----------|------|---------|
| admin | admin@rs-monitoring.local | Admin123!@# | admin | Administrator sistem |
| petugas | petugas@rs-monitoring.local | Petugas123!@# | petugas | Operator monitoring |
| doctor | doctor@rs-monitoring.local | Doctor123!@# | doctor | Dokter/Clinical staff |

### 2. **ProductionDeviceSeeder**
Membuat 1 device sensor untuk ruangan bayi:

- **Device ID**: DEVICE-BAYI-001
- **Nama**: Sensor Ruangan Bayi Unit 1
- **Lokasi**: Ruang Perawatan Bayi - Bed 1
- **Set Point AC**: 24°C
- **Range Temp**: 22-26°C

## 🚀 Cara Menggunakan

### Di Development/Testing:
```bash
php artisan db:seed --class=ProductionUserSeeder
php artisan db:seed --class=ProductionDeviceSeeder
```

### Di Production Server:
```bash
# Setup database dan jalankan semua migration
php artisan migrate

# Jalankan seeder production
php artisan db:seed --class=ProductionUserSeeder
php artisan db:seed --class=ProductionDeviceSeeder
```

### Atau semua sekaligus menggunakan DatabaseSeeder:
Edit file `database/seeders/DatabaseSeeder.php` dan uncomment:
```php
$this->call(ProductionUserSeeder::class);
$this->call(ProductionDeviceSeeder::class);
```

Kemudian jalankan:
```bash
php artisan db:seed
```

## ⚠️ Penting: Keamanan di Production

1. **Ubah Password Default**
   ```bash
   php artisan tinker
   >>> $user = \App\Models\User::find(1); // Admin user
   >>> $user->password = Hash::make('PASSWORD_BARU_YANG_KUAT');
   >>> $user->save();
   ```

2. **Update Email Domain**
   Edit `ProductionUserSeeder.php` dan ganti email domain sesuai kebutuhan RS Anda

3. **Backup Database Sebelum Seeding**
   ```bash
   mysqldump -u root -p database_name > backup.sql
   ```

4. **Cek Device Configuration**
   - Sesuaikan `ac_api_url` dengan IP/URL AC controller Anda
   - Generate `ac_api_key` yang baru dari AC controller
   - Update `device_id` jika sudah ada device dengan ID yang sama

## 📝 Modifikasi Sesuai Kebutuhan

### Menambah Device Baru
Edit `ProductionDeviceSeeder.php`:
```php
// Device 2 - Ruangan Bayi Unit 2
Device::updateOrCreate(
    ['device_id' => 'DEVICE-BAYI-002'],
    [
        'device_name' => 'Sensor Ruangan Bayi Unit 2',
        'location' => 'Ruang Perawatan Bayi - Bed 2',
        // ... field lainnya
    ]
);
```

### Menambah User Baru
Edit `ProductionUserSeeder.php`:
```php
User::updateOrCreate(
    ['email' => 'nama@rs-monitoring.local'],
    [
        'name' => 'Nama User',
        'username' => 'username',
        // ... field lainnya
    ]
);
```

## ✅ Verifikasi Setelah Seeding

```bash
# Cek users yang sudah dibuat
php artisan tinker
>>> App\Models\User::all();

# Cek devices yang sudah dibuat
>>> App\Models\Device::all();

# Test login dengan salah satu akun
# Buka aplikasi dan login dengan credential dari tabel di atas
```

## 🔄 Jika Perlu Reset Database

```bash
# Rollback semua migrations
php artisan migrate:reset

# Jalankan lagi dari awal
php artisan migrate
php artisan db:seed --class=ProductionUserSeeder
php artisan db:seed --class=ProductionDeviceSeeder
```

---

**Catatan**: Seeder ini menggunakan `updateOrCreate()` sehingga aman dijalankan berkali-kali tanpa duplikasi data.
