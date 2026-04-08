<?php
// =============================================
// HOTEL MANAGEMENT SYSTEM — admin.php
// =============================================

// PHP: Sample bookings data array
$bookings = [
    ["id"=>1, "name"=>"Ali",     "room"=>"Deluxe", "guests"=>2, "checkin"=>"2026-02-10", "checkout"=>"2026-02-12", "amount"=>15000, "payment"=>"Paid",    "method"=>"Card"],
    ["id"=>2, "name"=>"Rahul",   "room"=>"Single", "guests"=>1, "checkin"=>"2026-02-15", "checkout"=>"2026-02-16", "amount"=>2500,  "payment"=>"Pending", "method"=>"UPI"],
    ["id"=>3, "name"=>"Priya",   "room"=>"Suite",  "guests"=>3, "checkin"=>"2026-03-01", "checkout"=>"2026-03-05", "amount"=>48000, "payment"=>"Paid",    "method"=>"Net Banking"],
    ["id"=>4, "name"=>"James",   "room"=>"Double", "guests"=>2, "checkin"=>"2026-03-10", "checkout"=>"2026-03-12", "amount"=>8000,  "payment"=>"Paid",    "method"=>"Cash"],
    ["id"=>5, "name"=>"Fatima",  "room"=>"Single", "guests"=>1, "checkin"=>"2026-04-01", "checkout"=>"2026-04-02", "amount"=>2500,  "payment"=>"Pending", "method"=>"UPI"],
    ["id"=>6, "name"=>"Chen",    "room"=>"Deluxe", "guests"=>2, "checkin"=>"2026-04-05", "checkout"=>"2026-04-08", "amount"=>22500, "payment"=>"Paid",    "method"=>"Card"],
];

// PHP: Compute stats
$totalBookings = count($bookings);
$paidCount     = count(array_filter($bookings, fn($b) => $b["payment"] === "Paid"));
$pendingCount  = count(array_filter($bookings, fn($b) => $b["payment"] === "Pending"));
$totalRevenue  = array_sum(array_column(array_filter($bookings, fn($b) => $b["payment"] === "Paid"), "amount"));

$year = date("Y");
$generatedAt = date("d M Y, h:i A");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Hotel Management System — Admin dashboard."/>
  <title>Hotel Management System — Admin Dashboard</title>
  <link rel="stylesheet" href="style.css"/>
  <style>
    .php-info-bar { background: rgba(0,0,0,0.8); color: #aaa; text-align: center; font-size: 11px; padding: 6px; }
    .php-info-bar span { color: #ff9800; font-weight: bold; }
    .php-badge { display: inline-block; background: linear-gradient(135deg,#ff512f,#dd2476); color:#fff; font-size:10px; font-weight:700; letter-spacing:1px; padding:2px 9px; border-radius:20px; margin-left:6px; vertical-align:middle; }
    .admin-wrap { padding: 30px 20px; }
    h2.admin-title { text-align: center; color: white; font-size: 26px; margin-bottom: 6px; }
    .php-note { text-align: center; color: rgba(255,255,255,0.4); font-size: 11px; margin-bottom: 20px; font-style: italic; }
    .admin-cards { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 24px; }
    .admin-card {
      background: linear-gradient(135deg, #ff512f, #dd2476);
      color: white; padding: 20px 25px; min-width: 150px;
      border-radius: 15px; text-align: center;
      box-shadow: 0 0 15px rgba(0,0,0,0.4); transition: 0.3s;
    }
    .admin-card:hover { transform: scale(1.05); }
    .admin-card.blue  { background: linear-gradient(135deg, #0077cc, #00c6fb); }
    .admin-card.green { background: linear-gradient(135deg, #28a745, #20c997); }
    .admin-card.amber { background: linear-gradient(135deg, #ff9800, #ff6600); }
    .admin-card .card-val   { font-size: 28px; font-weight: bold; }
    .admin-card .card-label { font-size: 12px; opacity: 0.9; margin-top: 4px; }
    /* Table overrides for admin */
    table { width: 95%; }
    tbody tr { transition: background 0.15s; }
    .paid    { color: #28a745; font-weight: bold; }
    .pending { color: #ff9800; font-weight: bold; }
  </style>
</head>
<body>

<div class="php-info-bar">
  ⚙️ PHP <span><?php echo phpversion(); ?></span>
  &nbsp;|&nbsp; Generated: <span><?php echo $generatedAt; ?></span>
  &nbsp;|&nbsp; <span><?php echo $totalBookings; ?></span> bookings + stats computed server-side
</div>

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

<div class="admin-wrap">
  <h2 class="admin-title">🖥 Admin Dashboard <span class="php-badge">PHP</span></h2>
  <p class="php-note">All stats &amp; table rows computed and rendered by PHP</p>

  <!-- PHP: Summary Cards -->
  <div class="admin-cards">
    <div class="admin-card">
      <div class="card-val"><?php echo $totalBookings; ?></div>
      <div class="card-label">Total Bookings</div>
    </div>
    <div class="admin-card green">
      <div class="card-val"><?php echo $paidCount; ?></div>
      <div class="card-label">Paid</div>
    </div>
    <div class="admin-card amber">
      <div class="card-val"><?php echo $pendingCount; ?></div>
      <div class="card-label">Pending</div>
    </div>
    <div class="admin-card blue">
      <div class="card-val">₹<?php echo number_format($totalRevenue); ?></div>
      <div class="card-label">Total Revenue</div>
    </div>
  </div>

  <!-- PHP: Bookings Table -->
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Guest Name</th>
        <th>Room Type</th>
        <th>Guests</th>
        <th>Check-In</th>
        <th>Check-Out</th>
        <th>Amount (₹)</th>
        <th>Method</th>
        <th>Payment</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bookings as $b): ?>
        <tr>
          <td><?php echo $b["id"]; ?></td>
          <td><b><?php echo htmlspecialchars($b["name"]); ?></b></td>
          <td><?php echo htmlspecialchars($b["room"]); ?></td>
          <td><?php echo $b["guests"]; ?></td>
          <td><?php echo date("d M Y", strtotime($b["checkin"])); ?></td>
          <td><?php echo date("d M Y", strtotime($b["checkout"])); ?></td>
          <td>₹<?php echo number_format($b["amount"]); ?></td>
          <td><?php echo htmlspecialchars($b["method"]); ?></td>
          <td class="<?php echo strtolower($b['payment']); ?>"><?php echo htmlspecialchars($b["payment"]); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div style="text-align:center; margin-top:20px;">
    <button class="btn" onclick="window.location.href='index.php'" style="width:auto; padding:10px 30px;">Back to Home</button>
  </div>
</div>

<div class="footer">&copy; <?php echo $year; ?> Hotel Management System — Built with PHP <?php echo phpversion(); ?></div>
</body>
</html>
