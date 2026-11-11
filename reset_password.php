<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Houseblend Tea & Coffee Shop</title>
    <!-- Link to Google Fonts for Poppins -->
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

        input[type="text"],
        input[type="password"],
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #c2b280;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        input[type="text"],
        input[type="password"] {
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
        <h1>Reset Password</h1>
        <form method="POST" action="reset_password.php">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Reset Password</button>
        </form>
        <?php if ($message): ?>
            <div class="error-message"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="back-link">
            <a href="forgot_password.php">Back</a>
        </div>
    </div>
</body>
</html>
