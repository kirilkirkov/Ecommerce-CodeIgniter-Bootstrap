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

// Load default conrtoller when have only currency from multilanguage
$route['^(\w{2})$'] = $route['default_controller'];

//Checkout
$route['(\w{2})?/?checkout/successcash'] = 'checkout/successPaymentCashOnD';
$route['(\w{2})?/?checkout/successbank'] = 'checkout/successPaymentBank';
$route['(\w{2})?/?checkout/paypalpayment'] = 'checkout/paypalPayment';
$route['(\w{2})?/?checkout/order-error'] = 'checkout/orderError';

// Ajax called. Functions for managing shopping cart
$route['(\w{2})?/?manageShoppingCart'] = 'home/manageShoppingCart';
$route['(\w{2})?/?clearShoppingCart'] = 'home/clearShoppingCart';
$route['(\w{2})?/?discountCodeChecker'] = 'home/discountCodeChecker';

// home page pagination
$route[rawurlencode('home') . '/(:num)'] = "home/index/$1";
// load javascript language file
$route['loadlanguage/(:any)'] = "Loader/jsFile/$1";
// load default-gradient css
$route['cssloader/(:any)'] = "Loader/cssStyle";

// Template Routes
$route['template/imgs/(:any)'] = "Loader/templateCssImage/$1";
$route['templatecss/imgs/(:any)'] = "Loader/templateCssImage/$1";
$route['templatecss/(:any)'] = "Loader/templateCss/$1";
$route['templatejs/(:any)'] = "Loader/templateJs/$1";

// Products urls style
$route['(:any)_(:num)'] = "home/viewProduct/$2";
$route['(\w{2})/(:any)_(:num)'] = "home/viewProduct/$3";
$route['shop-product_(:num)'] = "home/viewProduct/$3";

// blog urls style and pagination
$route['blog/(:num)'] = "blog/index/$1";
$route['blog/(:any)_(:num)'] = "blog/viewPost/$2";
$route['(\w{2})/blog/(:any)_(:num)'] = "blog/viewPost/$3";

// Shopping cart page
$route['shopping-cart'] = "ShoppingCartPage";
$route['(\w{2})/shopping-cart'] = "ShoppingCartPage";

// Shop page (greenlabel template)
$route['shop'] = "home/shop";
$route['(\w{2})/shop'] = "home/shop";

// Textual Pages links
$route['page/(:any)'] = "page/index/$1";
$route['(\w{2})/page/(:any)'] = "page/index/$2";

// Login Public Users Page
$route['login'] = "Users/login";
$route['(\w{2})/login'] = "Users/login";

// Register Public Users Page
$route['register'] = "Users/register";
$route['(\w{2})/register'] = "Users/register";

// Users Profiles Public Users Page
$route['myaccount'] = "Users/myaccount";
$route['(\w{2})/myaccount'] = "Users/myaccount";

// Logout Profiles Public Users Page
$route['logout'] = "Users/logout";
$route['(\w{2})/logout'] = "Users/logout";

$route['sitemap.xml'] = "home/sitemap";

// Confirm link
$route['confirm/(:any)'] = "home/confirmLink/$1";

/*
 * Vendor Controllers Routes
 */
$route['vendor/login'] = "vendor/auth/login";
$route['(\w{2})/vendor/login'] = "vendor/auth/login";
$route['vendor/register'] = "vendor/auth/register";
$route['(\w{2})/vendor/register'] = "vendor/auth/register";
$route['vendor/forgotten-password'] = "vendor/auth/forgotten";
$route['(\w{2})/vendor/forgotten-password'] = "vendor/auth/forgotten";
$route['vendor/me'] = "vendor/VendorProfile";
$route['(\w{2})/vendor/me'] = "vendor/VendorProfile";
$route['vendor/logout'] = "vendor/VendorProfile/logout";
$route['(\w{2})/vendor/logout'] = "vendor/VendorProfile/logout";
$route['vendor/products'] = "vendor/Products";
$route['(\w{2})/vendor/products'] = "vendor/Products";
$route['vendor/products/(:num)'] = "vendor/Products/index/$1";
$route['(\w{2})/vendor/products/(:num)'] = "vendor/Products/index/$2";
$route['vendor/add/product'] = "vendor/AddProduct";
$route['(\w{2})/vendor/add/product'] = "vendor/AddProduct";
$route['vendor/edit/product/(:num)'] = "vendor/AddProduct/index/$1";
$route['(\w{2})/vendor/edit/product/(:num)'] = "vendor/AddProduct/index/$1";
$route['vendor/orders'] = "vendor/Orders";
$route['(\w{2})/vendor/orders'] = "vendor/Orders";
$route['vendor/uploadOthersImages'] = "vendor/AddProduct/do_upload_others_images";
$route['vendor/loadOthersImages'] = "vendor/AddProduct/loadOthersImages";
$route['vendor/removeSecondaryImage'] = "vendor/AddProduct/removeSecondaryImage";
$route['vendor/delete/product/(:num)'] = "vendor/products/deleteProduct/$1";
$route['(\w{2})/vendor/delete/product/(:num)'] = "vendor/products/deleteProduct/$1";
$route['vendor/view/(:any)'] = "Vendor/index/0/$1";
$route['(\w{2})/vendor/view/(:any)'] = "Vendor/index/0/$2";
$route['vendor/view/(:any)/(:num)'] = "Vendor/index/$2/$1";
$route['(\w{2})/vendor/view/(:any)/(:num)'] = "Vendor/index/$3/$2";
$route['(:any)/(:any)_(:num)'] = "Vendor/viewProduct/$1/$3";
$route['(\w{2})/(:any)/(:any)_(:num)'] = "Vendor/viewProduct/$2/$4";
$route['vendor/changeOrderStatus'] = "vendor/orders/changeOrdersOrderStatus";

// Site Multilanguage
$route['^(\w{2})/(.*)$'] = '$2';

/*
 * Admin Controllers Routes
 */
// HOME / LOGIN
$route['admin'] = "admin/home/login";
// ECOMMERCE GROUP
$route['admin/publish'] = "admin/ecommerce/publish";
$route['admin/publish/(:num)'] = "admin/ecommerce/publish/index/$1";
$route['admin/removeSecondaryImage'] = "admin/ecommerce/publish/removeSecondaryImage";
$route['admin/convertCurrency'] = "admin/ecommerce/publish/convertCurrency";
$route['admin/products'] = "admin/ecommerce/products";
$route['admin/products/(:num)'] = "admin/ecommerce/products/index/$1";
$route['admin/productStatusChange'] = "admin/ecommerce/products/productStatusChange";
$route['admin/shopcategories'] = "admin/ecommerce/ShopCategories";
$route['admin/shopcategories/(:num)'] = "admin/ecommerce/ShopCategories/index/$1";
$route['admin/editshopcategorie'] = "admin/ecommerce/ShopCategories/editShopCategorie";
$route['admin/orders'] = "admin/ecommerce/orders";
$route['admin/orders/(:num)'] = "admin/ecommerce/orders/index/$1";
$route['admin/changeOrdersOrderStatus'] = "admin/ecommerce/orders/changeOrdersOrderStatus";
$route['admin/brands'] = "admin/ecommerce/brands";
$route['admin/changePosition'] = "admin/ecommerce/ShopCategories/changePosition";
$route['admin/discounts'] = "admin/ecommerce/discounts";
$route['admin/discounts/(:num)'] = "admin/ecommerce/discounts/index/$1";
// BLOG GROUP
$route['admin/blogpublish'] = "admin/blog/BlogPublish";
$route['admin/blogpublish/(:num)'] = "admin/blog/BlogPublish/index/$1";
$route['admin/blog'] = "admin/blog/blog";
$route['admin/blog/(:num)'] = "admin/blog/blog/index/$1";
// SETTINGS GROUP
$route['admin/settings'] = "admin/settings/settings";
$route['admin/styling'] = "admin/settings/styling";
$route['admin/templates'] = "admin/settings/templates";
$route['admin/titles'] = "admin/settings/titles";
$route['admin/pages'] = "admin/settings/pages";
$route['admin/emails'] = "admin/settings/emails";
$route['admin/emails/(:num)'] = "admin/settings/emails/index/$1";
$route['admin/history'] = "admin/settings/history";
$route['admin/history/(:num)'] = "admin/settings/history/index/$1";
// ADVANCED SETTINGS
$route['admin/languages'] = "admin/advanced_settings/languages";
$route['admin/filemanager'] = "admin/advanced_settings/filemanager";
$route['admin/adminusers'] = "admin/advanced_settings/adminusers";
// TEXTUAL PAGES
$route['admin/pageedit/(:any)'] = "admin/textual_pages/TextualPages/pageEdit/$1";
$route['admin/changePageStatus'] = "admin/textual_pages/TextualPages/changePageStatus";
// LOGOUT
$route['admin/logout'] = "admin/home/home/logout";
// Admin pass change ajax
$route['admin/changePass'] = "admin/home/home/changePass";
$route['admin/uploadOthersImages'] = "admin/ecommerce/publish/do_upload_others_images";
$route['admin/loadOthersImages'] = "admin/ecommerce/publish/loadOthersImages";

/*
  | -------------------------------------------------------------------------
  | Sample REST API Routes
  | -------------------------------------------------------------------------
 */
$route['api/products/(\w{2})/get'] = 'Api/Products/all/$1';
$route['api/product/(\w{2})/(:num)/get'] = 'Api/Products/one/$1/$2';
$route['api/product/set'] = 'Api/Products/set';
$route['api/product/(\w{2})/delete'] = 'Api/Products/productDel/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
