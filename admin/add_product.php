<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include('../includes/db_connect.php');

if (!isset($_SESSION['admin_id'])) {
  header("Location: admin_login.php");
  exit;
}

$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $category = $_POST['category'];
  $stock = $_POST['stock'];
  $image_url = $_POST['image_url'];

  // Insert product
  $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, stock, image_url) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssdsss", $name, $description, $price, $category, $stock, $image_url);
  
  if ($stmt->execute()) {
    $success_message = "Product added successfully!";
  } else {
    $error_message = "Error adding product: " . $stmt->error;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="mb-0"><i class="fas fa-plus"></i> Add New Product</h3>
        </div>
        <div class="card-body">
          <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
          <?php endif; ?>
          
          <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
          <?php endif; ?>
          
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Product Name:</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            
            <div class="mb-3">
              <label class="form-label">Description:</label>
              <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Price ($):</label>
                  <input type="number" step="0.01" name="price" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Stock Quantity:</label>
                  <input type="number" name="stock" class="form-control" required>
                </div>
              </div>
            </div>
            
            <div class="mb-3">
              <label class="form-label">Category:</label>
              <select name="category" class="form-control" required>
                <option value="">Select Category</option>
                <option value="Laptops">Laptops</option>
                <option value="Desktops">Desktops</option>
                <option value="Accessories">Accessories</option>
                <option value="Monitors">Monitors</option>
                <option value="Storage">Storage</option>
                <option value="Furniture">Furniture</option>
              </select>
            </div>
            
            <div class="mb-3">
              <label class="form-label">Image URL:</label>
              <input type="url" name="image_url" class="form-control" placeholder="https://example.com/image.jpg" required>
              <small class="text-muted">Enter a valid image URL (e.g., Unsplash link)</small>
            </div>
            
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Add Product
              </button>
              <a href="dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
