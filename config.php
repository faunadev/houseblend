<?php
$servername = "localhost"; // or your server
$username = "root"; // your database username
$password = ""; // your database password (for local development, it may be empty)
$dbname = "reglog"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
