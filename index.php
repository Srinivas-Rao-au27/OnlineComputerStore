<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Computer Store</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

<main>
  <div class="hero-section">
    <div class="container">
      <h1>Buy All Your Computer Needs At One Place</h1>
      <p class="lead">Discover the latest computers, laptops, accessories, and more. Quality products at competitive prices.</p>
      <a href="products.php" class="btn btn-light btn-lg">Shop Now</a>
    </div>
  </div>

  <div class="container my-5">
    <div class="row">
      <div class="col-md-4">
        <div class="feature-card">
          <i class="fas fa-laptop"></i>
          <h3>Quality Products</h3>
          <p>Premium computers and accessories from top brands</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card">
          <i class="fas fa-shipping-fast"></i>
          <h3>Fast Delivery</h3>
          <p>Quick and reliable shipping to your doorstep</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card">
          <i class="fas fa-headset"></i>
          <h3>24/7 Support</h3>
          <p>Expert customer support whenever you need help</p>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
