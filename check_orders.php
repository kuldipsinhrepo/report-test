<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=cycle_test', 'root', '');
$rows = $pdo->query('SELECT * FROM orders LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);
print_r($rows); 