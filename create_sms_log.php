<?php
$logFilePath = __DIR__ . "/sms_log.txt"; // Path inside 'siaa' folder

// Check if the file exists
if (!file_exists($logFilePath)) {
    // Try creating the file
    if (file_put_contents($logFilePath, "SMS Log Initialized\n") !== false) {
        echo "sms_log.txt has been created successfully!";
    } else {
        echo "Failed to create sms_log.txt!";
    }
} else {
    echo "sms_log.txt already exists.";
}
?>
