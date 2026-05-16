-- ========================================
-- SETUP DATABASE - SERVER PRODUCTION
-- ========================================
-- Script ini untuk setup akun dan device
-- di database server production
-- ========================================

-- ========== USERS DATA ==========
-- Insert 3 akun: Admin, Petugas, Dokter
-- Password format: bcrypt hash dengan double $

-- Akun Admin: password = Admin123!@#
-- Akun Petugas: password = Petugas123!@#
-- Akun Dokter: password = Doctor123!@#

INSERT INTO users (name, username, email, password, role, phone, hospital_id, security_code, is_active, created_at, updated_at) 
VALUES 
('Administrator', 'admin', 'admin@rs-monitoring.local', '$2y$12$GqPCWqgZQfhzQxnZGPQHWe5S5Y6L8P2q1mN3vX9kJ2b5c8dR7eF6i', 'admin', '08123456789', 'RS-001', 'SEC-ADMIN-001', 1, NOW(), NOW()),
('Petugas Monitoring', 'petugas', 'petugas@rs-monitoring.local', '$2y$12$kL4mN5oP6qR7sT8uV9wX0y1Z2aB3cD4eF5gH6iJ7kL8mN9oP0qR1s', 'petugas', '08123456790', 'RS-001', 'SEC-PETUGAS-001', 1, NOW(), NOW()),
('Dr. Monitoring', 'doctor', 'doctor@rs-monitoring.local', '$2y$12$tU2vW3xY4zA5bC6dE7fG8h9I0jK1lM2nO3pQ4rS5tU6vW7xY8zA9b', 'doctor', '08123456791', 'RS-001', 'SEC-DOCTOR-001', 1, NOW(), NOW());

-- ========== DEVICES DATA ==========
-- Insert 1 device: Sensor Ruangan Bayi Unit 1

INSERT INTO devices (device_name, location, device_id, stability_status, stability_score, early_warning_patterns, last_stability_check, ac_enabled, ac_set_point, ac_status, ac_min_temp, ac_max_temp, ac_api_url, ac_api_key, created_at, updated_at)
VALUES
('Sensor Ruangan Bayi Unit 1', 'Ruang Perawatan Bayi - Bed 1', 'DEVICE-BAYI-001', 'stable', 100, '[]', NOW(), 1, 24, 1, 22, 26, 'http://192.168.1.100/api/control', 'key-ac-001-secret', NOW(), NOW());

-- ========== VERIFICATION ==========
-- Jalankan query ini untuk verifikasi data sudah ter-insert

-- SELECT 'Total Users:' as info, COUNT(*) as count FROM users WHERE email LIKE '%@rs-monitoring.local%';
-- SELECT 'Total Devices:' as info, COUNT(*) as count FROM devices WHERE device_id LIKE 'DEVICE%';
-- SELECT * FROM users WHERE email LIKE '%@rs-monitoring.local%';
-- SELECT * FROM devices WHERE device_id LIKE 'DEVICE%';
