<?php
    session_start();
    require 'connection.php';

    $user_id = $_SESSION['user_id'] ?? 1;

    if (!isset($_GET['id'])) {
        header("Location: men.php");
        exit();
    }

    $product_id = (int) $_GET['id'];

    // Check if product exists in cart already
    $sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cart_id = $row['id'];
        $quantity = $row['quantity'] + 1;

        $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $update->bind_param("ii", $quantity, $cart_id);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $insert->bind_param("ii", $user_id, $product_id);
        $insert->execute();
    }

    header("Location: cart.php");
    exit();
?>