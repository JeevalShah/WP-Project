<?php
    require 'connection.php';

    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $stmt->bind_param("ii", $quantity, $cart_id);
    $stmt->execute();

    header("Location: cart.php");
    exit;
?>
