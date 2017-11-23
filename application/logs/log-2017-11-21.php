<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-11-21 09:12:47 --> 404 Page Not Found: /index
ERROR - 2017-11-21 09:12:55 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 09:17:14 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 09:28:34 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 09:51:38 --> 404 Page Not Found: /index
ERROR - 2017-11-21 09:57:33 --> 404 Page Not Found: /index
ERROR - 2017-11-21 10:09:47 --> 404 Page Not Found: ../modules/vendor/controllers/Products/1
ERROR - 2017-11-21 10:32:49 --> 404 Page Not Found: ../modules/vendor/controllers//index
ERROR - 2017-11-21 10:32:51 --> 404 Page Not Found: ../modules/vendor/controllers//index
ERROR - 2017-11-21 10:32:57 --> 404 Page Not Found: ../modules/vendor/controllers//index
ERROR - 2017-11-21 10:33:17 --> 404 Page Not Found: ../modules/vendor/controllers//index
ERROR - 2017-11-21 10:33:20 --> 404 Page Not Found: ../modules/vendor/controllers//index
ERROR - 2017-11-21 10:33:35 --> 404 Page Not Found: ../modules/vendor/controllers//index
ERROR - 2017-11-21 10:33:42 --> Severity: Notice --> Undefined property: CI::$Brands_model /var/www/html/shop/application/third_party/MX/Controller.php 59
ERROR - 2017-11-21 10:33:42 --> Severity: error --> Exception: Call to a member function getBrands() on null /var/www/html/shop/application/controllers/Vendor.php 54
ERROR - 2017-11-21 10:45:14 --> 404 Page Not Found: ../modules/vendor/controllers//index
ERROR - 2017-11-21 10:45:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 10:49:37 --> Severity: Notice --> Undefined variable: data /var/www/html/shop/application/controllers/Vendor.php 19
ERROR - 2017-11-21 10:49:37 --> Severity: error --> Exception: Cannot access empty property /var/www/html/shop/application/controllers/Vendor.php 19
ERROR - 2017-11-21 10:50:09 --> 404 Page Not Found: 
ERROR - 2017-11-21 11:24:56 --> Could not find the language line ""
ERROR - 2017-11-21 11:25:46 --> Severity: Notice --> Undefined variable: arrSeo /var/www/html/shop/application/controllers/Vendor.php 26
ERROR - 2017-11-21 11:25:48 --> Severity: Notice --> Undefined variable: arrSeo /var/www/html/shop/application/controllers/Vendor.php 26
ERROR - 2017-11-21 11:28:23 --> Severity: Notice --> Undefined variable: sliderProducts /var/www/html/shop/application/views/templates/redlabel/home.php 3
ERROR - 2017-11-21 11:28:23 --> Severity: Notice --> Undefined variable: showBrands /var/www/html/shop/application/views/templates/redlabel/home.php 124
ERROR - 2017-11-21 11:28:23 --> Severity: Notice --> Undefined variable: showOutOfStock /var/www/html/shop/application/views/templates/redlabel/home.php 140
ERROR - 2017-11-21 11:28:23 --> Severity: Notice --> Undefined variable: shippingOrder /var/www/html/shop/application/views/templates/redlabel/home.php 157
ERROR - 2017-11-21 11:28:24 --> Severity: Notice --> Undefined variable: sliderProducts /var/www/html/shop/application/views/templates/redlabel/home.php 3
ERROR - 2017-11-21 11:28:24 --> Severity: Notice --> Undefined variable: showBrands /var/www/html/shop/application/views/templates/redlabel/home.php 124
ERROR - 2017-11-21 11:28:24 --> Severity: Notice --> Undefined variable: showOutOfStock /var/www/html/shop/application/views/templates/redlabel/home.php 140
ERROR - 2017-11-21 11:28:24 --> Severity: Notice --> Undefined variable: shippingOrder /var/www/html/shop/application/views/templates/redlabel/home.php 157
ERROR - 2017-11-21 11:29:30 --> Severity: Notice --> Undefined variable: showBrands /var/www/html/shop/application/views/templates/redlabel/vendor.php 65
ERROR - 2017-11-21 11:29:30 --> Severity: Notice --> Undefined variable: showOutOfStock /var/www/html/shop/application/views/templates/redlabel/vendor.php 81
ERROR - 2017-11-21 11:29:30 --> Severity: Notice --> Undefined variable: shippingOrder /var/www/html/shop/application/views/templates/redlabel/vendor.php 98
ERROR - 2017-11-21 11:29:59 --> Severity: Notice --> Undefined variable: shippingOrder /var/www/html/shop/application/views/templates/redlabel/vendor.php 65
ERROR - 2017-11-21 11:32:36 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:34:19 --> Query error: Unknown column 'visibility' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `visibility` = 1
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:35 --> Query error: Unknown column 'visibility' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `visibility` = 1
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:36 --> Query error: Unknown column 'visibility' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `visibility` = 1
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:36 --> Query error: Unknown column 'visibility' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `visibility` = 1
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:37 --> Query error: Unknown column 'visibility' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `visibility` = 1
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:37 --> Query error: Unknown column 'visibility' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `visibility` = 1
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:37 --> Query error: Unknown column 'visibility' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `visibility` = 1
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:37 --> Query error: Unknown column 'visibility' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `visibility` = 1
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:42 --> Query error: Unknown column 'in_slider' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:43 --> Query error: Unknown column 'in_slider' in 'where clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
AND `in_slider` =0
ORDER BY `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:34:55 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:34:56 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:34:56 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:34:56 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:36:09 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:36:09 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:36:09 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:36:09 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:40:00 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:40:00 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:11 --> Severity: Notice --> Use of undefined constant vendor_url - assumed 'vendor_url' /var/www/html/shop/application/views/templates/redlabel/_parts/header.php 99
ERROR - 2017-11-21 11:48:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:12 --> Severity: Notice --> Use of undefined constant vendor_url - assumed 'vendor_url' /var/www/html/shop/application/views/templates/redlabel/_parts/header.php 99
ERROR - 2017-11-21 11:48:12 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:12 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:12 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:12 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:34 --> Severity: Notice --> Use of undefined constant vendor_url - assumed 'vendor_url' /var/www/html/shop/application/views/templates/redlabel/_parts/header.php 99
ERROR - 2017-11-21 11:48:34 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:34 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:34 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:48:34 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:49:20 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:49:20 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:49:20 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:49:20 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:49:43 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:49:43 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:49:43 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:49:43 --> 404 Page Not Found: /index
ERROR - 2017-11-21 11:49:48 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:01 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:02 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:02 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:02 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:02 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:03 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:03 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:03 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:03 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:03 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:03 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:04 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:08 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 11:52:10 --> Query error: Unknown column 'products.id' in 'order clause' - Invalid query: SELECT `vendors_products`.`id`, `vendors_products`.`image`, `vendors_products`.`quantity`, `vendors_products_translations`.`title`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
WHERE `vendors_products_translations`.`abbr` = 'en'
AND `quantity` >0
ORDER BY CAST(price AS DECIMAL(10.2)) desc, `products`.`id` DESC, `position` ASC
 LIMIT 20
ERROR - 2017-11-21 12:20:05 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:20:05 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:20:08 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:20:08 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:20:08 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:20:09 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:20:09 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:20:09 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:20:09 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:21:45 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:21:45 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:21:52 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:21:52 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:21:52 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:21:52 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:22 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:22 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:22 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:22 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:45 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:46 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:46 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:49 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:22:49 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:23:01 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:23:02 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:23:03 --> 404 Page Not Found: ../modules/vendor/controllers//index
ERROR - 2017-11-21 12:23:35 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:23:36 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:23:36 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:23:36 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:23:36 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:23:37 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:24:05 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:05 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:07 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:07 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:21 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:22 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:22 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:24 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:24 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:25 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:25 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:51 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:24:51 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:25:00 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:25:00 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:25:01 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:25:01 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:27:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:27:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:27:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:27:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:27:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:27:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:27:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:27:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:34 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:34 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:34 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:34 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:36 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:36 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:36 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:36 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:28:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:30 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:30 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:30 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:30 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:33 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:33 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:33 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:33 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:45 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:45 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:45 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:45 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:48 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:48 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:48 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:29:48 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:33:55 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:33:55 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:33:55 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:33:55 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:35:50 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:36:25 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:39:23 --> Query error: Unknown column 'visibility' in 'where clause' - Invalid query: SELECT `vendors_products`.*, `vendors_products_translations`.`title`, `vendors_products_translations`.`description`, `vendors_products_translations`.`price`, `vendors_products_translations`.`old_price`, `vendors_products`.`url`, `shop_categories_translations`.`name` as `categorie_name`
FROM `vendors_products`
LEFT JOIN `vendors_products_translations` ON `vendors_products_translations`.`for_id` = `vendors_products`.`id`
INNER JOIN `shop_categories_translations` ON `shop_categories_translations`.`for_id` = `vendors_products`.`shop_categorie`
WHERE `vendors_products`.`id` = '2'
AND `vendors_products_translations`.`abbr` = 'bg'
AND `shop_categories_translations`.`abbr` = 'bg'
AND `visibility` = 1
ERROR - 2017-11-21 12:39:28 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:39:28 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:39:42 --> Image Upload Error: <p>You did not select a file to upload.</p>
ERROR - 2017-11-21 12:39:43 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:39:43 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:39:45 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:39:45 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:39:49 --> Image Upload Error: <p>You did not select a file to upload.</p>
ERROR - 2017-11-21 12:39:49 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:39:50 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:39:58 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:39:58 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:40:03 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:40:03 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:41:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:41:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:41:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:41:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:41:44 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:41:44 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:41:44 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:41:44 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:07 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:07 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:07 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:07 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:09 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:42:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:12 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:42:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:30 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:30 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:30 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:30 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:49 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:49 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:49 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:49 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:42:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:43:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:43:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:43:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:43:11 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:44:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:44:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:44:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:44:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:44:35 --> Could not find the language line "vendor"
ERROR - 2017-11-21 12:44:35 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:44:35 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:44:35 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:44:35 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:45:16 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:45:16 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:45:16 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:45:16 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:46:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:46:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:46:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:46:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:46:35 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:46:35 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:46:35 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:46:35 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:46:37 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:46:41 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:46:41 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:46:41 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:46:56 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:46:57 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:46:57 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:46:57 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:47:10 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:47:10 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:47:10 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:47:10 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:47:13 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:47:15 --> 404 Page Not Found: 
ERROR - 2017-11-21 12:47:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:47:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:47:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:47:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:18 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:20 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:20 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:20 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:20 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:23 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:41 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:41 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:41 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:41 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:52 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:52 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:48:53 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:19 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:19 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:19 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:19 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:38 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:38 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:38 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:38 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:39 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:39 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:39 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:49:39 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:50:13 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:50:13 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:50:16 --> 404 Page Not Found: /index
ERROR - 2017-11-21 12:50:16 --> 404 Page Not Found: /index
ERROR - 2017-11-21 16:15:11 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 16:21:31 --> Query error: Unknown column 'vendor_id' in 'field list' - Invalid query: INSERT INTO `products` (`image`, `shop_categorie`, `quantity`, `position`, `folder`, `vendor_id`, `time`) VALUES ('21192714_1575243769163183_2416063920923011951_n.jpg', '22', '3', '2', '1511273712', '1', 1511274091)
ERROR - 2017-11-21 16:22:09 --> Query error: Unknown column 'products_translations.position' in 'order clause' - Invalid query: SELECT `products`.*, `products_translations`.`title`, `products_translations`.`description`, `products_translations`.`price`
FROM `products`
LEFT JOIN `products_translations` ON `products_translations`.`for_id` = `products`.`id`
WHERE `products_translations`.`abbr` = 'en'
ORDER BY `products_translations`.`position` ASC
 LIMIT 20
ERROR - 2017-11-21 16:25:39 --> 404 Page Not Found: /index
ERROR - 2017-11-21 16:38:36 --> 404 Page Not Found: 
ERROR - 2017-11-21 16:41:21 --> Image Upload Error: <p>You did not select a file to upload.</p>
ERROR - 2017-11-21 16:41:21 --> Severity: Notice --> Undefined index: virtual_products /var/www/html/shop/application/modules/admin/models/Products_model.php 128
ERROR - 2017-11-21 16:41:35 --> Image Upload Error: <p>You did not select a file to upload.</p>
ERROR - 2017-11-21 16:41:35 --> Severity: Notice --> Undefined index: old_image /var/www/html/shop/application/modules/admin/models/Products_model.php 98
ERROR - 2017-11-21 16:41:35 --> Severity: Notice --> Undefined index: virtual_products /var/www/html/shop/application/modules/admin/models/Products_model.php 103
ERROR - 2017-11-21 16:43:41 --> Severity: error --> Exception: Call to undefined method Public_model::getOneVendorProduct() /var/www/html/shop/application/controllers/Vendor.php 69
ERROR - 2017-11-21 16:43:54 --> Severity: error --> Exception: Call to undefined method Public_model::sameCagegoryVendorProducts() /var/www/html/shop/application/controllers/Vendor.php 70
ERROR - 2017-11-21 16:43:55 --> Severity: error --> Exception: Call to undefined method Public_model::sameCagegoryVendorProducts() /var/www/html/shop/application/controllers/Vendor.php 70
ERROR - 2017-11-21 16:43:55 --> Severity: error --> Exception: Call to undefined method Public_model::sameCagegoryVendorProducts() /var/www/html/shop/application/controllers/Vendor.php 70
ERROR - 2017-11-21 16:43:55 --> Severity: error --> Exception: Call to undefined method Public_model::sameCagegoryVendorProducts() /var/www/html/shop/application/controllers/Vendor.php 70
ERROR - 2017-11-21 16:43:55 --> Severity: error --> Exception: Call to undefined method Public_model::sameCagegoryVendorProducts() /var/www/html/shop/application/controllers/Vendor.php 70
ERROR - 2017-11-21 16:44:01 --> Severity: Notice --> Undefined index: vendor_url /var/www/html/shop/application/libraries/Loop.php 110
ERROR - 2017-11-21 16:44:01 --> Severity: Notice --> Undefined index: vendor_url /var/www/html/shop/application/libraries/Loop.php 115
ERROR - 2017-11-21 16:44:14 --> 404 Page Not Found: /index
ERROR - 2017-11-21 16:44:27 --> Severity: Notice --> Undefined index: vendor_url /var/www/html/shop/application/libraries/Loop.php 110
ERROR - 2017-11-21 16:44:27 --> Severity: Notice --> Undefined index: vendor_url /var/www/html/shop/application/libraries/Loop.php 115
ERROR - 2017-11-21 16:44:27 --> Severity: Notice --> Undefined index: vendor_url /var/www/html/shop/application/libraries/Loop.php 110
ERROR - 2017-11-21 16:44:27 --> Severity: Notice --> Undefined index: vendor_url /var/www/html/shop/application/libraries/Loop.php 115
ERROR - 2017-11-21 16:44:28 --> 404 Page Not Found: /index
ERROR - 2017-11-21 16:44:32 --> Severity: Notice --> Undefined index: vendor_url /var/www/html/shop/application/libraries/Loop.php 110
ERROR - 2017-11-21 16:44:32 --> Severity: Notice --> Undefined index: vendor_url /var/www/html/shop/application/libraries/Loop.php 115
ERROR - 2017-11-21 16:44:40 --> 404 Page Not Found: /index
ERROR - 2017-11-21 16:46:50 --> 404 Page Not Found: /index
ERROR - 2017-11-21 16:54:37 --> Mailer Error: Could not instantiate mail function.
ERROR - 2017-11-21 17:01:58 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:02:13 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:04:08 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:12:52 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:13:55 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:22:47 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:22:47 --> Could not find the language line "vendor_name"
ERROR - 2017-11-21 17:22:47 --> Could not find the language line "vendor_url"
ERROR - 2017-11-21 17:23:22 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:23:22 --> Could not find the language line "vendor_name"
ERROR - 2017-11-21 17:23:22 --> Could not find the language line "vendor_url"
ERROR - 2017-11-21 17:23:26 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:23:26 --> Could not find the language line "vendor_name"
ERROR - 2017-11-21 17:23:26 --> Could not find the language line "vendor_url"
ERROR - 2017-11-21 17:23:38 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:23:38 --> Could not find the language line "vendor_name"
ERROR - 2017-11-21 17:23:38 --> Could not find the language line "vendor_url"
ERROR - 2017-11-21 17:23:53 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:23:53 --> Could not find the language line "vendor_name"
ERROR - 2017-11-21 17:23:53 --> Could not find the language line "vendor_url"
ERROR - 2017-11-21 17:23:57 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:24:09 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:24:09 --> Could not find the language line "vendor_name"
ERROR - 2017-11-21 17:24:09 --> Could not find the language line "vendor_url"
ERROR - 2017-11-21 17:24:10 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:25:03 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:25:03 --> Could not find the language line "vendor_url"
ERROR - 2017-11-21 17:25:04 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:25:40 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:25:41 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:26:10 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:26:10 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:27:14 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:28:03 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:28:22 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:29:43 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:29:55 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:29:56 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:30:06 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:30:21 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:30:33 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:31:55 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:32:28 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:32:29 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:32:33 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:32:33 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:34:23 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:34:24 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:34:24 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:34:25 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:35:39 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:35:40 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:35:42 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:35:42 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:35:43 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:35:44 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:46:33 --> Severity: error --> Exception: Call to undefined function emtpy() /var/www/html/shop/application/core/VENDOR_Controller.php 78
ERROR - 2017-11-21 17:46:39 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:46:39 --> Severity: Notice --> Array to string conversion /var/www/html/shop/application/modules/vendor/views/_parts/header.php 24
ERROR - 2017-11-21 17:46:43 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:47:06 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:07 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:47:08 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:08 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:47:11 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:13 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:47:27 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:28 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:47:29 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:29 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:47:33 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:55 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:56 --> Severity: Notice --> Undefined property: CI::$registerErrors /var/www/html/shop/application/third_party/MX/Controller.php 59
ERROR - 2017-11-21 17:47:56 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:56 --> Severity: Notice --> Undefined property: CI::$registerErrors /var/www/html/shop/application/third_party/MX/Controller.php 59
ERROR - 2017-11-21 17:47:56 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:57 --> Severity: Notice --> Undefined property: CI::$registerErrors /var/www/html/shop/application/third_party/MX/Controller.php 59
ERROR - 2017-11-21 17:47:57 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:47:59 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:48:10 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:48:11 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:48:13 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:48:14 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:48:17 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:48:19 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:48:21 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:49:44 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:49:45 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:50:40 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:50:40 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:50:42 --> Could not find the language line "vendor_url_taken"
ERROR - 2017-11-21 17:50:42 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:50:43 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:51:16 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:51:16 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:51:16 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:51:17 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:51:17 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:51:18 --> Could not find the language line "vendor_url_taken"
ERROR - 2017-11-21 17:51:18 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:51:19 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:51:21 --> Could not find the language line "vendor_url_taken"
ERROR - 2017-11-21 17:51:21 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:51:40 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:52:23 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:52:24 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:52:24 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:52:25 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:52:29 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:52:30 --> 404 Page Not Found: /index
ERROR - 2017-11-21 17:52:34 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:55:46 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:55:53 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:55:55 --> Could not find the language line "vendor_home_page"
ERROR - 2017-11-21 17:55:55 --> Could not find the language line "vendor_home_page"
