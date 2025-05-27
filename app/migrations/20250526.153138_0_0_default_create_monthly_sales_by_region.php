<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmDefault502e670b0b6601922fdace03d9e04cc4 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('monthly_sales_by_region')
        ->addColumn('id', 'bigPrimary', [
            'nullable' => false,
            'defaultValue' => null,
            'size' => 20,
            'autoIncrement' => true,
            'unsigned' => false,
            'zerofill' => false,
            'comment' => '',
        ])
        ->addColumn('year', 'integer', [
            'nullable' => false,
            'defaultValue' => null,
            'size' => 11,
            'autoIncrement' => false,
            'unsigned' => false,
            'zerofill' => false,
            'comment' => '',
        ])
        ->addColumn('month', 'integer', [
            'nullable' => false,
            'defaultValue' => null,
            'size' => 11,
            'autoIncrement' => false,
            'unsigned' => false,
            'zerofill' => false,
            'comment' => '',
        ])
        ->addColumn('region_id', 'bigInteger', [
            'nullable' => false,
            'defaultValue' => null,
            'size' => 20,
            'autoIncrement' => false,
            'unsigned' => false,
            'zerofill' => false,
            'comment' => '',
        ])
        ->addColumn('total_sales', 'decimal', [
            'nullable' => false,
            'defaultValue' => null,
            'comment' => '',
            'precision' => 12,
            'scale' => 2,
        ])
        ->addColumn('order_count', 'integer', [
            'nullable' => false,
            'defaultValue' => null,
            'size' => 11,
            'autoIncrement' => false,
            'unsigned' => false,
            'zerofill' => false,
            'comment' => '',
        ])
        ->addColumn('last_updated', 'timestamp', ['nullable' => false, 'defaultValue' => null, 'comment' => ''])
        ->setPrimaryKeys(['id'])
        ->create();
    }

    public function down(): void
    {
        $this->table('monthly_sales_by_region')->drop();
    }
}
