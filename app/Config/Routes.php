<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->add('dbtest', 'DatabaseTest::index');
$routes->get('fetch-data', 'BillingSummary::index');
$routes->get('fetch-trend', 'PaymentTrend::index');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/getPurokSummary/(:segment)', 'Dashboard::getPurokSummary/$1');
$routes->get('dashboard/getPaymentTrends/(:segment)', 'Dashboard::getPaymentTrends/$1');
$routes->get('/test', 'Test::index'); // This will load the view (test.php)
$routes->get('BillingSummary/index', 'BillingSummary::index');
$routes->get('Purok/getPaymentByPurok/(:segment)', 'Purok::getPaymentByPurok/$1');

$routes->get('fetch_trend_data', 'DashboardController::getTrendData');
$routes->get('fetch_data', 'DashboardController::getMonthlySummary');


$routes->get('water_billing_view', 'WaterBilling::index');