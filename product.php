<?php 
include('includes/header.php'); 
include('includes/db_connect.php'); 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<div class='container mt-5'><h4>Invalid product ID.</h4></div>";
  include('includes/footer.php');
  exit;
}

$product_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 1) {
  echo "<div class='container mt-5'><h4>Product not found.</h4></div>";
  include('includes/footer.php');
  exit;
}

// Get all images for the product
$image_stmt = $conn->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
$image_stmt->bind_param("i", $product_id);
$image_stmt->execute();
$image_result = $image_stmt->get_result();

$images = [];
while ($img = $image_result->fetch_assoc()) {
  $images[] = $img['image_path'];
}

$product = $result->fetch_assoc();
?>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-6">
      <div class="col-md-6">
        <?php if (count($images) > 0): ?>
          <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php foreach ($images as $index => $img): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                  <img src="<?php echo $img; ?>" class="d-block w-100" alt="Product Image" style="max-height: 400px; object-fit: contain;">
                </div>
              <?php endforeach; ?>
            </div>
            <?php if (count($images) > 1): ?>
              <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </button>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <img src="images/default.jpg" class="img-fluid" alt="No Image Available">
        <?php endif; ?>
      </div>

    </div>
    <div class="col-md-6">
      <h2><?php echo $product['name']; ?></h2>
      <h4 class="text-success">$<?php echo number_format($product['price'], 2); ?></h4>
      <p><?php echo $product['description']; ?></p>
      <p><strong>Category:</strong> <?php echo ucfirst($product['category']); ?></p>
      <p><strong>Stock:</strong> <?php echo $product['stock']; ?></p>
      
      <form action="cart.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" class="form-control w-25 mb-3">
        <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
      </form>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
