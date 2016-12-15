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
$route['default_controller'] = 'home';


$route['^(\w{2})$'] = $route['default_controller'];

//Ajax called
$route['convertCurrency'] = 'admin/convertCurrency';
$route['removeImage'] = 'admin/removeImage';
$route['(\w{2})/convertCurrency'] = 'admin/convertCurrency';
$route['changeOrderStatus'] = 'admin/changeOrderStatus';
$route['(\w{2})/changeOrderStatus'] = 'admin/changeOrderStatus';
$route['changePageStatus'] = 'admin/changePageStatus';
$route['(\w{2})/changePageStatus'] = 'admin/changePageStatus';
$route['manageShoppingCart'] = 'home/manageShoppingCart';
$route['(\w{2})/manageShoppingCart'] = 'home/manageShoppingCart';
$route['clearShoppingCart'] = 'home/clearShoppingCart';
$route['(\w{2})/clearShoppingCart'] = 'home/clearShoppingCart';

$route[rawurlencode('home') . '/(:num)'] = "home/index/$1";

$route['loadlanguage/(:any)'] = "Loader/jsFile/$1";
$route['cssloader/(:any)'] = "Loader/cssStyle";

// Template Routes
$template = $this->config->item('template');
$route['template/imgs/(:any)'] = "Loader/templateCssImage/$template/$1";
$route['templatecss/imgs/(:any)'] = "Loader/templateCssImage/$template/$1";
$route['templatecss/(:any)'] = "Loader/templateCss/$template/$1";
$route['templatejs/(:any)'] = "Loader/templateJs/$template/$1";

$route['(:any)_(:num)'] = "home/viewProduct/$2";
$route['(\w{2})/(:any)_(:num)'] = "home/viewProduct/$3";
$route['shop-product_(:num)'] = "home/viewProduct/$3";

$route['blog/(:num)'] = "blog/index/$1";
$route['blog/(:any)_(:num)'] = "blog/viewPost/$2";
$route['(\w{2})/blog/(:any)_(:num)'] = "blog/viewPost/$3";

$route['shopping-cart'] = "ShoppingCartPage";
$route['(\w{2})/shopping-cart'] = "ShoppingCartPage";

$route['page/(:any)'] = "page/index/$1";
$route['(\w{2})/page/(:any)'] = "page/index/$2";

$route['^(\w{2})/(.*)$'] = '$2';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
