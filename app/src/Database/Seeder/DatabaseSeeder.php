<?php

declare(strict_types=1);

namespace App\Database\Seeder;

use Cycle\Database\DatabaseInterface;

class DatabaseSeeder
{
    private DatabaseInterface $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function run(): void
    {
        // Run seeders in order
        (new StoreSeeder($this->db))->run();
        (new ProductSeeder($this->db))->run();
        (new OrderSeeder($this->db))->run();
    }
} 