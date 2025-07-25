<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include('../includes/db_connect.php');

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit;
}

$sql = "SELECT o.id, u.name, o.total_price, o.order_date
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>All Orders</h2>
  <table class="table table-bordered">
    <thead>
      <tr><th>Order ID</th><th>Customer</th><th>Total</th><th>Date</th></tr>
    </thead>
    <tbody>
      <?php while ($order = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $order['id'] ?></td>
        <td><?= $order['name'] ?></td>
        <td>$<?= number_format($order['total_price'], 2) ?></td>
        <td><?= $order['order_date'] ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
