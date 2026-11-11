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

// Get the current password entered by the user
$current_password = $_POST['current_password']; // User entered current password
$new_password = $_POST['new_password']; // User entered new password

// Get updated user information from the form
$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$address = $_POST['address'];
$contact = $_POST['contact'];

// Escape user inputs for safety
$name = mysqli_real_escape_string($conn, $name);
$username = mysqli_real_escape_string($conn, $username);
$email = mysqli_real_escape_string($conn, $email);
$address = mysqli_real_escape_string($conn, $address);
$contact = mysqli_real_escape_string($conn, $contact);

// Retrieve the stored hash from the database
$query = "SELECT password FROM tb_user WHERE username='{$_SESSION['username']}'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    // Verify if the entered current password matches the stored hash
    if (password_verify($current_password, $user['password'])) {
        // If the user wants to change the password
        if (!empty($new_password)) {
            // Hash the new password before saving it
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            // Update user information with new password
            $update_query = "UPDATE tb_user SET name='$name', username='$username', email='$email', password='$new_password', address='$address', contact='$contact',  WHERE username='{$_SESSION['username']}'";
        } else {
            // No password change, update other details only
            $update_query = "UPDATE tb_user SET name='$name', username='$username', email='$email', address='$address', contact='$contact' WHERE username='{$_SESSION['username']}'";
        }

        // Execute the update query
        if (mysqli_query($conn, $update_query)) {
            // Successfully updated
            $_SESSION['username'] = $username; // Update session username
            header("Location: profile.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        // Current password does not match
        echo "The current password is incorrect.";
    }
} else {
    echo "User not found.";
}

?>
