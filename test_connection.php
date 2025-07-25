<?php
echo "<h2>Database Connection Test</h2>";

$host = 'localhost';
$user = 'root';
$pass = '';

try {
    echo "Testing connection to MySQL server...<br>";
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }
    
    echo "✅ Successfully connected to MySQL server<br>";
    
    $result = $conn->query("SHOW DATABASES LIKE 'computer_store'");
    if ($result->num_rows > 0) {
        echo "✅ Database 'computer_store' exists<br>";
        
        $conn->select_db('computer_store');
        $tables = $conn->query("SHOW TABLES");
        echo "✅ Found " . $tables->num_rows . " tables in database<br>";
        
    } else {
        echo "❌ Database 'computer_store' does not exist<br>";
        echo "Creating database...<br>";
        
        if ($conn->query("CREATE DATABASE computer_store")) {
            echo "✅ Database created successfully<br>";
        } else {
            die("❌ Failed to create database: " . $conn->error);
        }
    }
    
    $conn->close();
    
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage());
}

echo "<br><a href='import_database.php'>Import Database Schema</a>";
?> 