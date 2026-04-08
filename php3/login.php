<?php
// =============================================
// HOTEL MANAGEMENT SYSTEM — login.php
// =============================================

// Hardcoded demo credentials
$users = [
    ["username" => "admin",  "password" => "admin123",  "role" => "Admin"],
    ["username" => "john",   "password" => "pass123",   "role" => "User"],
    ["username" => "ridwan", "password" => "ridwan123", "role" => "User"],
];

$message   = "";
$msgType   = "";
$loggedIn  = false;
$loginUser = "";
$loginRole = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(trim($_POST["username"] ?? ""));
    $password = trim($_POST["password"] ?? "");
    $role     = htmlspecialchars(trim($_POST["role"] ?? ""));

    $found = false;
    foreach ($users as $u) {
        if ($u["username"] === $username && $u["password"] === $password && $u["role"] === $role) {
            $found     = true;
            $loggedIn  = true;
            $loginUser = $u["username"];
            $loginRole = $u["role"];
            break;
        }
    }
    if (!$found) {
        $msgType = "error";
        $message = "❌ Invalid username, password, or role. Please try again.";
    }
}

$year = date("Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Hotel Management System — Login page."/>
  <title>Hotel Management System — Login</title>
  <link rel="stylesheet" href="style.css"/>
  <style>
    .php-info-bar { background: rgba(0,0,0,0.8); color: #aaa; text-align: center; font-size: 11px; padding: 6px; }
    .php-info-bar span { color: #ff9800; font-weight: bold; }
    .php-badge { display: inline-block; background: linear-gradient(135deg,#ff512f,#dd2476); color:#fff; font-size:10px; font-weight:700; letter-spacing:1px; padding:2px 9px; border-radius:20px; margin-left:6px; vertical-align:middle; }
    .msg { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; text-align: center; font-weight: bold; }
    .msg.error   { background: rgba(220,53,69,0.25); border: 1px solid #dc3545; color: #ffaaaa; }
    .msg.success { background: rgba(40,167,69,0.25); border: 1px solid #28a745; color: #aaffaa; }
    .success-box { text-align: center; padding: 20px; }
    .success-box h3 { font-size: 22px; margin-bottom: 10px; color: #aaffaa; }
    .success-box p  { color: #ddd; margin-bottom: 6px; }
    .demo-hint { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 12px; text-align: center; font-style: italic; }
  </style>
</head>
<body>

<div class="php-info-bar">
  ⚙️ PHP <span><?php echo phpversion(); ?></span>
  &nbsp;|&nbsp; Login form processed server-side via <span>$_POST</span>
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

<div class="container auth-box">
  <h2 class="page-title">🔐 Login <span class="php-badge">PHP</span></h2>

  <?php if ($loggedIn): ?>
    <!-- ✅ PHP: Show success if logged in -->
    <div class="msg success">✅ Welcome back, <strong><?php echo htmlspecialchars($loginUser); ?></strong>!</div>
    <div class="success-box">
      <h3>Login Successful 🎉</h3>
      <p>Role: <strong><?php echo htmlspecialchars($loginRole); ?></strong></p>
      <p>Logged in at: <strong><?php echo date("h:i A"); ?></strong></p>
      <?php if ($loginRole === "Admin"): ?>
        <a href="admin.php"><button class="btn" style="margin-top:14px;">Go to Admin Dashboard</button></a>
      <?php else: ?>
        <a href="book.php"><button class="btn" style="margin-top:14px;">Book a Room</button></a>
      <?php endif; ?>
    </div>

  <?php else: ?>
    <!-- ❌ PHP: Show error message if any -->
    <?php if (!empty($message)): ?>
      <div class="msg <?php echo $msgType; ?>"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Login Form — posted to itself via PHP -->
    <form method="POST" action="">
      <div class="form-section">
        <label>Username</label>
        <input type="text" name="username" id="username" placeholder="Enter username"
               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required/>

        <label>Password</label>
        <input type="password" name="password" id="password" placeholder="Enter password" required/>

        <label>Role</label>
        <select name="role" id="role">
          <option value="User"  <?php echo (($_POST['role'] ?? '') === 'User')  ? 'selected' : ''; ?>>User</option>
          <option value="Admin" <?php echo (($_POST['role'] ?? '') === 'Admin') ? 'selected' : ''; ?>>Admin</option>
        </select>
      </div>

      <input type="submit" value="Login"/>
    </form>

    <p class="demo-hint">Demo: username=<b>admin</b> | password=<b>admin123</b> | role=<b>Admin</b></p>
  <?php endif; ?>

  <button class="btn" onclick="window.location.href='index.php'" style="margin-top:10px;">Back to Home</button>
</div>

<div class="footer">&copy; <?php echo date("Y"); ?> Hotel Management System</div>
</body>
</html>
