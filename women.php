<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.html");
    exit;
}

include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winter Sport Products</title>
    <link rel="shortcut icon" href="image/logo.png">
    <link rel="stylesheet" href="style/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <style>
        .category-buttons .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .category-buttons .btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <section>
        <nav>
            <div class="logo">
                <h1>Winter<span> Sport</span></h1>
            </div>
            <ul>
                <li><a href="index.php#Home">Home</a></li>
                <li><a href="men.php">Products</a></li>
                <li><a href="index.php#About">About</a></li>
                <li><a href="index.php#Review">Review</a></li>
                <li><a href="index.php#Services">Services</a></li>
            </ul>
            <div class="icons">
                <i class="fa-solid fa-heart"></i>
                <a href="cart.php" style="text-decoration: none; color: black;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
                <i class="fa-solid fa-user"></i>
            </div>
        </nav>

    </section>


    <!-- Products Section -->
    <div class="products" id="Products">
        <!-- Category Buttons -->
        <div class="category-buttons" style="text-align:center; margin: 20px;">
            <a href="men.php" class="btn">Men</a>
            <a href="women.php" class="btn">Women</a>
            <a href="accessories.php" class="btn">Accessories</a>
        </div>
        <h1>Women's collection</h1>

        <div class="box">
        <?php
            include 'connection.php';

            $category = $_GET['category'] ?? 'women';

            $sql = "SELECT * FROM products WHERE category = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $result = $stmt->get_result();

            function renderStars($rating) {
                $fullStars = floor($rating);
                $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                $emptyStars = 5 - $fullStars - $halfStar;

                $output = '<div class="products_star">';
                for ($i = 0; $i < $fullStars; $i++) {
                    $output .= '<i class="fa-solid fa-star"></i>';
                }
                if ($halfStar) {
                    $output .= '<i class="fa-solid fa-star-half-stroke"></i>';
                }
                for ($i = 0; $i < $emptyStars; $i++) {
                    $output .= '<i class="fa-regular fa-star"></i>';
                }
                $output .= '</div>';

                return $output;
            }

            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="card">
                    <div class="small_card">
                        <i class="fa-solid fa-heart"></i>
                        <i class="fa-solid fa-share"></i>
                    </div>
                    <div class="image">
                        <img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["name"]) . '">
                    </div>
                    <div class="products_text">
                        <h2>' . htmlspecialchars($row["name"]) . '</h2>
                        <p>' . htmlspecialchars($row["description"]) . '</p>
                        <h3>₹' . htmlspecialchars($row["price"]) . '</h3>
                        ' . renderStars($row["rating"]) . '
                        <a href="add-to-cart.php?id=' . $row["id"] . '" class="btn">Add To Cart</a>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <!--Footer-->
    <footer>
        <div class="footer_main">
            <div class="tag">
                <h1>Contact</h1>
                <a href="#"><i class="fa-solid fa-house"></i>123, Mumbai India</a>
                <a href="#"><i class="fa-solid fa-phone"></i>+91 77777 77777</a>
                <a href="#"><i class="fa-solid fa-envelope"></i>info@gmail.com</a>
            </div>

            <div class="tag">
                <h1>Get Help</h1>
                <a href="#" class="center">FAQ</a>
                <a href="#" class="center">Shipping</a>
                <a href="#" class="center">Returns</a>
                <a href="#" class="center">Payment Options</a>
            </div>

            <div class="tag">
                <h1>Our Stores</h1>
                <a href="#" class="center">Sri Lanka</a>
                <a href="#" class="center">USA</a>
                <a href="#" class="center">India</a>
                <a href="#" class="center">Japan</a>
            </div>

            <div class="tag">
                <h1>Follw Us</h1>
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
