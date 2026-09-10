<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nursery Product Shelf</title>
    <style>
        :root {
            --cream: #fffaf0;
            --pink: #ff9ec7;
            --rose: #ff6fa6;
            --blue: #7ed9ff;
            --mint: #baf2da;
            --purple: #8e7dff;
            --ink: #2d2340;
            --card: rgba(255,255,255,0.88);
            --border: #d7caff;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(180deg, #fff6d7 0%, #ffe2f2 33%, #dff7ff 100%);
            color: var(--ink);
            padding: 36px 22px;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        h1 {
            margin: 0;
            font-size: clamp(2rem, 4vw, 3rem);
        }
        .topbar .right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .pill {
            display: inline-block;
            background: #fff;
            border: 2px solid var(--border);
            border-radius: 999px;
            padding: 8px 14px;
            font-weight: 700;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }
        .primary { background: linear-gradient(135deg, var(--pink), var(--purple)); color: white; }
        .secondary { background: white; color: var(--ink); border: 2px solid var(--border); }
        .danger { background: #ffd3df; color: #732d4b; border: 2px solid #ff9ec7; }
        .alert {
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .alert.success { background: #dffbf1; color: #1d6d50; border: 1px solid #8fe0b7; }
        .alert.error { background: #ffe0ed; color: #8d2b5d; border: 1px solid #ff88b1; }
        .card {
            background: var(--card);
            border: 2px solid var(--border);
            border-radius: 24px;
            padding: 22px;
            box-shadow: 0 14px 28px rgba(95, 70, 130, 0.08);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }
        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid #e7dfff;
        }
        th {
            background: rgba(142,125,255,0.1);
            color: #48386e;
        }
        td {
            background: rgba(255,255,255,0.4);
        }
        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .muted {
            color: #6a5d85;
            font-style: italic;
        }
        .empty {
            text-align: center;
            padding: 20px;
            color: #6a5d85;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h1>🌼 Nursery Product Shelf</h1>
            <div class="right">
                <span class="pill">Welcome, <?php echo htmlspecialchars($user ?? 'Nursery Keeper'); ?></span>
                <a class="btn secondary" href="<?php echo site_url('logout'); ?>">Logout</a>
            </div>
        </div>

        <?php if (!empty($success)): ?>
            <div class="alert success"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom: 16px; flex-wrap: wrap;">
                <p class="muted" style="margin:0;">Little treasures and rhyme-time goods</p>
                <?php if (($role ?? 'user') === 'admin'): ?>
                    <a class="btn primary" href="<?php echo site_url('products/create'); ?>">+ Add Product</a>
                <?php endif; ?>
            </div>

            <?php if (empty($products)): ?>
                <div class="empty">The shelf is empty right now. Add a product to begin the nursery tale.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <?php
                                $product_id = is_array($product) ? ($product['id'] ?? 0) : ($product->id ?? 0);
                                $product_name = is_array($product) ? ($product['product_name'] ?? 'Unknown') : ($product->product_name ?? 'Unknown');
                                $description = is_array($product) ? ($product['description'] ?? '-') : ($product->description ?? '-');
                                $price = is_array($product) ? ($product['price'] ?? 0) : ($product->price ?? 0);
                                $quantity = is_array($product) ? ($product['quantity'] ?? 0) : ($product->quantity ?? 0);
                                $created_at = is_array($product) ? ($product['created_at'] ?? '-') : ($product->created_at ?? '-');
                            ?>
                            <tr>
                                <td><?php echo (int) $product_id; ?></td>
                                <td><?php echo htmlspecialchars($product_name); ?></td>
                                <td><?php echo htmlspecialchars($description); ?></td>
                                <td>$<?php echo number_format((float) $price, 2); ?></td>
                                <td><?php echo (int) $quantity; ?></td>
                                <td><?php echo htmlspecialchars($created_at); ?></td>
                                <td>
                                    <?php if (($role ?? 'user') === 'admin'): ?>
                                        <div class="actions">
                                            <a class="btn secondary" href="<?php echo site_url('products/edit/' . (int) $product_id); ?>">Edit</a>
                                            <form action="<?php echo site_url('products/delete/' . (int) $product_id); ?>" method="post" onsubmit="return confirm('Remove this nursery item?');">
                                                <button class="btn danger" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <span class="muted">Read only</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
