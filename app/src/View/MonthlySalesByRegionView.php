<?php

declare(strict_types=1);

namespace App\View;

/**
 * View class for rendering monthly sales by region data in HTML format.
 */
final class MonthlySalesByRegionView
{
    /**
     * Render the monthly sales by region data as an HTML table.
     * 
     * @param array $data The sales data to render
     * @param int|null $year Current year filter
     * @param int|null $month Current month filter
     * @param int|null $regionId Current region filter
     * @return string HTML content
     */
    public function render(array $data, ?int $year = null, ?int $month = null, ?int $regionId = null): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Monthly Sales by Region</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .filters {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .filters form {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        .filters label {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .filters input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100px;
        }
        .filters button {
            padding: 8px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .filters button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        .total-sales {
            font-weight: bold;
            color: #28a745;
        }
        .order-count {
            color: #6c757d;
        }
        @media (max-width: 768px) {
            .filters form {
                flex-direction: column;
                align-items: stretch;
            }
            .filters input {
                width: 100%;
            }
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Monthly Sales by Region</h1>
        
        <div class="filters">
            <form method="GET">
                <label>
                    Year:
                    <input type="number" name="year" value="{$year}" placeholder="YYYY">
                </label>
                <label>
                    Month:
                    <input type="number" name="month" min="1" max="12" value="{$month}" placeholder="MM">
                </label>
                <label>
                    Region ID:
                    <input type="number" name="regionId" value="{$regionId}" placeholder="Region ID">
                </label>
                <button type="submit">Apply Filters</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Region ID</th>
                    <th>Total Sales</th>
                    <th>Order Count</th>
                </tr>
            </thead>
            <tbody>
                {$this->renderTableRows($data)}
            </tbody>
        </table>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Render table rows from the data array.
     * 
     * @param array $data The sales data
     * @return string HTML table rows
     */
    private function renderTableRows(array $data): string
    {
        $html = '';
        foreach ($data as $row) {
            $html .= sprintf(
                '<tr>
                    <td>%d</td>
                    <td>%d</td>
                    <td>%d</td>
                    <td class="total-sales">$%.2f</td>
                    <td class="order-count">%d</td>
                </tr>',
                $row['year'],
                $row['month'],
                $row['region_id'],
                $row['total_sales'],
                $row['order_count']
            );
        }
        return $html;
    }
} 