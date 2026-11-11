<?php
session_start();

include 'config.php';

$successMessage = $errorMessage = "";

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
        $successMessage = "Your message has been sent successfully!";
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}

// Navbar configuration
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
    <title>Contact Us - Houseblend Tea & Coffee Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            margin: 0;
            padding: 0;
        }

        h1, .faq-container h2 {
            color: #cb6701;
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            margin-top: 50px;
        }

        p {
            font-size: 18px;
            margin: 15px 0;
            text-align: center;
        }

        .contact-info {
            font-size: 18px;
            margin-top: 20px;
            text-align: center;
        }

        .contact-info a {
            color: #cb6701;
            text-decoration: none;
            margin: 5px;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .faq-container {
            margin-top: 40px;
            text-align: center;
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



.message-form {
    background-color: rgba(0, 0, 0, 0.7);
    padding: 20px;
    border-radius: 30px;
    margin: 20px auto;
    max-width: 600px; /* Form container width stays the same */
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-sizing: border-box; /* Ensure padding is included in container's width calculation */
}

.message-form h3,
.message-form label {
    color: #cb6701; /* Orange color for the text */
}

/* Apply Poppins font to form elements */
.message-form h3, .message-form label, .message-form input, .message-form select, .message-form textarea, .message-form button {
    font-family: 'Poppins', sans-serif;
}

/* Styling for select box, input fields, and textarea */
.message-form input,
.message-form select,
.message-form textarea {
    width: 100%; /* Ensure form elements stay within the container width */
    padding: 10px;
    border: 2px solid white;
    border-radius: 5px;
    background-color: transparent;
    color: white;
    font-size: 16px;
    margin-bottom: 15px;
    box-sizing: border-box; /* Include padding in width calculation */
}

/* Customize the select message type */
.message-form select {
    color: black; /* Set font color to black */
    border-radius: 10px;
    background-color: white;
}

/* Ensure the submit button has the same width */
.message-form button {
    width: 100%; /* Set to 100% width to match form fields */
    padding: 10px;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    background-color: #cb6701; /* Orange background */
    color: white;
    cursor: pointer;
    box-sizing: border-box; /* Include padding in width calculation */
    margin-top: 20px; /* Add spacing above the button */
}

.message-form button:hover {
    background-color: #a55200;
}

/* Flexbox for email and phone inputs to align them side by side */
.message-form .row {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.message-form .row input {
    width: 48%; /* Ensure side by side for email and phone fields */
}

/* Additional Styling for input and textarea */
.message-form input, 
.message-form textarea {
    border-radius: 10px;
}

.message {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<br><br><br>

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

<h1>Contact Us</h1>
<p>We are always here to assist you with any questions or inquiries. Reach out to us through the contact</p>
<p>information provided above. Your feedback helps us improve our services and serve you better.</p>

<div class="contact-info">
    <p><strong>Email:</strong> <a href="mailto:houseblend2020@gmail.com">houseblend2020@gmail.com</a></p>
    <p><strong>Facebook:</strong> <a href="https://www.facebook.com/profile.php?id=100067354791255&mibextid=kFxxJD" target="_blank">Houseblend N's Tea and Coffee</a></p>
    <p><strong>Instagram:</strong> <a href="https://www.instagram.com/houseblendnstea?igsh=MWs4ZmtjYXFremFp" target="_blank">@houseblendnstea</a></p>
</div>

<br>
<div class="faq-container">
    <h2>We value your Feedback</h2>
    <p>If you have any questions or thoughts you'd like to share, we would love to hear from you!</p>
    <p>Your feedback helps us improve our products and services.</p>
</div>

<div class="message-form">
    <h3>Send us a message</h3>
    <?php if (!empty($successMessage)): ?>
        <p id="success-message" class="message"><?php echo $successMessage; ?></p>
    <?php elseif (!empty($errorMessage)): ?>
        <p id="error-message" class="message error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <form action="feedback.php" method="post" id="feedback-form">
        <label for="message-type"><strong>Select message type</strong></label>
        <select id="message-type" name="message_type" required>
            <option value="General Inquiry">General Inquiry</option>
            <option value="Feedback">Feedback</option>
            <option value="Commendation">Commendation</option>
        </select>

        <div>
            <label for="name"><strong>First Name</strong></label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>
        </div>
        
        <div>
            <label for="email"><strong>Email Address</strong></label>
            <input type="email" id="email" name="email" placeholder="Your Email" required>
        </div>

        <div>
            <label for="phone"><strong>Phone Number</strong></label>
            <input type="tel" id="phone" name="phone" placeholder="+63" required>
        </div>

        <label for="message"><strong>Message</strong></label>
        <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>

        <button type="submit">Submit</button>
    </form>
</div>

<script>
    document.getElementById('feedback-form').addEventListener('submit', function(e) {
        // Check if all fields are filled
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const message = document.getElementById('message').value;

        if (!name || !email || !phone || !message) {
            e.preventDefault(); // Prevent form submission
            alert("Please fill in all fields before submitting.");
        }
    });

    setTimeout(() => {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 5000);
</script>

</body>
</html>