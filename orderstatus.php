<?php
session_start();
$title = "Homepage - Houseblend N's Tea & Coffee Shop";
$logoSrc = "logo.png";
$menuItems = [
    "HOME" => "homepage.php",
    "MENU" => "menupage.php",
    "ABOUT US" => "about.php",
    "CONTACTS" => "contacts.php",
];
$searchPlaceholder = "Search...";
$searchLogoSrc = "slogo.png";
$profileLogoSrc = "profile.png";


$conn = new mysqli("localhost", "root", "", "reglog");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the latest order for the logged-in user
$user_id = $_SESSION['user_id'] ?? 1;
$sql = "SELECT r.order_id, r.customer_name, r.address, r.contact, r.total_price, r.payment_method, r.gcash_ref_code, r.status 
        FROM tb_receipt r
        WHERE r.order_id = (SELECT MAX(order_id) FROM tb_receipt WHERE customer_name = (SELECT name FROM tb_user WHERE id = $user_id))
        LIMIT 1";

$result = $conn->query($sql);
$order = $result->fetch_assoc();

if (!$order) {
    echo "<p>No recent orders found.</p>";
    exit;
}

// Define order tracking statuses
$status_steps = [
    'Processing' => 'fas fa-spinner',
    'Preparing for Delivery' => 'fas fa-mug-hot',
    'Out for Delivery' => 'fas fa-truck',
    'Delivered' => 'fas fa-check-circle'
];

// Get the current status index
$status_index = array_search($order['status'], array_keys($status_steps));

// Check if status is updated and send SMS
if (isset($order['status']) && in_array($order['status'], array_keys($status_steps))) {
    $phone_number = $order['contact'];
    $message = "Your order status is now: " . $order['status'];
    sendSMS($phone_number, $message); // Send SMS update
}

function sendSMS($phone_number, $message) {
    $api_key = "your_sms_api_key";
    $api_url = "https://sms_provider_api.com/send_sms";
    $sender_number = "your_sender_number";

    $data = [
        'phone_number' => $phone_number,
        'message' => $message,
        'sender_number' => $sender_number,
        'api_key' => $api_key
    ];

    // Initialize cURL and send SMS request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            color: #cb6701;
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        h3 {
            text-align: center;
            font-size: 24px; /* Adjust size as needed */
            font-weight: bold; /* Make it bold if needed */
        }
        .shipping-status {
            margin-top: 20px;
            width: 90%; /* Adjust size */
            margin: 20px auto; /* Center horizontally */
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
        .shipping-status__recipient {
            font-size: 20px;
            font-weight: 700;
            color: #cb6701;
        }
        .shipping-status__icons-container {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 40px 0; /* Increased margin for better spacing */
        }
        .shipping-status__icon-block {
            text-align: center;
            width: 150px;
            padding: 10px;
            border: 2px solid #cb6701;
            border-radius: 10px;
            background: #fff;
            position: relative;
            z-index: 2;
        }
        .shipping-status__icon-block.active {
            background: #cb6701;
            color: white;
        }
        .shipping-status__bar-container {
            position: absolute;
            top: 65px; /* Lowered the bar */
            width: 100%;
            height: 10px;
            background: #ddd;
            border-radius: 10px;
            z-index: 1;
        }
        .shipping-status__bar {
            height: 100%;
            background: #cb6701;
            transition: width 0.5s ease-in-out;
            border-radius: 10px;
            width: <?php echo ($status_index / (count($status_steps) - 1)) * 100; ?>%;
        }

/* ---------- Navbar ---------- */
.navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(0, 0, 0, 0.8);
            height: 80px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 0 40px; /* Adjust padding for better spacing */
            box-sizing: border-box;
        }


        /* Align left and right sections properly */
        .menu-left, .menu-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }


        /* Navbar Links */
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 12px;
            line-height: 80px; /* Ensure vertical alignment */
        }

        .navbar button {
            font-weight: bold;
        }

        /* Button Hover Effect */
        .navbar a:hover {
            color: #cb6701;
        }

        /* Center Logo */
        .navbar img[alt="Logo"] {
            width: 120px; /* Adjust width */
            height: auto;
            display: block;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 50%;
            transform: translate(-50%, -50%);
        }


        /* Container for Search Logo and Search Bar */
        .search-container {
            display: flex;
            align-items: center;
        }


        /* Search Logo */
        .search-logo {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }


        /* Search Bar */
        .search-bar {
            border: 2px solid white;
            border-radius: 20px;
            padding: 5px 10px;
            width: 200px;
            background-color: transparent;
            color: white;
        }


        /* Profile Icon */
        .profile-logo {
            width: 30px;
            height: 30px;
        }


        /* Fix Navbar Pushing Content Down */
        body {
            margin: 0;
            padding: 0;
        }


        /* Ensure Content Starts Below Navbar */
        .content {
            padding-top: 80px; /* Matches navbar height */
        }




        /* Username display */
        .username-display {
            color: #cb6701;
            font-size: 16px;
            margin-right: 25px;
            font-weight: bold;
            text-transform: capitalize;
        }

          /* Bold specific navbar items */
          .navbar a[href="homepage.php"],
          .navbar a[href="menupage.php"],
          .navbar a[href="about.php"],
          .navbar a[href="contacts.php"] {
              font-weight: bold;
          }


      /* ----------End of Navbar---------- */
      
    </style>
</head>
<body>

<br>
<br>
<br>

<div>
    <h3>Shipping Progress</h3>
    <div class="shipping-status">
        <p class="shipping-status__recipient">Order ID: <?php echo $order['order_id']; ?></p>
        <p class="shipping-status__recipient">Name: <?php echo htmlspecialchars($order['customer_name']); ?></p>
        <p class="shipping-status__recipient">Address: <?php echo htmlspecialchars($order['address']); ?></p>
        <p class="shipping-status__recipient">Contact: <?php echo htmlspecialchars($order['contact']); ?></p>
        <p class="shipping-status__recipient">Total: P<?php echo number_format($order['total_price'], 2); ?></p>
        <p class="shipping-status__recipient">Payment Method: <?php echo htmlspecialchars($order['payment_method']); ?></p>
        <p class="shipping-status__recipient">Status: <span id="order-status"><?php echo $order['status']; ?></span></p>

        <div class="shipping-status__icons-container">
            <div class="shipping-status__bar-container">
                <div class="shipping-status__bar" id="progress-bar"></div>
            </div>
            <?php 
            $index = 0;
            foreach ($status_steps as $status => $icon) { ?>
                <div class="shipping-status__icon-block <?php echo ($index <= $status_index ? 'active' : ''); ?>" data-status="<?php echo $status; ?>">
                    <p class="shipping-status__title"><?php echo $status; ?></p>
                    <i class="<?php echo $icon; ?> fa-2x"></i> 
                </div>
            <?php $index++; } ?>
        </div>
    </div>
</div>

<script>
function updateOrderStatus() {
    fetch('fetch_status.php')
        .then(response => response.text())
        .then(status => {
            document.getElementById('order-status').innerText = status;
            updateProgressBar(status);
        });
}

function updateProgressBar(status) {
    let steps = ['Processing', 'Preparing for Delivery', 'Out for Delivery', 'Delivered'];
    let statusIndex = steps.indexOf(status);
    
    let progressBar = document.getElementById('progress-bar');
    if (progressBar) {
        progressBar.style.width = ((statusIndex / (steps.length - 1)) * 100) + '%';
    }

    let iconBlocks = document.querySelectorAll('.shipping-status__icon-block');
    iconBlocks.forEach((block, index) => {
        if (index <= statusIndex) {
            block.classList.add('active');
        } else {
            block.classList.remove('active');
        }
    });
}

setInterval(updateOrderStatus, 5000);
</script>

      <!-- Navbar Section -->
      <div class="navbar">
          <div class="menu-left">
              <?php foreach ($menuItems as $item => $link): ?>
                  <a href="<?php echo $link; ?>"><?php echo $item; ?></a>
              <?php endforeach; ?>
          </div>
          <img src="<?php echo $logoSrc; ?>" alt="Logo">
          <div class="menu-right">
              <div class="search-container">
                  <img src="<?php echo $searchLogoSrc; ?>" alt="Search" class="search-logo">
                  <input type="text" placeholder="<?php echo $searchPlaceholder; ?>" class="search-bar">
              </div>
      
      
              <!-- Profile logo as a button that links to profile.php -->
              <a href="profile.php">
                  <img src="<?php echo $profileLogoSrc; ?>" alt="Profile" class="profile-logo">
              </a>

</body>

</html>

<?php $conn->close(); ?>
