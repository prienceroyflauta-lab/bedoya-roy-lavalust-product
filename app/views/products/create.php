<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <style>
        :root { --cream: #fffaf0; --pink: #ff9ec7; --rose: #ff6fa6; --blue: #7ed9ff; --mint: #baf2da; --purple: #8e7dff; --ink: #2d2340; --card: rgba(255,255,255,0.88); --border: #d7caff; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: linear-gradient(180deg, #fff6d7 0%, #ffe2f2 33%, #dff7ff 100%); color: var(--ink); padding: 36px 22px; }
        .container { max-width: 720px; margin: 0 auto; }
        .card { background: var(--card); border: 2px solid var(--border); border-radius: 24px; padding: 24px; box-shadow: 0 14px 28px rgba(95, 70, 130, 0.08); }
        h1 { margin: 0 0 14px; }
        .meta { margin-bottom: 18px; color: #5a4d7a; }
        .alert { padding: 12px 14px; border-radius: 12px; margin-bottom: 18px; font-weight: 700; }
        .alert.error { background: #ffe0ed; color: #8d2b5d; border: 1px solid #ff88b1; }
        form { display: grid; gap: 18px; }
        label { display: grid; gap: 8px; font-weight: 700; }
        input, textarea { width: 100%; padding: 12px 14px; border-radius: 12px; border: 2px solid rgba(126, 217, 255, 0.9); font-size: 1rem; }
        textarea { min-height: 120px; resize: vertical; }
        .actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn { display: inline-block; text-decoration: none; border-radius: 12px; padding: 12px 18px; font-weight: 800; }
        .primary { background: linear-gradient(135deg, var(--pink), var(--purple)); color: white; }
        .secondary { background: white; color: var(--ink); border: 2px solid var(--border); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>🌱 Add a Nursery Product</h1>
            <div class="meta">Welcome, <?php echo htmlspecialchars($user ?? 'Nursery Keeper'); ?></div>

            <?php if (!empty($error)): ?>
                <div class="alert error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form action="<?php echo site_url('products'); ?>" method="post">
                <label>
                    Product Name
                    <input type="text" name="product_name" placeholder="Tiny Teddy Book" required>
                </label>
                <label>
                    Description
                    <textarea name="description" placeholder="A smiling storybook for bedtime rhymes..."></textarea>
                </label>
                <label>
                    Price
                    <input type="number" step="0.01" min="0" name="price" placeholder="25.00" required>
                </label>
                <label>
                    Quantity
                    <input type="number" min="0" name="quantity" placeholder="10" required>
                </label>
                <div class="actions">
                    <button class="btn primary" type="submit">Save Product</button>
                    <a class="btn secondary" href="<?php echo site_url('products'); ?>">Back to Shelf</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
