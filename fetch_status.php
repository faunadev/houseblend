<?php
session_start();
$conn = new mysqli("localhost", "root", "", "reglog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the latest order status
$user_id = $_SESSION['user_id'] ?? 1;
$sql = "SELECT status FROM tb_receipt WHERE order_id = (SELECT MAX(order_id) FROM tb_receipt WHERE customer_name = (SELECT name FROM tb_user WHERE id = $user_id))";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo $row['status'] ?? 'Processing';
?>
