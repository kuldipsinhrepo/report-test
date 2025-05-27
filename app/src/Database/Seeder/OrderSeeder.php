<?php

declare(strict_types=1);

namespace App\Database\Seeder;

use Cycle\Database\DatabaseInterface;
use Faker\Factory;

class OrderSeeder
{
    private DatabaseInterface $db;
    private \Faker\Generator $faker;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        $this->faker = Factory::create();
    }

    public function run(): void
    {
        // Create 1000 orders
        for ($i = 1; $i <= 1000; $i++) {
            $storeId = $this->faker->numberBetween(1, 50);
            $productId = $this->faker->numberBetween(1, 200);
            $quantity = $this->faker->numberBetween(1, 10);
            $unitPrice = $this->faker->randomFloat(2, 10, 1000);
            
            $this->db->insert('orders')->values([
                'order_id' => $i,
                'customer_id' => $this->faker->numberBetween(1, 100),
                'product_id' => $productId,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'order_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'store_id' => $storeId,
                'store_storeId' => $storeId,
                'product_productId' => $productId,
            ])->run();
        }
    }
} 