<?php
include('includes/header.php');
include('includes/db_connect.php');

// Redirect non-logged-in users to login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Handle Add to Cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
  $product_id = (int)$_POST['product_id'];
  $quantity = (int)$_POST['quantity'];

  // Check if item already exists in cart
  $check_stmt = $conn->prepare("SELECT quantity FROM user_cart WHERE user_id = ? AND product_id = ?");
  $check_stmt->bind_param("ii", $user_id, $product_id);
  $check_stmt->execute();
  $check_result = $check_stmt->get_result();

  if ($check_result->num_rows > 0) {
    // Update existing item
    $current_item = $check_result->fetch_assoc();
    $new_quantity = $current_item['quantity'] + $quantity;
    $update_stmt = $conn->prepare("UPDATE user_cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $update_stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
    $update_stmt->execute();
  } else {
    // Add new item
    $insert_stmt = $conn->prepare("INSERT INTO user_cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $insert_stmt->execute();
  }

  header("Location: cart.php");
  exit;
}

// Handle Update Quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
  $product_id = (int)$_POST['product_id'];
  $new_quantity = (int)$_POST['quantity'];
  
  if ($new_quantity <= 0) {
    // Remove item if quantity is 0 or less
    $delete_stmt = $conn->prepare("DELETE FROM user_cart WHERE user_id = ? AND product_id = ?");
    $delete_stmt->bind_param("ii", $user_id, $product_id);
    $delete_stmt->execute();
  } else {
    // Update quantity
    $update_stmt = $conn->prepare("UPDATE user_cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $update_stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
    $update_stmt->execute();
  }
  
  header("Location: cart.php");
  exit;
}

// Handle Remove from Cart
if (isset($_GET['remove'])) {
  $remove_id = (int)$_GET['remove'];
  $delete_stmt = $conn->prepare("DELETE FROM user_cart WHERE user_id = ? AND product_id = ?");
  $delete_stmt->bind_param("ii", $user_id, $remove_id);
  $delete_stmt->execute();
  header("Location: cart.php");
  exit;
}

// Get cart items from DB
$cart_items = [];
$total = 0;
$item_count = 0;

$cart_query = "SELECT p.*, uc.quantity FROM products p 
               INNER JOIN user_cart uc ON p.id = uc.product_id 
               WHERE uc.user_id = ?";
$cart_stmt = $conn->prepare($cart_query);
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

while ($item = $cart_result->fetch_assoc()) {
  $item['subtotal'] = $item['price'] * $item['quantity'];
  $cart_items[] = $item;
  $total += $item['subtotal'];
  $item_count += $item['quantity'];
}
?>

<main>
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-8">
        <h2 class="mb-4">
          <i class="fas fa-shopping-cart"></i> Your Shopping Cart
          <?php if ($item_count > 0): ?>
            <span class="badge bg-primary ms-2"><?php echo $item_count; ?> items</span>
          <?php endif; ?>
        </h2>

        <?php if (empty($cart_items)): ?>
          <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Your cart is empty</h4>
            <p class="text-muted">Start shopping to add items to your cart</p>
            <a href="products.php" class="btn btn-primary">Browse Products</a>
          </div>
        <?php else: ?>
          <div class="card">
            <div class="card-body">
              <?php foreach ($cart_items as $item): ?>
                <div class="row align-items-center border-bottom py-3">
                  <div class="col-md-2">
                    <img src="<?php echo $item['image_url']; ?>" class="img-fluid rounded" alt="<?php echo $item['name']; ?>" style="max-height: 80px; object-fit: contain;">
                  </div>
                  <div class="col-md-4">
                    <h6 class="mb-1"><?php echo $item['name']; ?></h6>
                    <small class="text-muted"><?php echo $item['category']; ?></small>
                  </div>
                  <div class="col-md-2">
                    <span class="fw-bold">$<?php echo number_format($item['price'], 2); ?></span>
                  </div>
                  <div class="col-md-2">
                    <form action="cart.php" method="POST" class="d-flex align-items-center">
                      <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                      <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="99" class="form-control form-control-sm" style="width: 60px;">
                      <button type="submit" name="update_quantity" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-sync-alt"></i>
                      </button>
                    </form>
                  </div>
                  <div class="col-md-2">
                    <span class="fw-bold text-primary">$<?php echo number_format($item['subtotal'], 2); ?></span>
                  </div>
                  <div class="col-md-1">
                    <a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this item?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
      
      <?php if (!empty($cart_items)): ?>
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal (<?php echo $item_count; ?> items):</span>
                <span>$<?php echo number_format($total, 2); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Shipping:</span>
                <span class="text-success">FREE</span>
              </div>
              <hr>
              <div class="d-flex justify-content-between mb-3">
                <strong>Total:</strong>
                <strong class="text-primary">$<?php echo number_format($total, 2); ?></strong>
              </div>
              <a href="checkout.php" class="btn btn-success w-100 mb-2">
                <i class="fas fa-credit-card"></i> Proceed to Checkout
              </a>
              <a href="products.php" class="btn btn-outline-primary w-100">
                <i class="fas fa-shopping-bag"></i> Continue Shopping
              </a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php include('includes/footer.php'); ?>
