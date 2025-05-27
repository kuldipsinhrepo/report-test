<?php

declare(strict_types=1);

namespace App\Endpoint\Console;

use App\Service\MonthlySalesByRegionService;
use Spiral\Console\Command;

class UpdateMonthlySalesCommand extends Command
{
    protected const NAME = 'update:monthly-sales';
    protected const DESCRIPTION = 'Update monthly sales by region materialized view';

    public function __construct(
        private readonly MonthlySalesByRegionService $service
    ) {
        parent::__construct();
    }

    public function perform(): int
    {
        $this->output->writeln('Updating monthly sales by region materialized view...');
        
        try {
            $this->service->updateMaterializedView();
            $this->output->writeln('Successfully updated monthly sales by region materialized view.');
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->output->error('Failed to update monthly sales by region materialized view: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
} 