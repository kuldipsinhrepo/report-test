<?php

require __DIR__ . '/vendor/autoload.php';

$host = '127.0.0.1';
$port = 3306;
$database = 'cycle_test';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the migrations table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'migrations'");
    if ($stmt->rowCount() > 0) {
        // Fetch and display the contents of the migrations table
        $stmt = $pdo->query("SELECT * FROM migrations");
        echo "Contents of the migrations table:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            print_r($row);
        }
    } else {
        echo "The migrations table does not exist.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 