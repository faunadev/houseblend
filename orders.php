<?php
// Start the session and include config.php for DB connection
session_start();
include 'config.php';

// Define the title for the page
$title = "Order Management - Houseblend N's Tea & Coffee Shop";

// Query to retrieve orders from the tb_receipt table
$sql = "SELECT * FROM tb_receipt";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
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
            padding: 5px 5px;
            background-color: #cb6701;
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
    <p class="admin-dashboard"><a href="adminpage.php"style="color: white;">Admin Dashboard</a></p>
    <a href="">STOCKS</a>
    <a href="sales.php">SALES</a>
    <a href="orders.php" class="active">ORDERS</a>
    <a href="adminfeedback.php">COMMENTS</a>
    <a href="logout.php">LOGOUT</a>
</div>

<!-- Main Content Section -->
<div class="content">
    <h1>Orders List</h1>
    <p>List of all orders:</p>

    <!-- Orders Table -->
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Loop through each order and display in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['customer_name'] . "</td>";
                    echo "<td>P" . number_format($row['total_price'], 2) . "</td>";
                    echo "<td>" . $row['payment_method'] . "</td>";
                    echo "<td><a href='order_details.php?order_id=" . $row['order_id'] . "' class='button'>View Details</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No orders found</td></tr>";
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
