<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORD Form System - Create Professional Form Reports</title>
    <link rel="stylesheet" href="<?= base_url('css/shared-styles.css') ?>">
    <style>
        body {
            background: linear-gradient(135deg, #21aef5 0%, #3eb9f7 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 30px;
        }

        .hero-container {
            text-align: center;
            max-width: 600px;
        }

        .hero-header {
            margin-bottom: 12px;
        }

        .hero-header .prc-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.15));
        }

        .hero-header h1 {
            color: #ffffff;
            font-size: 2.8rem;
            margin: 0 0 12px 0;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .hero-header .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin: 0;
            font-weight: 300;
            letter-spacing: 0.3px;
        }

        .hero-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 40px 30px;
            margin-top: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .hero-description {
            color: #666;
            font-size: 1rem;
            margin-bottom: 28px;
            line-height: 1.6;
        }

        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 28px;
            text-align: left;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
        }

        .feature-item::before {
            content: "✓";
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(33, 174, 245, 0.1);
            color: #21aef5;
            font-weight: 700;
            flex-shrink: 0;
            font-size: 0.9rem;
        }

        .feature-item span {
            color: #333;
            font-size: 0.95rem;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            background: linear-gradient(135deg, #21aef5 0%, #1e9dd8 100%);
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(33, 174, 245, 0.3);
            transition: all 220ms cubic-bezier(0.2, 0.9, 0.2, 1);
            border: none;
            cursor: pointer;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }

        .cta-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: left 300ms ease;
            pointer-events: none;
        }

        .cta-btn:hover::before {
            left: 100%;
        }

        .cta-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(33, 174, 245, 0.4);
        }

        .cta-btn:active {
            transform: translateY(-2px);
        }

        .cta-btn svg {
            width: 20px;
            height: 20px;
        }

        .secondary-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border: 2px solid transparent;
            border-radius: 10px;
            transition: all 200ms ease;
        }

        .secondary-link:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        @media (max-width: 600px) {
            .hero-header h1 {
                font-size: 2rem;
            }

            .hero-header .subtitle {
                font-size: 0.95rem;
            }

            .hero-content {
                padding: 30px 20px;
            }

            .cta-btn {
                padding: 12px 24px;
                font-size: 0.95rem;
            }

            .hero-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="hero-container">
        <div class="hero-header">
            <img src="<?= base_url('images/logo.png') ?>" alt="PRC Logo" class="prc-logo">
            <h1>ORD Form System</h1>
            <p class="subtitle">Professional Form Reports Made Simple</p>
        </div>

        <div class="hero-content">
            <p class="hero-description">
                Create, manage, and submit professional form reports with ease. 
                No complicated tools needed—just a streamlined, intuitive system built for efficiency.
            </p>

            <div class="feature-list">
                <div class="feature-item">
                    <span>Easy-to-use form creation</span>
                </div>
                <div class="feature-item">
                    <span>Professional report management</span>
                </div>
                <div class="feature-item">
                    <span>Secure data storage</span>
                </div>
                <div class="feature-item">
                    <span>Real-time form tracking</span>
                </div>
            </div>

            <div class="hero-actions">
                <a href="<?= base_url('form') ?>" class="cta-btn">
                    Get Started
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="<?= base_url('auth/login') ?>" class="secondary-link">Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>