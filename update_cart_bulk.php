<?php
    session_start();
    require 'connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_ids'], $_POST['quantities'])) {
        $cart_ids = $_POST['cart_ids'];
        $quantities = $_POST['quantities'];

        for ($i = 0; $i < count($cart_ids); $i++) {
            $cart_id = (int) $cart_ids[$i];
            $quantity = max(1, (int) $quantities[$i]);

            $sql = "UPDATE cart SET quantity = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $quantity, $cart_id);
            $stmt->execute();
        }
    }

    header("Location: cart.php");
    exit();
?>