<p align="center"><img src="https://codeigniter.com/assets/images/ci-logo-big.png"></p>
<p align="center">Shopping Cart Solution - CodeIgniter and Bootstrap</p>
 
## Bootsrap Responsive online shop

Current versions:

* Codeigniter 3.1.6
* Bootstrap 3.3.7

## Donate
If this project help you reduce time to develop, you can give me a cup of coffee to continue its development :)
[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=W5BR6K29BQX7E)

## Support of following features

1. Bootstrap responsive
2. MultiLanguage with interface for easy add/edit functionality!!
3. Beautifle design
4. Advanced search with treeView categories
5. Easy manage of products (new filed for every added language, subcategories are easy to manage)
6. Advanced sorting and order products
7. Ajax based shopping cart
8. Checkouts are saved to administration, email notifications for every new order
9. Quantity of products maganed from orders
10. Add textual pages
11. Activate and disable pages
12. File manager in administration
13. Blog integrated
14. Email subscribe
15. Easy installation
16. Easy code change
17. Edit every text from interface..
18. Receive ![alt text](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/paypalLogo.png "Logo Title Text 1") payments, also have option for paypal sandbox testing
19. Fast Loading
20. Site color change with easy to use gradient generator
21. Add multilanguage cookie notificator from silktide.com for EU Cookie Law 
22. Multiple templates.. also can create your own.. 
23. Bank account payments support
24. Highcharts statistics for orders
25. Discount codes
26. and more.. and more.. 

## Easy installation in 3 steps
1. Import dbDump.sql to your mysql
2. Set hostname, username and password in application/config/database.php
3. Set your site domain in application/config/config.php - $config['base_url'] = 'http://yourdomain.com';
4. Opss I forgot for last 4 step... ENJOY! ;)

Little explain for installation - if you paste installation of project in directory something like http://localhost/SHOP, you must 
set this directory to application/config/config.php - $config['base_url'] = 'http://localhost/SHOP'; and must remove from .htaccess file
"RewriteBase /" line because css and js files will not be loaded! But you must know that the best way to install this platform is to set it
in root http://localhost directory or if you want to be in other directory just set virtual host for this and point him to there.
(example: http://shop.dev - point to localhost/shop directory). How to create virtual hosts you can read here: http://goo.gl/UvpYMG

## Login to administration with

* User: admin
* Pass: admin

## Screenshot
![alt text](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/templates.png "Logo Title Text 1")

## Screenshot of admin panel
![alt text](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/admin_panel4.png "Logo Title Text 1")

## How To Write Templates
1. Every template in /application/views/templates/ folder must have this file structure:
![alt text](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/templateFileStructure.png "Logo Title Text 1")

2. Every file name is for the page that will show.
3. Page urls are
  * / - for home page (home.php)
  * /checkout - checkout page (checkout.php)
  * /shopping-cart - shopping cart page (shopping_cart.php)
  * /contacts - contacts page (contacts.php)
  * /page/pageName - every textual page added from administration (dynPage.php)
  * /blog - blog (blog.php)
  * /blog/myarticle_1 - blog articles preview (view_blog_post.php)
  * /myProduct_1 - online store product preview (view_product.php)
4. *_parts/footer.php* and *_parts/header.php* are loaded in every of this pages
5. Url for load cssfile.css from your css folder is *base_url('templatecss/nameOfFile.css')*
6. Url for load jsfile.js from your js folder is *base_url('templatejs/nameOfFile.js')*
7. Comming variables from controllers to views you can see in each conroller (names of controllers are equal to views)

Shopping cart:

1. To add article to your shopping cart add this class to your links - **add-to-cart** , if you want to redirect user after add product to shopping cart add also add **data-goto="http://..."**
2. Variable $cartItems have all your added items