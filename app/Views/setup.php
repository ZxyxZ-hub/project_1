<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - ORD Form System</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #21aef5ff 0%, #3eb9f7ff 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            color: #2b2b2b;
            margin-bottom: 30px;
            text-align: center;
        }
        .message {
            padding: 12px 16px;
            margin: 10px 0;
            border-radius: 8px;
            font-size: 0.95rem;
        }
        .message.success {
            background: #efe;
            color: #3c3;
            border-left: 4px solid #3c3;
        }
        .message.error {
            background: #fee;
            color: #c33;
            border-left: 4px solid #c33;
        }
        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        .link {
            text-align: center;
            margin-top: 30px;
        }
        a {
            background: linear-gradient(180deg, #21aef5ff 0%, #1e9dd8ff 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 8px;
            display: inline-block;
            transition: transform 0.2s;
        }
        a:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Database Setup</h1>
        <?php if ($success): ?>
            <div class="message success">
                Setup completed successfully! ✓
            </div>
            <?php foreach ($messages as $msg): ?>
                <div class="message success">
                    <?= $msg ?>
                </div>
            <?php endforeach; ?>
            <div class="link">
                <a href="<?= base_url('auth/login') ?>">Go to Login</a>
            </div>
        <?php else: ?>
            <div class="message error">
                Setup failed! ✗
            </div>
            <?php foreach ($messages as $msg): ?>
                <div class="message error">
                    <?= $msg ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
