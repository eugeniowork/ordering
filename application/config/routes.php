<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

//FOR VERIFICATION RELATED
$route['verify-account/(:any)'] = 'verification/verifyAccountPage/$1';

//FOR LOGIN RELATED
$route['login'] = 'login/loginPage';

//FOR DASHBOARD RELATED
$route['dashboard'] = 'dashboard/dashboardPage';

//FOR ORDERS RELATED
$route['my-orders'] = 'order/myOrdersPage';
$route['ongoing-orders'] = 'order/ongoingOrdersPage';
$route['ongoing-orders-view/(:any)'] = 'order/ongoingOrdersView/$1';
$route['order-payment/(:any)'] = 'order/orderPaymentPage/$1';
$route['order-payment-successful/(:any)'] = 'order/orderPaymentSuccessfulPage/$1';
$route['order-receipt-pdf/(:any)'] = 'order/orderReceiptPdf/$1';

//FOR USER RELATED
$route['my-profile'] = 'user/myProfilePage';

//FOR WALLET RELATED
$route['my-wallet'] = 'wallet/myWalletPage';
$route['cash-in'] = 'wallet/cashInPage';
$route['cash-in-view/(:any)'] = 'wallet/cashInView/$1';
$route['cash-in-successful/(:any)'] = 'wallet/cashInSuccessfulPage/$1';
$route['cash-in-receipt-pdf/(:any)'] = 'wallet/cashInReceiptPdf/$1';

//FOR PRODUCT RELATED
$route['product'] = 'product/productPage';
$route['product-add'] = 'product/productAddPage';

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
