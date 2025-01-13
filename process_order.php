<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

require_once 'inc/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    die('Bạn cần đăng nhập trước khi đặt hàng.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $note = isset($_POST['note']) ? trim($_POST['note']) : '';
    $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $total_amount = 0;

    if (empty($cart)) {
        die('Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi đặt hàng.');
    }

    foreach ($cart as $item) {
        if (is_object($item)) {
            $total_amount += $item->quantity * $item->price * 1000;
        } else {
            $decoded_item = json_decode($item);
            if ($decoded_item) {
                $total_amount += $decoded_item->quantity * $decoded_item->price * 1000;
            }
        }
    }

    if (empty($name) || empty($address) || empty($phone)) {
        die('Vui lòng nhập đầy đủ thông tin bắt buộc.');
    }

    $_SESSION['order_info'] = [
        'name' => $name,
        'address' => $address,
        'phone' => $phone,
        'note' => $note
    ];

    $db = Database::getConnection();
    $user_id = $_SESSION['user']['id'];

    $db->begin_transaction();
    try {
        $status = 'Pending';
        $stmt = $db->prepare("INSERT INTO `orders` (customer_name, customer_address, customer_phone, note, total_amount, user_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception($db->error);
        }
        $stmt->bind_param("ssssdis", $name, $address, $phone, $note, $total_amount, $user_id, $status);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        $order_id = $db->insert_id;

        // Insert order items
        $stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception($db->error);
        }

        foreach ($cart as $item) {
            $product_data = is_object($item) ? $item : json_decode($item);
            if ($product_data) {
                $product_id = $product_data->id;
                $quantity = $product_data->quantity;
                $price = $product_data->price * 1000;
                
                $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                if (!$stmt->execute()) {
                    throw new Exception($stmt->error);
                }
            }
        }

        unset($_SESSION['cart']);
        unset($_SESSION['total']);
        unset($_SESSION['order_info']);

        $db->commit();
        ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: linear-gradient(135deg, #74b9ff, #a29bfe);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .container {
            max-width: 500px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            padding: 40px 30px;
            animation: fadeIn 1s ease-in-out;
        }
        .checkmark {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #2ecc71;
            margin: 0 auto 20px;
            position: relative;
            animation: popIn 0.6s ease-in-out;
        }
        .checkmark::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            width: 35px;
            height: 70px;
            border: solid #fff;
            border-width: 0 6px 6px 0;
            animation: draw 0.5s ease-in-out 0.5s forwards;
        }
        @keyframes popIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        @keyframes draw {
            0% {
                width: 0;
                height: 0;
            }
            100% {
                width: 35px;
                height: 70px;
            }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        h1 {
            font-size: 26px;
            color: #2ecc71;
            margin-bottom: 15px;
            animation: fadeIn 1.2s ease-in-out;
        }
        .success-message {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
        }
        .order-details {
            background: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            animation: fadeIn 1.4s ease-in-out;
        }
        .order-details p {
            margin: 5px 0;
            font-size: 14px;
        }
        .order-details strong {
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            border-radius: 30px;
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        .button:hover {
            transform: translateY(-5px);
            background: linear-gradient(135deg, #0984e3, #74b9ff);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="checkmark"></div>
        <h1>Đặt hàng thành công!</h1>
        <div class="success-message">
            <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.</p>
        </div>
        <div class="order-details">
            <p><strong>Mã đơn hàng:</strong> #<?php echo $order_id; ?></p>
            <p><strong>Tổng tiền:</strong> <?php echo number_format($total_amount, 0, ',', '.'); ?> đ</p>
        </div>
        <div class="center">
            <a href="index.php" class="button">Tiếp tục mua sắm</a>
            <a href="order.php" class="button">Xem đơn hàng</a>
        </div>
    </div>
</body>
</html>
        <?php
        exit();
    } catch (Exception $e) {
        $db->rollback();
        die('Có lỗi xảy ra trong quá trình xử lý đơn hàng: ' . $e->getMessage());
    } finally {
        $db->close();
    }
} else {
    die('Yêu cầu không hợp lệ.');
}
?>
