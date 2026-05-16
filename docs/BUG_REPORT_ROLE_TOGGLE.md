# 🐛 DOKUMENTASI BUG: Role User Berubah Balik ke Nilai Lama

## 📋 RINGKASAN ISSUE

Ketika admin mengubah role user dari **petugas** menjadi **admin**, setelah save, role berubah balik menjadi **petugas**. Begitu juga sebaliknya - perubahan role selalu revert ke nilai sebelumnya.

---

## 🔍 ROOT CAUSE - PENYEBAB SEBENARNYA

### Problem #1: Missing `'role'` di User Model Fillable Array

**File:** [app/Models/User.php](app/Models/User.php)

**Baris 17-27:**
```php
protected $fillable = [
    'name',
    'username',
    'hospital_id',
    'security_code',
    'email',
    'phone',
    'password',
    'is_active',
    'last_login_at',
    'profile_photo_path',
    // ❌ 'role' tidak ada di sini! Inilah BUG!
];
```

**Penjelasan:**
- Laravel memiliki "Mass Assignment Protection" untuk keamanan
- Hanya kolom yang ada di `$fillable` yang bisa di-update via `$model->update()`
- Karena `'role'` TIDAK ada di `$fillable`, maka:
  - `$user->update(['role' => 'admin'])` AKAN DIABAIKAN
  - Role tidak akan ter-update di database
  - User akan tetap dengan role lama

---

### Problem #2: Tidak Konsistennya Role Update Logic

**File:** [app/Http/Controllers/UserManagementController.php](app/Http/Controllers/UserManagementController.php)

Ada 2 cara berbeda untuk update role:

#### Cara 1: Method `update()` (Line 106-130) ❌ PUNYA BUG
```php
public function update(Request $request, User $user)
{
    $validated = $request->validate([
        // ... validasi lain
        'role' => 'required|in:admin,petugas,public',
        // ...
    ]);

    $data = [
        'name' => $validated['name'],
        'username' => $validated['username'],
        'email' => $validated['email'],
        'hospital_id' => $validated['hospital_id'],
        'role' => $validated['role'],  // ❌ DIRECT ASSIGN - akan diabaikan
    ];

    $user->update($data);  // ❌ Role tidak ter-update karena tidak di fillable!
    
    return redirect()->route('admin.users.index')
        ->with('success', "✅ Akun '{$user->username}' berhasil diperbarui.");
}
```

#### Cara 2: Method `updateRole()` (Line 138-217) ✅ BENAR
```php
public function updateRole(Request $request, User $user)
{
    $validated = $request->validate([
        'role' => ['required', 'string', 'in:admin,petugas,public'],
    ]);

    // ...validasi keamanan...

    try {
        $oldRole = $user->role;
        $newRole = $validated['role'];

        // ✅ BENAR: Panggil method dengan validation logic
        $user->updateRole($newRole);

        Log::info('User role berhasil diubah', [...]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', "✅ Role user {$user->name} berhasil diubah dari {$oldRole} menjadi {$newRole}");
    } catch (\InvalidArgumentException $e) {
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage());
    }
}
```

---

## 📍 DIMANA BUG TERJADI?

### Skenario 1: Edit via Edit Form (BUG - Role tidak berubah)
1. User buka [/admin/users/{id}/edit](resources/views/admin/users/edit.blade.php)
2. Ubah role dari "petugas" menjadi "admin"
3. Click "Simpan Perubahan"
4. Submit form ke: `PUT /admin/users/{id}` → `update()` method
5. ❌ **BUG**: Role diabaikan karena `'role'` tidak di `$fillable`
6. Role TIDAK berubah di database

### Skenario 2: Edit via Show/Detail Page (BENAR - Role berubah)
1. User buka [/admin/users/{id}](resources/views/admin/users/show.blade.php)
2. Di section "Manajemen Role", ubah role
3. Click "Simpan Perubahan"
4. Submit form ke: `POST /admin/users/{id}/update-role` → `updateRole()` method
5. ✅ **BENAR**: Method `updateRole()` di-call, validation dilakukan
6. Role BERUBAH di database

---

## ✅ SOLUSI / CARA MEMPERBAIKI

### OPTION 1: Fix dengan Tambah `'role'` di Fillable (SIMPLE)

**File:** [app/Models/User.php](app/Models/User.php)

**Baris 17-27:**
```php
protected $fillable = [
    'name',
    'username',
    'hospital_id',
    'security_code',
    'email',
    'phone',
    'password',
    'is_active',
    'last_login_at',
    'profile_photo_path',
    'role',  // ✅ TAMBAHKAN INI
];
```

**Kelebihan:**
- Cepat, simple, langsung fix

**Kekurangan:**
- `update()` method masih tidak punya validation logic yang sama dengan `updateRole()`
- Bisa ada security issue jika mass-assignment kurang hati-hati

---

### OPTION 2: Fix dengan Consistency (RECOMMENDED)

Edit method `update()` di [UserManagementController.php](app/Http/Controllers/UserManagementController.php) agar konsisten menggunakan `updateRole()` method:

**Current Code (Line 106-130):**
```php
public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'hospital_id' => 'nullable|string|max:255|unique:users,hospital_id,' . $user->id,
        'role' => 'required|in:admin,petugas,public',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $data = [
        'name' => $validated['name'],
        'username' => $validated['username'],
        'email' => $validated['email'],
        'hospital_id' => $validated['hospital_id'],
        'role' => $validated['role'],
    ];

    if (!empty($validated['password'])) {
        $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
    }

    $user->update($data);

    return redirect()->route('admin.users.index')
        ->with('success', "✅ Akun '{$user->username}' berhasil diperbarui.");
}
```

**Fixed Code:**
```php
public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'hospital_id' => 'nullable|string|max:255|unique:users,hospital_id,' . $user->id,
        'role' => 'required|in:admin,petugas,public',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Update basic fields
    $data = [
        'name' => $validated['name'],
        'username' => $validated['username'],
        'email' => $validated['email'],
        'hospital_id' => $validated['hospital_id'],
        // ✅ JANGAN update role di sini
    ];

    if (!empty($validated['password'])) {
        $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
    }

    $user->update($data);

    // ✅ Handle role update menggunakan dedicated method dengan validation
    try {
        if ($user->role !== $validated['role']) {
            $user->updateRole($validated['role']);
        }
    } catch (\InvalidArgumentException $e) {
        return redirect()->back()
            ->with('error', 'Peringatan: ' . $e->getMessage())
            ->withInput();
    }

    return redirect()->route('admin.users.index')
        ->with('success', "✅ Akun '{$user->username}' berhasil diperbarui.");
}
```

**Kelebihan:**
- Consistent: Semua role update melalui method `updateRole()` yang punya validation
- Keamanan lebih baik: Logic terpusat di satu tempat
- Lebih maintainable

**Kekurangan:**
- Perlu ubah di 2 tempat: controller dan User model fillable

---

## 🔧 IMPLEMENTATION UNTUK KIMY

### Step 1: Edit [app/Models/User.php](app/Models/User.php)

Tambahkan `'role'` di `$fillable`:

```php
protected $fillable = [
    'name',
    'username',
    'hospital_id',
    'security_code',
    'email',
    'phone',
    'password',
    'is_active',
    'last_login_at',
    'profile_photo_path',
    'role',  // ✅ TAMBAHKAN
];
```

### Step 2 (OPTIONAL - untuk consistency lebih baik): Edit [app/Http/Controllers/UserManagementController.php](app/Http/Controllers/UserManagementController.php)

Ubah method `update()` seperti kode "Fixed Code" di atas (gunakan `updateRole()` method untuk handle role change).

### Step 3: Test di Browser

1. Login sebagai admin
2. Buka [/admin/users](routes/web.php) - halaman list user
3. Click edit salah satu user
4. Ubah role dari "petugas" menjadi "admin"
5. Click "Simpan Perubahan"
6. Verify: Role harus berubah ✅

---

## 🧪 VERIFICATION CHECKLIST

- [ ] `'role'` sudah ditambah di `User::$fillable`
- [ ] Bisa ubah role dari petugas → admin via edit form
- [ ] Bisa ubah role dari admin → petugas via edit form
- [ ] Tidak bisa ubah role sendiri (disabled select)
- [ ] Success message ditampilkan setelah save
- [ ] Database ter-update dengan benar

---

## 📝 RELATED FILES

- [app/Models/User.php](app/Models/User.php#L17-L27) - Fillable array
- [app/Http/Controllers/UserManagementController.php](app/Http/Controllers/UserManagementController.php#L106-L130) - `update()` method
- [app/Http/Controllers/UserManagementController.php](app/Http/Controllers/UserManagementController.php#L138-L217) - `updateRole()` method
- [resources/views/admin/users/edit.blade.php](resources/views/admin/users/edit.blade.php) - Edit form
- [resources/views/admin/users/show.blade.php](resources/views/admin/users/show.blade.php) - Detail page dengan role change form

---

## 🎯 KESIMPULAN

**ROOT CAUSE:** `'role'` tidak ada di `User::$fillable` array, sehingga Laravel's Mass Assignment Protection mengabaikan role update.

**QUICK FIX:** Tambahkan `'role'` di `$fillable`.

**BEST FIX:** Tambahkan `'role'` di `$fillable` + Refactor `update()` method untuk konsistent gunakan `updateRole()` method.
