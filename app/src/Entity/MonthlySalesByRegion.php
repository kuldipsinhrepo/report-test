<?php

declare(strict_types=1);

namespace App\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(table: 'monthly_sales_by_region')]
class MonthlySalesByRegion
{
    #[Column(type: 'bigPrimary')]
    public int $id;
    
    #[Column(type: 'integer')]
    public int $year;
    
    #[Column(type: 'integer')]
    public int $month;
    
    #[Column(type: 'bigInteger')]
    public int $regionId;
    
    #[Column(type: 'decimal', precision: 12, scale: 2)]
    public float $totalSales;
    
    #[Column(type: 'integer')]
    public int $orderCount;
    
    #[Column(type: 'timestamp')]
    public \DateTimeInterface $lastUpdated;
    
    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'region_id' => $this->regionId,
            'total_sales' => $this->totalSales,
            'order_count' => $this->orderCount,
            'last_updated' => $this->lastUpdated->format('Y-m-d H:i:s')
        ];
    }
} 