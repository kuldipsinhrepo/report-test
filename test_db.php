<?php

require "vendor/autoload.php";

use Cycle\Database\Config;
use Cycle\Database\DatabaseManager;
use Cycle\Database\Config\MySQLDriverConfig;
use Cycle\Database\Config\MySQL\TcpConnectionConfig;

// Database configuration
$config = new Config\DatabaseConfig([
    'default' => 'default',
    'databases' => [
        'default' => [
            'driver' => 'mysql',
        ],
    ],
    'drivers' => [
        'mysql' => new MySQLDriverConfig(
            connection: new TcpConnectionConfig(
                database: 'cycle_test', // Your database name
                host: '127.0.0.1',
                port: 3306,
                user: 'root',
                password: '' // Set password to blank
            ),
            queryCache: true
        ),
    ],
]);

try {
    // Create database manager
    $dbal = new DatabaseManager($config);
    
    // Get database connection
    $db = $dbal->database('default');
    
    // Real query: fetch all users
    $result = $db->query('SELECT * FROM users LIMIT 5')->fetchAll();
    
    echo "Database connection successful!\n";
    echo "Query result:\n";
    print_r($result);
    
} catch (\Exception $e) {
    echo "Database connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
} 