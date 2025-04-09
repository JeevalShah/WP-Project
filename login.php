<?php
    session_start();

    include 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $email;

                header("Location: index.php");
                exit;
            } else {
                echo "<script>alert('Incorrect password!'); window.location.href='login.html';</script>";
            }
        } else {
            echo "<script>alert('No user found with that email!'); window.location.href='login.html';</script>";
        }

        $stmt->close();
        $conn->close();
    }
?>
