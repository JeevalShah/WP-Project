<?php
  include 'connection.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    $stmt = $conn->prepare("INSERT INTO reviews (name, rating, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $rating, $feedback);

    if ($stmt->execute()) {
      echo "success";
    } else {
      echo "error";
    }

    $stmt->close();
    $conn->close();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Customer Feedback</title>
  <link rel="stylesheet" href="./style/style1.css" type="text/css">
  <link rel="stylesheet" href="./style/feedback.css" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" href="./image/logo.png" type="image/png">
</head>
<body>

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

      <div class="flex items-center space-x-4">
        <a href="#" class="text-gray-800 hover:text-mint-green">
            <i class="fas fa-heart"></i>
        </a>
        <a href="./cart.php" class="text-gray-800 hover:text-mint-green">
            <i class="fas fa-shopping-cart"></i>
        </a>
        <a href="./login.php" class="text-gray-800 hover:text-mint-green">
            <i class="fas fa-user"></i>
        </a>
    </div>
  </nav>

  <h1>Customer Feedback</h1>
  <button class="btn-back" onclick="window.location.href='index.html'">Back to Home</button>

  <div class="feedback-section">
    <h2 class="heading blue">Submit Your Feedback</h2>

    <form id="feedbackForm" method="POST" action=""
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
          $stars = str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']);
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
      header("feedback.php");
    ?>
  </div>


  <script>
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingInput = document.getElementById('ratingInput');
    let selectedRating = 0;

    stars.forEach((star, index) => {
      star.addEventListener('mouseover', () => highlightStars(index + 1));
      star.addEventListener('mouseout', () => highlightStars(selectedRating));
      star.addEventListener('click', () => {
        selectedRating = index + 1;
        ratingInput.value = selectedRating;
        highlightStars(selectedRating);
      });
    });

    function highlightStars(rating) {
      stars.forEach((star, index) => {
        star.classList.toggle('selected', index < rating);
      });
    }
  </script>

</body>
</html>