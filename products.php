<?php 
include('includes/header.php'); 
include('includes/db_connect.php'); 

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<main>
  <div class="container mt-4">
    <h2 class="mb-4 text-center">All Products</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">

      <?php while($row = $result->fetch_assoc()): ?>
        <div class="col">
          <div class="card h-100">
            <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>" style="max-height: 200px; object-fit: contain;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?php echo $row['name']; ?></h5>
              <p class="card-text text-muted"><?php echo $row['category']; ?></p>
              <p class="card-text"><?php echo substr($row['description'], 0, 100); ?>...</p>
              <div class="mt-auto">
                <h6 class="text-primary mb-3">$<?php echo number_format($row['price'], 2); ?></h6>
                <div class="d-flex gap-2">
                  <a href="product.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                  <form action="cart.php" method="POST" style="display: inline;">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="btn btn-success btn-sm">Add to Cart</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>

    </div>
  </div>
</main>

<?php include('includes/footer.php'); ?>
