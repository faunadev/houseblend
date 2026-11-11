<?php
// Start the session
session_start();
require 'config.php'; 

// Initialize error message
$error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    if ($username === 'admin' && $password === '123') {
        // Set session for admin
        $_SESSION['user_id'] = 'admin';
        $_SESSION['username'] = 'admin';

        header('Location: adminpage.php');
        exit;
    }
    
    // Check if both fields are filled
    if (empty($username) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Query to check if the user exists in the database
        $sql = "SELECT * FROM tb_user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, fetch user data
            $user = $result->fetch_assoc();
            
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Password is correct, start a session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                if ($remember) {
                    setcookie('username', $username, time() + (86400 * 30), "/"); // Remember user for 30 days
                }

                header('Location: homepage.php'); // Redirect to your actual landing page
                exit;
            } else {
                // Invalid credentials
                $error = "Invalid username or password!";
            }
        } else {
            // Invalid username
            $error = "Username not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Houseblend Tea & Coffee Shop</title>
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

        .checkbox-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            margin: 10px 0;
            color: #cb6701;
        }

        .forgot-password {
            font-size: 12px;
            color: #cb6701;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
        }

        .register-link {
            margin-top: 15px;
            font-size: 14px;
            color: #cb6701;
        }

        .register-link a {
            color: #cb6701;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .eye-icon {
            position: absolute;
            top: 15px;
            right: 10px;
            cursor: pointer;
            color: #cb6701;
            font-size: 18px;
        }

        .password-container {
            position: relative;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>User Login</h1>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <!-- Username input -->
        <input type="text" name="username" placeholder="Username" required>
        <!-- Password input with eye icon toggle -->
        <div class="password-container">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span class="eye-icon" onclick="togglePassword()">👁️</span>
        </div>

        <div class="checkbox-container">
            <label>
                <input type="checkbox" name="remember" id="remember"> Remember Me
            </label>
            <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
        </div>

        <div class="button-container">
            <button type="submit">Login</button>
        </div>
    </form>

    <div class="register-link">
        Don't have an account? <a href="register.php">Register</a>
    </div>
</div>

<script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var icon = document.querySelector(".eye-icon");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>

</body>
</html>
