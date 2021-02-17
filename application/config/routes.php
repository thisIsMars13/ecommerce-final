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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'indexes';
$route['signin'] = 'users_ctrl/users/signin_page';
$route['register'] = 'users_ctrl/users/register_page';
$route['logoff'] = 'indexes/logoff';
$route['cart'] = 'normal/carts/cart';
$route['signin_process'] = 'users_ctrl/users/signin_process';
$route['register_process'] = 'users_ctrl/users/register_process';


$route['dashboards/orders'] = 'admin/dashboards/orders';
$route['dashboards/orders_load'] = 'admin/dashboards/orders_load';
$route['dashboards/update_status/(:any)'] = 'admin/dashboards/update_status/$1';
$route['dashboards/order_details/(:any)'] = 'admin/dashboards/order_details/$1';
$route['dashboards/order_details_load/(:any)'] = 'admin/dashboards/order_details_load/$1';
$route['dashboards/get_orders_by_filter'] = 'admin/dashboards/get_orders_by_filter';


$route['dashboards/products/(:any)'] = 'admin/dashboards/products/$1';
$route['dashboards/add_products'] = 'admin/dashboards/add_products';
$route['dashboards/update_category'] = 'admin/dashboards/update_category';
$route['dashboards/load_edit_form/(:any)'] = 'admin/dashboards/load_edit_form/$1';
$route['dashboards/load_add_form'] = 'admin/dashboards/load_add_form';
$route['dashboards/organize_img/(:any)'] = 'admin/dashboards/organize_img/$1';
$route['dashboards/edit_products/(:any)'] = 'admin/dashboards/edit_products/$1';
$route['dashboards/get_products_by_filter'] = 'admin/dashboards/get_products_by_filter';
$route['dashboards/delete_image/(:any)/(:any)'] = 'admin/dashboards/delete_image/$1/$2';
$route['dashboards/delete_product/(:any)'] = 'admin/dashboards/delete_product/$1';
$route['dashboards/load_questions'] = 'admin/dashboards/load_questions';
$route['dashboards/answer/(:any)'] = 'admin/dashboards/answer/$1';


$route['products'] = 'normal/products';
$route['products/catalog_load'] = 'normal/products/catalog_load';
$route['products/search'] = 'normal/products/search';
$route['products/show/(:any)'] = 'normal/products/show/$1';
$route['products/show_load/(:any)'] = 'normal/products/show_load/$1';
$route['products/add_cart'] = 'normal/products/add_cart';

$route['questions/ask_question/(:any)'] = 'normal/questions/ask_question/$1';

$route['profiles/settings_page'] = 'normal/profiles/settings_page';
$route['profiles/settings_page_load'] = 'normal/profiles/settings_page_load';
$route['profiles/update_password'] = 'normal/profiles/update_password';
$route['profiles/update_default_shipping'] = 'normal/profiles/update_default_shipping';
$route['profiles/update_default_billing'] = 'normal/profiles/update_default_billing';

$route['carts/update_quantity'] = 'normal/carts/update_quantity';
$route['carts/delete'] = 'normal/carts/delete';
$route['carts/cart_load'] = 'normal/carts/cart_load';

$route['orders/process_order'] = 'normal/orders/process_order';
$route['orders/orders_history'] = 'normal/orders/orders_history';
$route['orders/orders_history_load'] = 'normal/orders/orders_history_load'; 
$route['orders/order_details/(:any)'] = 'normal/orders/order_details/$1';
$route['orders/order_details_load/(:any)'] = 'normal/orders/order_details_load/$1';
$route['orders/load_form_review/(:any)'] = 'normal/orders/load_form_review/$1';
$route['orders/add_review/(:any)/(:any)'] = 'normal/orders/add_review/$1/$2';
$route['orders/done_review/(:any)'] = 'normal/orders/done_review/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;