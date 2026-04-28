<?php
// Simple database setup script

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'project_1';

// Connect without database first to create it
$conn = new mysqli($hostname, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `$database`";
if ($conn->query($sql) === TRUE) {
    echo "✓ Database created or already exists\n";
} else {
    die("Error creating database: " . $conn->error);
}

// Select database
$conn->select_db($database);

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `role` ENUM('pending', 'user', 'admin') DEFAULT 'pending',
    `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Users table created or already exists\n";
} else {
    die("Error creating table: " . $conn->error);
}

// Check if admin user exists
$result = $conn->query("SELECT * FROM users WHERE email = 'admin'");

if ($result->num_rows == 0) {
    // Insert admin user
    $password_hash = password_hash('admin123', PASSWORD_BCRYPT);
    $now = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO users (email, password, full_name, role, status, created_at, updated_at) 
            VALUES ('admin', '$password_hash', 'Administrator', 'admin', 'approved', '$now', '$now')";
    
    if ($conn->query($sql) === TRUE) {
        echo "✓ Admin user created (email: admin, password: admin123)\n";
    } else {
        die("Error inserting admin user: " . $conn->error);
    }
} else {
    echo "✓ Admin user already exists\n";
}

echo "\n✓ Setup completed successfully!\n";
$conn->close();
?>
