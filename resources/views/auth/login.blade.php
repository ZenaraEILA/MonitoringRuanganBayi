<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Monitoring Suhu Bayi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Favicon Medical Icon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='grad1' x1='0%' y1='0%' x2='100%' y2='100%'><stop offset='0%' style='stop-color:%23ff6b6b;stop-opacity:1' /><stop offset='100%' style='stop-color:%234ecdc4;stop-opacity:1' /></linearGradient></defs><rect width='100' height='100' fill='white'/><g transform='translate(50,50)'><circle cx='0' cy='0' r='45' fill='url(%23grad1)' opacity='0.1' stroke='url(%23grad1)' stroke-width='2'/><path d='M -8,-25 L -8,5 C -8,10 -4,15 0,15 C 4,15 8,10 8,5 L 8,-25 C 8,-28 5,-30 0,-30 C -5,-30 -8,-28 -8,-25 Z' fill='%23ff6b6b'/><circle cx='0' cy='-22' r='3' fill='%23ff6b6b'/><path d='M -0.5,-8 L 0.5,-8 L 0.5,-2 C 0.5,0 -0.5,0 -0.5,-2 Z' fill='%23fff' opacity='0.6'/><path d='M 12,-10 Q 18,-15 20,-8 Q 18,0 12,5 Q 15,0 12,-10 Z' fill='%234ecdc4'/></g></svg>" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0d6efd 0%, #e0f2ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 20px 0;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(30px); }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 35px 35px;
            animation: slideInUp 0.6s ease-out;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
            animation: slideInDown 0.6s ease-out;
        }

        .logo-icon {
            font-size: 42px;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            display: inline-block;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .login-header h1 {
            font-size: 26px;
            font-weight: 800;
            color: #2d3436;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
            transition: opacity 0.3s ease;
        }

        .login-header p {
            color: #636e72;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .alert {
            border: 1px solid;
            border-radius: 12px;
            margin-bottom: 25px;
            animation: slideInDown 0.4s ease-out;
            font-size: 14px;
            padding: 14px 16px;
        }
        
        .alert i {
            margin-right: 8px;
            font-size: 16px;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(231, 76, 60, 0.08) 0%, rgba(192, 57, 43, 0.06) 100%);
            color: #c0392b;
            border-color: #e74c3c;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.15);
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(81, 207, 102, 0.08) 0%, rgba(64, 192, 87, 0.06) 100%);
            color: #27ae60;
            border-color: #51cf66;
            box-shadow: 0 4px 12px rgba(81, 207, 102, 0.15);
        }

        .alert ul {
            margin-bottom: 0;
            list-style: none;
            padding-left: 20px;
        }

        .alert li {
            position: relative;
            padding-left: 10px;
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 16px;
            position: relative;
        }

        .form-group label {
            display: flex;
            align-items: center;
            color: #2d3436;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
            letter-spacing: 0.3px;
        }
        
        .form-group label i {
            margin-right: 8px;
            color: #0d6efd;
            font-size: 16px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8ebed;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f8f9fa;
            color: #2d3436;
            font-family: inherit;
        }

        .form-group input::placeholder {
            color: #b2bec3;
            transition: color 0.3s ease;
        }

        .form-group input:focus::placeholder {
            color: #95a5a6;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0d6efd;
            background: white;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.12),
                        0 0 0 8px rgba(13, 110, 253, 0.06),
                        inset 0 2px 4px rgba(0, 0, 0, 0.02);
            transform: translateY(-1px);
        }

        .form-group input:hover:not(:focus) {
            border-color: #d4d8db;
            background: #fbfbfc;
        }

        .form-group input.is-invalid {
            border-color: #e74c3c;
            background-color: rgba(231, 76, 60, 0.02);
        }

        .form-group input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.12),
                        0 0 0 8px rgba(231, 76, 60, 0.06);
            border-color: #c0392b;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(13, 110, 253, 0.4);
        }

        .btn-login:active {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #636e72;
            font-size: 14px;
            line-height: 1.6;
        }

        .login-footer a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline;
            position: relative;
            padding-bottom: 2px;
        }

        .login-footer a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #0d6efd, #0a58ca);
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .login-footer a:hover {
            color: #0a58ca;
        }

        .login-footer a:hover::after {
            width: 100%;
        }

        /* Custom segmented toggle */
        .method-toggle {
            display: flex;
            background: transparent;
            border-radius: 12px;
            padding: 4px;
            border: 2px solid #e8ebed;
            position: relative;
        }

        .method-toggle .btn-check:checked + .btn {
            background: #e0f2ff;
            color: #0d6efd;
            box-shadow: none;
            border-color: transparent;
            font-weight: 700;
        }

        .method-toggle .btn {
            flex: 1;
            border: none;
            border-radius: 8px;
            padding: 12px 10px;
            font-size: 14px;
            font-weight: 600;
            color: #636e72;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .method-toggle .btn:hover {
            color: #2d3436;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 25px 20px;
            }

            .login-header h1 {
                font-size: 20px;
            }

            .login-header p {
                font-size: 12px;
            }

            .logo-icon {
                font-size: 32px;
            }

            .form-group input, .form-group select {
                padding: 10px 12px;
                font-size: 16px;
            }

            body::before,
            body::after {
                display: none;
            }
            
            .btn-public-float {
                top: auto !important;
                bottom: 20px !important;
                right: 20px !important;
                padding: 10px 20px !important;
                font-size: 14px !important;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            
            .login-wrapper {
                padding: 10px;
                max-width: 100%;
            }
            
            .method-toggle {
                flex-direction: column;
                gap: 5px;
                border: none;
                background: #f1f3f5;
            }
            
            .method-toggle .btn {
                width: 100%;
                border-radius: 8px !important;
                background: white;
                border: 1px solid #e8ebed;
            }
            
            .method-toggle .btn-check:checked + .btn {
                background: #0d6efd;
                color: white;
                border-color: #0d6efd;
            }
        }

        @media (max-width: 375px) {
            .login-card {
                padding: 20px 15px;
            }
            
            .login-header h1 {
                font-size: 18px;
            }
        }

        /* Public Login Button */
        .btn-public-float {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(13, 110, 253, 0.2);
            color: #0d6efd;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            animation: slideInDown 0.6s ease-out;
        }

        .btn-public-float:hover {
            background: #0d6efd;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
        }

        .btn-public-float i {
            font-size: 18px;
        }
    </style>

    <!-- --- MEDICAL ECG LOADER ANIMATION --- -->
    <style>
        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .loader-overlay.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .ecg-loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .heart-pulse-box {
            font-size: 60px;
            color: #ff4757;
            animation: professionalPulse 1.5s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ecg-svg-container {
            width: 200px;
            height: 40px;
            margin-bottom: 20px;
        }

        .ecg-path {
            stroke-dasharray: 400;
            stroke-dashoffset: 400;
            animation: ecgScan 2.5s linear infinite;
        }

        @keyframes ecgScan {
            0% {
                stroke-dashoffset: 400;
            }
            50% {
                stroke-dashoffset: 0;
            }
            100% {
                stroke-dashoffset: -400;
            }
        }

        @keyframes professionalPulse {
            0%, 100% { 
                transform: scale(1); 
                opacity: 0.8; 
            }
            50% { 
                transform: scale(1.15); 
                opacity: 1; 
                text-shadow: 0 0 15px rgba(255, 71, 87, 0.4); 
            }
        }

        .loader-text {
            font-size: 14px;
            font-weight: 700;
            color: #2d3436;
            letter-spacing: 1px;
            text-transform: uppercase;
            animation: pulseText 1.5s infinite;
        }

        @keyframes pulseText {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Loader Overlay -->
    <div id="appLoader" class="loader-overlay">
        <div class="ecg-loader-container">
            <div class="heart-pulse-box">
                <i class="fas fa-heartbeat"></i>
            </div>
            <div class="ecg-svg-container">
                <svg class="ecg-svg" viewBox="0 0 200 40" width="100%" height="100%">
                    <path class="ecg-path" d="M 0,20 L 40,20 L 50,5 L 60,35 L 70,20 L 110,20 L 120,10 L 130,30 L 140,20 L 200,20" fill="none" stroke="#0d6efd" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="loader-text">Memproses Data Medis...</div>
        </div>
    </div>
    <!-- Public Quick Access Button -->
    <form action="{{ route('login.public') }}" method="POST">
        @csrf
        <button type="submit" class="btn-public-float border-0">
            <i class="fas fa-eye"></i>
            <span>Publik</span>
        </button>
    </form>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h1 id="rotatingTitle">Monitoring Bayi</h1>
                <p>Sistem Monitoring Suhu & Kelembapan Ruang Perawatan</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong><i class="fas fa-exclamation-circle"></i> Gagal Login!</strong>
                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle"></i> {{ Session::get('success') }}
            </div>
            @endif

            @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ Session::get('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group mb-3">
                    <label><i class="fas fa-id-card"></i> Login via</label>
                    <select id="identityType" onchange="switchIdentity()" class="form-select" style="padding: 12px 16px; border: 2px solid #e8ebed; border-radius: 12px; background: #f8f9fa; font-size: 15px;">
                        <option value="username">Username</option>
                        <option value="hospital_id">NISN / ID</option>
                        <option value="email">Email</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label id="identityLabel"><i class="fas fa-user"></i> Username</label>
                    
                    <!-- Username Input -->
                    <input 
                        type="text" 
                        id="username_input" 
                        name="username" 
                        class="form-control" 
                        value="{{ old('username') }}" 
                        placeholder="Masukkan Username"
                    >
                    
                    <!-- NISN Input (Hidden) -->
                    <input 
                        type="text" 
                        id="hospital_id_input" 
                        name="hospital_id" 
                        class="form-control d-none" 
                        value="{{ old('hospital_id') }}" 
                        placeholder="Masukkan NISN / ID"
                        disabled
                    >

                    <!-- Email Input (Hidden) -->
                    <input 
                        type="email" 
                        id="email_input" 
                        name="email" 
                        class="form-control d-none" 
                        value="{{ old('email') }}" 
                        placeholder="Masukkan Email"
                        disabled
                    >
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-shield-alt"></i> Metode Login
                    </label>
                    <div class="method-toggle mt-2 mb-3">
                        <input type="radio" class="btn-check" name="login_method" id="methodPassword" value="password" autocomplete="off" checked onchange="toggleMethod()">
                        <label class="btn" for="methodPassword">
                            <i class="fas fa-lock"></i> Password
                        </label>

                        <input type="radio" class="btn-check" name="login_method" id="methodCode" value="code" autocomplete="off" onchange="toggleMethod()">
                        <label class="btn" for="methodCode">
                            <i class="fas fa-key"></i> Code Keamanan
                        </label>
                    </div>
                </div>

                <div class="form-group" id="credentialWrapper">
                    <label id="credentialLabel" for="credential">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input 
                        type="password" 
                        id="credential" 
                        name="credential" 
                        class="form-control @error('credential') is-invalid @enderror" 
                        placeholder="Masukkan password Anda"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="login-footer">
                <p class="mb-2"><i class="fas fa-info-circle"></i> Hubungi Administrator jika Anda membutuhkan akses.</p>
                <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal" class="text-muted text-decoration-none small"><i class="fas fa-user-shield"></i> Kebijakan Privasi</a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Loader handling
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('appLoader');
            
            // Hide loader after page load (Entrance animation)
            setTimeout(() => {
                loader.classList.add('hidden');
            }, 800); // Small delay for effect

            // Show loader on form submit
            const loginForm = document.querySelector('form[action="{{ route('login.post') }}"]');
            const publicForm = document.querySelector('form[action="{{ route('login.public') }}"]');

            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    loader.classList.remove('hidden');
                });
            }

            if (publicForm) {
                publicForm.addEventListener('submit', function() {
                    loader.classList.remove('hidden');
                });
            }

            // Rotating Title (Exclusive to Login Page)
            const titleElement = document.getElementById('rotatingTitle');
            const titles = ["Room Temp Baby", "Monitoring Suhu Bayi"];
            let titleIndex = 0;
            
            setInterval(() => {
                titleIndex = (titleIndex + 1) % titles.length;
                
                // Update Browser Tab Title
                document.title = titles[titleIndex];
                
                // Update Page Header with fade effect
                if (titleElement) {
                    titleElement.style.opacity = 0;
                    setTimeout(() => {
                        titleElement.textContent = titles[titleIndex];
                        titleElement.style.opacity = 1;
                    }, 300);
                }
            }, 5000);
        });

        function switchIdentity() {
            const type = document.getElementById('identityType').value;
            const label = document.getElementById('identityLabel');
            
            const userIn = document.getElementById('username_input');
            const hospIn = document.getElementById('hospital_id_input');
            const mailIn = document.getElementById('email_input');

            // Hide and disable all
            userIn.classList.add('d-none'); userIn.disabled = true;
            hospIn.classList.add('d-none'); hospIn.disabled = true;
            mailIn.classList.add('d-none'); mailIn.disabled = true;

            if (type === 'username') {
                label.innerHTML = '<i class="fas fa-user"></i> Username';
                userIn.classList.remove('d-none');
                userIn.disabled = false;
            } else if (type === 'hospital_id') {
                label.innerHTML = '<i class="fas fa-id-badge"></i> NISN / ID';
                hospIn.classList.remove('d-none');
                hospIn.disabled = false;
            } else if (type === 'email') {
                label.innerHTML = '<i class="fas fa-envelope"></i> Email';
                mailIn.classList.remove('d-none');
                mailIn.disabled = false;
            }
        }

        function toggleMethod() {
            const methodPassword = document.getElementById('methodPassword').checked;
            const label = document.getElementById('credentialLabel');
            const input = document.getElementById('credential');
            
            if (methodPassword) {
                label.innerHTML = '<i class="fas fa-lock"></i> Password';
                input.placeholder = 'Masukkan password Anda';
                input.type = 'password';
            } else {
                label.innerHTML = '<i class="fas fa-key"></i> Code Keamanan';
                input.placeholder = 'Masukkan code keamanan darurat';
                input.type = 'text';
            }
        }
    </script>

    <!-- Modal Kebijakan Privasi -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                <div class="modal-header bg-primary text-white p-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-shape bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 20px;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-white" id="privacyModalLabel">Kebijakan Privasi</h5>
                            <small class="text-white-50">Terakhir diperbarui: 17 Mei 2026</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 p-md-5">
                    <p class="lead text-muted mb-4">
                        Selamat datang di Sistem Monitoring Suhu & Kelembapan Ruangan Bayi (<strong>Room Temp Baby</strong>). Kami sangat menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi serta data medis yang dikelola dalam sistem ini.
                    </p>

                    <hr class="my-4" style="opacity: 0.1;">

                    <!-- Section 1 -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-2"><i class="fas fa-database text-primary me-2"></i> 1. Data yang Kami Kumpulkan</h6>
                        <ul class="text-muted small">
                            <li><strong>Data Sensor Real-Time</strong>: Suhu dan kelembapan ruangan yang diambil secara otomatis oleh perangkat ESP8266/ESP32.</li>
                            <li><strong>Data Akun Pengguna</strong>: Nama, email, username, dan password (terenkripsi) untuk keperluan login dan hak akses.</li>
                            <li><strong>Log Aktivitas</strong>: Catatan waktu login, logout, dan perubahan data untuk keperluan audit keamanan.</li>
                        </ul>
                    </div>

                    <!-- Section 2 -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-2"><i class="fas fa-clipboard-check text-primary me-2"></i> 2. Penggunaan Data</h6>
                        <ul class="text-muted small">
                            <li>Menampilkan kondisi suhu dan kelembapan ruangan bayi secara real-time pada dashboard.</li>
                            <li>Memberikan notifikasi darurat jika kondisi ruangan berada di luar batas aman.</li>
                            <li>Menyusun laporan riwayat (history) untuk keperluan analisis medis oleh dokter atau perawat.</li>
                        </ul>
                    </div>

                    <!-- Section 3 -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-2"><i class="fas fa-lock text-primary me-2"></i> 3. Keamanan Data</h6>
                        <ul class="text-muted small">
                            <li>Semua komunikasi data antara perangkat ESP dan server menggunakan protokol yang aman.</li>
                            <li>Password pengguna dienkripsi menggunakan algoritma <code>Bcrypt</code> standar industri.</li>
                            <li>Akses ke database dibatasi dan dilindungi dengan kredensial yang kuat.</li>
                        </ul>
                    </div>

                    <!-- Section 4 -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-2"><i class="fas fa-user-tag text-primary me-2"></i> 4. Hak Akses Data</h6>
                        <ul class="text-muted small">
                            <li><strong>Admin</strong>: Memiliki akses penuh untuk mengelola user dan perangkat.</li>
                            <li><strong>Petugas/Perawat</strong>: Dapat melihat data real-time dan riwayat untuk keperluan medis.</li>
                            <li><strong>Publik</strong>: Hanya dapat melihat data real-time tanpa bisa melihat data pribadi atau riwayat masa lalu.</li>
                        </ul>
                    </div>

                    <!-- Section 5 -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-2"><i class="fas fa-star text-primary me-2"></i> 5. Landasan Nilai Pancasila</h6>
                        <ul class="text-muted small">
                            <li><strong>Sila 1</strong>: Mengelola data adalah sebuah amanah dan tanggung jawab moral kepada Tuhan dan manusia.</li>
                            <li><strong>Sila 2</strong>: Menghormati hak asasi pasien (bayi) untuk perlindungan privasi yang layak.</li>
                            <li><strong>Sila 3</strong>: Sistem dibangun demi kepentingan bersama menjaga standar kesehatan nasional.</li>
                            <li><strong>Sila 4</strong>: Kebijakan dibuat dengan penuh pertimbangan bijaksana demi transparansi.</li>
                            <li><strong>Sila 5</strong>: Semua kalangan berhak mendapatkan standar pemantauan kesehatan yang sama amannya.</li>
                        </ul>
                    </div>

                    <div class="alert alert-info border-0 shadow-sm mt-4 mb-0" style="border-radius: 12px; background: rgba(13, 110, 253, 0.05);">
                        <div class="d-flex gap-3">
                            <i class="fas fa-info-circle text-primary fs-5 mt-1"></i>
                            <div>
                                <h6 class="fw-bold text-primary mb-1 small">Catatan Penting</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                                    Kebijakan ini dapat berubah sewaktu-waktu mengikuti perkembangan regulasi. Penggunaan sistem secara terus-menerus berarti Anda menyetujui kebijakan ini.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Saya Mengerti</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
