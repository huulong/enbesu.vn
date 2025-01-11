<?php
if (session_status() === PHP_SESSION_NONE) {
    ob_start();
}
require_once('./inc/database.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: order.php');
    exit();
}

$order_id = $_GET['id'];
$user_id = $_SESSION['user']['id'];
$db = Database::getConnection();

$query = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('ii', $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: order.php');
    exit();
}

$order_info = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?php echo $order_id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success">Chi tiết đơn hàng #<?php echo $order_id; ?></h2>
            <a href="order.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="row g-4">
            <!-- Thông tin đơn hàng -->
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order_info['created_at'])); ?></p>
                        <p><strong>Trạng thái đơn hàng:</strong> 
                            <span class="badge 
                                <?php 
                                    echo match($order_info['status']) {
                                        'Pending' => 'bg-warning',
                                        'Processing' => 'bg-info',
                                        'Cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                ?>">
                                <?php 
                                    echo match($order_info['status']) {
                                        'Pending' => 'Chờ xử lý',
                                        'Processing' => 'Đang xử lý',
                                        'Cancelled' => 'Đã hủy',
                                        default => $order_info['status']
                                    };
                                ?>
                            </span>
                        </p>
                        <p><strong>Trạng thái thanh toán:</strong> 
                            <span class="badge 
                                <?php 
                                    echo match($order_info['payment_status']) {
                                        'Đã thanh toán' => 'bg-success',
                                        'Chưa thanh toán' => 'bg-warning',
                                        default => 'bg-secondary'
                                    };
                                ?>">
                                <?php echo $order_info['payment_status']; ?>
                            </span>
                        </p>
                        <p><strong>Phương thức thanh toán:</strong> <?php echo $order_info['payment_method']; ?></p>
                        <p><strong>Tổng tiền:</strong> <span class="text-success fw-bold"><?php echo number_format($order_info['total_amount'], 0, ',', '.'); ?> đ</span></p>
                    </div>
                </div>
            </div>

            <!-- Thông tin người nhận -->
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Thông tin người nhận</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($order_info['customer_name']); ?></p>
                        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order_info['customer_address']); ?></p>
                        <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order_info['customer_phone']); ?></p>
                        <p><strong>Ghi chú:</strong> <?php echo htmlspecialchars($order_info['note'] ?? 'Không có'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút hủy đơn hàng -->
        <?php if ($order_info['status'] === 'Pending' && $order_info['payment_status'] === 'Chưa thanh toán'): ?>
            <div class="mt-4 text-center">
                <form action="cancel_order.php" method="POST" 
                      onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng #<?php echo $order_id; ?> không?')">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <button type="submit" class="btn btn-danger px-4 py-2">
                        <i class="fas fa-times-circle"></i> Hủy đơn hàng
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
