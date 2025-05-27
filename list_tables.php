<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=cycle_test', 'root', '');
    $stmt = $pdo->query('SHOW TABLES');
    echo "Tables in cycle_test database:\n";
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo $row[0] . "\n";
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
} 