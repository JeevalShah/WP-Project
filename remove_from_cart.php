<?php
    session_start();
    require 'connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
        $cartId = $_POST['cart_id'];

        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $cartId, $userId);
        } 

        if ($stmt->execute()) {
            header("Location: cart.php");
            exit;
        } else {
            echo "Error removing item.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid request.";
    }
?>