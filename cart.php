<?php
    session_start();
    require 'connection.php';

    $user_id = $_SESSION['user_id'] ?? 1;

    $promoDiscount = 0;
    $promoCode = '';
    $validPromoCodes = [
        'DISCOUNT10' => 0.10,
        'SAVE20' => 0.20
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['promo_code'])) {
        $promoCode = strtoupper(trim($_POST['promo_code']));
        if (array_key_exists($promoCode, $validPromoCodes)) {
            $promoDiscount = $validPromoCodes[$promoCode];
        }
    }

    $sql = "SELECT 
                c.id as cart_id,
                p.id as product_id,
                p.name,
                p.price,
                p.image_url,
                c.quantity
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $cartItems = [];
    $subtotal = 0;

    while ($row = $result->fetch_assoc()) {
        $row['total'] = $row['price'] * $row['quantity'];
        $subtotal += $row['total'];
        $cartItems[] = $row;
    }

    $shippingFee = 100;
    $discountAmount = $subtotal * $promoDiscount;
    $total = $subtotal - $discountAmount + $shippingFee;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winter Sport - Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style/cart.css" type="text/css">
    <style>
        a {
            text-decoration: none;
        }
    </style>
    <link rel="icon" href="./image/logo.png" type="image/png">
</head>
<body>
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <header class="border-b border-gray-200 bg-white">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/" class="text-3xl font-bold">
                        <span class="text-mint-green">Winter</span> <span class="text-sky-blue">Sport</span>
                    </a>
                </div>
                
                <nav class="hidden md:flex space-x-8">
                    <a href="./index.php" class="text-gray-800 hover:text-mint-green transition">Home</a>
                    <a href="./men.php" class="text-gray-800 hover:text-mint-green transition">Products</a>
                    <a href="./aboutus.php" class="text-gray-800 hover:text-mint-green transition">About Us</a>
                    <a href="./feedback.php" class="text-gray-800 hover:text-mint-green transition">Review</a>
                    <a href="./services.php" class="text-gray-800 hover:text-mint-green transition">Services</a>
                    <a href="./contactus.php" class="text-gray-800 hover:text-mint-green transition">Contact</a>
                </nav>
                
                <div class="flex items-center space-x-4">
                    <i class="fas fa-heart"></i>
                    <a href="#" class="text-gray-800 hover:text-mint-green">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <a href="./profile.php" style="text-decoration: none; color: black;">
                        <i class="fa-solid fa-user"></i>
                    </a>
                </div>
            </div>
        </header>

        <!-- Cart Content -->
        <div class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <h1 class="text-3xl font-bold mb-6">Your Shopping Cart</h1>

                <?php if (empty($cartItems)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-shopping-cart text-5xl text-gray-300 mb-4"></i>
                        <h2 class="text-xl font-medium mb-4">Your cart is empty</h2>
                        <a href="./men.php" class="px-6 py-3 bg-mint-green text-white rounded-full" style="text-decoration:none">Continue Shopping</a>
                    </div>
                <?php else: ?>
                    <form method="POST" action="">
                        <div class="flex flex-col lg:flex-row gap-8">
                            <!-- Cart Items -->
                            <div class="lg:w-2/3">
                                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200" align="center">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody align="center">
                                            <?php foreach ($cartItems as $index => $item): ?>
                                                <tr>
                                                    <td class="px-6 py-4 flex items-center">
                                                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="h-16 w-16 rounded object-cover">
                                                        <span class="ml-4"><?= htmlspecialchars($item['name']) ?></span>
                                                    </td>
                                                    <td>₹<?= $item['price'] ?></td>
                                                    <td>
                                                        <input type="hidden" name="cart_ids[]" value="<?= $item['cart_id'] ?>">
                                                        <input type="number" name="quantities[]" value="<?= $item['quantity'] ?>" min="1" class="border rounded px-2 py-1 w-16">
                                                    </td>
                                                    <td>₹<?= $item['total'] ?></td>
                                                    <td>
                                                            <button type="submit" formaction="remove_from_cart.php" class="text-red-500" name="cart_id" id="cart_id" value="<?= $item['cart_id'] ?>">Remove</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-6 flex justify-between items-center">
                                    <a href="./men.php" class="text-sky-blue font-medium"><i class="fas fa-arrow-left mr-2"></i>Continue Shopping</a>
                                    <button type="submit" formaction="update_cart_bulk.php" class="px-6 py-2 bg-mint-green text-white rounded-full">Update Cart</button>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="lg:w-1/3">
                                <div class="bg-white rounded-lg shadow-sm p-6">
                                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                                    <div class="border-t border-b py-4 space-y-2">
                                        <div class="flex justify-between"><span>Subtotal</span><span>₹<?= number_format($subtotal, 2) ?></span></div>
                                        <div class="flex justify-between"><span>Shipping</span><span>₹<?= number_format($shippingFee, 2) ?></span></div>
                                        <?php if ($promoDiscount > 0): ?>
                                            <div class="flex justify-between text-green-600"><span>Promo (<?= $promoCode ?>)</span><span>-₹<?= number_format($discountAmount, 2) ?></span></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex justify-between font-semibold text-lg pt-4">
                                        <span>Total</span>
                                        <span>₹<?= number_format($total, 2) ?></span>
                                    </div>

                                    <button type="submit" formaction="checkout.php" class="w-full mt-4 bg-mint-green text-white py-3 rounded-full font-medium" name="total" value="<?= $total ?>">
                                        Proceed to Checkout
                                    </button>

                                    <!-- Promo Code Input -->
                                    <div class="mt-6">
                                        <h3 class="text-sm font-medium mb-2">Apply Promo Code</h3>
                                        <div class="flex">
                                            <input type="text" name="promo_code" id="promo_code" placeholder="Enter your code" class="px-4 py-2 border border-gray-300 rounded-l-lg w-full" value="<?= htmlspecialchars($promoCode)?>">
                                            <button type="submit" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-r-lg hover:bg-gray-300">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-100 mt-auto">
            <div class="container mx-auto px-4 py-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact</h3>
                        
                        <div class="space-y-2">
                            <p><i class="fas fa-map-marker-alt mr-2"></i>123, Mumbai India</p>
                            <p><i class="fas fa-phone mr-2"></i>+91 77777 77777</p>
                            <p><i class="fas fa-envelope mr-2"></i>wintersports@gmail.com</p>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Get Help</h3>
                        <ul class="space-y-2">
                            <li><a href="./faq.php" class="hover:text-mint-green transition">FAQ</a></li>
                            <li><a href="#" class="hover:text-mint-green transition">Shipping</a></li>
                            <li><a href="#" class="hover:text-mint-green transition">Returns</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Our Stores</h3>
                        <ul class="space-y-2">
                            <li>UK</li>
                            <li>USA</li>
                            <li>India</li>
                            <li>Japan</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                        <div class="flex space-x-4 mb-4">
                            <a href="#" class="text-gray-800 hover:text-mint-green transition"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-gray-800 hover:text-mint-green transition"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-800 hover:text-mint-green transition"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-gray-800 hover:text-mint-green transition"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        
                        <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                        <div class="flex">
                            <input 
                                type="email" 
                                placeholder="Your email address" 
                                class="px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-1 focus:ring-mint-green w-full"
                                id="newsletterEmail"
                            />
                            <button class="bg-mint-green text-white px-4 py-2 rounded-r-lg" id="subscribeBtn">
                                Subscribe
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>


</body>
</html>