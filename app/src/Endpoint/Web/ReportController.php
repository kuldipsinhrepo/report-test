<?php

declare(strict_types=1);

namespace App\Endpoint\Web;

use App\Entity\Order;
use App\Service\MonthlySalesByRegionService;
use Cycle\ORM\ORMInterface;
use Spiral\Http\ResponseWrapper;
use Spiral\Router\Annotation\Route;

final class ReportController
{
    private ResponseWrapper $response;
    
    public function __construct(
        ResponseWrapper $response,
        private readonly MonthlySalesByRegionService $monthlySalesService
    ) {
        $this->response = $response;
    }

    #[Route(route: '/report', name: 'report.index')]
    public function index(): \Psr\Http\Message\ResponseInterface
    {
        return $this->response->json([
            'type' => 'reports',
            'available_reports' => [
                [
                    'name' => 'Orders Report',
                    'endpoint' => '/report/orders',
                    'description' => 'View all orders'
                ],
                [
                    'name' => 'Sales Report',
                    'endpoint' => '/report/sales',
                    'description' => 'View total sales and order count'
                ],
                [
                    'name' => 'Monthly Sales by Region',
                    'endpoint' => '/report/monthly-sales-by-region',
                    'description' => 'View monthly sales aggregated by region'
                ],
                [
                    'name' => 'Inventory Report',
                    'endpoint' => '/report/inventory',
                    'description' => 'View inventory status (coming soon)'
                ],
                [
                    'name' => 'Customers Report',
                    'endpoint' => '/report/customers',
                    'description' => 'View customer information (coming soon)'
                ]
            ]
        ]);
    }
    
    #[Route(route: '/report/orders', name: 'report.orders')]
    public function orders(ORMInterface $orm): \Psr\Http\Message\ResponseInterface
    {
        $repository = $orm->getRepository(Order::class);
        $orders = $repository->findAll();
        $data = array_map(fn(Order $order) => $order->toArray(), $orders);
        
        return $this->response->json([
            'type' => 'orders',
            'data' => $data
        ]);
    }
    
    #[Route(route: '/report/sales', name: 'report.sales')]
    public function sales(ORMInterface $orm): \Psr\Http\Message\ResponseInterface
    {
        $repository = $orm->getRepository(Order::class);
        $orders = $repository->findAll();
        
        // Calculate total sales
        $totalSales = array_reduce($orders, function($carry, Order $order) {
            return $carry + ($order->quantity * $order->unitPrice);
        }, 0);
        
        return $this->response->json([
            'type' => 'sales',
            'data' => [
                'total_sales' => $totalSales,
                'order_count' => count($orders)
            ]
        ]);
    }
    
    #[Route(route: '/report/inventory', name: 'report.inventory')]
    public function inventory(ORMInterface $orm): \Psr\Http\Message\ResponseInterface
    {
        // TODO: Implement inventory report
        return $this->response->json([
            'type' => 'inventory',
            'message' => 'Inventory report endpoint - to be implemented'
        ]);
    }
    
    #[Route(route: '/report/customers', name: 'report.customers')]
    public function customers(ORMInterface $orm): \Psr\Http\Message\ResponseInterface
    {
        // TODO: Implement customers report
        return $this->response->json([
            'type' => 'customers',
            'message' => 'Customers report endpoint - to be implemented'
        ]);
    }
} 