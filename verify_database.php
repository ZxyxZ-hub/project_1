<?php

$conn = new mysqli('localhost', 'root', '', 'project_1');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "=== DATABASE VERIFICATION ===\n\n";

// Check tables
$result = $conn->query("SHOW TABLES");
echo "Tables in project_1:\n";
while ($row = $result->fetch_array()) {
    echo "  - " . $row[0] . "\n";
}

echo "\n=== USERS TABLE STRUCTURE ===\n";
$result = $conn->query("DESCRIBE users");
while ($row = $result->fetch_assoc()) {
    echo sprintf("%-20s %-30s %-8s %-8s %s\n", 
        $row['Field'], 
        $row['Type'], 
        $row['Null'], 
        $row['Key'],
        $row['Default'] ?? 'NULL'
    );
}

echo "\n=== FORMS TABLE STRUCTURE ===\n";
if ($conn->query("DESCRIBE forms")) {
    $result = $conn->query("DESCRIBE forms");
    while ($row = $result->fetch_assoc()) {
        echo sprintf("%-20s %-30s %-8s %-8s %s\n", 
            $row['Field'], 
            $row['Type'], 
            $row['Null'], 
            $row['Key'],
            $row['Default'] ?? 'NULL'
        );
    }
    
    echo "\n=== FORMS TABLE DATA ===\n";
    $result = $conn->query("SELECT COUNT(*) as count FROM forms");
    $row = $result->fetch_assoc();
    echo "Total forms: " . $row['count'] . "\n";
} else {
    echo "ERROR: Forms table does not exist!\n";
}

echo "\n=== MIGRATIONS TABLE ===\n";
$result = $conn->query("SELECT * FROM migrations ORDER BY batch DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
    echo "  - " . $row['version'] . " (Batch: " . $row['batch'] . ", Time: " . $row['time'] . ")\n";
}

$conn->close();
echo "\n✓ Database verification complete\n";
?>
