<?php
echo "<h2>Database Setup for Online Computer Store</h2>";

$host = 'localhost';
$user = 'root';
$pass = '';

try {
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "✅ Successfully connected to MySQL server<br>";
    
    $result = $conn->query("SHOW DATABASES LIKE 'computer_store'");
    
    if ($result->num_rows > 0) {
        echo "✅ Database 'computer_store' already exists<br>";
    } else {
        if ($conn->query("CREATE DATABASE computer_store")) {
            echo "✅ Database 'computer_store' created successfully<br>";
        } else {
            die("❌ Failed to create database: " . $conn->error);
        }
    }
    
    $conn->select_db('computer_store');
    echo "✅ Selected database 'computer_store'<br>";
    
    $result = $conn->query("SHOW TABLES");
    if ($result->num_rows > 0) {
        echo "✅ Tables already exist in the database<br>";
        echo "<strong>Existing tables:</strong><br>";
        while ($row = $result->fetch_array()) {
            echo "- " . $row[0] . "<br>";
        }
    } else {
        echo "⚠️ No tables found. You need to import the database schema.<br>";
        echo "<a href='http://localhost/phpmyadmin' target='_blank'>Open phpMyAdmin</a>";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    die("Database setup error: " . $e->getMessage());
}
?>

<br><br>
<a href="index.php">Go to application</a>  