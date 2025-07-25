<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include('../includes/db_connect.php');

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Welcome to Admin Dashboard</h2>

  <div class="list-group">
    <a href="manage_products.php" class="list-group-item list-group-item-action">📦 Manage Products</a>
    <a href="add_product.php" class="list-group-item list-group-item-action">➕ Add New Product</a>
    <a href="view_orders.php" class="list-group-item list-group-item-action">📄 View Orders</a>
    <a href="../logout.php" class="list-group-item list-group-item-action text-danger">🚪 Logout</a>
  </div>
</div>
</body>
</html>
