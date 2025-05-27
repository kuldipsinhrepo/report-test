<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\Store;
use Cycle\Database\DatabaseInterface;
use Cycle\ORM\ORMInterface;

class MonthlySalesByRegionService
{
    private DatabaseInterface $db;
    private ORMInterface $orm;

    public function __construct(DatabaseInterface $db, ORMInterface $orm)
    {
        $this->db = $db;
        $this->orm = $orm;
    }

    /**
     * Get monthly sales by region for a specific period
     */
    public function getMonthlySalesByRegion(
        ?int $year = null,
        ?int $month = null,
        ?int $regionId = null
    ): array {
        $params = [];
        $where = [];
        if ($year !== null) {
            $where[] = 'YEAR(o.order_date) = ?';
            $params[] = $year;
        }
        if ($month !== null) {
            $where[] = 'MONTH(o.order_date) = ?';
            $params[] = $month;
        }
        if ($regionId !== null) {
            $where[] = 's.region_id = ?';
            $params[] = $regionId;
        }
        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        $sql = "
            SELECT 
                YEAR(o.order_date) as year,
                MONTH(o.order_date) as month,
                s.region_id,
                SUM(o.quantity * o.unit_price) as total_sales,
                COUNT(DISTINCT o.order_id) as order_count
            FROM orders o
            JOIN stores s ON s.store_id = o.store_storeId
            $whereSql
            GROUP BY year, month, s.region_id
            ORDER BY year DESC, month DESC, s.region_id ASC
        ";
        $results = $this->db->query($sql, $params)->fetchAll();
        return $results;
    }
} 