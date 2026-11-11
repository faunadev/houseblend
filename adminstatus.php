<?php
session_start();
$conn = new mysqli("localhost", "root", "", "reglog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders including total price (amount)
$sql = "SELECT order_id, customer_name, contact, status, total_price FROM tb_receipt ORDER BY order_id DESC";
$result = $conn->query($sql);

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];

    // Update order status in database (Reflects in orderstatus.php)
    $update_sql = "UPDATE tb_receipt SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        // Fetch customer details for SMS
        $fetch_sql = "SELECT customer_name, contact, total_price FROM tb_receipt WHERE order_id = ?";
        $stmt_fetch = $conn->prepare($fetch_sql);
        $stmt_fetch->bind_param("i", $order_id);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();
        $order = $result_fetch->fetch_assoc();
        $stmt_fetch->close();

        if ($order) {
            $customerName = $order['customer_name'];
            $recipientNumber = preg_replace('/^(09|0)/', '639', strval($order['contact']));
            $total_price = number_format($order['total_price'], 2); // Format price properly
            file_put_contents(__DIR__ . "/sms_log.txt", date("Y-m-d H:i:s") . " - Order ID: $order_id, Status: $status, Recipient Number: $recipientNumber\n", FILE_APPEND);
            
            // Status Messages
            $statusMessages = [
                'Processing' => "Hello $customerName, your order #$order_id (₱$total_price) is now being processed.",
                'Preparing for Delivery' => "Hello $customerName, your order #$order_id (₱$total_price) is being prepared for delivery.",
                'Out for Delivery' => "Hello $customerName, your order #$order_id (₱$total_price) is out for delivery. Expect it soon!",
                'Delivered' => "Hello $customerName, your order #$order_id (₱$total_price) has been delivered. Thank you for ordering!"
            ];
            

            if (isset($statusMessages[$status])) {
                // Send SMS Notification
                $apiKey = "se-xPvQ5a4W-hmASzbt7jxw0Tj_ErliuqCRW7a0j3sD2weu0CbQgbeqw1GhvgJFV";
                $message = $statusMessages[$status];
                $smsData = [
                    'content' => $message,
                    'from'    => '+639605242464',
                    'to'      => $recipientNumber
                ];

                $ch = curl_init("https://api.httpsms.com/v1/messages/send");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($smsData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Content-Type: application/json",
                    "Accept: application/json",
                    "x-api-key: $apiKey"
                ]);

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($response === false) {
                    // cURL error
                    $error = curl_error($ch);
                    echo "<script>alert('SMS failed to send. cURL error: $error');</script>";
                    file_put_contents(__DIR__ . "/sms_log.txt", date("Y-m-d H:i:s") . " - Order ID: $order_id, Status: $status, cURL Error: $error\n", FILE_APPEND);
                } else {
                    // Log the SMS response
                    file_put_contents(__DIR__ . "/sms_log.txt", date("Y-m-d H:i:s") . " - Order ID: $order_id, Status: $status, Response Code: $httpCode, Response: $response\n", FILE_APPEND);

                    if ($httpCode == 200) {
                        echo "<script>alert('Order status updated & SMS sent successfully!'); window.location.href='adminstatus.php';</script>";
                    } else {
                        echo "<script>alert('Order updated but SMS failed! Check logs.');</script>";
                    }
                }

                curl_close($ch);
            }
        }
    } else {
        echo "<script>alert('Failed to update order status.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order Status</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Table Styling */
        table {
            width: 75%; /* Adjusted width for proper spacing */
            border-collapse: collapse;
            margin: 20px auto 20px 300px; /* Move table to the right */
            background: white;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            white-space: nowrap; /* Prevents text from breaking */
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Sidebar Styling */
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

        /* Content Section */
        .content {
            margin-left: 270px;
            padding: 20px;
        }

        /* Admin Dashboard Title */
        .admin-dashboard {
            color: #cb6701;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            margin-left: 300px; /* Align with the table */
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar Section -->
<div class="sidebar">
    <p class="admin-dashboard"><a href="adminpage.php">Admin Dashboard</a></p>
    <a href="adminstatus.php">STATUS</a>
    <a href="sales.php" class="active">SALES</a>
    <a href="orders.php">ORDERS</a>
    <a href="adminfeedback.php">COMMENTS</a>
    <a href="logout.php">LOGOUT</a>
</div>

<h2>Admin Order Status Management</h2>
<table>
    <tr>
        <th>Order ID</th>
        <th>Customer Name</th>
        <th>Contact</th>
        <th>Amount (PHP)</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <form method="POST">
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
            <td><?php echo htmlspecialchars($row['contact']); ?></td>
            <td><?php echo "PHP " . number_format($row['total_price'], 2); ?></td>
            <td>
                <select name="status">
                    <option value="Processing" <?php echo ($row['status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
                    <option value="Preparing for Delivery" <?php echo ($row['status'] == 'Preparing for Delivery') ? 'selected' : ''; ?>>Preparing for Delivery</option>
                    <option value="Out for Delivery" <?php echo ($row['status'] == 'Out for Delivery') ? 'selected' : ''; ?>>Out for Delivery</option>
                    <option value="Delivered" <?php echo ($row['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                </select>
            </td>
            <td>
                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                <button type="submit">Update</button>
            </td>
        </form>
    </tr>
    <?php } ?>
</table>
</body>
</html>

