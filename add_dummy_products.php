<?php
include('includes/db_connect.php');

$products = [
    [
        'name' => 'Gaming Laptop - ASUS ROG',
        'description' => 'High-performance gaming laptop with RTX 4060, 16GB RAM, 512GB SSD',
        'price' => 1299.99,
        'image_url' => 'https://images.unsplash.com/photo-1603302576830-37561eb2bee6?auto=format&fit=crop&w=600&q=80',
        'category' => 'Laptops',
        'stock' => 15
    ],
    [
        'name' => 'MacBook Pro 14"',
        'description' => 'Apple MacBook Pro with M2 Pro chip, 16GB RAM, 512GB SSD',
        'price' => 1999.99,
        'image_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=600&q=80',
        'category' => 'Laptops',
        'stock' => 10
    ],
    [
        'name' => 'Gaming Desktop PC',
        'description' => 'Custom gaming PC with RTX 4070, Intel i7, 32GB RAM, 1TB SSD',
        'price' => 1899.99,
        'image_url' => 'https://images.unsplash.com/photo-1547082299-de196ea013d6?auto=format&fit=crop&w=600&q=80',
        'category' => 'Desktops',
        'stock' => 8
    ],
    [
        'name' => 'Wireless Gaming Mouse',
        'description' => 'Logitech G Pro X Superlight wireless gaming mouse with 25K DPI',
        'price' => 149.99,
        'image_url' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=600&q=80',
        'category' => 'Accessories',
        'stock' => 25
    ],
    [
        'name' => 'Mechanical Gaming Keyboard',
        'description' => 'Razer BlackWidow V3 Pro mechanical keyboard with RGB lighting',
        'price' => 199.99,
        'image_url' => 'https://images.unsplash.com/photo-1541140532154-b024d705b90a?auto=format&fit=crop&w=600&q=80',
        'category' => 'Accessories',
        'stock' => 20
    ],
    [
        'name' => '4K Gaming Monitor',
        'description' => '27" 4K gaming monitor with 144Hz refresh rate and HDR',
        'price' => 599.99,
        'image_url' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=600&q=80',
        'category' => 'Monitors',
        'stock' => 12
    ],
    [
        'name' => 'Gaming Headset',
        'description' => 'SteelSeries Arctis Pro wireless gaming headset with 7.1 surround',
        'price' => 299.99,
        'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80',
        'category' => 'Accessories',
        'stock' => 18
    ],
    [
        'name' => 'External SSD 1TB',
        'description' => 'Samsung T7 portable SSD with 1050MB/s read/write speeds',
        'price' => 129.99,
        'image_url' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?auto=format&fit=crop&w=600&q=80',
        'category' => 'Storage',
        'stock' => 30
    ],
    [
        'name' => 'Webcam HD 1080p',
        'description' => 'Logitech C920 HD webcam with autofocus and noise cancellation',
        'price' => 79.99,
        'image_url' => 'https://images.unsplash.com/photo-1563861826100-9cb868fdbe1c?auto=format&fit=crop&w=600&q=80',
        'category' => 'Accessories',
        'stock' => 22
    ],
    [
        'name' => 'Gaming Chair',
        'description' => 'Ergonomic gaming chair with lumbar support and adjustable armrests',
        'price' => 399.99,
        'image_url' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=600&q=80',
        'category' => 'Furniture',
        'stock' => 10
    ]
];

echo "<h2>Adding Dummy Products</h2>";

$stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url, category, stock) VALUES (?, ?, ?, ?, ?, ?)");

$added_count = 0;
foreach ($products as $product) {
    $stmt->bind_param("ssdssi", 
        $product['name'], 
        $product['description'], 
        $product['price'], 
        $product['image_url'], 
        $product['category'], 
        $product['stock']
    );
    
    if ($stmt->execute()) {
        $added_count++;
        echo "✅ Added: " . $product['name'] . "<br>";
    } else {
        echo "❌ Failed to add: " . $product['name'] . " - " . $stmt->error . "<br>";
    }
}

echo "<br><strong>Summary:</strong> Added $added_count products successfully!<br>";
echo "<a href='products.php'>View Products</a>";

$stmt->close();
$conn->close();
?> 