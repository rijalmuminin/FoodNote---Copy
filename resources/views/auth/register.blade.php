@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #FF6B6B 0%, #4ECDC4 50%, #45B7D1 100%);
        --secondary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-bg: rgba(255, 255, 255, 0.95);
        --shadow-main: 0 20px 40px rgba(0,0,0,0.08);
        --border-radius: 20px;
        --transition: all 0.3s ease;
    }

    * {
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #4facfe 100%);
        min-height: 100vh;
        font-family: system-ui, -apple-system, sans-serif;
        padding: 20px 0;
    }

    .auth-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .auth-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-main);
        border: 1px solid rgba(255,255,255,0.2);
        overflow: hidden;
        width: 100%;
        max-width: 900px;
        display: flex;
        min-height: 650px;
    }

    .illustration-side {
        flex: 1;
        background: var(--primary-gradient);
        padding: 40px;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 380px;
    }

    .logo-section {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo-img {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        object-fit: cover;
        transition: var(--transition);
        border: 3px solid rgba(255,255,255,0.4);
    }

    .logo-img:hover {
        transform: scale(1.05);
    }

    .brand-name {
        color: white;
        font-size: 2.2rem;
        font-weight: 800;
        margin: 15px 0 5px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .brand-tagline {
        color: rgba(255,255,255,0.9);
        font-size: 1rem;
        margin: 0;
        font-weight: 500;
    }

    .food-icons {
        position: absolute;
        font-size: 2.5rem;
        opacity: 0.4;
    }

    .icon-1 { top: 20%; left: 15%; animation: float 4s ease-in-out infinite; }
    .icon-2 { bottom: 25%; right: 15%; animation: float 4s 1s ease-in-out infinite; }
    .icon-3 { top: 60%; left: 20%; animation: float 4s 2s ease-in-out infinite; }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .form-side {
        flex: 1;
        padding: 50px 40px;
        display: flex;
        flex-direction: column;
    }

    .form-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0 0 8px;
    }

    .form-subtitle {
        color: #718096;
        margin: 0;
        font-size: 0.95rem;
    }

    .input-group {
        position: relative;
        margin-bottom: 25px;
    }

    .form-control {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: var(--transition);
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #FF6B6B;
        box-shadow: 0 0 0 3px rgba(255,107,107,0.1);
    }

    .form-label {
        position: absolute;
        top: 16px;
        left: 20px;
        color: #64748b;
        font-weight: 500;
        font-size: 0.95rem;
        transition: var(--transition);
        pointer-events: none;
    }

    .form-control:focus ~ .form-label,
    .form-control:not(:placeholder-shown) ~ .form-label {
        top: -10px;
        left: 15px;
        font-size: 0.8rem;
        color: #FF6B6B;
        background: white;
        padding: 0 6px;
    }

    .password-strength {
        margin-top: 8px;
        height: 4px;
        border-radius: 2px;
        background: #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .strength-weak { width: 25%; background: #f56565; }
    .strength-fair { width: 50%; background: #ed8936; }
    .strength-good { width: 75%; background: #48bb78; }
    .strength-strong { width: 100%; background: #38a169; }

    .form-options {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 25px;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
        margin-right: auto;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        accent-color: #FF6B6B;
    }

    .btn-register {
        width: 100%;
        padding: 18px;
        background: var(--primary-gradient);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 1.15rem;
        font-weight: 600;
        margin-bottom: 20px;
        transition: var(--transition);
        box-shadow: 0 8px 25px rgba(255,107,107,0.3);
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(255,107,107,0.4);
    }

    .divider {
        text-align: center;
        margin: 25px 0;
        color: #a0aec0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e2e8f0;
    }

    .divider span {
        background: var(--card-bg);
        padding: 0 20px;
        font-size: 0.9rem;
    }

    .btn-login {
        width: 100%;
        padding: 16px;
        background: rgba(255,255,255,0.9);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        color: #2d3748;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-login:hover {
        background: white;
        border-color: #FF6B6B;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .error-message {
        color: #f56565;
        font-size: 0.85rem;
        margin-top: 5px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .auth-card {
            flex-direction: column;
            max-width: 500px;
            min-height: auto;
        }
        
        .illustration-side {
            min-width: auto;
            padding: 40px 30px;
            min-height: 250px;
        }
        
        .form-side {
            padding: 40px 30px;
        }
    }

    @media (max-width: 576px) {
        .auth-container {
            padding: 15px;
        }
        
        .illustration-side {
            padding: 30px 20px;
        }
        
        .form-side {
            padding: 30px 25px;
        }
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <!-- Illustration Side -->
        <div class="illustration-side">
            <div class="food-icons icon-1">🍔</div>
            <div class="food-icons icon-2">🍕</div>
            <div class="food-icons icon-3">🍜</div>
            
            <div class="logo-section">
                <img src="{{ asset('assets/frontend/img/core-img/logo.png') }}" 
                     alt="FoodNote" 
                     class="logo-img"
                     onerror="this.style.display='none'">
                <h1 class="brand-name">FoodNote</h1>
                <p class="brand-tagline">Mulai perjalanan kuliner Anda</p>
            </div>
        </div>

        <!-- Form Side -->
        <div class="form-side">
            <div class="form-header">
                <h2 class="form-title">Buat Akun</h2>
                <p class="form-subtitle">Daftar untuk mulai menikmati FoodNote</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="input-group">
                    <input id="name" 
                           type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder=" " 
                           required 
                           autocomplete="name" 
                           autofocus>
                    <label class="form-label" for="name">Nama Lengkap</label>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="input-group">
                    <input id="email" 
                           type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder=" " 
                           required 
                           autocomplete="email">
                    <label class="form-label" for="email">Email</label>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group">
                    <input id="password" 
                           type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           placeholder=" " 
                           required 
                           autocomplete="new-password">
                    <label class="form-label" for="password">Password</label>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="password-strength"></div>
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <input id="password-confirm" 
                           type="password" 
                           class="form-control" 
                           name="password_confirmation" 
                           placeholder=" " 
                           required 
                           autocomplete="new-password">
                    <label class="form-label" for="password-confirm">Konfirmasi Password</label>
                </div>

                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms">
                        <label for="terms">Saya setuju dengan <strong>Syarat & Ketentuan</strong></label>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    Daftar Sekarang
                </button>
            </form>

            <div class="divider">
                <span>Sudah punya akun?</span>
            </div>

            <a href="{{ route('login') }}" class="btn-login">
                Masuk ke Akun
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthBar = document.querySelector('.password-strength');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;
        
        strengthBar.className = 'password-strength';
        if (strength <= 1) strengthBar.classList.add('strength-weak');
        else if (strength <= 2) strengthBar.classList.add('strength-fair');
        else if (strength <= 3) strengthBar.classList.add('strength-good');
        else strengthBar.classList.add('strength-strong');
    });
});
</script>
@endsection