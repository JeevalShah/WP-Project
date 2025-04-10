<?php
    session_start();
    require_once 'connection.php';

    $user_id = $_SESSION['user_id'] ?? 1;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
        $stmt->execute();

        header("Location: profile.php");
        exit();
    }
?>