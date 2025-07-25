<?php
echo "<h2>Importing Database Schema</h2>";

$host = 'localhost';
$user = 'root';
$pass = '';

try {
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->query("CREATE DATABASE IF NOT EXISTS computer_store");
    $conn->select_db('computer_store');
    
    echo "✅ Connected to database 'computer_store'<br>";
    
    $sql_file = 'database.sql';
    
    if (!file_exists($sql_file)) {
        die("❌ database.sql file not found in the current directory");
    }
    
    $sql_content = file_get_contents($sql_file);
    $statements = array_filter(array_map('trim', explode(';', $sql_content)));
    
    $success_count = 0;
    $error_count = 0;
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            if ($conn->query($statement)) {
                $success_count++;
                echo "✅ Executed: " . substr($statement, 0, 50) . "...<br>";
            } else {
                $error_count++;
                echo "❌ Error executing: " . substr($statement, 0, 50) . "...<br>";
                echo "Error: " . $conn->error . "<br>";
            }
        }
    }
    
    echo "<br><strong>Import Summary:</strong><br>";
    echo "✅ Successful statements: $success_count<br>";
    echo "❌ Failed statements: $error_count<br>";
    
    if ($error_count == 0) {
        echo "<br>🎉 Database setup completed successfully!<br>";
        echo "<a href='index.php'>Go to your application</a>";
    } else {
        echo "<br>⚠️ Some statements failed. Please check the errors above.";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    die("Import error: " . $e->getMessage());
}
?> 