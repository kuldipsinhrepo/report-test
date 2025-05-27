<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use Cycle\Database\DatabaseInterface;
use Cycle\ORM\ORMInterface;
use DateTime;
use PDOException;

final class TopCategoriesByStoreService
{
    public function __construct(
        private readonly DatabaseInterface $db,
        private readonly ORMInterface $orm
    ) {
    }

    public function getTopCategoriesByStore(?string $startDate = null, ?string $endDate = null): array
    {
        try {
            // If no dates provided, default to last 3 months
            if (!$startDate) {
                $endDate = new DateTime();
                $startDate = (clone $endDate)->modify('-3 months');
            } else {
                $startDate = new DateTime($startDate);
                $endDate = $endDate ? new DateTime($endDate) : new DateTime();
            }

            // Validate date range (must be within 3 months)
            $maxDateRange = (clone $startDate)->modify('+3 months');
            if ($endDate > $maxDateRange) {
                throw new \InvalidArgumentException('Date range cannot exceed 3 months');
            }

            // Use raw SQL query for better performance
            $results = $this->db->query('
                SELECT 
                    o.store_id,
                    s.name as store_name,
                    o.category_id,
                    c.name as category_name,
                    SUM(o.quantity * o.unit_price) as total_sales
                FROM orders o
                LEFT JOIN stores s ON o.store_id = s.id
                LEFT JOIN categories c ON o.category_id = c.id
                WHERE o.created_at >= ? AND o.created_at <= ?
                GROUP BY o.store_id, o.category_id, s.name, c.name
                ORDER BY o.store_id ASC, total_sales DESC
            ', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ])->fetchAll();

            if (empty($results)) {
                return [];
            }

            // Process results to add ranks
            $storeCategories = [];
            $currentStoreId = null;
            $rank = 1;

            foreach ($results as $row) {
                if ($currentStoreId !== $row['store_id']) {
                    $currentStoreId = $row['store_id'];
                    $rank = 1;
                }

                $storeCategories[] = [
                    'store_id' => $row['store_id'],
                    'store_name' => $row['store_name'] ?? 'Unknown Store',
                    'category_id' => $row['category_id'],
                    'category_name' => $row['category_name'] ?? 'Unknown Category',
                    'total_sales' => (float)$row['total_sales'],
                    'rank' => $rank++
                ];
            }

            return $storeCategories;
        } catch (PDOException $e) {
            throw new \RuntimeException('Database error: ' . $e->getMessage(), 0, $e);
        } catch (\Exception $e) {
            throw new \RuntimeException('Error processing data: ' . $e->getMessage(), 0, $e);
        }
    }
} 