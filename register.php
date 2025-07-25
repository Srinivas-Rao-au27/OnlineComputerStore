<?php include('includes/header.php'); ?>

<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];

  if ($password !== $confirm) {
    $error = "Passwords do not match.";
  } else {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed);

    if ($stmt->execute()) {
      $_SESSION['user_id'] = $stmt->insert_id;
      $_SESSION['is_admin'] = 0;
      header("Location: index.php");
      exit;
    } else {
      $error = "Registration failed. Email might already exist.";
    }
  }
}
?>

<main>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="text-center mb-4">Register</h2>
        
        <?php if (isset($error)): ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="register.php" method="POST">
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
          </div>

          <div class="d-grid">
            <button type="submit" name="register" class="btn btn-success">Register</button>
          </div>

          <p class="mt-3 text-center">
            Already have an account? <a href="login.php">Login here</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</main>

<?php include('includes/footer.php'); ?>
