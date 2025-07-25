<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include('../includes/db_connect.php');

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit;
}

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Manage Products</h2>
  <a href="add_product.php" class="btn btn-success mb-3">➕ Add New Product</a>

  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price ($)</th>
        <th>Stock</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['name'] ?></td>
          <td><?= number_format($row['price'], 2) ?></td>
          <td><?= $row['stock'] ?></td>
          <td><?= $row['category'] ?></td>
          <td>
            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
            <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?');">🗑️ Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
