<?php

declare(strict_types=1);

namespace App\Endpoint\Web;

use App\Service\TopCategoriesByStoreService;
use App\View\TopCategoriesByStoreView;
use Spiral\Http\ResponseWrapper;
use Spiral\Router\Annotation\Route;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Stream;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Controller for handling top categories by store reports.
 * Provides both HTML table view and JSON API endpoints.
 */
final class TopCategoriesByStoreController
{
    public function __construct(
        private readonly ResponseWrapper $response,
        private readonly TopCategoriesByStoreService $topCategoriesService,
        private readonly TopCategoriesByStoreView $view
    ) {
    }

    /**
     * Display top categories by store in HTML table format.
     * 
     * @param ServerRequestInterface $request The HTTP request
     * @return ResponseInterface HTML response with categories data table
     */
    #[Route(route: '/top-categories-by-store', name: 'top-categories-by-store', methods: ['GET'])]
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        
        // Handle empty string values
        $startDate = !empty($queryParams['startDate']) ? $queryParams['startDate'] : null;
        $endDate = !empty($queryParams['endDate']) ? $queryParams['endDate'] : null;

        $data = $this->topCategoriesService->getTopCategoriesByStore($startDate, $endDate);
        $html = $this->view->render($data, $startDate, $endDate);
        
        return $this->response->create(200)
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withBody(Stream::create($html));
    }

    /**
     * Get top categories by store data in JSON format.
     * 
     * @param ServerRequestInterface $request The HTTP request
     * @return ResponseInterface JSON response with categories data
     */
    #[Route(route: '/top-categories-by-store-json', name: 'top-categories-by-store-json', methods: ['GET'])]
    public function json(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        
        // Handle empty string values
        $startDate = !empty($queryParams['startDate']) ? $queryParams['startDate'] : null;
        $endDate = !empty($queryParams['endDate']) ? $queryParams['endDate'] : null;

        $data = $this->topCategoriesService->getTopCategoriesByStore($startDate, $endDate);
        
        return $this->response->json([
            'type' => 'top_categories_by_store',
            'data' => $data
        ]);
    }
} 