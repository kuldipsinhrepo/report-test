<?php return array (
  'user' => 
  array (
    1 => 'App\\Domain\\User\\Entity\\User',
    2 => 'Cycle\\ORM\\Mapper\\Mapper',
    3 => 'Cycle\\ORM\\Select\\Source',
    4 => 'App\\Infrastructure\\Persistence\\CycleORMUserRepository',
    5 => 'default',
    6 => 'users',
    7 => 
    array (
      0 => 'id',
    ),
    8 => 
    array (
      0 => 'id',
    ),
    9 => 
    array (
      'id' => 'id',
      'username' => 'username',
      'email' => 'email',
    ),
    10 => 
    array (
    ),
    12 => NULL,
    13 => 
    array (
      'id' => 'int',
      'username' => 'string',
      'email' => 'string',
    ),
    14 => 
    array (
    ),
    19 => NULL,
    20 => 
    array (
      'id' => 2,
    ),
  ),
  'monthlySalesByRegion' => 
  array (
    1 => 'App\\Entity\\MonthlySalesByRegion',
    2 => 'Cycle\\ORM\\Mapper\\Mapper',
    3 => 'Cycle\\ORM\\Select\\Source',
    4 => 'Cycle\\ORM\\Select\\Repository',
    5 => 'default',
    6 => 'monthly_sales_by_region',
    7 => 
    array (
      0 => 'id',
    ),
    8 => 
    array (
      0 => 'id',
    ),
    9 => 
    array (
      'id' => 'id',
      'year' => 'year',
      'month' => 'month',
      'regionId' => 'region_id',
      'totalSales' => 'total_sales',
      'orderCount' => 'order_count',
      'lastUpdated' => 'last_updated',
    ),
    10 => 
    array (
    ),
    12 => NULL,
    13 => 
    array (
      'id' => 'int',
      'year' => 'int',
      'month' => 'int',
      'regionId' => 'int',
      'totalSales' => 'float',
      'orderCount' => 'int',
      'lastUpdated' => 'datetime',
    ),
    14 => 
    array (
    ),
    19 => NULL,
    20 => 
    array (
      'id' => 2,
    ),
  ),
  'order' => 
  array (
    1 => 'App\\Entity\\Order',
    2 => 'Cycle\\ORM\\Mapper\\Mapper',
    3 => 'Cycle\\ORM\\Select\\Source',
    4 => 'Cycle\\ORM\\Select\\Repository',
    5 => 'default',
    6 => 'orders',
    7 => 
    array (
      0 => 'orderId',
    ),
    8 => 
    array (
      0 => 'orderId',
    ),
    9 => 
    array (
      'orderId' => 'order_id',
      'customerId' => 'customer_id',
      'productId' => 'product_id',
      'quantity' => 'quantity',
      'unitPrice' => 'unit_price',
      'orderDate' => 'order_date',
      'storeId' => 'store_id',
      'store_storeId' => 'store_storeId',
      'product_productId' => 'product_productId',
    ),
    10 => 
    array (
      'store' => 
      array (
        0 => 12,
        1 => 'store',
        3 => 10,
        2 => 
        array (
          30 => true,
          31 => false,
          33 => 'store_storeId',
          32 => 
          array (
            0 => 'storeId',
          ),
        ),
      ),
    ),
    12 => NULL,
    13 => 
    array (
      'orderId' => 'int',
      'customerId' => 'int',
      'productId' => 'int',
      'quantity' => 'int',
      'unitPrice' => 'float',
      'orderDate' => 'datetime',
      'storeId' => 'int',
      'store_storeId' => 'int',
      'product_productId' => 'int',
    ),
    14 => 
    array (
    ),
    19 => NULL,
    20 => 
    array (
      'orderId' => 2,
    ),
  ),
  'product' => 
  array (
    1 => 'App\\Entity\\Product',
    2 => 'Cycle\\ORM\\Mapper\\Mapper',
    3 => 'Cycle\\ORM\\Select\\Source',
    4 => 'Cycle\\ORM\\Select\\Repository',
    5 => 'default',
    6 => 'products',
    7 => 
    array (
      0 => 'productId',
    ),
    8 => 
    array (
      0 => 'productId',
    ),
    9 => 
    array (
      'productId' => 'product_id',
      'categoryId' => 'category_id',
      'productName' => 'product_name',
    ),
    10 => 
    array (
      'orders' => 
      array (
        0 => 11,
        1 => 'order',
        3 => 10,
        2 => 
        array (
          30 => true,
          31 => false,
          41 => 
          array (
          ),
          42 => 
          array (
          ),
          33 => 
          array (
            0 => 'productId',
          ),
          32 => 'product_productId',
          4 => NULL,
        ),
      ),
    ),
    12 => NULL,
    13 => 
    array (
      'productId' => 'int',
      'categoryId' => 'int',
      'productName' => 'string',
    ),
    14 => 
    array (
    ),
    19 => NULL,
    20 => 
    array (
      'productId' => 2,
    ),
  ),
  'store' => 
  array (
    1 => 'App\\Entity\\Store',
    2 => 'Cycle\\ORM\\Mapper\\Mapper',
    3 => 'Cycle\\ORM\\Select\\Source',
    4 => 'Cycle\\ORM\\Select\\Repository',
    5 => 'default',
    6 => 'stores',
    7 => 
    array (
      0 => 'storeId',
    ),
    8 => 
    array (
      0 => 'storeId',
    ),
    9 => 
    array (
      'storeId' => 'store_id',
      'regionId' => 'region_id',
      'storeName' => 'store_name',
    ),
    10 => 
    array (
      'orders' => 
      array (
        0 => 11,
        1 => 'order',
        3 => 10,
        2 => 
        array (
          30 => true,
          31 => false,
          41 => 
          array (
          ),
          42 => 
          array (
          ),
          33 => 
          array (
            0 => 'storeId',
          ),
          32 => 'store_storeId',
          4 => NULL,
        ),
      ),
    ),
    12 => NULL,
    13 => 
    array (
      'storeId' => 'int',
      'regionId' => 'int',
      'storeName' => 'string',
    ),
    14 => 
    array (
    ),
    19 => NULL,
    20 => 
    array (
      'storeId' => 2,
    ),
  ),
);