<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=cycle_test', 'root', '');
$rows = $pdo->query('SELECT * FROM monthly_sales_by_region LIMIT 10')->fetchAll(PDO::FETCH_ASSOC);
print_r($rows); 