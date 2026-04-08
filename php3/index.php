<?php
// =============================================
// HOTEL MANAGEMENT SYSTEM — index.php (Home)
// =============================================

$pageTitle = "Home";
$services = [
    ["icon" => "🛏", "label" => "Luxury Rooms",   "desc" => "Spacious rooms with premium amenities"],
    ["icon" => "🍽", "label" => "Restaurant",      "desc" => "Fine dining with global cuisine"],
    ["icon" => "🏊", "label" => "Swimming Pool",   "desc" => "Heated pool open 6 AM – 10 PM"],
    ["icon" => "🏋", "label" => "Fitness Center",  "desc" => "State-of-the-art gym equipment"],
    ["icon" => "💆", "label" => "Spa & Wellness",  "desc" => "Relax with our luxury spa treatments"],
    ["icon" => "🚗", "label" => "Free Parking",    "desc" => "24-hour secure parking facility"],
];

$year = date("Y");
$generatedAt = date("d M Y, h:i A");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Hotel Management System — Book luxury rooms, manage bookings and more."/>
  <title>Hotel Management System — <?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="style.css"/>
  <style>
    .php-info-bar {
      background: rgba(0,0,0,0.8);
      color: #aaa;
      text-align: center;
      font-size: 11px;
      padding: 6px;
      letter-spacing: 0.4px;
    }
    .php-info-bar span { color: #ff9800; font-weight: bold; }
    .php-badge {
      display: inline-block;
      background: linear-gradient(135deg, #ff512f, #dd2476);
      color: #fff;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 1px;
      padding: 2px 9px;
      border-radius: 20px;
      margin-left: 6px;
      vertical-align: middle;
    }
    .services-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
      padding: 0 20px 40px;
    }
    .service-card {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px 20px;
      width: 200px;
      text-align: center;
      color: white;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      transition: 0.3s;
    }
    .service-card:hover { transform: translateY(-8px); }
    .service-card .s-icon { font-size: 36px; margin-bottom: 10px; }
    .service-card .s-label { font-size: 16px; font-weight: bold; margin-bottom: 6px; }
    .service-card .s-desc { font-size: 12px; color: #ddd; }
    .php-note { font-size: 10px; color: rgba(255,255,255,0.4); margin-top: 8px; font-style: italic; }
    .hero-badge { display: inline-block; background: rgba(255,152,0,0.3); border: 1px solid #ff9800; padding: 4px 14px; border-radius: 20px; font-size: 13px; margin-bottom: 16px; color: #ff9800; }
  </style>
</head>
<body>

<!-- PHP Info Bar -->
<div class="php-info-bar">
  ⚙️ PHP <span><?php echo phpversion(); ?></span>
  &nbsp;|&nbsp; Generated: <span><?php echo $generatedAt; ?></span>
  &nbsp;|&nbsp; <span><?php echo count($services); ?></span> services rendered server-side
</div>

<!-- Navbar -->
<div class="navbar">
  <h2>🏨 Hotel Management <span class="php-badge">PHP</span></h2>
  <div>
    <a href="index.php">Home</a>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
    <a href="book.php">Book Room</a>
    <a href="feedback.php">Feedback</a>
    <a href="admin.php">Admin</a>
  </div>
</div>

<!-- Hero -->
<div class="hero">
  <div class="hero-badge">⭐ 5-Star Luxury Experience</div>
  <h1>Welcome to Our Luxury Hotel</h1>
  <p>Book rooms easily &amp; enjoy your stay</p>
</div>

<!-- Services — rendered by PHP loop -->
<div class="container" style="width:90%; max-width:900px; padding:30px 20px;">
  <h2 style="text-align:center; margin-bottom:5px;">Our Services</h2>
  <p class="php-note" style="text-align:center;">Services dynamically rendered by PHP</p>
  <div class="services-grid">
    <?php foreach ($services as $svc): ?>
      <div class="service-card">
        <div class="s-icon"><?php echo $svc["icon"]; ?></div>
        <div class="s-label"><?php echo htmlspecialchars($svc["label"]); ?></div>
        <div class="s-desc"><?php echo htmlspecialchars($svc["desc"]); ?></div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Footer -->
<div class="footer">
  &copy; <?php echo $year; ?> Hotel Management System — Built with PHP <?php echo phpversion(); ?>
</div>

</body>
</html>
