<?php

declare(strict_types=1);

namespace App\View;

/**
 * View class for rendering top categories by store data in HTML format.
 */
final class TopCategoriesByStoreView
{
    /**
     * Render the top categories by store data as an HTML table.
     * 
     * @param array $data The categories data to render
     * @param string|null $startDate Start date filter
     * @param string|null $endDate End date filter
     * @return string HTML content
     */
    public function render(array $data, ?string $startDate = null, ?string $endDate = null): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Top Categories by Store</title>
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
            width: 150px;
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
        .store-header {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .total-sales {
            font-weight: bold;
            color: #28a745;
            text-align: right;
        }
        .rank {
            font-weight: bold;
            color: #007bff;
            text-align: center;
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
        <h1>Top Categories by Store</h1>
        
        <div class="filters">
            <form method="GET">
                <label>
                    Start Date:
                    <input type="date" name="startDate" value="{$startDate}" placeholder="YYYY-MM-DD">
                </label>
                <label>
                    End Date:
                    <input type="date" name="endDate" value="{$endDate}" placeholder="YYYY-MM-DD">
                </label>
                <button type="submit">Apply Filters</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Category</th>
                    <th>Total Sales</th>
                    <th>Rank</th>
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
     * @param array $data The categories data
     * @return string HTML table rows
     */
    private function renderTableRows(array $data): string
    {
        if (empty($data)) {
            return '<tr><td colspan="4" style="text-align: center;">No data available for the selected period.</td></tr>';
        }

        $html = '';
        $currentStore = null;

        foreach ($data as $row) {
            if ($currentStore !== $row['store_name']) {
                $currentStore = $row['store_name'];
                $html .= sprintf(
                    '<tr class="store-header"><td colspan="4">%s</td></tr>',
                    htmlspecialchars($row['store_name'])
                );
            }

            $html .= sprintf(
                '<tr>
                    <td></td>
                    <td>%s</td>
                    <td class="total-sales">$%.2f</td>
                    <td class="rank">%d</td>
                </tr>',
                htmlspecialchars($row['category_name']),
                $row['total_sales'],
                $row['rank']
            );
        }

        return $html;
    }
} 