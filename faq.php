<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FAQs</title>
  <link rel="stylesheet" href="./style/faq.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" href="./image/logo.png" type="image/png">
  <style>
    a {
      text-decoration: none;
      color: inherit;
    }
  </style>
</head>
<body>
    <nav>
        <div class="logo">
          <h1>Winter<span> Sport</span></h1>
        </div>
    
        <ul>
          <li><a href="./index.php">Home</a></li>
          <li><a href="./men.php">Products</a></li>
          <li><a href="./aboutus.php">About</a></li>
          <li><a href="./feedback.php">Review</a></li>
          <li><a href="./services.php">Services</a></li>
          <li><a href="./contactus.php">Contact</a></li>
        </ul>
    
        <div class="icons">
          <i class="fa-solid fa-heart"></i>
          <a href="./cart.php" class="text-gray-800 hover:text-mint-green">
            <i class="fas fa-shopping-cart"></i>
          </a>
          <a href="./profile.php" style="text-decoration: none; color: black;">
            <i class="fa-solid fa-user"></i>
          </a>
        </div>
      </nav>

  <div class="container">
    <div class="header">
      <h1>Frequently Asked Questions</h1>
      <a href="index.php">
        <button class="back-btn">Back to Home</button>
      </a>      
    </div>
    <p class="description">Find answers to the most common questions about our products, services, shipping, returns, and more.</p>

    <div class="accordion">
      <div class="accordion-item">
        <button class="accordion-trigger">How do I choose the right ski size?</button>
        <div class="accordion-content">
          Select skis based on your height, weight, and skill level. Generally, beginner skis should reach between your chin and nose, intermediate skis should reach your eyebrow level, and advanced skis can be as tall as the top of your head. Our product descriptions include size recommendations, or you can contact our customer service for personalized advice.
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">What is your shipping policy?</button>
        <div class="accordion-content">
          We offer free standard shipping on all orders over $100 within the continental US. Standard shipping takes 3-5 business days. Express shipping (1-2 business days) is available for an additional fee. International shipping rates and delivery times vary by location. All orders are processed within 24-48 hours.
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">How do I return or exchange an item?</button>
        <div class="accordion-content">
          We accept returns and exchanges within 30 days of purchase for unused items in original packaging. To initiate a return, log into your account and follow the return instructions, or contact our customer service team. Return shipping is free for exchanges, while standard returns may incur a small return shipping fee.
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">Do you offer seasonal equipment rentals?</button>
        <div class="accordion-content">
          Yes, we offer seasonal rentals for skis, snowboards, and other winter sports equipment. Rental packages can be customized based on your needs and experience level. Visit our physical stores to get fitted for rental equipment or contact customer service for more details about our rental program.
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">How do I properly maintain my winter sports equipment?</button>
        <div class="accordion-content">
          Regular maintenance extends the life of your equipment. Clean your gear after each use and store it in a dry place. For skis and snowboards, we recommend waxing them 3-4 times per season. Check bindings regularly for wear and tear. We offer professional maintenance services in our stores, including edge sharpening, waxing, and binding adjustments.
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">Do you offer price matching?</button>
        <div class="accordion-content">
          Yes, we offer price matching for identical items found at lower prices from authorized retailers. To request a price match, contact our customer service team with evidence of the lower price within 14 days of your purchase. Price matching does not apply to clearance items, flash sales, or unauthorized dealers.
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">What warranty do your products carry?</button>
        <div class="accordion-content">
          All products are covered by the manufacturer's warranty. Most hard goods (skis, snowboards, etc.) come with a 1-2 year warranty against manufacturing defects. Apparel typically carries a 1-year warranty. Extended warranty options are available for select items at the time of purchase. Please keep your receipt for warranty claims.
        </div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">Do you offer gift cards?</button>
        <div class="accordion-content">
          Yes, we offer both physical and digital gift cards in various denominations. Gift cards do not expire and can be used for online purchases or in our physical stores. To purchase a gift card, visit our website or any of our retail locations.
        </div>
      </div>
    </div>

    <div class="separator"></div>

    <div class="support">
      <h2>Still have questions?</h2>
      <p>Our customer service team is here to help. Reach out to us via email, phone, or visit one of our stores for personalized assistance.</p>
      <div class="support-buttons">
        <a href="mailto:wintersports@gmail.com" class="button email-btn">
            📧 Email Us
          </a>          
          <button class="button call-btn" onclick="alert('Calling support at +91 77777 77777')">📞 Call Us</button>
      </div>
    </div>
  </div>

  <script>
    const triggers = document.querySelectorAll(".accordion-trigger");

    triggers.forEach(trigger => {
      trigger.addEventListener("click", () => {
        const item = trigger.parentElement;
        item.classList.toggle("active");
      });
    });
  </script>
</body>
</html>
