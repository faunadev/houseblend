<?php
// Start the session and include config.php for DB connection
session_start();
include 'config.php';

// Check if order_id is passed in the URL
if (!isset($_GET['order_id'])) {
    die('Order ID is missing.');
}

$order_id = $_GET['order_id'];

// Query to fetch order details from tb_receipt using the order_id
$sql = "SELECT * FROM tb_receipt WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

// Check if order exists
if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
} else {
    die('Order not found.');
}

// Query to fetch order items from tb_order_items using the order_id
$sql_items = "SELECT item_name, quantity, price FROM tb_order_items WHERE order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items_result = $stmt_items->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Houseblend N's Tea & Coffee Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Body Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styling (Use the same as your adminpage) */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 10px 0;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #cb6701;
        }

        .sidebar a.active {
            background-color: #cb6701;
            font-weight: bold;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .button {
            padding: 2px 2px;
            background-color: #cb6701;
            font-size: 12px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .button:hover {
            background-color: #ff6f00;
        }

        .admin-dashboard {
            color: #cb6701;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar Section -->
<div class="sidebar">
    <p class="admin-dashboard"><a href="adminpage.php">Admin Dashboard</a></p>
    <a href="">STOCKS</a>
    <a href="sales.php">SALES</a>
    <a href="orders.php" class="active">ORDERS</a>
    <a href="adminfeedback.php">COMMENTS</a>
    <a href="logout.php">LOGOUT</a>
</div>

<!-- Main Content Section -->
<div class="content">
    <h1>Order Details for Order ID: <?php echo $order['order_id']; ?></h1>

    <!-- Order Summary -->
    <h3>Customer Information:</h3>
    <p><strong>Customer Name:</strong> <?php echo $order['customer_name']; ?></p>
    <p><strong>Contact:</strong> <?php echo $order['contact']; ?></p>
    <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
    <p><strong>Total Price:</strong> P<?php echo number_format($order['total_price'], 2); ?></p>
    <p><strong>Payment Method:</strong> <?php echo $order['payment_method']; ?></p>
    <?php if ($order['gcash_ref_code']) { ?>
        <p><strong>GCash Ref Code:</strong> <?php echo $order['gcash_ref_code']; ?></p>
    <?php } ?>

    <!-- Order Items -->
    <h3>Order Items:</h3>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($items_result->num_rows > 0) {
                while ($item = $items_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $item['item_name'] . "</td>";
                    echo "<td>" . $item['quantity'] . "</td>";
                    echo "<td>P" . number_format($item['price'], 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No items found for this order.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Back Button -->
    <a href="orders.php" class="button">Back to Orders</a>
</div>

</body>
</html>

<?php
// Close the database connection
$stmt->close();
$stmt_items->close();
$conn->close();
?>
