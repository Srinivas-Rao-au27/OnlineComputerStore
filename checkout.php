<?php
include('includes/header.php');
include('includes/db_connect.php');

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

// Get cart items and total
$cart_query = "SELECT p.*, uc.quantity FROM products p INNER JOIN user_cart uc ON p.id = uc.product_id WHERE uc.user_id = ?";
$cart_stmt = $conn->prepare($cart_query);
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

$cart_items = [];
$total = 0;
$item_count = 0;

while ($item = $cart_result->fetch_assoc()) {
  $item['subtotal'] = $item['price'] * $item['quantity'];
  $cart_items[] = $item;
  $total += $item['subtotal'];
  $item_count += $item['quantity'];
}

$shipping_fee = ($total < 2000 && $item_count > 0) ? 49.99 : 0;
$final_total = $total + $shipping_fee;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
  echo '<script>setTimeout(function(){ document.getElementById("payment-loader").style.display = "none"; document.getElementById("payment-success").style.display = "block"; }, 2500);</script>';
}
?>

<main>
  <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="mb-4">Checkout & Payment</h2>
        <div class="card mb-4">
          <div class="card-body">
            <h5>Order Summary</h5>
            <ul class="list-group mb-3">
              <?php foreach ($cart_items as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><?php echo $item['name']; ?> <span class="badge bg-secondary ms-2">x<?php echo $item['quantity']; ?></span></span>
                  <span>$<?php echo number_format($item['subtotal'], 2); ?></span>
                </li>
              <?php endforeach; ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Subtotal</span>
                <span>$<?php echo number_format($total, 2); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Shipping <?php if ($shipping_fee == 0) echo "<span class='text-success'>(On us!)</span>"; ?></span>
                <span><?php echo $shipping_fee == 0 ? '<span class="text-success">FREE</span>' : '$' . number_format($shipping_fee, 2); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                <span>Total</span>
                <span class="text-primary">$<?php echo number_format($final_total, 2); ?></span>
              </li>
            </ul>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-body">
            <h5>Payment Options</h5>
            <form id="payment-form" method="POST">
              <div class="mb-3">
                <label class="form-label">Choose Payment Method:</label>
                <select class="form-select" name="payment_method" required>
                  <option value="card">Credit/Debit Card</option>
                  <option value="upi">UPI</option>
                  <option value="paypal">PayPal</option>
                  <option value="cod">Cash on Delivery</option>
                </select>
              </div>
              <div id="payment-details">
                <!-- Dummy payment fields -->
                <div class="mb-3" id="card-fields">
                  <label class="form-label">Card Number</label>
                  <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                  <div class="row mt-2">
                    <div class="col">
                      <input type="text" class="form-control" placeholder="MM/YY">
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" placeholder="CVV">
                    </div>
                  </div>
                </div>
                <div class="mb-3 d-none" id="upi-fields">
                  <label class="form-label">UPI ID</label>
                  <input type="text" class="form-control" placeholder="yourname@upi">
                </div>
                <div class="mb-3 d-none" id="paypal-fields">
                  <label class="form-label">PayPal Email</label>
                  <input type="email" class="form-control" placeholder="your@email.com">
                </div>
              </div>
              <button type="submit" name="pay_now" class="btn btn-success w-100 mt-3">Pay $<?php echo number_format($final_total, 2); ?></button>
            </form>
            <div id="payment-loader" style="display:none;" class="text-center mt-4">
              <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Processing...</span>
              </div>
              <p class="mt-3">Processing your payment, please wait...</p>
            </div>
            <div id="payment-success" style="display:none;" class="alert alert-success text-center mt-4">
              <i class="fas fa-check-circle fa-2x mb-2"></i>
              <h4 class="mb-2">Payment Successful!</h4>
              <p>Your order is confirmed and will be delivered in 3-4 working days.<br>Thank you for shopping with us!</p>
              <p class="text-muted mt-3">Redirecting to products page in <span id="countdown">15</span> seconds...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
// Payment method fields toggle
const paymentSelect = document.querySelector('select[name="payment_method"]');
const cardFields = document.getElementById('card-fields');
const upiFields = document.getElementById('upi-fields');
const paypalFields = document.getElementById('paypal-fields');

if (paymentSelect) {
  paymentSelect.addEventListener('change', function() {
    cardFields.classList.add('d-none');
    upiFields.classList.add('d-none');
    paypalFields.classList.add('d-none');
    if (this.value === 'card') cardFields.classList.remove('d-none');
    if (this.value === 'upi') upiFields.classList.remove('d-none');
    if (this.value === 'paypal') paypalFields.classList.remove('d-none');
  });
}

// Payment loading and success
const paymentForm = document.getElementById('payment-form');
if (paymentForm) {
  paymentForm.addEventListener('submit', function(e) {
    e.preventDefault();
    document.getElementById('payment-loader').style.display = 'block';
    paymentForm.style.display = 'none';
    setTimeout(function() {
      document.getElementById('payment-loader').style.display = 'none';
      document.getElementById('payment-success').style.display = 'block';
      
      // Countdown and redirect
      let countdown = 15;
      const countdownElement = document.getElementById('countdown');
      const countdownInterval = setInterval(function() {
        countdown--;
        countdownElement.textContent = countdown;
        if (countdown <= 0) {
          clearInterval(countdownInterval);
          window.location.href = 'products.php';
        }
      }, 1000);
    }, 2500);
  });
}
</script>

<?php include('includes/footer.php'); ?>
