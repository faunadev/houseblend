<?php
// Include your database connection
include('config.php');

// Start the session to check if the user is logged in
session_start();

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get user info from the database based on session username
$username = $_SESSION['username'];
$query = "SELECT * FROM tb_user WHERE username='$username'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found!";
    exit();
}

// Handle form submission to update user data
$successMessage = ''; // Default to empty string for success message
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);

    // Fetch current password from the database
    $query = "SELECT password FROM tb_user WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row && $current_password == $row['password']) {
        // If the current password matches, update the user data
        $update_query = "UPDATE tb_user SET 
                            name='$name', 
                            email='$email', 
                            address='$address', 
                            contact='$contact'";

        // If a new password is provided, update it as well
        if (!empty($new_password)) {
            $update_query .= ", password='$new_password'";
        }

        // Update the user's data
        $update_query .= " WHERE username='$username'";

        if (mysqli_query($conn, $update_query)) {
            $successMessage = "Profile successfully updated!"; // Set success message
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }
    } else {
        $successMessage = "Current password is incorrect!"; // If password is incorrect
    }
}

// Define variables for dynamic content
$title = "Profile - Houseblend N's Tea & Coffee Shop";
$backgroundImg = "bg.jpg";
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
    <title><?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Body Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('<?php echo $backgroundImg; ?>');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Profile Container */
        .profile-container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            height: 700px;
            width: 500px;
            max-width: 90%;
            box-sizing: border-box;
        }

        /* Header Text */
        .profile-container h2 {
            color: #cb6701;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Form Styling */
        form label {
            display: block;
            font-weight: 400;
            color: #cb6701;
            margin-top: 5px;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: none;
            background-color: #333;
            color: white;
            box-sizing: border-box;
        }

        .row {
            display: flex;
            gap: 10px;
        }

        .row div {
            flex: 1;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .cancel-btn,
        .save-btn {
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            width: 48%;
        }

        .cancel-btn {
            background-color: transparent;
            color: #cb6701;
            border: 2px solid #cb6701;
        }

        .cancel-btn:hover {
            background-color: #cb6701;
            color: black;
        }

        .save-btn {
            background-color: #cb6701;
            color: black;
            border: none;
        }

        .save-btn:hover {
            background-color: #ff7f00;
        }

        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .logout-btn:hover {
            background-color: #e60000;
        }

        /* Success Message */
        .success-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Edit Profile</h2>

    <!-- Display success or error message -->
    <?php if ($successMessage != ''): ?>
        <div id="successMessage" class="<?php echo (strpos($successMessage, 'incorrect') !== false) ? 'error-message' : 'success-message'; ?>">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <form action="profile.php" method="POST">
        <!-- Name -->
        <label>Name</label>
        <input type="text" name="name" value="<?php echo isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?>" required />

        <!-- Username -->
        <label>Username</label>
        <input type="text" name="username" value="<?php echo isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?>" required />

        <!-- Email -->
        <label>Email</label>
        <input type="email" name="email" value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" required />

        <!-- Address -->
        <label>Address</label>
        <input type="text" name="address" value="<?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?>" required />

        <!-- Contact -->
        <label>Contact</label>
        <input type="text" name="contact" value="<?php echo isset($user['contact']) ? htmlspecialchars($user['contact']) : ''; ?>" required />

        <!-- Current Password -->
        <label>Current Password</label>
        <input type="password" name="current_password" required />

        <!-- New Password -->
        <label>New Password</label>
        <input type="password" name="new_password" />

        <!-- Buttons -->
        <div class="button-container">
            <button type="button" class="cancel-btn" onclick="window.location.href='homepage.php';">Cancel</button>
            <button type="submit" class="save-btn">Save</button>
        </div>

        <!-- Logout Button -->
        <button type="button" class="logout-btn" onclick="window.location.href='logout.php';">Logout</button>
    </form>
</div>

<script>
// If there's a success message, vanish it after 2 seconds
<?php if ($successMessage != ''): ?>
    setTimeout(function() {
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 2000);
<?php endif; ?>
</script>

</body>
</html>