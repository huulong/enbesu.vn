<?php
session_start();
require_once('./inc/database.php');


if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $user_id = $_SESSION['user']['id'];
    
    $db = Database::getConnection();
    
   
    $stmt = $db->prepare("UPDATE orders SET status = 'Cancelled' 
                         WHERE id = ? AND user_id = ? 
                         AND status = 'Pending' 
                         AND payment_status = 'Chưa thanh toán'");
    
    $stmt->bind_param('ii', $order_id, $user_id);
    
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $_SESSION['message'] = 'Đã hủy đơn hàng thành công';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Không thể hủy đơn hàng này';
        $_SESSION['message_type'] = 'danger';
    }
}

header('Location: order.php');
exit();
?>
