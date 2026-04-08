<?php
// =============================================
// HOTEL MANAGEMENT SYSTEM — feedback.php
// =============================================

$message = "";
$msgType = "";
$success = false;

// PHP: Handle feedback form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars(trim($_POST["name"]    ?? ""));
    $rating  = (int)($_POST["rating"] ?? 0);
    $comment = htmlspecialchars(trim($_POST["comment"] ?? ""));

    if (empty($name)) {
        $msgType = "error";
        $message = "❌ Please enter your name.";
    } elseif ($rating < 1 || $rating > 5) {
        $msgType = "error";
        $message = "❌ Please select a valid rating (1–5).";
    } elseif (empty($comment)) {
        $msgType = "error";
        $message = "❌ Please write a comment.";
    } else {
        $success = true;
        $msgType = "success";
        $message = "✅ Thank you, <strong>" . $name . "</strong>! Your feedback has been submitted.";
    }
}

// PHP: Star emoji helper
function renderStars(int $rating): string {
    return str_repeat("⭐", $rating) . str_repeat("☆", 5 - $rating);
}

$year = date("Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Hotel Management System — Submit your feedback."/>
  <title>Hotel Management System — Feedback</title>
  <link rel="stylesheet" href="style.css"/>
  <style>
    .php-info-bar { background: rgba(0,0,0,0.8); color: #aaa; text-align: center; font-size: 11px; padding: 6px; }
    .php-info-bar span { color: #ff9800; font-weight: bold; }
    .php-badge { display: inline-block; background: linear-gradient(135deg,#ff512f,#dd2476); color:#fff; font-size:10px; font-weight:700; letter-spacing:1px; padding:2px 9px; border-radius:20px; margin-left:6px; vertical-align:middle; }
    .msg { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; text-align: center; font-weight: bold; }
    .msg.error   { background: rgba(220,53,69,0.25); border: 1px solid #dc3545; color: #ffaaaa; }
    .msg.success { background: rgba(40,167,69,0.25); border: 1px solid #28a745; color: #aaffaa; }
    .success-box { text-align: center; padding: 10px 0 20px; }
    .success-box .stars { font-size: 28px; margin: 10px 0; }
    .success-box p { color: #ddd; font-size: 14px; margin-top: 6px; }
    .success-box .comment-preview {
      background: rgba(255,255,255,0.1);
      border-radius: 10px;
      padding: 12px 16px;
      margin-top: 14px;
      color: #eee;
      font-style: italic;
      font-size: 14px;
      text-align: left;
    }
  </style>
</head>
<body>

<div class="php-info-bar">
  ⚙️ PHP <span><?php echo phpversion(); ?></span>
  &nbsp;|&nbsp; Feedback validated &amp; processed server-side via <span>$_POST</span>
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

<div class="container auth-box" style="max-width:420px;">
  <h2 class="page-title">💬 Feedback <span class="php-badge">PHP</span></h2>

  <?php if (!empty($message)): ?>
    <div class="msg <?php echo $msgType; ?>"><?php echo $message; ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <!-- PHP: Show feedback summary after submission -->
    <div class="success-box">
      <div class="stars"><?php echo renderStars((int)$_POST["rating"]); ?></div>
      <p>Rating: <strong><?php echo (int)$_POST["rating"]; ?> / 5</strong></p>
      <p>Submitted at: <strong><?php echo date("h:i A, d M Y"); ?></strong></p>
      <div class="comment-preview">"<?php echo htmlspecialchars($_POST["comment"]); ?>"</div>
      <a href="feedback.php"><button class="btn" style="margin-top:14px;">Submit Another</button></a>
    </div>

  <?php else: ?>
    <form method="POST" action="">
      <div class="form-section">
        <label>Your Name</label>
        <input type="text" name="name" id="fb-name" placeholder="Enter your name"
               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required/>

        <label>Rating</label>
        <select name="rating" id="fb-rating">
          <?php for ($i = 5; $i >= 1; $i--): ?>
            <option value="<?php echo $i; ?>" <?php echo (($_POST['rating'] ?? '') == $i) ? 'selected' : ''; ?>>
              <?php echo $i; ?> Star<?php echo $i > 1 ? 's' : ''; ?> <?php echo renderStars($i); ?>
            </option>
          <?php endfor; ?>
        </select>

        <label>Comment</label>
        <textarea name="comment" id="fb-comment" rows="5" placeholder="Share your experience..."><?php echo htmlspecialchars($_POST['comment'] ?? ''); ?></textarea>
      </div>

      <input type="submit" value="Submit Feedback"/>
    </form>
  <?php endif; ?>

  <button class="btn" onclick="window.location.href='index.php'" style="margin-top:10px;">Back to Home</button>
</div>

<div class="footer">&copy; <?php echo $year; ?> Hotel Management System</div>
</body>
</html>
