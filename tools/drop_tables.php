<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'project_1';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    echo "Connect error: " . $mysqli->connect_error . PHP_EOL;
    exit(1);
}

$tables = ['users','forms','migrations'];
foreach ($tables as $t) {
    if ($mysqli->query("DROP TABLE IF EXISTS `$t`")) {
        echo "Dropped: $t\n";
    } else {
        echo "Failed to drop $t: " . $mysqli->error . "\n";
    }
}

$mysqli->close();
