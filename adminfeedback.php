<?php
// Start the session and include config.php for DB connection
session_start();
include 'config.php';

// Query to fetch feedback data from tb_contact
$sql = "SELECT * FROM tb_contact ORDER BY created_at DESC";

// Execute the query
$result = $conn->query($sql);

// Handle "update viewed" functionality
if (isset($_POST['id']) && isset($_POST['action']) && $_POST['action'] == 'update_viewed') {
    $feedbackId = $_POST['id'];

    // Update the 'is_viewed' status to 1 for the specific feedback
    $sql_update = "UPDATE tb_contact SET is_viewed = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $feedbackId);
    
    if ($stmt->execute()) {
        echo "Viewed status updated successfully.";
    } else {
        echo "Error updating viewed status.";
    }

    $stmt->close();
}

// Close the database connection when done
// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks - Houseblend N's Tea & Coffee Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styling */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            margin: 12px 0;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #cb6701;
        }

        .sidebar a.active {
            background-color: #cb6701;
            font-weight: bold;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .admin-dashboard {
            color: #cb6701;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Pop-up Modal Styling */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            box-sizing: border-box;
            z-index: 1001;
        }

        .popup input, .popup textarea {
            width: 95%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: transparent;
            color: black;
        }

        .popup button {
            background-color: #cb6701;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .popup button:hover {
            background-color: #a55200;
        }

        /* Notification light for new feedback */
        .notification-light {
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: red;
            border-radius: 50%;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<!-- Sidebar Section -->
<div class="sidebar">
    <p class="admin-dashboard"><a href="adminpage.php">Admin Dashboard</a></p>
    <a href="">STOCKS</a>
    <a href="sales.php">SALES</a>
    <a href="orders.php">ORDERS</a>
    <a href="feedbacks.php" class="active">COMMENTS</a>
    <a href="logout.php">LOGOUT</a>
</div>

<!-- Main Content Section -->
<div class="content">
    <h1>Feedback Records</h1>

    <!-- Feedback Data Table -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Show notification light for new feedback (if is_viewed = 0)
                    $notification = $row['is_viewed'] == 0 ? '<span class="notification-light"></span>' : '';

                    echo "<tr data-id='" . $row['id'] . "' class='feedback-row'>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['message'] . "</td>
                            <td>" . $row['created_at'] . "</td>
                            <td><button class='reply-btn' data-email='" . $row['email'] . "'>Reply</button> $notification</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No feedback records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Pop-up Modal -->
<div class="popup-overlay" id="popup-overlay"></div>
<div class="popup" id="popup">
    <h3>Send to: <span id="email-display"></span></h3>
    <textarea placeholder="Write your message..." id="reply-message"></textarea>
    <button onclick="sendReply()">Send</button>
</div>

<script>
    const replyBtns = document.querySelectorAll('.reply-btn');
    const popup = document.getElementById('popup');
    const popupOverlay = document.getElementById('popup-overlay');
    const emailDisplay = document.getElementById('email-display');
    const replyMessage = document.getElementById('reply-message');
    const feedbackRows = document.querySelectorAll('.feedback-row');

    replyBtns.forEach(button => {
        button.addEventListener('click', function () {
            const email = button.getAttribute('data-email');
            const row = button.closest('.feedback-row');
            const feedbackId = row.getAttribute('data-id');

            // Send AJAX request to update 'is_viewed' status
            updateViewedStatus(feedbackId);

            emailDisplay.textContent = email;
            popup.style.display = 'block';
            popupOverlay.style.display = 'block';
        });
    });

    popupOverlay.addEventListener('click', function() {
        popup.style.display = 'none';
        popupOverlay.style.display = 'none';
    });

    function sendReply() {
        const email = emailDisplay.textContent;
        const message = replyMessage.value;

        if (message) {
            // Send the email using PHP (you need a backend solution for sending emails)
            alert(`Email sent to: ${email}`);
            popup.style.display = 'none';
            popupOverlay.style.display = 'none';
        } else {
            alert("Please enter a message.");
        }
    }

    // Update 'is_viewed' status using AJAX
    function updateViewedStatus(feedbackId) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "adminfeedback.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Remove the notification light after feedback is viewed
                const row = document.querySelector(`.feedback-row[data-id="${feedbackId}"]`);
                const notificationLight = row.querySelector('.notification-light');
                if (notificationLight) {
                    notificationLight.remove();
                }
            }
        };
        xhr.send("id=" + feedbackId + "&action=update_viewed");
    }
</script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
