<?php
// db connection setup
include 'config.php';

// Get the JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Extract order details
$name = $data['name'];
$address = $data['address'];
$contact = $data['contact'];
$cartItems = $data['cartItems'];
$totalPrice = $data['totalPrice'];
$paymentMethod = $data['paymentMethod'];
$gcashRefCode = $data['gcashRefCode'];

// Insert the order details into the tb_order table
$sql = "INSERT INTO tb_order (name, address, contact, total_price, payment_method, gcash_ref_code) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssiss", $name, $address, $contact, $totalPrice, $paymentMethod, $gcashRefCode);

// Execute the query
if ($stmt->execute()) {
    // Get the inserted order ID
    $orderId = $stmt->insert_id;

    // Insert cart items into the tb_order_items table
    foreach ($cartItems as $item) {
        $itemName = $item['name'];
        $itemQuantity = $item['quantity'];
        $itemPrice = $item['price'];

        $itemSql = "INSERT INTO tb_order_items (order_id, item_name, quantity, price) 
                    VALUES (?, ?, ?, ?)";
        $itemStmt = $conn->prepare($itemSql);
        $itemStmt->bind_param("isid", $orderId, $itemName, $itemQuantity, $itemPrice);
        $itemStmt->execute();
    }

    // Return the order_id in the response
    echo json_encode(["success" => true, "order_id" => $orderId]);
} else {
    // Return failure response
    echo json_encode(["success" => false]);
}

$stmt->close();
$conn->close();
?>
