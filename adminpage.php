<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Define variables for dynamic content
$title = "Admin Dashboard - Houseblend N's Tea & Coffee Shop";
$logoSrc = "logo.png"; // Assuming logo is the same
$icedCoffeeSrc = "icedkopi.png";

$menuItems = [
    "STATUS" => ["link" => "adminstatus.php", "icon" => "fas fa-box"], // Stocks Icon
    "SALES" => ["link" => "sales.php", "icon" => "fas fa-chart-line"], // Sales Icon
    "ORDERS" => ["link" => "orders.php", "icon" => "fas fa-shopping-cart"], // Orders Icon
    "FEEDBACKS" => ["link" => "adminfeedback.php", "icon" => "fas fa-comments"], // Feedback Icon
    "LOGOUT" => ["link" => "logout.php", "icon" => "fas fa-sign-out-alt"], // Logout Icon
];
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Body Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('bg.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            color: white;
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

        /* Section Title Styling */
        .sidebar .admin-dashboard {
            color: #cb6701;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Content area */
        .content {
            margin-left: 270px;
            padding: 20px;
            text-align: center;
            color: white;
        }

        /* Logo container for alignment */
        .logo-container {
            display: inline-flex;
            margin-bottom: 50px;
            align-items: center;
            justify-content: center;
        }

        .logo-container img {
            height: auto;
        }

        .logo-container img:first-child {
            width: 250px; /* Main logo size */
            margin-bottom: 50px;
        }

        .logo-container img:last-child {
            width: 500px; /* Larger size for iced coffee logo */
            margin-left: -100px; /* Adds the slight gap between the two logos */
        }

        footer {
            padding: 20px;
            text-align: center;
            border-top: 1px solid #ddd;
            background-color: black;
            position: relative;
            width: 100%;
            bottom: 0;
        }

        footer a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ff8500;
        }

        /* Sidebar Toggle for Mobile */
        #menu-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: sticky;
                display: none;
                top: 0;
                background-color: rgba(0, 0, 0, 0.9);
            }

            .sidebar.active {
                display: block;
            }

            #menu-toggle {
                display: block;
                background: none;
                color: white;
                font-size: 24px;
                border: none;
                cursor: pointer;
                margin: 10px;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar Toggle Button for Mobile -->
<button id="menu-toggle">&#9776;</button>

<!-- Sidebar Section -->
<div class="sidebar" id="sidebar">
    <p class="admin-dashboard">Admin Dashboard</p>
    
    <?php foreach ($menuItems as $item => $details): ?>
        <a href="<?php echo $details['link']; ?>" class="<?php echo $currentPage === $details['link'] ? 'active' : ''; ?>">
            <i class="<?php echo $details['icon']; ?>"></i> <?php echo $item; ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Main Content Section -->
<div class="content">
    <div class="logo-container">
        <img src="<?php echo $logoSrc; ?>" alt="Main Logo">
        <img src="<?php echo $icedCoffeeSrc; ?>" alt="Iced Coffee Logo">
    </div>
</div>

<footer>
    <p>&copy; 2024 Houseblend N's Tea & Coffee Shop. All rights reserved.</p>
</footer>

<script>
    // Toggle Sidebar on Mobile
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    });
</script>

</body>
</html>
