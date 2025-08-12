<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ 'img/LOGO-QUANTUM.png' }}" type="image/x-icon">
    <title>Penilaian Siswa | Daftar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
            overflow-x: hidden;
        }

        /* Background Animation */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .floating-shapes {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .floating-shapes:nth-child(1) {
            width: 120px;
            height: 120px;
            top: 15%;
            left: 15%;
            animation-delay: 0s;
        }

        .floating-shapes:nth-child(2) {
            width: 80px;
            height: 80px;
            top: 60%;
            left: 75%;
            animation-delay: -3s;
        }

        .floating-shapes:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 30%;
            left: 80%;
            animation-delay: -6s;
        }

        .floating-shapes:nth-child(4) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: -2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
            50% { transform: translateY(-30px) rotate(180deg); opacity: 1; }
        }

        /* Daftar Container */
        .signup-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
            transform: translateY(0);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin: 1rem;
        }

        .signup-container:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .signup-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            animation: bounce 2s infinite;
            position: relative;
        }

        .logo::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            opacity: 0.3;
            animation: pulse-ring 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.1; }
            100% { transform: scale(1.4); opacity: 0; }
        }

        .signup-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .signup-subtitle {
            color: #666;
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Form Styles */
        .signup-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-group {
            position: relative;
            flex: 1;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e1e5e9;
            border-radius: 14px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: scale(1.02);
        }

        .form-input:valid {
            border-color: #10b981;
        }

        .form-input:invalid:not(:placeholder-shown) {
            border-color: #ef4444;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus + .input-icon {
            color: #667eea;
            transform: translateY(-50%) scale(1.1);
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.85rem;
        }

        .strength-bar {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #ef4444; width: 25%; }
        .strength-fair { background: #f59e0b; width: 50%; }
        .strength-good { background: #10b981; width: 75%; }
        .strength-strong { background: #059669; width: 100%; }

        /* Terms and Conditions */
        .terms-group {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin: 1rem 0;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .checkbox {
            width: 20px;
            height: 20px;
            accent-color: #667eea;
            margin-top: 0.1rem;
        }

        .terms-text {
            color: #666;
        }

        .terms-text a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        /* Daftar Button */
        .signup-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1.2rem;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .signup-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .signup-button:active {
            transform: translateY(-1px);
        }

        .signup-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .signup-button:hover::before {
            left: 100%;
        }

        /* Social Daftar */
        .social-signup {
            margin-top: 1.5rem;
            text-align: center;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        }

        .divider span {
            padding: 0 1.5rem;
            background: white;
        }

        .social-buttons {
            display: flex;
            gap: 1rem;
        }

        .social-btn {
            flex: 1;
            padding: 0.9rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .social-btn:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Success Message */
        .success-message {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            text-align: center;
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        .success-message.show {
            transform: scale(1);
        }

        /* Loading Animation */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading .signup-button {
            background: #9ca3af;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 640px) {
            .signup-container {
                margin: 0.5rem;
                padding: 2rem;
            }
            
            .form-row {
                flex-direction: column;
                gap: 1.25rem;
            }
            
            .social-buttons {
                flex-direction: column;
            }

            .signup-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <div class="floating-shapes"></div>
        <div class="floating-shapes"></div>
        <div class="floating-shapes"></div>
        <div class="floating-shapes"></div>
    </div>

    <div class="signup-container">
        <div class="signup-header">
            <div class="logo"><img src="img/LOGO-QUANTUM.png" alt="Logo Quantum" width="80"></div>
            <h1 class="signup-title">Bergabung Dengan Kami</h1>
            <p class="signup-subtitle">Buat akun baru</p>
        </div>

        <div class="success-message" id="successMessage">
            <strong>🎉 Pendaftaran berhasil!</strong><br>
            Selamat datang! Akun Anda telah dibuat.
        </div>

        <form action="{{ route('register') }}" method="POST" class="signup-form" id="signupForm">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="username" class="form-input" placeholder="Username" required>
                    <span class="input-icon">👤</span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="name" class="form-input" placeholder="Nam Lengkap" required>
                    <span class="input-icon">👤</span>
                </div>
            </div>

            <div class="form-group">
                <input type="email" name="email" class="form-input" placeholder="Alamat Email" required>
                <span class="input-icon">📧</span>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-input" placeholder="Password" id="password" required>
                <span class="input-icon">🔒</span>
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <div class="strength-text" id="strengthText">Masukkan password</div>
                </div>
            </div>

            <div class="form-group">
                <input type="password" name="confirmation_password" class="form-input" placeholder="Konfirmasi Password" id="confirmPassword" required>
                <span class="input-icon">🔐</span>
            </div>


            <button type="submit" class="signup-button" id="signupBtn" >
                Daftar Sekarang
            </button>
            <input type="hidden" name="role" id="role" value="siswa">
        </form>
            @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="color:red;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        <div class="login-link">
            Sudah punya akun? <a href="/login">Masuk</a>
        </div>
    </div>

    <script>
        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        
        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = [];
            
            if (password.length >= 8) strength++;
            else feedback.push('minimal 8 karakter');
            
            if (/[a-z]/.test(password)) strength++;
            else feedback.push('huruf kecil');
            
            if (/[A-Z]/.test(password)) strength++;
            else feedback.push('huruf besar');
            
            if (/[0-9]/.test(password)) strength++;
            else feedback.push('angka');
            
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            else feedback.push('simbol');
            
            return { strength, feedback };
        }
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const result = checkPasswordStrength(password);
            
            strengthFill.className = 'strength-fill';
            
            if (password.length === 0) {
                strengthText.textContent = 'Masukkan password';
                return;
            }
            
            switch (result.strength) {
                case 0:
                case 1:
                    strengthFill.classList.add('strength-weak');
                    strengthText.textContent = 'Lemah - butuh: ' + result.feedback.join(', ');
                    break;
                case 2:
                    strengthFill.classList.add('strength-fair');
                    strengthText.textContent = 'Cukup - butuh: ' + result.feedback.join(', ');
                    break;
                case 3:
                case 4:
                    strengthFill.classList.add('strength-good');
                    strengthText.textContent = 'Bagus - hampir sempurna!';
                    break;
                case 5:
                    strengthFill.classList.add('strength-strong');
                    strengthText.textContent = 'Sangat kuat! 💪';
                    break;
            }
        });

        // Confirm password validation
        const confirmPasswordInput = document.getElementById('confirmPassword');
        
        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.setCustomValidity('Password tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });

        // Enable/disable submit button
        const form = document.getElementById('signupForm');
        const submitBtn = document.getElementById('signupBtn');
        const termsCheckbox = document.getElementById('termsCheckbox');
        
        function updateSubmitButton() {
            const isFormValid = form.checkValidity();
            const isTermsChecked = termsCheckbox.checked;
            const isPasswordStrong = checkPasswordStrength(passwordInput.value).strength >= 3;
            
            submitBtn.disabled = !(isFormValid && isTermsChecked && isPasswordStrong);
        }
        

        // Form submission
       

        // Input animations
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Social button interactions
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const provider = this.textContent.trim();
                alert(`Daftar dengan ${provider} (Demo)`);
            });
        });

        // Terms links
        document.querySelectorAll('.terms-text a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const linkText = this.textContent;
                alert(`Halaman ${linkText} akan segera hadir!`);
            });
        });


        // Phone number formatting
        document.querySelector('input[type="tel"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = '62' + value.slice(1);
            }
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4);
            }
            if (value.length > 9) {
                value = value.slice(0, 9) + '-' + value.slice(9);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>