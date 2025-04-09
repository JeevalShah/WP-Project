<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO message (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully!'); window.location.href='contactus.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Winter Sport</title>
    <link rel="shortcut icon" href="image/logo.png">
    <link rel="stylesheet" href="./style/style1.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="icon" href="./image/logo.png" type="image/png">
    <script>
        function validateForm() {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const message = document.getElementById("message").value.trim();
    
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const nameRegex = /^[A-Za-z\s]{2,}$/;
    
            if (name === "" || email === "" || message === "") {
                alert("Please fill out all fields.");
                return false;
            }
    
            if (!nameRegex.test(name)) {
                alert("Name should only contain letters and spaces (at least 2 characters).");
                return false;
            }
    
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }
    
            return true;
        }
    </script>
</head>
<body>

<!-- Navigation -->
<nav>
    <div class="logo">
        <h1>Winter<span> Sport</span></h1>
    </div>
    <ul>
        <li><a href="./index.php#Home">Home</a></li>
        <li><a href="./men.php">Products</a></li>
        <li><a href="./aboutus.php">About</a></li>
        <li><a href="./feedback.php">Review</a></li>
        <li><a href="./services.php">Services</a></li>
        <li><a href="./contactus.php">Contact</a></li>
    </ul>
    <div class="icons">
        <i class="fa-solid fa-heart"></i>
        <i class="fa-solid fa-cart-shopping"></i>
        <i class="fa-solid fa-user"></i>
    </div>
</nav>

<!-- Contact Section -->
<section class="contact-section">
    <div class="contact-container">
        <h1>Contact Us</h1>
        <p>If you have any questions or inquiries, feel free to reach out using the form below.</p>
        <form action="#" method="POST" class="contact-form" onsubmit="return validateForm()" novalidate>
            <input type="text" name="name" id="name" placeholder="Your Name" required>
            <input type="email" name="email" id="email" placeholder="Your Email" required>
            <textarea name="message" id="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" class="btn">Send Message</button>
        </form>

    </div>
</section>

<!--Footer-->
<footer>
        <div class="footer_main" align="center">
            <div class="tag">
                <h1>Contact</h1>
                <a href="#"><i class="fa-solid fa-house"></i>123, Mumbai India</a>
                <a href="#"><i class="fa-solid fa-phone"></i>+91 77777 77777</a>
                <a href="#"><i class="fa-solid fa-envelope"></i>wintersports@gmail.com</a>
            </div>

            <div class="tag">
                <h1>Get Help</h1>
                <a href="./faq.php" class="center">FAQ</a>
                <a href="#" class="center">Shipping</a>
                <a href="#" class="center">Returns</a>
                <a href="#" class="center">Payment Options</a>
            </div>

            <div class="tag">
                <h1>Our Stores</h1>
                <a href="#" class="center">UK</a>
                <a href="#" class="center">USA</a>
                <a href="#" class="center">India</a>
                <a href="#" class="center">Japan</a>
            </div>

            <div class="tag">
                <h1>Follow Us</h1>
                <div class="social_link">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>                    
                </div>
            </div>

            <div class="tag">
                <h1>Newsletter</h1>
                <div class="search_bar">
                    <input type="text" placeholder="You email id here">
                    <button type="submit">Subscribe</button>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
