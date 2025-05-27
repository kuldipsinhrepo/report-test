<?php

declare(strict_types=1);

namespace App\Endpoint\Web;

use App\Service\MonthlySalesByRegionService;
use App\View\MonthlySalesByRegionView;
use Spiral\Http\ResponseWrapper;
use Spiral\Router\Annotation\Route;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Stream;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Controller for handling monthly sales by region reports.
 * Provides both HTML table view and JSON API endpoints.
 */
final class MonthlySalesByRegionController
{
    public function __construct(
        private readonly ResponseWrapper $response,
        private readonly MonthlySalesByRegionService $monthlySalesService,
        private readonly MonthlySalesByRegionView $view
    ) {
    }

    /**
     * Display monthly sales by region in HTML table format.
     * 
     * @param ServerRequestInterface $request The HTTP request
     * @return ResponseInterface HTML response with sales data table
     */
    #[Route(route: '/report/monthly-sales-by-region', name: 'report.monthly-sales-by-region', methods: ['GET'])]
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        
        // Handle empty string values
        $year = !empty($queryParams['year']) ? (int)$queryParams['year'] : null;
        $month = !empty($queryParams['month']) ? (int)$queryParams['month'] : null;
        $regionId = !empty($queryParams['regionId']) ? (int)$queryParams['regionId'] : null;

        $data = $this->monthlySalesService->getMonthlySalesByRegion($year, $month, $regionId);
        $html = $this->view->render($data, $year, $month, $regionId);
        
        return $this->response->create(200)
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody(Stream::create($html));
    }

    /**
     * Get monthly sales by region data in JSON format.
     * 
     * @param ServerRequestInterface $request The HTTP request
     * @return ResponseInterface JSON response with sales data
     */
    #[Route(route: '/report/monthly-sales-by-region-json', name: 'report.monthly-sales-by-region-json', methods: ['GET'])]
    public function json(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        
        // Handle empty string values
        $year = !empty($queryParams['year']) ? (int)$queryParams['year'] : null;
        $month = !empty($queryParams['month']) ? (int)$queryParams['month'] : null;
        $regionId = !empty($queryParams['regionId']) ? (int)$queryParams['regionId'] : null;

        $data = $this->monthlySalesService->getMonthlySalesByRegion($year, $month, $regionId);
        
        return $this->response->json([
            'type' => 'monthly_sales_by_region',
            'data' => $data
        ]);
    }
} 