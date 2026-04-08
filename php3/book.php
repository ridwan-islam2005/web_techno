<?php
// =============================================
// HOTEL MANAGEMENT SYSTEM — book.php
// =============================================

// PHP: Room pricing data
$roomPrices = [
    "Single" => 2500,
    "Double" => 4000,
    "Deluxe" => 7500,
    "Suite"  => 12000,
];

$message = "";
$msgType = "";
$success = false;
$summary = [];

// PHP: Handle booking form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $roomType      = htmlspecialchars(trim($_POST["room_type"]   ?? ""));
    $guests        = (int)($_POST["guests"] ?? 0);
    $checkin       = htmlspecialchars(trim($_POST["checkin"]     ?? ""));
    $checkout      = htmlspecialchars(trim($_POST["checkout"]    ?? ""));
    $payMethod     = htmlspecialchars(trim($_POST["pay_method"]  ?? ""));
    $payStatus     = htmlspecialchars(trim($_POST["pay_status"]  ?? ""));
    $staffName     = htmlspecialchars(trim($_POST["staff_name"]  ?? ""));
    $staffRole     = htmlspecialchars(trim($_POST["staff_role"]  ?? ""));
    $staffPhone    = htmlspecialchars(trim($_POST["staff_phone"] ?? ""));

    // PHP: Validation
    if (empty($roomType) || $guests < 1 || empty($checkin) || empty($checkout)) {
        $msgType = "error";
        $message = "❌ Please fill in all required fields.";
    } elseif (strtotime($checkout) <= strtotime($checkin)) {
        $msgType = "error";
        $message = "❌ Check-out date must be after check-in date.";
    } else {
        // PHP: Compute nights & total amount
        $nights = (int)((strtotime($checkout) - strtotime($checkin)) / 86400);
        $pricePerNight = $roomPrices[$roomType] ?? 0;
        $totalAmount   = $nights * $pricePerNight;

        $success = true;
        $msgType = "success";
        $message = "✅ Room booked successfully!";
        $summary = [
            "Room Type"      => $roomType,
            "Guests"         => $guests,
            "Check-In"       => date("d M Y", strtotime($checkin)),
            "Check-Out"      => date("d M Y", strtotime($checkout)),
            "Nights"         => $nights,
            "Price/Night"    => "₹" . number_format($pricePerNight),
            "Total Amount"   => "₹" . number_format($totalAmount),
            "Payment Method" => $payMethod,
            "Payment Status" => $payStatus,
        ];
        if (!empty($staffName)) {
            $summary["Staff Name"] = $staffName;
            $summary["Staff Role"] = $staffRole;
        }
    }
}

$year = date("Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Hotel Management System — Book a room online."/>
  <title>Hotel Management System — Book Room</title>
  <link rel="stylesheet" href="style.css"/>
  <style>
    .php-info-bar { background: rgba(0,0,0,0.8); color: #aaa; text-align: center; font-size: 11px; padding: 6px; }
    .php-info-bar span { color: #ff9800; font-weight: bold; }
    .php-badge { display: inline-block; background: linear-gradient(135deg,#ff512f,#dd2476); color:#fff; font-size:10px; font-weight:700; letter-spacing:1px; padding:2px 9px; border-radius:20px; margin-left:6px; vertical-align:middle; }
    .msg { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; text-align: center; font-weight: bold; }
    .msg.error   { background: rgba(220,53,69,0.25); border: 1px solid #dc3545; color: #ffaaaa; }
    .msg.success { background: rgba(40,167,69,0.25); border: 1px solid #28a745; color: #aaffaa; }
    .summary-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .summary-table td { padding: 9px 14px; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 14px; }
    .summary-table td:first-child { color: #ffcc80; font-weight: bold; width: 45%; }
    .room-price-hint { font-size: 11px; color: rgba(255,255,255,0.45); margin-top: -10px; margin-bottom: 12px; font-style: italic; }
    .booking-container { width: 90%; max-width: 500px; }
  </style>
</head>
<body>

<div class="php-info-bar">
  ⚙️ PHP <span><?php echo phpversion(); ?></span>
  &nbsp;|&nbsp; Booking + price calculation done server-side via <span>$_POST</span>
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

<div class="container booking-container">
  <h2 class="page-title">🛏 Book a Room <span class="php-badge">PHP</span></h2>

  <?php if (!empty($message)): ?>
    <div class="msg <?php echo $msgType; ?>"><?php echo $message; ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <!-- PHP: Booking Summary -->
    <table class="summary-table">
      <?php foreach ($summary as $key => $val): ?>
        <tr>
          <td><?php echo htmlspecialchars($key); ?></td>
          <td><?php echo htmlspecialchars($val); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <a href="book.php"><button class="btn" style="margin-top:18px;">Book Another Room</button></a>

  <?php else: ?>
    <form method="POST" action="">

      <div class="form-section booking-section">
        <h3>Room Details</h3>
        <label>Room Type</label>
        <!-- PHP: Room types from array -->
        <select name="room_type" id="room_type">
          <?php foreach ($roomPrices as $type => $price): ?>
            <option value="<?php echo $type; ?>" <?php echo (($_POST['room_type'] ?? '') === $type) ? 'selected' : ''; ?>>
              <?php echo $type; ?> — ₹<?php echo number_format($price); ?>/night
            </option>
          <?php endforeach; ?>
        </select>
        <p class="room-price-hint">💡 Prices computed by PHP from room data array</p>

        <label>Number of Guests</label>
        <input type="number" name="guests" id="guests" min="1" max="10" placeholder="e.g. 2"
               value="<?php echo htmlspecialchars($_POST['guests'] ?? ''); ?>" required/>

        <label>Check-in Date</label>
        <input type="date" name="checkin" id="checkin"
               value="<?php echo htmlspecialchars($_POST['checkin'] ?? ''); ?>" required/>

        <label>Check-out Date</label>
        <input type="date" name="checkout" id="checkout"
               value="<?php echo htmlspecialchars($_POST['checkout'] ?? ''); ?>" required/>
      </div>

      <div class="form-section booking-section">
        <h3>Payment Details</h3>
        <label>Payment Method</label>
        <select name="pay_method" id="pay_method">
          <?php foreach (["Cash", "UPI", "Card", "Net Banking"] as $m): ?>
            <option value="<?php echo $m; ?>" <?php echo (($_POST['pay_method'] ?? '') === $m) ? 'selected' : ''; ?>><?php echo $m; ?></option>
          <?php endforeach; ?>
        </select>

        <label>Payment Status</label>
        <select name="pay_status" id="pay_status">
          <option value="Paid"    <?php echo (($_POST['pay_status'] ?? '') === 'Paid')    ? 'selected' : ''; ?>>Paid</option>
          <option value="Pending" <?php echo (($_POST['pay_status'] ?? '') === 'Pending') ? 'selected' : ''; ?>>Pending</option>
        </select>
      </div>

      <div class="form-section booking-section">
        <h3>Staff (Optional)</h3>
        <label>Staff Name</label>
        <input type="text" name="staff_name" id="staff_name" placeholder="Staff assigned"
               value="<?php echo htmlspecialchars($_POST['staff_name'] ?? ''); ?>"/>

        <label>Role</label>
        <input type="text" name="staff_role" id="staff_role" placeholder="e.g. Concierge"
               value="<?php echo htmlspecialchars($_POST['staff_role'] ?? ''); ?>"/>

        <label>Phone Number</label>
        <input type="text" name="staff_phone" id="staff_phone" placeholder="Staff phone"
               value="<?php echo htmlspecialchars($_POST['staff_phone'] ?? ''); ?>"/>
      </div>

      <input type="submit" value="Book Room"/>
    </form>
  <?php endif; ?>

  <button class="btn" onclick="window.location.href='index.php'" style="margin-top:10px;">Back to Home</button>
</div>

<div class="footer">&copy; <?php echo $year; ?> Hotel Management System</div>
</body>
</html>
