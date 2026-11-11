<?php
// Start the session to access session data
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

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

include 'config.php';

// Fetch the logged-in user's username from session
$loggedInUsername = $_SESSION['username'];

// Query to fetch user details from tb_user table
$sql = "SELECT name, address, contact FROM tb_user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInUsername); // Bind the username parameter
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name, $address, $contact);

// Check if user exists and fetch data
if ($stmt->num_rows > 0) {
    $stmt->fetch();
} else {
    // If no user is found, you can handle this error
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .order-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            margin-top: 50px;
            margin-left: 40px;
            margin-right: 5px;
        }

        .order-items {
            width: 65%;
            padding: 20px;
            background-color: black;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .order-items h3 {
            color: #ff6f00;
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #333;
            border-radius: 8px;
        }

        .order-item img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }

        .order-summary {
            width: 25%;
            padding: 20px;
            background-color: black;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-summary h2 {
            color: #ff6f00;
            font-size: 24px;
            margin-bottom: 20px;
        }

        #cart-total {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .payment-option {
            margin-top: 20px;
        }

        .payment-option label {
            display: block;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .confirm-order {
            width: 100%;
            padding: 15px;
            background-color: #ff6f00;
            border: none;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            transition: all 0.3s;
        }

        .confirm-order:hover {
            background-color: #ff8500;
        }

        .cancel-order {
            width: 100%;
            padding: 15px;
            background-color: #e63946;
            border: none;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            margin-top: 10px;
            transition: all 0.3s;
        }

        .cancel-order:hover {
            background-color: #ff4b5c;
        }

        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffff;
            color: #333;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }

        .popup h3 {
            color: #ff6f00;
            margin-bottom: 20px;
        }

        .popup button {
            margin-top: 20px;
            background-color: #ff6f00;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            padding: 10px 20px;
        }

        .popup button:hover {
            background-color: #ff8500;
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

<div class="order-container">
    <div class="order-items" id="order-items">
        <!-- Order items will be dynamically inserted -->
    </div>
    <div class="order-summary">
        <h2>Your Order</h2>
        <div id="cart-total"></div>
        <div class="payment-option">
            <label><input type="radio" name="payment" value="COD" onclick="hideGcashQRCode()"> Cash on Delivery</label>
            <label><input type="radio" name="payment" value="Gcash" onclick="toggleGcashQRCode()"> GCash</label>
            <div id="gcash-qr-container" style="display: none; margin-top: 20px; text-align: center;">
    <h3>Scan to Pay with GCash</h3>
    <canvas id="gcash-qr-code" style="margin: auto;"></canvas>
</div>
        <button class="confirm-order" onclick="showPopup()">Confirm Order</button>
        <button class="cancel-order" onclick="cancelOrder()">Cancel Order</button>
    </div>
</div>
<!-- Popup for order details -->
<div class="popup" id="order-popup">
    <h3>Order Details</h3>
    <div id="popup-details"></div>
    <div id="gcash-reference" style="display: none;">
        <label for="gcash-ref-code">Enter GCash Reference Code (Required):</label>
        <input type="text" id="gcash-ref-code" placeholder="Enter reference code" required>
        <span id="gcash-error-message" style="color: red; display: none;">Please enter your GCash Reference Code.</span>
    </div>
    <button onclick="closePopup()">Cancel</button>
    <button onclick="proceedToOrder()" id="proceed-button">Proceed to receipt</button>
</div>



<script src="https://cdn.jsdelivr.net/npm/qrious/dist/qrious.min.js"></script>
<script>

let isQRCodeVisible = false; // Track QR code visibility

function toggleGcashQRCode() {
    const qrContainer = document.getElementById('gcash-qr-container');
    const qrCodeCanvas = document.getElementById('gcash-qr-code');
    
    if (isQRCodeVisible) {
        // Hide QR code
        qrContainer.style.display = 'none';
        isQRCodeVisible = false;
    } else {
        // Show QR code and generate it
        qrContainer.style.display = 'block';

        const qr = new QRious({
            element: qrCodeCanvas,
            value: 'GCash payment details or URL here', // Replace this with the actual payment details
            size: 200, // Size of the QR code
        });

        isQRCodeVisible = true;
    }
}

function hideGcashQRCode() {
    const qrContainer = document.getElementById('gcash-qr-container');
    qrContainer.style.display = 'none';
    isQRCodeVisible = false; // Reset visibility state
}

function toggleProceedButton() {
    const gcashRefCode = document.getElementById('gcash-ref-code').value.trim();
    const proceedButton = document.getElementById('proceed-button');
    const paymentOption = document.querySelector('input[name="payment"]:checked');
    
    // Enable the button only if the reference code is filled in and payment option is selected
    if (paymentOption && paymentOption.value === 'Gcash' && gcashRefCode) {
        proceedButton.disabled = false;
    } else {
        proceedButton.disabled = true;
    }
}

function proceedToOrder() {
    const paymentOption = document.querySelector('input[name="payment"]:checked');
    const gcashRefCode = document.getElementById('gcash-ref-code').value.trim();
    
    // Ensure the GCash reference code is filled before proceeding
    if (paymentOption.value === 'Gcash') {
        // Check if the reference code is at least 8 digits
        const referenceCodeRegex = /^\d{8,}$/; // Ensures the code has at least 8 digits
        if (!gcashRefCode || !referenceCodeRegex.test(gcashRefCode)) {
            alert('Please enter a valid GCash reference code with at least 8 digits.');
            return; // Stop the process if reference code is invalid
        }
    }

    // Gather order details
    const orderDetails = {
        name: userData.name,
        address: userData.address,
        contact: userData.contact,
        cartItems: cartItems,
        totalPrice: 0,
        paymentMethod: paymentOption.value,
        gcashRefCode: paymentOption.value === 'Gcash' ? gcashRefCode : null
    };

    // Calculate total price
    orderDetails.cartItems.forEach(item => {
        orderDetails.totalPrice += item.price * item.quantity;
    });

    // Send data to PHP via Ajax
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save_order.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Redirect to receipt.php after successful order save
                window.location.href = "receipt.php?order_id=" + response.order_id;
            } else {
                alert('Failed to save the order. Please try again.');
            }
        }
    };
    xhr.send(JSON.stringify(orderDetails));
}

// Retrieve cart items from localStorage
let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
let userData = { name: "<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>", address: "<?php echo htmlspecialchars($address, ENT_QUOTES, 'UTF-8'); ?>", contact: "<?php echo htmlspecialchars($contact, ENT_QUOTES, 'UTF-8'); ?>" };

function renderCartItems() {
    const orderItemsContainer = document.getElementById('order-items');
    const cartTotalContainer = document.getElementById('cart-total');
    orderItemsContainer.innerHTML = ''; // Clear existing items

    if (cartItems.length === 0) {
        orderItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
        cartTotalContainer.innerHTML = ''; // No total if empty
    } else {
        let totalPrice = 0;
        cartItems.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('order-item');
            cartItem.innerHTML = ` 
                <img src="${item.image}" alt="${item.name}">
                <div>
                    <h4>${item.name} x${item.quantity}</h4>
                    <p>Total: P${item.price * item.quantity}</p>
                </div>
            `;
            orderItemsContainer.appendChild(cartItem);
            totalPrice += item.price * item.quantity;
        });

        // Display total price
        cartTotalContainer.innerHTML = `<h3>Total: P${totalPrice}</h3>`;
    }
}

function showPopup() {
    const popup = document.getElementById('order-popup');
    const popupDetails = document.getElementById('popup-details');
    const paymentOption = document.querySelector('input[name="payment"]:checked');
    const gcashReferenceDiv = document.getElementById('gcash-reference');
    const gcashRefCodeInput = document.getElementById('gcash-ref-code');

    if (!paymentOption) {
        alert('Please select a payment method.');
        return;
    }

    // Show or hide the GCash reference code input based on payment method
    if (paymentOption.value === 'Gcash') {
        gcashReferenceDiv.style.display = 'block'; // Show reference input
    } else {
        gcashReferenceDiv.style.display = 'none'; // Hide reference input
    }

    // Populate popup with order details
    let orderDetails = ` 
        <p><strong>Name:</strong> ${userData.name}</p>
        <p><strong>Address:</strong> ${userData.address}</p>
        <p><strong>Contact:</strong> ${userData.contact}</p>
        <h4>Order Items:</h4>
    `;

    let totalPrice = 0;
    cartItems.forEach(item => {
        orderDetails += `<p>${item.name} x${item.quantity} = P${item.price * item.quantity}</p>`;
        totalPrice += item.price * item.quantity;
    });

    orderDetails += `<p><strong>Total Price:</strong> P${totalPrice}</p>`;
    orderDetails += `<p><strong>Payment Method:</strong> ${paymentOption.value}</p>`;

    // Add the reference code to the details if it's GCash
    if (paymentOption.value === 'Gcash') {
        const refCode = gcashRefCodeInput.value.trim();
        if (refCode) {
            orderDetails += `<p><strong>GCash Reference Code:</strong> ${refCode}</p>`;
        } 
    }

    popupDetails.innerHTML = orderDetails;
    popup.style.display = 'block';
}

function closePopup() {
    const popup = document.getElementById('order-popup');
    popup.style.display = 'none';
}

function cancelOrder() {
    // Clear cart data from localStorage
    localStorage.removeItem('cartItems');

    // Clear the order-container display
    document.getElementById('order-items').innerHTML = '<p>Your cart is empty.</p>';
    document.getElementById('cart-total').innerHTML = '';

    // Redirect to homepage
    window.location.href = 'menupage.php';
}

// Initialize the page with cart items
renderCartItems();
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
