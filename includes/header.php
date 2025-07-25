<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Online Computer Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">CompuStore</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
          
          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link cart-badge" href="cart.php">
                Cart
                <?php 
                if (isset($_SESSION['user_id'])) {
                  include('includes/db_connect.php');
                  $user_id = $_SESSION['user_id'];
                  $cart_count_query = "SELECT SUM(quantity) as total FROM user_cart WHERE user_id = ?";
                  $cart_count_stmt = $conn->prepare($cart_count_query);
                  $cart_count_stmt->bind_param("i", $user_id);
                  $cart_count_stmt->execute();
                  $cart_count_result = $cart_count_stmt->get_result();
                  $cart_count = $cart_count_result->fetch_assoc()['total'];
                  
                  if ($cart_count > 0): ?>
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                  <?php endif;
                  $conn->close();
                }
                ?>
              </a>
            </li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="admin/admin_login.php">Admin</a></li>
        </ul>
      </div>
    </div>
  </nav>
