<?php
include('includes/db_connect.php');

$sql = "CREATE TABLE IF NOT EXISTS user_cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
)";

if ($conn->query($sql)) {
    echo "✅ Cart table created successfully!<br>";
} else {
    echo "❌ Error creating cart table: " . $conn->error . "<br>";
}

$conn->close();
?> 