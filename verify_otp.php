<?php
session_start();
include 'config.php';

if (isset($_POST['otp'])) {
    $inputOtp = $_POST['otp'];
    $contact = $_SESSION['contact'];
    $otpFile = "otp_logs/otp_$contact.txt";

    if (file_exists($otpFile)) {
        list($savedOtp, $timestamp) = explode("|", file_get_contents($otpFile));

        if (time() - (int)$timestamp > 60) {
            $error = "OTP expired. Please register again.";
            unlink($otpFile);
            session_destroy();
        } elseif ($inputOtp == $savedOtp) {
            $data = $_SESSION['register_data'];
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO tb_user (name, username, email, address, contact, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $data['name'], $data['username'], $data['email'], $data['address'], $data['contact'], $hashedPassword);

            if ($stmt->execute()) {
                unlink($otpFile);
                unset($_SESSION['otp'], $_SESSION['contact'], $_SESSION['register_data']);
                header('Location: login.php');
                exit;
            } else {
                $error = "Failed to save user: " . $stmt->error;
            }
        } else {
            $error = "Invalid OTP. Please try again.";
        }
    } else {
        $error = "OTP not found. Please register again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP - Houseblend</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #cb6701, #000);
            color: #cb6701;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .otp-container {
            width: 400px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.85);
            border-radius: 17px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input[type="text"], button {
            width: 100%;
            padding: 7px;
            margin: 10px 0;
            border: 1px solid #c2b280;
            border-radius: 5px;
            background-color: #333;
            color: #cb6701;
            font-family: 'Poppins', sans-serif;
        }
        button {
            background-color: #cb6701;
            color: #000;
            font-weight: bold;
            border: none;
            border-radius: 15px;
            cursor: pointer;
        }
        button:hover {
            background-color: #6d4c41;
            color: white;
        }
        .cancel-button {
            background-color: #d32f2f;
            color: white;
        }
        .cancel-button:hover {
            background-color: #c2185b;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="otp-container">
    <h1>Verify OTP</h1>

    <?php if (isset($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit">Verify OTP</button>
    </form>

    <form action="register.php" method="get">
        <button type="submit" class="cancel-button">Cancel</button>
    </form>
</div>

</body>
</html>
