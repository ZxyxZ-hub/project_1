<?php
$session = session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ORD Form System</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #21aef5ff 0%, #3eb9f7ff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            min-height: 100vh;
        }

        .login-container {
            background: #ffffff;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 420px;
            animation: slideUp 0.5s ease-out;
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

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2b2b2b;
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 30px;
        }

        .subtitle {
            color: #7a7a7a;
            text-align: center;
            font-size: 0.95rem;
            margin-bottom: 30px;
            display: none;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
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
            background: #fee;
            color: #c33;
            border-left: 4px solid #c33;
        }

        .alert.success {
            background: #efe;
            color: #3c3;
            border-left: 4px solid #3c3;
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
            color: #2b2b2b;
            font-weight: 600;
            font-size: 0.95rem;
        }

        input {
            padding: 12px 14px;
            border: 2px solid #e6eef7;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            background: #fbfdff;
            transition: border-color 180ms ease, box-shadow 180ms ease;
            outline: none;
        }

        input:focus {
            border-color: #21aef5ff;
            box-shadow: 0 0 0 3px rgba(33, 174, 245, 0.1);
        }

        .btn {
            background: linear-gradient(180deg, #21aef5ff 0%, #1e9dd8ff 100%);
            color: #fff;
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 180ms ease, box-shadow 180ms ease, filter 180ms ease;
            box-shadow: 0 8px 20px rgba(33, 174, 245, 0.25);
            margin-top: 10px;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(33, 174, 245, 0.35);
            filter: brightness(1.05);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #7a7a7a;
            font-size: 0.95rem;
        }

        .signup-link a {
            color: #21aef5ff;
            text-decoration: none;
            font-weight: 700;
            transition: color 180ms ease;
        }

        .signup-link a:hover {
            color: #1e9dd8ff;
            text-decoration: underline;
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
            color: black;
            font-size: 1.2rem;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 180ms ease, opacity 180ms ease;
            opacity: 0.5;
        }

        .toggle-password:hover {
            color: black;
            opacity: 0.7;
        }

        .toggle-password.active {
            opacity: 1;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 35px 25px;
            }

            h1 {
                font-size: 1.4rem;
            }

            input, .btn {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="<?= base_url('images/prc logo.png') ?>" alt="PRC Logo" class="logo">
        </div>
        <h1>ORD Form System</h1>
        <p class="subtitle">ORD Form System</p>

        <?php if ($session->has('error')): ?>
            <div class="alert error">
                <?= $session->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if ($session->has('success')): ?>
            <div class="alert success">
                <?= $session->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="./login-submit" method="POST">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">Username</label>
                <input type="text" id="email" name="email" placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <button type="button" class="toggle-password" id="togglePassword" aria-label="Toggle password visibility">
                        <svg class="eye-hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        <svg class="eye-shown" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="./signup">Sign up here</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var togglePassword = document.getElementById('togglePassword');
            var passwordInput = document.getElementById('password');
            var eyeHidden = togglePassword.querySelector('.eye-hidden');
            var eyeShown = togglePassword.querySelector('.eye-shown');

            togglePassword.addEventListener('click', function(e) {
                e.preventDefault();
                var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Swap eye icons
                if (type === 'text') {
                    eyeHidden.style.display = 'none';
                    eyeShown.style.display = 'block';
                    togglePassword.classList.add('active');
                } else {
                    eyeHidden.style.display = 'block';
                    eyeShown.style.display = 'none';
                    togglePassword.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
