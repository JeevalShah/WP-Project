<?php
session_start();
require 'connection.php'; // replace with your actual DB connection file

// Get total amount
$total = $_POST['total'] ?? 0;
$total = number_format((float)$total, 2);

// Get the user ID from session
$userId = $_SESSION['user_id'] ?? null;

// Clear session cart
unset($_SESSION['cart']);

// Delete cart entries from the database for this user
if ($userId) {
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <script>
        window.onload = function () {
            alert("Payment of ₹<?= $total ?> made successfully!");
            window.location.href = "index.php";
        };
    </script>
</head>
<body>
</body>
</html>
