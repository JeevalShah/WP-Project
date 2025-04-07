<?php
    session_start();
    require 'connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
        $cartId = $_POST['cart_id'];
        $userId = $_SESSION['user_id'];

        if ($userId) {
            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            if ($stmt) {
                $stmt->bind_param("ii", $cartId, $userId);
                
                if ($stmt->execute()) {
                    header("Location: cart.php");
                    exit;
                
                } else {
                    error_log("Error removing item with cart_id: $cartId for user: $userId");
                    echo "<script>alert('Error removing item. Please try again later.');</script>";
                }

                $stmt->close();
            } else {
                echo "<script>alert('Error processing your request.');</script>";
            }
        } else {
            echo "<script>alert('You need to be logged in to remove items from your cart.');</script>";
            header("Location: login.html"); 
            exit;
        }

        $conn->close();
    } else {
        echo "<script>alert('Invalid request.');</script>";
    }
?>