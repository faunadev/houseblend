<?php
// Start the session
session_start();
require 'config.php'; // Include database configuration for database connection

// Initialize the message variable
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';

    // Check if email is provided
    if (!empty($email)) {
        // Query to check if the email exists in the database
        $sql = "SELECT * FROM tb_user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                // Simulate OTP generation and email sending
                $otp = rand(100000, 999999);
                $_SESSION['otp'] = $otp;
                $_SESSION['email'] = $email;

                // Here you would normally send the OTP via email (e.g., using PHPMailer)
                // For now, we'll assume the email was sent successfully.
                $message = "An OTP has been sent to your email. Please check your inbox.";

                // Redirect to reset_password.php
                header("Location: reset_password.php");
                exit();
            } else {
                $message = "Email not found in our records.";
            }
            $stmt->close();
        } else {
            $message = "Error preparing query: " . $conn->error;
        }
    } else {
        $message = "Please enter your email!";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Houseblend Tea & Coffee Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #cb6701, #000);
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            width: 400px;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 17px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #cb6701;
        }

        h1 {
            margin-bottom: 20px;
            color: #cb6701;
        }

        input[type="email"],
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #c2b280;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        input[type="email"] {
            background-color: #333;
            color: white;
        }

        button {
            background-color: #cb6701;
            color: #000;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 15px;
        }

        button:hover {
            background-color: #6d4c41;
            color: white;
        }

        .error-message {
            color: red;
        }

        .back-link {
            margin-top: 15px;
            font-size: 14px;
            color: #cb6701;
        }

        .back-link a {
            color: #cb6701;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Forgot Password</h1>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send OTP</button>
        </form>
        <?php if (!empty($message)): ?>
            <div class="error-message"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="back-link">
            <a href="login.php">Back to Login</a>
        </div>
    </div>
</body>
</html>
