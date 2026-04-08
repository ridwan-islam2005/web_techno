<?php
// =============================================
// HOTEL MANAGEMENT SYSTEM — register.php
// =============================================

$message = "";
$msgType = "";
$success = false;

// PHP: Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = htmlspecialchars(trim($_POST["name"]     ?? ""));
    $email    = htmlspecialchars(trim($_POST["email"]    ?? ""));
    $phone    = htmlspecialchars(trim($_POST["phone"]    ?? ""));
    $username = htmlspecialchars(trim($_POST["username"] ?? ""));
    $password = trim($_POST["password"] ?? "");
    $confirm  = trim($_POST["confirm"]  ?? "");

    // PHP: Validation
    if (empty($name) || empty($email) || empty($phone) || empty($username) || empty($password)) {
        $msgType = "error";
        $message = "❌ All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msgType = "error";
        $message = "❌ Please enter a valid email address.";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $msgType = "error";
        $message = "❌ Phone number must be exactly 10 digits.";
    } elseif (strlen($password) < 6) {
        $msgType = "error";
        $message = "❌ Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $msgType = "error";
        $message = "❌ Passwords do not match.";
    } else {
        $success = true;
        $message = "✅ Registration successful! Welcome, <strong>" . $name . "</strong>!";
        $msgType = "success";
    }
}

$year = date("Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Hotel Management System — Register a new account."/>
  <title>Hotel Management System — Register</title>
  <link rel="stylesheet" href="style.css"/>
  <style>
    .php-info-bar { background: rgba(0,0,0,0.8); color: #aaa; text-align: center; font-size: 11px; padding: 6px; }
    .php-info-bar span { color: #ff9800; font-weight: bold; }
    .php-badge { display: inline-block; background: linear-gradient(135deg,#ff512f,#dd2476); color:#fff; font-size:10px; font-weight:700; letter-spacing:1px; padding:2px 9px; border-radius:20px; margin-left:6px; vertical-align:middle; }
    .msg { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; text-align: center; font-weight: bold; }
    .msg.error   { background: rgba(220,53,69,0.25); border: 1px solid #dc3545; color: #ffaaaa; }
    .msg.success { background: rgba(40,167,69,0.25); border: 1px solid #28a745; color: #aaffaa; }
    .success-box { text-align: center; padding: 10px 0 20px; }
    .success-box h3 { font-size: 22px; color: #aaffaa; margin-bottom: 10px; }
    .success-box p  { color: #ddd; }
    .php-note { font-size: 10px; color: rgba(255,255,255,0.35); text-align: center; margin-top: -8px; margin-bottom: 12px; font-style: italic; }
  </style>
</head>
<body>

<div class="php-info-bar">
  ⚙️ PHP <span><?php echo phpversion(); ?></span>
  &nbsp;|&nbsp; Registration validated server-side via <span>$_POST</span>
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

<div class="container auth-box" style="max-width:440px;">
  <h2 class="page-title">📝 Register <span class="php-badge">PHP</span></h2>
  <p class="php-note">Server-side validation with PHP</p>

  <!-- PHP: Output message if form was submitted -->
  <?php if (!empty($message)): ?>
    <div class="msg <?php echo $msgType; ?>"><?php echo $message; ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="success-box">
      <h3>Account Created 🎉</h3>
      <p>Registered at: <strong><?php echo date("h:i A, d M Y"); ?></strong></p>
      <a href="login.php"><button class="btn" style="margin-top:14px;">Go to Login</button></a>
    </div>
  <?php else: ?>
    <!-- Registration Form -->
    <form method="POST" action="">
      <div class="form-section">
        <label>Full Name</label>
        <input type="text" name="name" id="name" placeholder="Enter your full name"
               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required/>

        <label>Email</label>
        <input type="email" name="email" id="email" placeholder="Enter your email"
               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required/>

        <label>Phone Number</label>
        <input type="text" name="phone" id="phone" placeholder="10-digit phone number"
               value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required/>

        <label>Username</label>
        <input type="text" name="username" id="reg-username" placeholder="Choose a username"
               value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required/>

        <label>Password</label>
        <input type="password" name="password" id="reg-password" placeholder="Min 6 characters" required/>

        <label>Confirm Password</label>
        <input type="password" name="confirm" id="reg-confirm" placeholder="Re-enter password" required/>
      </div>

      <input type="submit" value="Register"/>
    </form>
  <?php endif; ?>

  <button class="btn" onclick="window.location.href='index.php'" style="margin-top:10px;">Back to Home</button>
</div>

<div class="footer">&copy; <?php echo $year; ?> Hotel Management System</div>
</body>
</html>
