<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winter Sport - Women</title>
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

        /* Horizontal Filter & Sort Form */
        form[method="POST"] {
        background-color: #f3f1f1;
        padding: 20px 30px;
        margin: 30px auto;
        width: fit-content;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        font-size: 16px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 15px;
        }

        /* Labels */
        form[method="POST"] label {
        font-weight: bold;
        color: #1c0080;
        margin-right: 5px;
        }

        /* Dropdown */
        form[method="POST"] select {
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        background-color: white;
        cursor: pointer;
        }

        /* Radio buttons and their labels */
        form[method="POST"] input[type="radio"] {
        margin-left: 10px;
        accent-color: #94b9ff;
        cursor: pointer;
        }

        /* Submit Button */
        form[method="POST"] .btn {
        padding: 8px 16px;
        background: linear-gradient(to right, #cdffd8, #94b9ff);
        border: none;
        color: white;
        border-radius: 6px;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.3s ease;
        }

        form[method="POST"] .btn:hover {
        background: linear-gradient(to left, #cdffd8, #94b9ff);
        }
    </style>
    <link rel="icon" href="./image/logo.png" type="image/png">
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
                <li><a href="./aboutus.php">About Us</a></li>
                <li><a href="index.php#Review">Review</a></li>
                <li><a href="./services.php">Services</a></li>
                <li><a href="./contactus.php">Contact</a></li>
            </ul>
            <div class="icons">
                <i class="fa-solid fa-heart"></i>
                <a href="./cart.php" style="text-decoration: none; color: black;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
                <a href="./profile.php" style="text-decoration: none; color: black;">
                    <i class="fa-solid fa-user"></i>
                </a>
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
        
        <center>
            <form method="POST" style="text-align: center; margin: 20px 0;">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort">
                    <option value="">Default</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="rating">Rating</option>
                </select>

                <!-- Price filter -->
                <label style="margin-left: 20px;">Price:</label>
                <input type="radio" name="price_range" value="0"> &lt; ₹500
                <input type="radio" name="price_range" value="500"> ₹500 - ₹1000
                <input type="radio" name="price_range" value="1000"> &gt; ₹1000

                <button type="submit" class="btn" style="margin-left: 20px;">Apply</button>
            </form>
        </center>

        <div class="box">
        <?php
            include 'connection.php';

            $category = $_GET['category'] ?? 'women';
            $price_range = $_POST['price_range'] ?? '';
            $sort = $_POST['sort'] ?? '';

            $sql = "SELECT * FROM products WHERE category = ?";
            $params = [$category];
            $types = "s";

            if ($price_range === '0') {
                $sql .= " AND price < ?";
                $params[] = 500;
                $types .= "i";
            } elseif ($price_range === '500') {
                $sql .= " AND price BETWEEN ? AND ?";
                $params[] = 500;
                $params[] = 1000;
                $types .= "ii";
            } elseif ($price_range === '1000') {
                $sql .= " AND price > ?";
                $params[] = 1000;
                $types .= "i";
            }

            if ($sort === 'price_asc') {
                $sql .= " ORDER BY price ASC";
            } elseif ($sort === 'price_desc') {
                $sql .= " ORDER BY price DESC";
            } elseif ($sort === 'rating') {
                $sql .= " ORDER BY rating DESC";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

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
