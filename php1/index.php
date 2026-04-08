<?php
// =============================================
// PHP FASHION STORE - Dynamic Page with PHP
// =============================================

// --- PHP: Product Data Array ---
$products = [
    [
        "id"      => 1,
        "name"    => "Men's T-Shirt",
        "badge"   => "NEW",
        "image"   => "images/product1.jpg",
        "alt"     => "Men T-Shirt",
        "rating"  => 5,
        "old"     => "₹1299",
        "new"     => "₹799",
        "details" => "Free Delivery • Easy Returns",
    ],
    [
        "id"      => 2,
        "name"    => "Women's Dress",
        "badge"   => "SALE",
        "image"   => "images/product2.jpg",
        "alt"     => "Women Dress",
        "rating"  => 4,
        "old"     => "₹1999",
        "new"     => "₹1499",
        "details" => "Stylish Fit • Easy Returns",
    ],
    [
        "id"      => 3,
        "name"    => "Stylish Jacket",
        "badge"   => "BEST",
        "image"   => "images/product3.jpg",
        "alt"     => "Jacket",
        "rating"  => 5,
        "old"     => "₹2999",
        "new"     => "₹2199",
        "details" => "Winter Wear • Premium Quality",
    ],
    [
        "id"      => 4,
        "name"    => "Casual Sneakers",
        "badge"   => "HOT",
        "image"   => "images/product4.jpg",
        "alt"     => "Sneakers",
        "rating"  => 4,
        "old"     => "₹3499",
        "new"     => "₹2499",
        "details" => "Comfortable • Lightweight",
    ],
];

// --- PHP: Categories ---
$categories = ["Men", "Women", "Kids", "Accessories"];

// --- PHP: Features ---
$features = [
    ["icon" => "🚚", "label" => "Free Shipping"],
    ["icon" => "💳", "label" => "Secure Payment"],
    ["icon" => "🔄", "label" => "Easy Returns"],
    ["icon" => "📞", "label" => "24/7 Support"],
];

// --- PHP: Helper function to render star ratings ---
function renderStars(int $rating): string {
    $stars = "";
    for ($i = 1; $i <= 5; $i++) {
        $stars .= ($i <= $rating) ? "★" : "☆";
    }
    return $stars;
}

// --- PHP: Handle newsletter form submission ---
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
    $email = htmlspecialchars(trim($_POST["email"]));
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "✅ Thank you! <strong>" . $email . "</strong> has been subscribed.";
    } else {
        $message = "❌ Invalid email address. Please try again.";
    }
}

// --- PHP: Get current year for footer ---
$year = date("Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fashion Store — Trendy styles at the best prices. Shop Men, Women, and Kids collections.">
    <title>FashionStore — PHP Edition</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS File -->
    <link rel="stylesheet" href="style.css">

    <!-- Extra PHP-page styles -->
    <style>
        .php-badge {
            display: inline-block;
            background: linear-gradient(135deg, #7b2ff7, #4a90e2);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 8px;
            vertical-align: middle;
        }
        .message-box {
            margin: 0 40px 20px;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 15px;
            background: #eafaf1;
            border-left: 5px solid #27ae60;
            color: #1e8449;
        }
        .message-box.error {
            background: #fdf2f2;
            border-color: #e74c3c;
            color: #c0392b;
        }
        .newsletter {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            padding: 60px 20px;
            text-align: center;
            color: #fff;
        }
        .newsletter h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .newsletter p {
            color: #ccc;
            margin-bottom: 25px;
        }
        .newsletter form {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .newsletter input[type="email"] {
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            outline: none;
            width: 280px;
            font-size: 14px;
        }
        .newsletter button {
            padding: 12px 28px;
            background: #f39c12;
            border: none;
            border-radius: 30px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .newsletter button:hover {
            background: #d35400;
        }
        .php-info-bar {
            background: #1d1d2e;
            color: #aaa;
            text-align: center;
            font-size: 12px;
            padding: 6px;
            letter-spacing: 0.5px;
        }
        .php-info-bar span { color: #f39c12; }
    </style>
</head>
<body>

<!-- ================= PHP INFO BAR ================= -->
<div class="php-info-bar">
    ⚙️ Powered by <span>PHP <?php echo phpversion(); ?></span> &nbsp;|&nbsp;
    Page generated on <span><?php echo date("d M Y, h:i A"); ?></span> &nbsp;|&nbsp;
    <?php echo count($products); ?> products loaded dynamically
</div>

<!-- ================= NAVBAR ================= -->
<header>
    <div class="logo">
        FashionStore
        <span class="php-badge">PHP</span>
    </div>

    <nav>
        <a href="#">Home</a>
        <a href="#">Shop</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>

    <div class="nav-right">
        <input type="text" placeholder="Search products...">
        <span>🛒</span>
        <span>❤️</span>
    </div>
</header>

<!-- ================= HERO ================= -->
<section class="hero">
    <h1>New Fashion Collection</h1>
    <p>Trendy styles at best prices</p>
    <button>Shop Now</button>
</section>

<!-- ================= CATEGORIES (PHP Loop) ================= -->
<section class="categories">
    <?php foreach ($categories as $cat): ?>
        <div class="cat"><?php echo htmlspecialchars($cat); ?></div>
    <?php endforeach; ?>
</section>

<!-- ================= NEWSLETTER FORM RESULT ================= -->
<?php if (!empty($message)): ?>
    <div class="message-box <?php echo (str_starts_with($message, '❌')) ? 'error' : ''; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<!-- ================= PRODUCTS (PHP Loop) ================= -->
<section class="products">
    <h2>Featured Products</h2>

    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <span class="badge"><?php echo htmlspecialchars($product["badge"]); ?></span>

                <div class="img-box">
                    <img src="<?php echo htmlspecialchars($product["image"]); ?>"
                         alt="<?php echo htmlspecialchars($product["alt"]); ?>">
                    <div class="overlay">Quick View</div>
                </div>

                <h3><?php echo htmlspecialchars($product["name"]); ?></h3>
                <div class="rating"><?php echo renderStars($product["rating"]); ?></div>

                <p class="price">
                    <span class="old"><?php echo $product["old"]; ?></span>
                    <span class="new"><?php echo $product["new"]; ?></span>
                </p>

                <p class="details"><?php echo htmlspecialchars($product["details"]); ?></p>
                <button id="add-cart-<?php echo $product["id"]; ?>">Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ================= FEATURES (PHP Loop) ================= -->
<section class="features">
    <?php foreach ($features as $feature): ?>
        <div><?php echo $feature["icon"] . " " . htmlspecialchars($feature["label"]); ?></div>
    <?php endforeach; ?>
</section>

<!-- ================= NEWSLETTER (PHP Form) ================= -->
<section class="newsletter">
    <h2>📧 Subscribe to Our Newsletter</h2>
    <p>Get the latest deals and fashion updates right in your inbox.</p>

    <form method="POST" action="">
        <input type="email" name="email" id="newsletter-email"
               placeholder="Enter your email address"
               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
               required>
        <button type="submit" id="newsletter-submit">Subscribe</button>
    </form>
</section>

<!-- ================= CTA ================= -->
<section class="cta">
    <button id="join-now-btn">Join Now</button>
</section>

<!-- ================= FOOTER ================= -->
<footer class="footer">
    <div class="social">
        <span>📘</span>
        <span>📸</span>
        <span>🐦</span>
        <span>🌐</span>
    </div>
    <p style="margin-top:12px; font-size:13px; color:#aaa;">
        &copy; <?php echo $year; ?> FashionStore. All rights reserved. &mdash; Built with PHP
    </p>
</footer>

</body>
</html>
