<?php

declare(strict_types=1);

namespace App\Database\Seeder;

use Cycle\Database\DatabaseInterface;
use Faker\Factory;

class ProductSeeder
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
        // Create 20 categories
        $categories = [];
        for ($i = 1; $i <= 20; $i++) {
            $categories[] = $i;
        }

        // Create 200 products
        for ($i = 1; $i <= 200; $i++) {
            $this->db->insert('products')->values([
                'product_id' => $i,
                'category_id' => $this->faker->randomElement($categories),
                'product_name' => $this->faker->words(3, true),
            ])->run();
        }
    }
} 