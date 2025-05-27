<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Seeder script started.\n";

$host = '127.0.0.1';
$db   = 'cycle_test';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Print the structure of the orders table
    echo "\n--- orders table structure ---\n";
    $stmt = $pdo->query("DESCRIBE orders");
    $structure = $stmt->fetchAll();
    foreach ($structure as $column) {
        echo $column['Field'] . ' - ' . $column['Type'] . "\n";
    }
    echo "-----------------------------\n\n";

    // Clear tables before seeding
    $pdo->exec("DELETE FROM orders");
    $pdo->exec("DELETE FROM products");
    $pdo->exec("DELETE FROM stores");
    $pdo->exec("DELETE FROM users");
    
    // Reset AUTO_INCREMENT
    $pdo->exec("ALTER TABLE orders AUTO_INCREMENT = 1");
    $pdo->exec("ALTER TABLE products AUTO_INCREMENT = 1");
    $pdo->exec("ALTER TABLE stores AUTO_INCREMENT = 1");
    $pdo->exec("ALTER TABLE users AUTO_INCREMENT = 1");

    // Insert regions and stores (10 stores across 5 regions)
    $regions = [
        ['id' => 1, 'name' => 'North Region'],
        ['id' => 2, 'name' => 'South Region'],
        ['id' => 3, 'name' => 'East Region'],
        ['id' => 4, 'name' => 'West Region'],
        ['id' => 5, 'name' => 'Central Region']
    ];

    $stores = [];
    for ($i = 1; $i <= 10; $i++) {
        $regionId = ceil($i / 2); // Distribute stores across regions
        $stores[] = [
            'id' => $i,
            'region_id' => $regionId,
            'name' => "Store {$i}"
        ];
    }

    // Insert stores
    foreach ($stores as $store) {
        $pdo->exec("INSERT INTO stores (store_id, region_id, store_name) VALUES ({$store['id']}, {$store['region_id']}, '{$store['name']}')");
    }
    echo "Inserted " . count($stores) . " stores.\n";

    // Insert product categories and products (100 products across 5 categories)
    $categories = [
        ['id' => 1, 'name' => 'Electronics'],
        ['id' => 2, 'name' => 'Clothing'],
        ['id' => 3, 'name' => 'Home & Kitchen'],
        ['id' => 4, 'name' => 'Books'],
        ['id' => 5, 'name' => 'Sports']
    ];

    $products = [];
    for ($i = 1; $i <= 100; $i++) {
        $categoryId = ceil($i / 20); // 20 products per category
        $products[] = [
            'id' => $i,
            'category_id' => $categoryId,
            'name' => "Product {$i}",
            'price' => rand(1000, 10000) / 100
        ];
    }

    // Insert products
    foreach ($products as $product) {
        $pdo->exec("INSERT INTO products (product_id, category_id, product_name) VALUES ({$product['id']}, {$product['category_id']}, '{$product['name']}')");
    }
    echo "Inserted " . count($products) . " products.\n";

    // Insert users (10 users)
    $users = [];
    for ($i = 1; $i <= 10; $i++) {
        $users[] = [
            'id' => $i,
            'name' => "User {$i}",
            'email' => "user{$i}@example.com"
        ];
    }

    // Insert users
    foreach ($users as $user) {
        $pdo->exec("INSERT INTO users (id, username, email) VALUES ({$user['id']}, '{$user['name']}', '{$user['email']}')");
    }
    echo "Inserted " . count($users) . " users.\n";

    // Insert 1000 orders
    $totalOrders = 0;
    $startDate = strtotime('-12 months');
    $endDate = time();
    $daysDiff = ceil(($endDate - $startDate) / 86400);
    $ordersPerDay = ceil(1000 / $daysDiff); // Distribute 1000 orders across the date range

    for ($date = $startDate; $date <= $endDate && $totalOrders < 1000; $date += 86400) {
        $ordersToday = min($ordersPerDay, 1000 - $totalOrders);
        
        for ($i = 1; $i <= $ordersToday; $i++) {
            $orderId = $totalOrders + 1;
            $customerId = rand(1, 10); // Random user (1-10)
            $storeId = rand(1, 10); // Random store (1-10)
            $productId = rand(1, 100); // Random product (1-100)
            $quantity = rand(1, 5);
            $unitPrice = $products[$productId - 1]['price'];
            $orderDate = date('Y-m-d', $date);

            $sql = "INSERT INTO orders (order_id, customer_id, product_productId, quantity, unit_price, order_date, store_storeId) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$orderId, $customerId, $productId, $quantity, $unitPrice, $orderDate, $storeId]);
            
            $totalOrders++;
        }
    }
    echo "Inserted {$totalOrders} orders.\n";

    echo "Seeding completed successfully!\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 