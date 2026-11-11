<?php
session_start();
include 'config.php';

function sendOtp($contact, $otp) {
    $apiUrl = 'https://api.httpsms.com/v1/messages/send';
    $apiKey = 'se-xPvQ5a4W-hmASzbt7jxw0Tj_ErliuqCRW7a0j3sD2weu0CbQgbeqw1GhvgJFV';

    $message = "Your OTP is: $otp";
    $smsData = [
        'content' => $message,
        'from'    => '+639605242464',
        'to'      => $contact
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($smsData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Accept: application/json",
        "x-api-key: $apiKey"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpCode == 200 ? true : "Error: $response (HTTP Code: $httpCode)";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (!preg_match("/^639[0-9]{9}$/", $contact)) {
        $error = "Invalid contact number!";
    } elseif (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) ||
              !preg_match("/[0-9]/", $password) || !preg_match("/[\W_]/", $password)) {
        $error = "Password must be at least 8 characters long, with uppercase, number, and special character!";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['contact'] = $contact;

        $_SESSION['register_data'] = [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'address' => $address,
            'contact' => $contact,
            'password' => $password
        ];

        $smsResult = sendOtp($contact, $otp);

        if ($smsResult !== true) {
            $error = "Failed to send OTP. Error: $smsResult";
        } else {
            // Save OTP to text file with timestamp
            if (!is_dir("otp_logs")) {
                mkdir("otp_logs");
            }
            $logPath = "otp_logs/otp_$contact.txt";
            $logData = $otp . "|" . time();
            file_put_contents($logPath, $logData);

            header('Location: verify_otp.php');
            exit;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Houseblend Tea & Coffee Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #cb6701, #000);
            background-size: cover;
            background-position: center;
            color: #cb6701;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            width: 400px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 17px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #cb6701;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="fullName"],
        button {
            width: 100%;
            padding: 7px;
            margin: 10px 0;
            border: 1px solid #c2b280;
            border-radius: 5px;
            background-color: #333;
            color: #cb6701;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
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

        .password-container {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .password-container input {
            padding-right: 40px;
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            cursor: pointer;
        }

        .login-link {
            margin-top: 15px;
            font-size: 14px;
            color: #cb6701;
        }

        .login-link a {
            color: #cb6701;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h1>Sign Up</h1>

    <?php if (isset($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Fullname" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="contact" placeholder="Contact Number" required>

        <label class="password-container">
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <span class="eye-icon" id="toggle-password">
                <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4C7.305 4 3.385 6.257 1.738 9.238a1 1 0 0 0 0 1.524C3.385 15.742 7.305 18 12 18c4.695 0 8.615-2.257 10.262-5.238a1 1 0 0 0 0-1.524C20.615 6.257 16.695 4 12 4zM12 16c-3.315 0-6-1.343-6-3s2.685-3 6-3 6 1.343 6 3-2.685 3-6 3z" fill="#cb6701"></path>
                </svg>
            </span>
        </label>

        <label class="password-container">
            <input type="password" id="confirm-password" name="confirmPassword" placeholder="Confirm Password" required>
            <span class="eye-icon" id="toggle-confirm-password">
                <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4C7.305 4 3.385 6.257 1.738 9.238a1 1 0 0 0 0 1.524C3.385 15.742 7.305 18 12 18c4.695 0 8.615-2.257 10.262-5.238a1 1 0 0 0 0-1.524C20.615 6.257 16.695 4 12 4zM12 16c-3.315 0-6-1.343-6-3s2.685-3 6-3 6 1.343 6 3-2.685 3-6 3z" fill="#cb6701"></path>
                </svg>
            </span>
        </label>

        <div class="button-container">
            <button type="submit">Register</button>
        </div>
    </form>

    <div class="login-link">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    togglePassword.addEventListener('click', () => {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
    });

    const toggleConfirmPassword = document.getElementById('toggle-confirm-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    toggleConfirmPassword.addEventListener('click', () => {
        const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
        confirmPasswordInput.type = type;
    });
</script>

</body>
</html>
