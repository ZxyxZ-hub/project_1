<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'project_1';

$mysqli = new mysqli($host, $user, $pass);
if ($mysqli->connect_error) {
    echo "Connect error: " . $mysqli->connect_error . PHP_EOL;
    exit(1);
}

if ($mysqli->query("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
    echo "Created or exists: $db" . PHP_EOL;
    exit(0);
}

echo "Failed to create database: " . $mysqli->error . PHP_EOL;
exit(1);
