<?php
$title = "Delivery Tracking - Houseblend N's Tea & Coffee Shop";
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
$deliveryLogoSrc = "delivery.png";
$cartLogoSrc = "cart.png";

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
            background-image: url('bg.jpg'); /* Background image */
            background-size: cover; /* Cover the entire viewport */
            background-repeat: repeat-y; /* Repeat the image vertically */
            background-position: center; /* Center the background image */
            margin: 0;
            padding: 0;
            color: white; /* White text color for better contrast */
            display: flex;
            justify-content: center; /* Center the container horizontally */
            align-items: flex-start; /* Align items at the start of the page */
            flex-direction: column; /* Arrange items in a column */
            min-height: 100vh; /* Minimum height to cover the viewport */
            text-align: center;
            overflow: auto; /* Enable scrolling */
        }

        /* Space above the main container */
        .spacer {
            height: 30px; /* Space above the container */
        }

        /* Container for content */
        .container {
            background: rgba(0, 0, 0, 0.8); /* Black background with slight transparency */
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); /* Soft shadow */
            padding: 30px;
            width: 90%; /* Change to a percentage width for responsiveness */
            max-width: 800px; /* Set maximum width */
            margin: 0 auto; /* Center container */
            margin-bottom: 20px; /* Space below container */
            margin-top: 20px; /* Space above container */
        }

        /* Header styling */
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: white; /* White color for heading */
        }

        /* Paragraph styling */
        p {
            color: #f0f0f0; /* Slightly lighter white for better readability */
            font-size: 16px; /* Font size for better visibility */
            margin-bottom: 15px; /* Space below paragraphs */
        }

        /* Input styling */
        input[type="text"] {
            width: calc(100% - 20px); /* Adjust width for padding */
            padding: 10px; /* Reduced padding */
            margin: 10px 0; /* Top and bottom margin */
            border-radius: 10px; /* Rounded corners */
            border: 1px solid white; /* White border */
            font-size: 16px; /* Font size */
            color: white; /* White text for input */
            background: rgba(255, 255, 255, 0.1); /* Light background for input */
            box-sizing: border-box; /* Include padding in the element's total width and height */
        }

        /* Button styling */
        button {
            background-color: #ff7f00; /* Lighter orange for button */
            color: white; /* White text for button */
            padding: 10px 15px; /* Padding for height */
            border: none;
            border-radius: 10px; /* Rounded button */
            cursor: pointer;
            font-size: 14px; /* Smaller font size */
            width: 150px; /* Set a specific width for the button */
            margin-top: 10px; /* Space between input and button */
        }

        button:hover {
            background-color: #cb6701; /* Darker shade on hover */
        }

        /* Map section */
        .map {
            margin-top: 20px;
            height: 300px; /* Adjust the height as needed */
            width: 100%;
            border: none; /* Remove iframe border */
            border-radius: 10px; /* Rounded corners for the iframe */
        }

        /* Status message */
        .status {
            margin-top: 20px;
            font-size: 18px;
            color: white; /* White color for status messages */
        }

        /* Delivery info container */
        .delivery-info {
            background: rgba(0, 0, 0, 0.8); /* Black background with slight transparency */
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); /* Soft shadow */
            padding: 30px;
            width: 90%; /* Same width as the main container */
            max-width: 800px; /* Increased max width for better readability */
            margin: 20px auto; /* Centered with automatic margins */
            text-align: left; /* Left align text */
        }

        /* Progress bar */
        .progress {
            width: 100%;
            background-color: #e0e0e0; /* Light gray background */
            border-radius: 10px; /* Rounded corners */
            margin: 10px 0; /* Margin for spacing */
        }

        .progress-fill {
            height: 10px; /* Height of the filled part */
            background-color: #cb6701; /* Orange color for progress fill */
            border-radius: 10px; /* Rounded corners for filled part */
            width: 0; /* Start with 0 width */
        }

        /* Contact rider button container */
        .contact-rider-container {
            text-align: center; /* Center the button */
            margin-top: 20px; /* Space above the button */
        }

        /* Navbar Styling */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            opacity: 0.8;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px 60px;
            height: 80px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-sizing: border-box;
        }

        /* Aligning Left Side (Links only) */
        .menu-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Navbar Links Styling */
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
            transition: color 0.3s;
        }

        /* Button Hover Effect */
        .navbar a:hover {
            color: #cb6701;
        }

        /* Centered Logo */
        .navbar img[alt="Logo"] {
            width: 150px;
            height: auto;
        }

        /* Right Side (Search bar and icons) */
        .menu-right {
            display: flex;
            align-items: center;
            gap: 15px;
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

        /* Consistent size for all icons */
        .profile-logo, .delivery-logo, .cart-logo {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
    </style>


</head>
<body>
    <div class="spacer"></div> <!-- Space above the main container -->
    <br>
    <br>
    <div class="container">
        <h1>Track Your Delivery</h1> <!-- Updated header -->
        <p>Enter your location to see where your order is.</p> <!-- Added explanatory text -->
        <input type="text" id="locationInput" placeholder="Enter Your Location" />
        <button type="button" onclick="trackDelivery()">Track Delivery</button>
        <div class="status" id="statusMessage"></div>

        <iframe
            class="map"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2799013087!2d120.9842228!3d14.5995123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33d64c8a8d6d319f%3A0x1f971eeb16c5294a!2sMetro%20Manila%2C%20Philippines!5e0!3m2!1sen!2sus!4v1625169226268!5m2!1sen!2sus"
            frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> <!-- Google Map iframe -->
    </div>

    <div class="delivery-info">
        <h2>Delivery Information</h2>
        <p>Order ID: #123456</p>
        <p>Expected Delivery Time: 3:30 PM</p>
        <p>Delivery Address: 123 Main St, Sample City</p>
        
        <div class="progress">
            <div class="progress-fill" style="width: 50%"></div>
        </div>
        <p>Delivery Status: On the way!</p>
        <div class="contact-rider-container">
            <button>Contact Rider</button>
        </div>
    </div>

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
        
        <!-- Delivery logo as a button that links to delivery.php -->
        <a href="delivery.php">
            <img src="<?php echo $deliveryLogoSrc; ?>" alt="Delivery" class="delivery-logo">
        </a>
        
        <!-- Cart logo as a button that links to cart.php -->
        <a href="cart.php">
            <img src="<?php echo $cartLogoSrc; ?>" alt="Cart" class="cart-logo">
        </a>
    </div>
</div>

</body>
</html>

