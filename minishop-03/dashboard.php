<?php
declare(strict_types=1);
session_start();

// Guard: Chặn truy cập nếu chưa đăng nhập và đẩy về trang login
if (empty($_SESSION['auth'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/data.php';

// Xử lý Form đặt hàng (Lưu vào Session) 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'order') {
    $sku = trim($_POST['order_sku'] ?? '');
    $qty = (int)($_POST['order_qty'] ?? 0);
    
    if ($sku !== '' && $qty > 0) {
        // Khởi tạo mảng orders trong session nếu chưa có
        if (!isset($_SESSION['orders'])) {
            $_SESSION['orders'] = [];
        }
        
        $_SESSION['orders'][] = [
            'sku' => $sku,
            'qty' => $qty,
            'at'  => date('H:i:s'),
        ];
    }
    
    // PRG Pattern: Redirect để tránh bị submit lại form khi ấn F5
    header('Location: dashboard.php');
    exit;
}

// Hàm tiện ích hỗ trợ escape HTML ngắn gọn theo chuẩn trên lớp
function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$totalInventoryValue = 0;
$orders = $_SESSION['orders'] ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>MiniShop — Dashboard (Buổi 3)</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 1.5rem; }
        table { border-collapse: collapse; width: 100%; max-width: 960px; margin-bottom: 1.5rem; }
        th, td { border: 1px solid #ccc; padding: .5rem .75rem; text-align: left; }
        th { background: #f3f4f6; }
        .header-bar { display: flex; justify-content: space-between; align-items: center; max-width: 960px; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px;}
        .header-bar h1 { margin: 0; }
    </style>
</head>
<body>
    <div class="header-bar">
        <h1>MiniShop Dashboard (OOP)</h1>
        <p>Xin chào, <strong><?= h($_SESSION['username']) ?></strong>! | <a href="logout.php">Đăng xuất</a></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>SL</th>
                <th>Thành tiền</th>
                <th>Mức tồn</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productObjects as $p): 
                // Tính tổng giá trị kho bằng CÁCH GỌI METHOD của object
                $totalInventoryValue += $p->lineTotal();
            ?>
            <tr>
                <td><?= h($p->sku) ?></td>
                <td><?= h($p->name) ?></td>
                <!-- Gọi tên danh mục từ mảng map đã chuẩn bị trong data.php -->
                <td><?= h($categoryMap[$p->categoryId] ?? '—') ?></td>
                <td><?= $p->price ?></td>
                <td><?= $p->qty ?></td>
                <!-- Hiển thị thành tiền bằng cách gọi method -->
                <td><?= $p->lineTotal() ?></td>
                <td><?= h($p->stockLevel()) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <p>Số sản phẩm: <?= count($productObjects) ?></p>
    <p>Tổng giá trị kho: <strong><?= $totalInventoryValue ?></strong></p>

    <hr>
    
    <h2>Đặt hàng thử nghiệm (Lưu Session)</h2>
    <form method="POST" action="dashboard.php" style="margin-bottom: 1rem;">
        <input type="hidden" name="action" value="order">
        <select name="order_sku" required>
            <option value="">-- Chọn sản phẩm --</option>
            <?php foreach ($productObjects as $p): ?>
                <option value="<?= h($p->sku) ?>"><?= h($p->sku . ' — ' . $p->name) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="order_qty" value="1" min="1" required>
        <button type="submit">Đặt thử</button>
    </form>

    <?php if (!empty($orders)): ?>
        <h3>Danh sách đã đặt trong phiên:</h3>
        <ul>
            <?php foreach ($orders as $order): ?>
                <li>SKU: <strong><?= h($order['sku']) ?></strong> | Số lượng: <?= $order['qty'] ?> | <em>Lúc: <?= h($order['at']) ?></em></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>