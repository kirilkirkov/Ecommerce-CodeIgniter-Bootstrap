<p align="center"><img src="https://cdn.worldvectorlogo.com/logos/codeigniter-1.svg" width="100"></p>
<p align="center">Shopping Cart Solution - CodeIgniter and Bootstrap</p>
 
## Bootsrap Responsive Multi-Vendor, MultiLanguage Online Shop Platform

Current versions:

* Codeigniter 3.1.11
* Bootstrap 3.3.7

## Donate
If this project help you reduce time to develop, you can give me a cup of coffee to continue its development. Thank you! :)
[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=W5BR6K29BQX7E)

## Support of following features

1. Multi-Vendor
2. MultiLanguage
3. Virtual products support
4. Multi Templates support
5. API
6. Beautiful administration with high level of access
7. Ajax based shopping cart
8. Checkouts are saved to administration, email notifications for every new order
9. Quantity of products managed from orders
10. Add textual pages
11. Activate and disable pages
12. File manager in administration
13. Integrated blog
14. Email subscribe
15. Easy installation
16. Readable source
17. Complete editing of public texts
18. Receive ![alt text](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/paypalLogo.png "Logo Title Text 1") payments, also have option for paypal sandbox testing
19. Fast-loading templates for good seo
20. Site color change with easy to use gradient generator
21. Add multilanguage cookie notificator from silktide.com for EU Cookie Law 
22. Multiple templates.. also can easy create your own.. 
23. Bank account payments support
24. Highcharts statistics for orders
25. Discount codes
26. Available on English, Greek, Bulgarian
27. Responsive public pages, responsive administration, responsive vendor pages
28. Advanced search with treeView categories
29. Easy manage of products (new filed for every added language, subcategories are easy to manage)
30. Advanced sorting and order products
31. etc.

## Easy installation in 3 steps
1. Import database.sql to your mysql
2. Set hostname, username and password in application/config/database.php
3. Set your site domain in application/config/config.php - $config['base_url'] = 'http://yourdomain.com';
4. Opss I forgot for last 4 step... ENJOY! ;)

Little explanation about the installation - if you paste installation of project in directory something like http://localhost/SHOP, you must 
set this directory to application/config/config.php - $config['base_url'] = 'http://localhost/SHOP'; and must remove from .htaccess file
"RewriteBase /" line because css and js files will not be loaded! But you must know that the best way to install this platform is to set it
in root http://localhost directory or if you want to be in other directory just set virtual host for this and point him to there.
(example: http://shop.dev - point to localhost/shop directory). How to create virtual hosts you can read here: http://goo.gl/UvpYMG

## Login to administration with
User: admin, 
Pass: admin

## Vendors support
Login url is - vendor/login. Vendors are not supported only from "onepage" template.
Can register new vendor from url - vendor/register. 
Vendors must be enabled from /admin (administration) ->Settings->Multi-Vendor Support.

## Users registration
Users registration/login is added only in greenlabel template. (easily can be added to any other template, just copy files: login.php, signup.php, user.php and change your design).
Users can track their orders history only.

## Screenshots of public pages
![alt text](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/templates.png "Logo Title Text 1")

## Screenshots of vendors pages
![alt text](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/vendors_pages.jpg "Logo Title Text 1")

## Screenshot of admin panel
![alt text](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/admin_panel4.png "Logo Title Text 1")

### How To Write Templates
Read in our wiki - https://github.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/wiki/How-to-write-templates

### Shopping cart peculiarities
Read in our wiki - https://github.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/wiki/Shopping-cart-peculiarities

### Multi Vendor Support
Read in our wiki - https://github.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/wiki/Multi-Vendor-Support

### API Documentation
Read in our wiki - https://github.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/wiki/API
