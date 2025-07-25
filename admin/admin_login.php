<?php
ob_start();
session_start();

require_once('../includes/db_connect.php');

$adminEmail = 'admin@example.com';
$adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
$conn->query("INSERT IGNORE INTO users (email, password, is_admin) VALUES ('$adminEmail', '$adminPassword', 1)");


$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  if (!empty($email) && !empty($password)) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND is_admin = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin) {
      if (password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit;
      } else {
        $error = "Incorrect password.";
      }
    } else {
      $error = "Admin user not found.";
    }
  } else {
    $error = "Please fill in all fields.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="text-center">Admin Login</h2>
    <form method="POST" class="mx-auto" style="max-width: 400px;">
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <button type="submit" name="login" class="btn btn-dark w-100">Login</button>
    </form>
  </div>
</body>
</html>

<?php ob_end_flush(); ?>
