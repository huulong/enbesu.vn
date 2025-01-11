<?php
ob_start();
require_once 'inc/database.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user'])) {
    die('Vui lòng đăng nhập để đặt hàng.');
}


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die('Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng.');
}

_header('Đặt hàng');
_navbar();


$total_amount = 0;
foreach ($_SESSION['cart'] as $item) {
    if (is_object($item)) {
        $total_amount += $item->quantity * $item->price * 1000;
    } else {
        $decoded_item = json_decode($item);
        if ($decoded_item) {
            $total_amount += $decoded_item->quantity * $decoded_item->price * 1000;
        }
    }
}
?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">Thông tin đặt hàng</h2>
                </div>
                <div class="card-body">
                    <form action="process_order.php" method="POST">
                        <div class="form-group mb-3">
                            <label for="name">Họ tên *</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Địa chỉ *</label>
                            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">Số điện thoại *</label>
                            <input type="tel" name="phone" id="phone" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="note">Ghi chú</label>
                            <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="payment_method">Phương thức thanh toán *</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="cod">Thanh toán khi nhận hàng</option>
                            </select>
                        </div>

                        <div class="alert alert-success">
                            <strong>Tổng tiền:</strong> <?php echo number_format($total_amount, 0, ',', '.'); ?> đ
                        </div>

                        <button type="submit" class="btn btn-success">Đặt hàng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
_footer();
?>
