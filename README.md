<p align="center"><img src="https://cdn.worldvectorlogo.com/logos/codeigniter-1.svg" width="100"></p>
<p align="center">Shopping Cart Solution - CodeIgniter and Bootstrap</p>
 
## Bootstrap Responsive Multi-Vendor, MultiLanguage Online Shop Platform

Current versions:

* Codeigniter 3.1.13 (CodeIgniter Foundation) - modified version with PHP 8.5 support
* Bootstrap 3.3.7

## Donate
<p>If this project help you reduce time to develop, you can give me a cup of coffee to continue its development. Thank you! :)</p>

[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=W5BR6K29BQX7E)

## See also
- <a href="https://wordpress.org/plugins/kirilkirkov-pdf-invoice-manager/" title="Electronic invoicing and warehouse management plugin which allows you to issue, send and download invoices as pdf file">Invoct – PDF Invoices & Billing for WooCommerce and WordPress</a> - <b>Invoct</b> is FREE powerful Invoice Generator for WordPress — designed to work standalone or seamlessly with WooCommerce including <b>Periodic Invoicing</b>, <b>PDF Generation</b>, <b>API Integration</b> and many more..
- <a href="https://apps.shopify.com/smartsellio" title="Upsell, Cross Sell & AOV with Frequently Bought Together, bundles, smart product recommendations based on user behavior">SmartSellio</a> - <b>SmartSellio</b> is powerful AOV which helps Shopify merchants increase revenue by automatically showing the right products to the right customers at the perfect moment. SmartSellio support <b>post-purchase</b>, <b>checkout page</b>, <b>product pages</b> and <b>cart page</b>.

## Support of following features

1. Multi-Vendor
2. Multilingual (MultiLanguage)
3. Virtual products
4. Multi-template support (Bootstrap 3 templates and TailwindCSS 4.1 templates)
5. API
6. Powerful administration panel with role-based access
7. AJAX-based shopping cart
8. Orders are saved in the admin panel + email notifications for each new order
9. Product stock quantity is updated from orders
10. Add content pages
11. Activate and disable pages
12. File manager in the admin panel
13. Integrated blog
14. Email subscriptions
15. Easy installation
16. Readable source
17. Fully editable public texts (translations)
18. Accept ![PayPal Ecommerce Integration](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/paypalLogo.png "Paypal Integration") payments + PayPal Sandbox support
19. Fast-loading templates for better SEO
20. Site color themes with an easy-to-use gradient generator
21. Multilingual cookie notification (Silktide) for EU Cookie Law compliance
22. Multiple templates (you can easily create your own; see `application/views/templates/`)
23. Bank account payments support
24. Highcharts statistics for orders
25. Discount codes
26. Available on English, Greek, Bulgarian
27. Responsive public pages, responsive administration, responsive vendor pages
28. Advanced search with treeView categories
29. Easy product management (a new field for each added language; subcategories are easy to manage)
30. Advanced sorting and order products
31. etc.

## Easy installation in 2 steps
1. Create an empty MySQL database (or use an existing one)
2. Choose ONE of the following options:
   - <b>Option A (installer)</b>: open the project locally in your browser. If the database is not configured / schema is missing, the app will redirect you to <code>/installation.php</code>. Enter <b>hostname</b>, <b>username</b>, <b>password</b>, <b>database</b> and click <b>Install</b> (it will automatically import <code>database.sql</code>).
   - <b>Option B (manual)</b>: import <code>database.sql</code> manually to your database and set <b>hostname</b>, <b>username</b>, <b>password</b>, <b>database</b> in <code>application/config/database.php</code>.

Notes:
- The installer writes credentials into <code>application/config/database.php</code>, so the file must be writable by PHP.
- After successful install, a lock file <code>application/config/installed.lock</code> is created (delete it if you need to re-run the installer).

## Available Languages
- ![CodeIgniter Ecommerce English](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/attachments/lang_flags/en.jpg "English Translation CodeIgniter") English
- ![CodeIgniter Ecommerce Greece](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/attachments/lang_flags/gr.png "Greece Translation CodeIgniter") Greece
- ![CodeIgniter Ecommerce Bulgarian](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/attachments/lang_flags/bg.jpg "Bulgarian Translation CodeIgniter") Bulgarian
- ![CodeIgniter Ecommerce French](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/attachments/lang_flags/fr.jpg "French Translation CodeIgniter") French
- ![CodeIgniter Ecommerce Hindi](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/attachments/lang_flags/hi.svg "Hindi Translation CodeIgniter") Hindi
- ![CodeIgniter Ecommerce German](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/attachments/lang_flags/de.svg "German Translation CodeIgniter") German
- ![CodeIgniter Ecommerce Spanish](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/attachments/lang_flags/es.svg "Spanish Translation CodeIgniter") Spanish
- ![CodeIgniter Ecommerce Chinese](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/attachments/lang_flags/zh.svg "Simplified Chinese Translation CodeIgniter") Chinese (Simplified)
- ![CodeIgniter Ecommerce Indonesian](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/attachments/lang_flags/id.jpg "Indonesian Translation CodeIgniter") Indonesian

## Login to administration with
- Administration url - /admin (eg. https://yourwebsite.com/admin)
- Username: admin 
- Password: admin

<p>Its good then to change your password for the administration from the Password Change button into the navigation.</p>

## Vendors support
- Login url is - /vendor/login (eg. https://yourwebsite.com/vendor/login)
- Vendors are not supported only from "onepage" template.
- Can register new vendor from url - /vendor/register.  (eg. https://yourwebsite.com/vendor/register)
- Vendors must be enabled from administration - /admin (eg. https://yourwebsite.com/admin/settings) Settings -> Multi-Vendor Support (panel).

## Users registration
<p>Users /registration/login (https://yourwebsite.com/registration/login) is added only in <b>greenlabel template</b>. (easily can be added to any other template, just copy files: login.php, signup.php, user.php to the new template directory (application/views/templates) and change your design).</p>
<b>Users can track their orders history only.</b>

## Screenshots of public pages
![MultiLanguage CodeIgniter Template Ecommerce](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/templates.png "Multiple Templates")

## Screenshots of vendors pages
![MultiVendor CodeIgniter Template Ecommerce](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/vendors_pages.jpg "Vendors Page Preview")

## Screenshot of admin panel
![CodeIgniter Administration Bootstrap](https://raw.githubusercontent.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/master/github/admin_panel4.png "Powerful Administration CodeIgniter")

### How To Write Templates
Read in our wiki - https://github.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/wiki/How-to-write-templates

### Shopping cart peculiarities
Read in our wiki - https://github.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/wiki/Shopping-cart-peculiarities

### Multi Vendor Support
Read in our wiki - https://github.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/wiki/Multi-Vendor-Support

### API Documentation
Read in our wiki - https://github.com/kirilkirkov/Shopping-Cart-Solution-CodeIgniter/wiki/API

### Server Requirements
- PHP 7.4–8.5 (any version in this range)
- MySQL 5.7–8.4.7 (any version in this range)

Note: Versions outside these ranges (e.g., PHP 5.6) may work, but are not officially supported or tested.
