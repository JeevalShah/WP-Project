<?php
    require 'connection.php';

    $cart_id = $_POST['cart_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();

    header("Location: cart.php");
    exit;
?>
