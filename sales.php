<?php
// Start the session and include config.php for DB connection
session_start();
include 'config.php';

// Query to fetch sales data from tb_receipt and tb_order_items
$sql = "SELECT 
            r.customer_name, r.address, r.contact, r.total_price, r.payment_method, r.gcash_ref_code, 
            r.created_at, i.item_name, i.quantity, r.order_id
        FROM tb_receipt r
        LEFT JOIN tb_order_items i ON r.order_id = i.order_id
        ORDER BY r.created_at DESC"; // Ordering by the most recent sales

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales - Houseblend N's Tea & Coffee Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
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
    <a href="adminstatus.php">STATUS</a>
    <a href="sales.php" class="active">SALES</a>
    <a href="orders.php">ORDERS</a>
    <a href="adminfeedback.php">COMMENTS</a>
    <a href="logout.php">LOGOUT</a>
</div>

<!-- Main Content Section -->
<div class="content">
    <h1>Sales Records</h1>

    <!-- Sales Data Table -->
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>GCash Ref Code</th>
                <th>Items</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Declare a variable to keep track of order_id and its items
                $current_order_id = null;
                $items_list = '';

                while ($row = $result->fetch_assoc()) {
                    if ($current_order_id !== $row['order_id']) {
                        // Output the previous order's details before moving to the next order
                        if ($current_order_id !== null) {
                            echo "<tr>
                                    <td>$current_order_id</td>
                                    <td>" . $last_customer_name . "</td>
                                    <td>" . $last_address . "</td>
                                    <td>" . $last_contact . "</td>
                                    <td>P" . number_format($last_total_price, 2) . "</td>
                                    <td>" . $last_payment_method . "</td>
                                    <td>" . $last_gcash_ref_code . "</td>
                                    <td>" . $items_list . "</td>
                                    <td>" . $last_created_at . "</td>
                                  </tr>";
                        }

                        // Set the new order's initial details
                        $current_order_id = $row['order_id'];
                        $last_customer_name = $row['customer_name'];
                        $last_address = $row['address'];
                        $last_contact = $row['contact'];
                        $last_total_price = $row['total_price'];
                        $last_payment_method = $row['payment_method'];
                        $last_gcash_ref_code = $row['gcash_ref_code'];
                        $last_created_at = $row['created_at'];
                        $items_list = $row['item_name'] . ' (x' . $row['quantity'] . ')';
                    } else {
                        // Append items if this is a subsequent item for the same order
                        $items_list .= ', ' . $row['item_name'] . ' (x' . $row['quantity'] . ')';
                    }
                }

                // Output the last order after the loop
                echo "<tr>
                        <td>$current_order_id</td>
                        <td>" . $last_customer_name . "</td>
                        <td>" . $last_address . "</td>
                        <td>" . $last_contact . "</td>
                        <td>P" . number_format($last_total_price, 2) . "</td>
                        <td>" . $last_payment_method . "</td>
                        <td>" . $last_gcash_ref_code . "</td>
                        <td>" . $items_list . "</td>
                        <td>" . $last_created_at . "</td>
                      </tr>";

            } else {
                echo "<tr><td colspan='9'>No sales records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
