<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

include 'config.php';

// Check if the order_id is passed in the URL
if (!isset($_GET['order_id'])) {
    die('Order ID is missing.');
}

$order_id = $_GET['order_id'];

// Query to fetch order details from the tb_order table
$sql = "SELECT * FROM tb_order WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the order exists
if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    die('Order not found.');
}

// Fetch order items from the tb_order_items table (only item_name, quantity, price)
$sqlItems = "SELECT item_name, quantity, price FROM tb_order_items WHERE order_id = ?";
$stmtItems = $conn->prepare($sqlItems);
$stmtItems->bind_param("i", $order_id);
$stmtItems->execute();
$resultItems = $stmtItems->get_result();

// Store the order items in an array for both display and saving
$orderItems = [];
while ($item = $resultItems->fetch_assoc()) {
    $orderItems[] = $item;
}

// Convert the order items array to JSON format for storage
$orderItemsJson = json_encode($orderItems);

// Prepare the insert statement for tb_receipt
$insertSql = "INSERT INTO tb_receipt (order_id, customer_name, address, contact, total_price, payment_method, gcash_ref_code, items) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("issdssss", 
    $order['id'], 
    $order['name'], 
    $order['address'], 
    $order['contact'], 
    $order['total_price'], 
    $order['payment_method'], 
    $order['gcash_ref_code'], 
    $orderItemsJson
);

// Execute the insert statement
if (!$insertStmt->execute()) {
    die('Failed to store receipt in the database.');
}

// Close the database connection
$stmt->close();
$stmtItems->close();
$insertStmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            color: white;
            position: relative;
        }

        .receipt-container {
            width: 20%; /* Adjusted width to make it narrower */
            padding: 20px;
            margin: 50px auto;
            background-color: #2F4F4F;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .logo {
            width: 130px; /* Larger logo size */
            display: inline-block;
            margin-top: -60px;
        }

        .receipt-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .r {
            color: #fff;
            text-align: center;
            margin-top: -60px;
            flex: 1; /* Center the title */
            text-align: center;
        }

        .order-details, .order-items {
            margin-bottom: 20px;
        }

        .order-details p,
        .order-items p {
            font-size: 14px;
            margin: 8px 0;
        }

        .order-details p strong,
        .order-items p strong {
            font-weight: bold;
        }

        .order-items div {
            background-color: #333;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .order-items div p {
            margin: 5px 0;
        }

        .order-items h4 {
            color: #ff6f00;
            margin-bottom: 10px;
        }

        .customer{
            color: #ff6f00;
            font-weight: bold;
        }

        .ok-button {
            display: inline-block;
            background-color: #fff;
            padding: 2px 8px;
            color: #333;
            font-size: 12px;
            border-radius:4px;
            text-decoration: none;
            text-align: center;
            margin-top: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .ok-button:hover {
            background-color: #ff8500;
        }

        /* Prompt Message Styles */
        .thank-you-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px 40px;
            border-radius: 8px;
            font-size: 18px;
            display: none;
            z-index: 999;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 998;
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <div class="receipt-header">
        <img src="logo.png" alt="Company Logo" class="logo">
    </div>
    <h1 class="r">Receipt</h1>
    <p class="customer">Customer's info:</p>

    <div class="order-details">
        <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
        <p><strong>Name:</strong> <?php echo $order['name']; ?></p>
        <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
        <p><strong>Contact:</strong> <?php echo $order['contact']; ?></p>
        <p><strong>Total:</strong> P<?php echo number_format($order['total_price'], 2); ?></p>
        <p><strong>Payment Method:</strong> <?php echo $order['payment_method']; ?></p>
        <?php if ($order['gcash_ref_code']) { ?>
            <p><strong>GCash Ref Code:</strong> <?php echo $order['gcash_ref_code']; ?></p>
        <?php } ?>
    </div>

    <div class="order-items">
        <h4>Order Items:</h4>
        <?php foreach ($orderItems as $item) { ?>
            <div>
                <p><strong>Item:</strong> <?php echo $item['item_name']; ?></p>
                <p><strong>Qty:</strong> <?php echo $item['quantity']; ?></p>
                <p><strong>Price:</strong> P<?php echo number_format($item['price'], 2); ?></p>
            </div>
        <?php } ?>
    
    
    <a href="#" class="ok-button" id="okButton">OK</a>
</div>

<!-- Thank You Prompt -->
<div class="overlay" id="overlay"></div>
<div class="thank-you-message" id="thankYouMessage">Thank You for your purchase!</div>

<script>
    document.getElementById("okButton").addEventListener("click", function(e) {
        e.preventDefault();

        // Show the thank you message and overlay
        document.getElementById("thankYouMessage").style.display = "block";
        document.getElementById("overlay").style.display = "block";

        // After 2 seconds, hide the prompt and redirect
        setTimeout(function() {
            // Hide the thank you message and overlay
            document.getElementById("thankYouMessage").style.display = "none";
            document.getElementById("overlay").style.display = "none";
            
            // Redirect to homepage with the username parameter
            window.location.href = "orderstatus.php?username=<?php echo urlencode($_SESSION['username']); ?>";
        }, 2000); // 2000ms = 2 seconds
    });
</script>

</body>
</html>
