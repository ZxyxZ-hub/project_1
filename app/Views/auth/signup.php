<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - ORD Form System</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgb(231, 233, 235) 0%, rgb(171, 203, 207) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            min-height: 100vh;
        }

        .signup-container {
            background: #ffffff;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 440px;
            animation: slideUp 0.5s cubic-bezier(0.2, 0.9, 0.2, 1);
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: #000;
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .subtitle {
            color: #666;
            text-align: center;
            font-size: 0.95rem;
            margin-bottom: 28px;
            display: block;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert.error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .alert.success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #10b981;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        label {
            color: #000;
            font-weight: 600;
            font-size: 0.95rem;
        }

        input {
            padding: 12px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            background: #f9fafb;
            transition: all 180ms ease;
            outline: none;
            color: #000;
        }

        input::-webkit-credentials-auto-fill-button,
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            display: none !important;
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="password"]::-ms-reveal {
            display: none;
        }

        input:focus {
            border-color: #21aef5;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(33, 174, 245, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, #21aef5 0%, #1e9dd8 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 180ms ease;
            box-shadow: 0 8px 20px rgba(33, 174, 245, 0.25);
            margin-top: 8px;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(33, 174, 245, 0.35);
            filter: brightness(1.05);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .auth-link {
            text-align: center;
            margin-top: 24px;
            color: #666;
            font-size: 0.95rem;
        }

        .auth-link a {
            color: #21aef5;
            text-decoration: none;
            font-weight: 700;
            transition: color 180ms ease;
        }

        .auth-link a:hover {
            color: #1e9dd8;
            text-decoration: underline;
        }

        .error-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .error-list li {
            padding: 4px 0;
        }

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-wrapper input {
            width: 100%;
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 1.2rem;
            padding: 6px;
            display: none;
            align-items: center;
            justify-content: center;
            transition: all 180ms ease;
            opacity: 0.6;
        }

        .toggle-password.visible {
            display: flex;
        }

        .toggle-password:hover {
            color: #000;
            opacity: 1;
        }

        @media (max-width: 480px) {
            .signup-container {
                padding: 35px 25px;
                max-width: 100%;
            }

            h1 {
                font-size: 1.5rem;
            }

            input, .btn {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h1>Create Account</h1>
        <p class="subtitle">Join ORD Form System</p>

        <?php if ($session->has('errors')): ?>
            <div class="alert error">
                <ul class="error-list">
                    <?php foreach ($session->getFlashdata('errors') as $error): ?>
                        <li>• <?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($session->has('success')): ?>
            <div class="alert success">
                ✓ <?= $session->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/signup-submit') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" 
                       value="<?= old('full_name') ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Username</label>
                <input type="text" id="email" name="email" placeholder="Choose a username (no spaces)" 
                       value="<?= old('email') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Minimum 6 characters" required autocomplete="off">
                    <button type="button" class="toggle-password" id="togglePassword" aria-label="Toggle password visibility">
                        <svg class="eye-hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        <svg class="eye-shown" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirm" name="password_confirm" 
                           placeholder="Confirm your password" required autocomplete="off">
                    <button type="button" class="toggle-password" id="togglePasswordConfirm" aria-label="Toggle password visibility">
                        <svg class="eye-hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        <svg class="eye-shown" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn">Create Account</button>
        </form>

        <div class="auth-link">
            Already have an account? <a href="<?= base_url('auth/login') ?>">Sign in</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var togglePassword = document.getElementById('togglePassword');
            var togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            var passwordInput = document.getElementById('password');
            var passwordConfirmInput = document.getElementById('password_confirm');

            function setupPasswordToggle(button, input) {
                var eyeHidden = button.querySelector('.eye-hidden');
                var eyeShown = button.querySelector('.eye-shown');
                
                // Show/hide eye icon based on input value
                function updateIconVisibility() {
                    if (input.value.length > 0) {
                        button.classList.add('visible');
                    } else {
                        button.classList.remove('visible');
                        // Reset to password type if field is cleared
                        input.setAttribute('type', 'password');
                        eyeHidden.style.display = 'block';
                        eyeShown.style.display = 'none';
                        button.classList.remove('active');
                    }
                }

                // Listen for input changes
                input.addEventListener('input', updateIconVisibility);
                
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    var type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    
                    // Swap eye icons
                    if (type === 'text') {
                        eyeHidden.style.display = 'none';
                        eyeShown.style.display = 'block';
                        button.classList.add('active');
                    } else {
                        eyeHidden.style.display = 'block';
                        eyeShown.style.display = 'none';
                        button.classList.remove('active');
                    }
                });
            }

            setupPasswordToggle(togglePassword, passwordInput);
            setupPasswordToggle(togglePasswordConfirm, passwordConfirmInput);
        });
    </script>
</body>
</html>
