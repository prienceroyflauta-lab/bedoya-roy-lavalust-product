<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursery Rhyme Login</title>
    <style>
        :root {
            --sky: #fff7d9;
            --pink: #ff9ec7;
            --rose: #ff6fa6;
            --blue: #7ed9ff;
            --mint: #a6f1d6;
            --purple: #8e7dff;
            --ink: #2d2340;
            --card: rgba(255,255,255,0.7);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(180deg, #fffaf0 0%, #ffe8f1 38%, #d7f7ff 100%);
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }
        .card {
            background: var(--card);
            border: 3px solid rgba(142,125,255,0.6);
            border-radius: 25px;
            box-shadow: 0 18px 50px rgba(91, 71, 160, 0.18);
            padding: 32px;
            width: min(100%, 500px);
        }
        .badge {
            display: inline-block;
            background: var(--mint);
            color: var(--ink);
            padding: 7px 14px;
            border-radius: 999px;
            font-weight: 700;
            letter-spacing: 0.06em;
            margin-bottom: 12px;
        }
        h1 {
            margin: 0 0 12px;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.1;
        }
        p {
            margin: 0 0 18px;
            color: #4f4969;
        }
        .alert {
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 12px;
            font-weight: 600;
        }
        .alert.error { background: #ffe0ed; color: #8d2b5d; border: 1px solid #ff88b1; }
        .alert.success { background: #dffbf1; color: #1d6d50; border: 1px solid #8fe0b7; }
        form {
            display: grid;
            gap: 16px;
        }
        label {
            display: grid;
            gap: 8px;
            font-weight: 700;
        }
        input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 2px solid rgba(126, 217, 255, 0.9);
            font-size: 1rem;
        }
        button {
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--pink), var(--purple));
            color: white;
            font-size: 1rem;
            font-weight: 800;
            padding: 14px;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(142,125,255,0.25);
        }
        .hint {
            margin-top: 18px;
            font-size: 0.9rem;
            color: #4b3d67;
        }
        .hint strong { color: var(--rose); }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">🍼 Nursery Login</span>
        <h1>Little Lamb's Tale</h1>
        <p>Enter the rhyme gate to manage the nursery shelf.</p>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <form action="<?php echo site_url('login'); ?>" method="post">
            <label>
                Username
                <input type="text" name="username" placeholder="admin" required>
            </label>
            <label>
                Password
                <input type="password" name="password" placeholder="nursery123" required>
            </label>
            <button type="submit">Enter the Nursery</button>
        </form>

        <div class="hint">
            Default rhyme keeper: <strong>admin</strong> / <strong>admin123</strong>
        </div>
    </div>
</body>
</html>
