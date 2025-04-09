<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winter Sports project</title>
    <link rel="shortcut icon" href="image/logo.png">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    <link rel="icon" href="./image/logo.png" type="image/png">
</head>
<body>
    <section>
        <nav>
            <div class="logo">
                <h1>Winter<span> Sport</span></h1>
            </div>
        
            <ul>
                <li><a href="./index.php">Home</a></li>
                <li><a href="men.php">Products</a></li>
                <li><a href="./aboutus.php">About Us</a></li>
                <li><a href="#Review">Review</a></li>
                <li><a href="./services.php">Services</a></li>
            </ul>

            <div class="icons">
                <i class="fa-solid fa-heart"></i>
                <a href="cart.php" style="text-decoration: none; color: black;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
                <i class="fa-solid fa-user"></i>
            </div>
        
        </nav>

        <div class="main" id="Home">
            <div class="main_content">
                <div class="main_text">
                    <h1>Winter Sport<br><span>Collection</span></h1>
                    <p>
                        Welcome to Winter Sport, your one-stop destination for top-quality winter sports gear! Whether you're carving down the slopes, conquering backcountry trails, or just embracing the winter chill, we’ve got the perfect equipment and apparel to keep you warm, safe, and performing at your best.
                    </p>
                </div>
                <div class="main_image">
                    <img src="image/main_snow.png">
                </div>
            </div>
        
            <div class="social_icon">
                <i class="fa-brands fa-facebook-f"></i>
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-linkedin-in"></i>
            </div>

            <div class="button">
                <a href="./men.php">SHOP NOW</a>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </div>
    
    </section>

    <!--Products-->

    <div class="products" id="Products">
        <h1>New Arrivals</h1>
        <div class="box">
            <?php
                include 'connection.php';

                $category = $_GET['category'] ?? 'highlights';

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

    <!--About-->

    <br> <br>
    <div class="about" id="About">
        
        <h1><span>About Us</span></h1>

        <div class="about_main">
            <div class="about_image">
                <div class="about_small_image">
                    <img src="image/goggles1.webp" onclick="functio(this)">
                    <img src="image/goggles2.webp" onclick="functio(this)">
                    <img src="image/goggles3.webp" onclick="functio(this)">
                    <!--<img src="image/goggles4.jpg" onclick="functio(this)"> -->
                </div>

                <div class="image_contaner">
                    <img src="image/goggles1.webp" id="imagebox">
                </div>

            </div>

            <div class="about_text">
                <p>
                    At Winter Sport, we’re more than just a winter sports gear store—we’re a community of adventurers, thrill-seekers, and snow lovers. Born out of a passion for the mountains, our mission is to equip every winter enthusiast with the best gear to make every run, ride, and trek unforgettable.

We handpick high-quality skis, snowboards, outerwear, and accessories from top brands to ensure durability, performance, and comfort. Whether you're a seasoned pro or just discovering the magic of winter sports, we’re here to help you find the perfect fit for your next adventure.

Our team is made up of experienced riders, skiers, and outdoor enthusiasts who know the gear inside and out. We’re always ready to offer expert advice, product recommendations, and tips to help you make the most of your time in the snow.

Join us in embracing the season, pushing limits, and making memories in the mountains. Because winter isn’t just a season—it’s a lifestyle. 
                </p>
            </div>

        </div>

        <a href="./men.php" class="about_btn">Shop Now</a>

        <script>
            function functio(small){
                var full = document.getElementById("imagebox")
                full.src = small.src
            }
        </script>
        
    </div>

<div class="review" id="Review">
    <h1>Customer's <span>review</span></h1>

    <?php
        include "connection.php";

        $sql = "SELECT * FROM reviews";
        $result = $conn->query($sql);

        $count = 0;
        if ($result->num_rows > 0) {
            echo '<div class="review_box">';
            while ($row = $result->fetch_assoc()) {
                if ($count > 0 && $count % 3 == 0) {
                    echo '</div><div class="review_box">';
                }

                echo '<div class="review_card">
                        <div class="card_top">
                            <div class="profile">
                                <div class="profile_image">
                                    <img src="' . $row['image_path'] . '">
                                </div>
                                <div class="name">
                                    <strong>' . htmlspecialchars($row['name']) . '</strong>
                                    <div class="like">';

                $full_stars = floor($row['rating']);
                $half_star = ($row['rating'] - $full_stars) >= 0.5;
                for ($i = 0; $i < $full_stars; $i++) {
                    echo '<i class="fa-solid fa-star"></i>';
                }
                if ($half_star) {
                    echo '<i class="fa-solid fa-star-half-stroke"></i>';
                    $i++;
                }
                while ($i < 5) {
                    echo '<i class="fa-regular fa-star"></i>';
                    $i++;
                }

                echo        '</div>
                            </div>
                        </div>
                    </div>
                    <div class="comment">
                        <p>' . htmlspecialchars($row['comment']) . '</p>
                    </div>
                </div>';

                $count++;
            }
            echo '</div>'; 
        } else {
            echo '<p>No reviews found.</p>';
        }
        echo '</div>';
    ?>

    <!--Services-->

    <div class="services" id="Servises">
        <h1>our<span>services</span></h1>

        <div class="services_cards">
            <div class="services_box">
                <i class="fa-solid fa-truck-fast"></i>
                <h3>Fast Delivery</h3>
                <p>
                    Reliable Delivery within 6-7 days.
                </p>
            </div>

            <div class="services_box">
                <i class="fa-solid fa-rotate-left"></i>
                <h3>10 Days Replacement</h3>
                <p>
                    Guaranteed replacement options.
                </p>
            </div>

            <div class="services_box">
                <i class="fa-solid fa-headset"></i>
                <h3>24 x 7 Support</h3>
                <p>
                    Customer service available 24 x 7.
                </p>
            </div>
        </div>

    </div>

    <div align="center">
            <img src="image/snow.jpg">
    </div>



    <!--Footer-->
    <footer>
        <div class="footer_main" align="center">
            <div class="tag">
                <h1>Contact</h1>
                <a href="#"><i class="fa-solid fa-house"></i>123, Mumbai India</a>
                <a href="#"><i class="fa-solid fa-phone"></i>+91 77777 77777</a>
                <a href="#"><i class="fa-solid fa-envelope"></i>info@gmail.com</a>
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

   

