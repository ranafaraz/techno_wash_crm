<?php  
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'IC - Institute on Cloud',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'ur',
    'sourceLanguage' => 'en',
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'backup' => [
            'class' => 'spanjeta\modules\backup\Module',
        ], 
    ],
    'components' => [
        'request' => [
            'class' => 'common\components\Request',
            'web'=> '/backend/web',
            'adminUrl' => '/admin',
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //site
                'admin' => 'admin',
                'user' => 'admin/user/index',
                'login' => 'site/login',
                'logout' => 'site/login',
                'home' => 'site/index',
                'passwords' => 'site/passwords',
                'user-profile' => 'site/user-profile',
                'update-profile' => 'site/update-profile',   
                'car-wash-details' => 'site/car-wash-details',
                'credit-sale-invoices' => 'site/credit-sale-invoices',
                'under-construction' => 'site/under-construction',
                
                // organization
                'organization'    => 'organization/index',

                // Branches
                'branches'        => 'branches/index',

                // Customer
                'customer'        => 'customer/index',

                // Customer Vehicles
                'customer-vehicles'    => 'customer-vehicles/index',

                 // Customer Vehicles
                'customer-detail-view'    => 'customer-vehicles/index',
                'customer-detail-view'    => 'customer-vehicles/view',
                // Employee
                'employee'         => 'employee/index',
                'employee-detail-view' => 'employee/view',
                'employee-update' => 'employee/update',
                'emp-atten-create' => 'emp-attendance/create',
                'emp-atten' => 'emp-atten/index',
                'payroll-month-report' =>'site/payroll-month-report',
                'emp-payroll-view' => 'employee/emp-payroll-view',
 
                // Employee salary
                'salary'           => 'salary/index',

                // Employee allowances
                'employee-allowances'      => 'employee-allowances/index',

                // Membership
                'membership'       => 'membership/index',

                // Services
                'services'         => 'services/index',
                'service-detail-view'         => 'services/view',

                // Stock
                'stock'            => 'stock/index',

                // Stock issue
                'stock-issue'      => 'stock-issue/index',

                // Sale Invoice Head
                'sale-invoice-head'    => 'sale-invoice-head/index',

                // Sale Invoice Services Detais
                'sale-invoice-services-detail'          => 'sale-invoice-services-detail/index',

                // Sale Invoice Stock Detais
                'sale-invoice-stock-detail'          => 'sale-invoice-stock-detail/index',

                // Vehicle Type
                'vehicle-type'      => 'vehicle-type/index',
                'vehicle-type-view'      => 'vehicle-type/view',

                // Vehicle Type Sub Category
                'vehicle-type-sub-category'      => 'vehicle-type-sub-category/index',

                // Card Type
                'card-type'      => 'card-type/index',

                // Manufacture
                'manufacture'      => 'manufacture/index',

                // Stock Type
                'stock-type'      => 'stock-type/index',
                'stock-type-view' => 'stock-type/view',
                'update-stock' => 'stock-type/update-stock',
                'fetch-stock-info' => 'stock-type/fetch-stock-info',

                // User Type
                'user-type'      => 'user-type/index',

                // Employee Types
                'employee-types'      => 'employee-types/index',

                // Wage Type
                'wage-type'      => 'wage-type/index',

                // Allowance Type
                'allowance-type'      => 'allowance-type/index',
                'customer-detail-view'       =>     'customer/view',
                'customer-update'       =>       'customer/update',
                'customer-vehicles-create'    =>    'customer-vehicles/create',
                'customer-vehicles-update'    =>    'customer-vehicles/update',

                // sale invoice
                'create-sale-invoice'      => 'sale-invoice-head/create-sale-invoice',
                'sale-invoice-view' => 'sale-invoice-head/sale-invoice-view',
                'add-sale-invoice-service' => 'sale-invoice-head/add-sale-invoice-service',
                'add-sale-invoice-stock' => 'sale-invoice-head/add-sale-invoice-stock',
                'customer-invoice-lists' => 'sale-invoice-head/customer-invoice-lists',

                'sale-invoice-view' => 'customer/sale-invoice-view',
                'fetch-info' => 'customer/fetch-info',
                'collect-sale-invoice' => 'customer/collect-sale-invoice',
                'paid-sale-invoice' => 'customer/paid-sale-invoice',
                'update-sale-invoice' => 'customer/update-sale-invoice',
                'credit-sale-invoice' => 'customer/credit-sale-invoice',

                 // Vendor
                'vendor' => 'vendor/index',
                'vendor-update' => 'vendor/update',
                'fetch-vendor-info' => 'vendor/fetch-vendor-info',
                'purchase-invoice-view' => 'vendor/purchase-invoice-view',
                'paid-purchase-invoice' => 'vendor/paid-purchase-invoice',
                'update-purchase-invoice' => 'vendor/update-purchase-invoice',
                'pay-purchase-invoice' => 'vendor/pay-purchase-invoice',
                'credit-purchase-invoice' => 'vendor/credit-purchase-invoice',
                'credit-purchase-invoice' => 'site/credit-purchase-invoice',





            ],
        ],
    ],
    'params' => $params,
];


