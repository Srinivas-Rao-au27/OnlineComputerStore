<?php
include('includes/header.php');
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['is_admin'] = $user['is_admin'];
      header("Location: index.php");
      exit;
    } else {
      $error = "Incorrect password.";
    }
  } else {
    $error = "User not found.";
  }
}
?>

<main>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="text-center mb-4">Login</h2>
        
        <?php if (isset($error)): ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          
          <div class="d-grid">
            <button type="submit" name="login" class="btn btn-dark w-100">Login</button>
          </div>

          <p class="mt-3 text-center">
            Don't have an account? <a href="register.php">Register here</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</main>

<?php include('includes/footer.php'); ?>
