<?php
session_start(); 
include 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $messageType = $conn->real_escape_string($_POST['message_type']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert data into tb_contact
    $sql = "INSERT INTO tb_contact (message_type, name, email, phone, message) 
            VALUES ('$messageType', '$name', '$email', '$phone', '$message')";

    if ($conn->query($sql) === TRUE) {
        // No success message
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}

// Define variables for dynamic content
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <!-- Link to Google Fonts for Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Basic reset */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', sans-serif; /* Apply Poppins to the whole page */
        }

        /* Set the background image */
        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content {
            text-align: center;
            color: white;
            max-width: 600px;
            padding: 20px;
        }

        /* Style for the "THANK YOU!" text */
        .thank-you {
            font-size: 50px;
            color: #cb6701;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Style for the smaller text below */
        .message {
            font-size: 20px;
            color: white;
            margin-bottom: 20px;
        }

        /* Style for the "Back to Home" button */
        .back-button {
            background-color: #cb6701;
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            border: none;
            border-radius: 30px; /* Curvy button */
            cursor: pointer;
            text-decoration: none; /* Remove underline from link */
            display: inline-block;
        }

        .back-button:hover {
            background-color: #a55200; /* Darker orange on hover */
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

/* Aligning Left Side (Links) */
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
.profile-logo {
    width: 30px;
    height: 30px;
    cursor: pointer;
}

/* Bold specific navbar items */
.navbar a[href="homepage.php"],
.navbar a[href="menupage.php"],
.navbar a[href="about.php"],
.navbar a[href="contacts.php"] {
    font-weight: bold;
}

    </style>
</head>
<body>
    <div class="content">
        <!-- "THANK YOU!" Text -->
        <div class="thank-you">
            THANK YOU!
        </div>
        <!-- Subtext -->
        <div class="message">
            Your Inquiry has been Submitted. Please expect an email from us once we reviewed your message.
        </div>
        <!-- Back to Home Button -->
        <a href="homepage.php" class="back-button">Back to Home</a>
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
        
    </div>
</div>

</body>
</html>
