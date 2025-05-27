<?php

declare(strict_types=1);

namespace App\Database\Seeder;

use Cycle\Database\DatabaseInterface;
use Faker\Factory;

class StoreSeeder
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
        // Create 10 regions
        $regions = [];
        for ($i = 1; $i <= 10; $i++) {
            $regions[] = $i;
        }

        // Create 50 stores
        for ($i = 1; $i <= 50; $i++) {
            $this->db->insert('stores')->values([
                'store_id' => $i,
                'region_id' => $this->faker->randomElement($regions),
                'store_name' => $this->faker->company . ' Store',
            ])->run();
        }
    }
} 