<?php
  include 'connection.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    $stmt = $conn->prepare("INSERT INTO reviews (name, rating, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $rating, $feedback);

    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: feedback.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Customer Feedback</title>
  <link rel="stylesheet" href="./style/feedback.css" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" href="./image/logo.png" type="image/png">
  <style>
        a {
            text-decoration: none;
        }
  </style>
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
            <li><a href="./feedback.php">Review</a></li>
            <li><a href="./services.php">Services</a></li>
            <li><a href="./contactus.php">Contact</a></li>
        </ul>

        <div class="icons">
            <i class="fa-solid fa-heart"></i>
            <a href="cart.php" style="text-decoration: none; color: black;">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
            <a href="./profile.php" style="text-decoration: none; color: black;">
                <i class="fa-solid fa-user"></i>
            </a>
        </div>
    
    </nav>
  </section>

  <br>
  <h1>Customer Feedback</h1>
  <button class="btn-back" onclick="window.location.href='index.php'">Back to Home</button>

  <div class="feedback-section">
    <h2 class="heading blue">Submit Your Feedback</h2>

    <form id="feedbackForm" method="POST" action="">
      <label>Name</label>
      <input type="text" name="name" placeholder="Your name" required />

      <label>Your Rating</label>
      <div class="star-rating" id="starRating">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>
      </div>

      <input type="hidden" name="rating" id="ratingInput" value="0" />

      <label>Your Feedback</label>
      <textarea name="feedback" placeholder="Tell us about your experience" rows="5" required></textarea>

      <button class="submit-btn" type="submit">Submit Feedback</button>
    </form>
  </div>

  <div class="reviews-section">
    <h2 class="heading green">Recent Reviews</h2>

    <?php
      include 'connection.php';
      $result = $conn->query("SELECT * FROM reviews");

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $stars = str_repeat("★", $row['rating']) . str_repeat("☆", 5 - (int)$row['rating']);
          echo '<div class="review-card">';
          echo '<div><span class="stars">' . $stars . '</span></div>';
          echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
          echo '<p>' . htmlspecialchars($row['comment']) . '</p>';
          echo '</div>';
        }
      } else {
        echo '<p>No reviews yet. Be the first to share your thoughts!</p>';
      }

      $conn->close();
    ?>
  </div>

  <script>
    const stars = document.querySelectorAll('#starRating .star');
    const ratingInput = document.getElementById('ratingInput');

    stars.forEach((star) => {
        star.addEventListener('click', () => {
            const value = star.getAttribute('data-value');
            ratingInput.value = value;

            // Remove 'selected' class from all stars
            stars.forEach(s => s.classList.remove('selected'));

            // Add 'selected' class up to the clicked star
            for (let i = 0; i < value; i++) {
                stars[i].classList.add('selected');
            }
        });
    });
  </script>

</body>
</html>