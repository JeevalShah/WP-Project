<?php
    session_start();
    require_once 'connection.php';

    $user_id = $_SESSION['user_id'];

    $user_stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user = $user_stmt->get_result()->fetch_assoc();

    $order_stmt = $conn->prepare("SELECT * FROM orderitems WHERE user_id = ? ORDER BY order_date DESC");
    $order_stmt->bind_param("i", $user_id);
    $order_stmt->execute();
    $orders = $order_stmt->get_result();

    function getOrderItems($conn, $order_id) {
        $sql = "SELECT p.name, o.quantity 
                FROM orderitems o
                JOIN products p ON o.product_id = p.id 
                WHERE o.order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    $order_stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY date DESC");
    $order_stmt->bind_param("i", $user_id);
    $order_stmt->execute();
    $orders = $order_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Winter Sport</title>
    <link rel="stylesheet" href="./style/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="./image/logo.png" type="image/png">
    <style>
        a {
            text-decoration:none;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">
          <h1>Winter<span> Sport</span></h1>
        </div>
    
        <ul>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./men.php">Products</a></li>
            <li><a href="./aboutus.php">About Us</a></li>
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
            
            
        </div>
    </header>

    <!-- Profile Section -->
    <div class="flex-grow container py-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col md-flex-row gap-8">
                <!-- User Info Card -->
                <div class="md-w-1-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <div class="flex justify-center mb-4">
                                <div class="avatar">
                                    <?= strtoupper(substr($user['name'], 0, 2)) ?>
                                </div>
                            </div>
                            <h3 class="card-title"><?= htmlspecialchars($user['name']) ?></h3>
                            <p class="card-description">Member since <?= date('F Y', strtotime($user['created_at'])) ?></p>
                        </div>
                        <div class="card-content">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                    <p class="text-gray-700"><?= htmlspecialchars($user['email']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders and Settings -->
                <div class="md-w-2-3">
                    <div class="tabs">
                        <div class="tabs-list">
                            <div class="tabs-trigger active" data-tab="orders">Order History</div>
                            <div class="tabs-trigger" data-tab="settings">Settings</div>
                        </div>

                        <!-- Order History -->
                        <div class="tabs-content active" id="orders-tab">
                            <h2 class="text-2xl font-semibold mb-4">Your Orders</h2>
                            <?php while ($order = $orders->fetch_assoc()): ?>
                                <?php $order_items = getOrderItems($conn, $order['order_id']); ?>
                                <div class="card mb-4">
                                    <div class="card-header pb-2">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="card-title">ORD-<?= $order['order_id'] ?></h4>
                                                <p class="card-description"><?= date('F d, Y', strtotime($order['date'])) ?></p>
                                            </div>
                                            <div>
                                                <span class="badge badge-delivered">Delivered</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-content pt-0 pb-2">
                                        <p class="text-sm font-medium">Total: ₹<?= number_format($order['total'], 2) ?></p>
                                        <button class="btn btn-ghost mt-2 view-details-btn" data-order="order<?= $order['order_id'] ?>">
                                            View Details
                                        </button>
                                    </div>
                                    <div class="card-content pt-0 border-t hidden" id="order<?= $order['order_id'] ?>-details">
                                        <h4 class="font-medium mb-2">Items:</h4>
                                        <ul class="list-disc list-inside space-y-1">
                                            <?php while ($item = $order_items->fetch_assoc()): ?>
                                                <li class="text-sm flex justify-between">
                                                    <span><?= htmlspecialchars($item['name']) ?></span>
                                                    <span class="text-gray-500">Qty: <?= $item['quantity'] ?></span>
                                                </li>
                                            <?php endwhile; ?>
                                        </ul>
                                        <div class="mt-4 flex flex-end">
                                            <button class="btn btn-outline">Track Order</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <!-- Settings Tab -->
                        <div class="tabs-content" id="settings-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Account Settings</h3>
                                    <p class="card-description">Update your account information.</p>
                                </div>
                                <div class="card-content">
                                    <form method="POST" action="update_profile.php">
                                        <div class="space-y-4">
                                            <div class="form-group">
                                                <label for="name">Full Name</label>
                                                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" pattern="[A-Za-z\s]{2,}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" pattern="^\w+([.-]?\w+)*@\w+([.]?\w+)*(\.-\w{2,3})+$">
                                            </div>
                                            <div class="mt-6">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-gray-100">
        <div class="container py-6 text-center">
            <p class="text-gray-600">© 2025 Winter Sport. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const tabTriggers = document.querySelectorAll('.tabs-trigger');
        const tabContents = document.querySelectorAll('.tabs-content');
        
        tabTriggers.forEach(trigger => {
            trigger.addEventListener('click', () => {
                tabTriggers.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                trigger.classList.add('active');
                const tabId = trigger.getAttribute('data-tab');
                document.getElementById(`${tabId}-tab`).classList.add('active');
            });
        });

        
        // Order details toggle
        const viewDetailsBtns = document.querySelectorAll('.view-details-btn');
        viewDetailsBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const orderId = btn.getAttribute('data-order');
                const details = document.getElementById(`${orderId}-details`);
                details.classList.toggle('hidden');
                btn.textContent = details.classList.contains('hidden') ? 'View Details' : 'Hide Details';
            });
        });
        
        // Responsive navigation toggle for mobile
        const mobileMenuToggle = document.createElement('button');
        mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';
        mobileMenuToggle.className = 'md:hidden text-gray-800';
        mobileMenuToggle.style.marginLeft = '1rem';
        
        const headerContainer = document.querySelector('header .container');
        headerContainer.insertBefore(mobileMenuToggle, headerContainer.children[1]);
        
        const nav = document.querySelector('nav');
        mobileMenuToggle.addEventListener('click', () => {
            nav.classList.toggle('hidden');
        });
        
        // Check screen size and adjust navigation
        function checkScreenSize() {
            if (window.innerWidth >= 768) {
                nav.classList.remove('hidden');
            } else {
                nav.classList.add('hidden');
            }
        }
        
        window.addEventListener('resize', checkScreenSize);
        checkScreenSize();
    </script>
</body>
</html>
