<?php
    session_start();
    require "connection.php";

    // Get total amount
    $total = $_POST['total'] ?? 0;
    $total = number_format((float)$total, 2);

    // Get the user ID from session
    $userId = $_SESSION['user_id'] ?? null;

    if ($userId) {
        $stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $cartItems = $stmt->get_result();
        $stmt->close();

        $result = $conn->query("SELECT MAX(order_id) AS max_order_id FROM orders");
        $row = $result->fetch_assoc();
        $newOrderId = ($row['max_order_id'] ?? 0) + 1;

        $insertStmt = $conn->prepare("INSERT INTO orders (order_id, user_id, product_id, quantity) VALUES (?, ?, ?, ?)");
        foreach ($cartItems as $item) {
            $insertStmt->bind_param("iiii", $newOrderId, $userId, $item['product_id'], $item['quantity']);
            $insertStmt->execute();
        }
        $insertStmt->close();

        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

    
        unset($_SESSION['cart']);
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
