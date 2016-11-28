<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Europe/Sofia');

class Admin extends MX_Controller
{

    private $num_rows = 10;
    private $thumb_width = 300;
    private $thumb_height = 300;
    private $username;
    private $history;
    private $activePages;
    private $allowed_img_types = 'gif|jpg|png|jpeg|JPG|PNG|JPEG';

    public function __construct()
    {
        parent::__construct();
        $this->history = $this->config->item('admin_history');
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('text', 'file', 'pagination', 'text', 'except_letters', 'currencies', 'rcopy', 'rrmdir', 'rreadDir', 'savefile'));
        $this->load->Model('AdminModel');
        $this->activePages = $vars['activePages'] = $this->getActivePages();
        $vars['textualPages'] = getTextualPages($this->activePages);
        $vars['nonDynPages'] = $this->config->item('no_dynamic_pages');
        $this->load->vars($vars);
    }

    public function index()
    {
        $data = array();
        $head = array();
        $head['title'] = 'Administration';
        $head['description'] = '!';
        $head['keywords'] = '';
        $this->load->view('_parts/header', $head);
        if ($this->session->userdata('logged_in')) {
            $this->username = $this->session->userdata('logged_in');
            redirect('admin/publish');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run($this)) {
                $result = $this->AdminModel->loginCheck($_POST);
                if (!empty($result)) {
                    $this->session->set_userdata('logged_in', $result['username']);
                    $this->username = $this->session->userdata('logged_in');
                    $this->saveHistory('User ' . $result['username'] . ' logged in');
                    redirect('admin/publish');
                } else {
                    $this->saveHistory('Cant login with - User:' . $_POST['username'] . ' and Pass:' . $_POST['username']);
                    $this->session->set_flashdata('err_login', 'Wrong username or password!');
                }
            }
            $this->load->view('login');
        }
        $this->load->view('_parts/footer');
    }

    public function publish($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->AdminModel->getOneproduct($id);
            $trans_load = $this->AdminModel->getTranslations($id, 'product');
        }
        if (isset($_POST['submit'])) {
            if ($id > 0)
                $is_update = true;
            unset($_POST['submit']);
            $config['upload_path'] = './attachments/shop_images/';
            $config['allowed_types'] = $this->allowed_img_types;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
            }
            $img = $this->upload->data();
            if ($img['file_name'] != null) {
                $_POST['image'] = $img['file_name'];
            }
            $this->do_upload_others_images();
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $translations = array(
                'abbr' => $_POST['translations'],
                'title' => $_POST['title'],
                'basic_description' => $_POST['basic_description'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'old_price' => $_POST['old_price']
            );
            $flipped = array_flip($_POST['translations']);
            $_POST['title_for_url'] = $_POST['title'][$flipped[MY_DEFAULT_LANGUAGE_ABBR]];
            unset($_POST['translations'], $_POST['title'], $_POST['basic_description'], $_POST['description'], $_POST['price'], $_POST['old_price']); //remove for product
            $result = $this->AdminModel->setProduct($_POST, $id);
            if ($result !== false) {
                $this->AdminModel->setProductTranslation($translations, $result, $is_update); // send to translation table
                $this->session->set_flashdata('result_publish', 'product is published!');
                if ($id == 0) {
                    $this->saveHistory('Success published product');
                } else {
                    $this->saveHistory('Success updated product');
                }
                redirect('admin/products');
            } else {
                $this->session->set_flashdata('result_publish', 'Problem with product publish!');
            }
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->AdminModel->getLanguages();
        $data['shop_categories'] = $this->AdminModel->getShopCategories();
        $this->load->view('_parts/header', $head);
        $this->load->view('publish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }

    private function do_upload_others_images()
    {
        $upath = './attachments/shop_images/' . $_POST['folder'] . '/';
        if (!file_exists($upath)) {
            mkdir($upath, 0777);
        }

        $this->load->library('upload');

        $files = $_FILES;
        $cpt = count($_FILES['others']['name']);
        for ($i = 0; $i < $cpt; $i++) {
            unset($_FILES);
            $_FILES['others']['name'] = $files['others']['name'][$i];
            $_FILES['others']['type'] = $files['others']['type'][$i];
            $_FILES['others']['tmp_name'] = $files['others']['tmp_name'][$i];
            $_FILES['others']['error'] = $files['others']['error'][$i];
            $_FILES['others']['size'] = $files['others']['size'][$i];

            $this->upload->initialize(array(
                'upload_path' => $upath,
                'allowed_types' => $this->allowed_img_types
            ));
            $this->upload->do_upload('others');
        }
    }

    public function titles()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Titles / Descriptions';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['save'])) {
            $translations = array(
                'pages' => $_POST['pages'],
                'abbr' => $_POST['translations'],
                'title' => $_POST['title'],
                'description' => $_POST['description']
            );
            $this->AdminModel->setSeoPageTranslations($translations);
            $this->saveHistory('Changed Titles / Descriptions');
            $this->session->set_flashdata('result_publish', 'Saved successful!');
            redirect('admin/titles');
        }

        $data['seo_trans'] = $this->AdminModel->getSeoTranslations();
        $data['languages'] = $this->AdminModel->getLanguages();
        $data['seo_pages'] = $this->AdminModel->getSeoPages();
        $this->load->view('_parts/header', $head);
        $this->load->view('titles', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Titles / Descriptions page');
    }

    public function products($page = 0)
    {
        $this->login_check();
        $this->saveHistory('Go to products');
        if (isset($_GET['delete'])) {
            $result = $this->AdminModel->deleteproduct($_GET['delete']);
            if ($result == true) {
                $this->session->set_flashdata('result_delete', 'product is deleted!');
                $this->saveHistory('Delete product id - ' . $_GET['delete']);
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with product delete!');
            }
            redirect('admin/products');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if ($this->input->get('search') !== NULL) {
            $search = $this->input->get('search');
            $this->saveHistory('Search for product - ' . $search);
        } else {
            $search = null;
        }
        if ($this->input->get('orderby') !== NULL) {
            $orderby = $this->input->get('orderby');
        } else {
            $orderby = null;
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->AdminModel->productsCount($search);
        $data['products'] = $this->AdminModel->getproducts($this->num_rows, $page, $search, $orderby);
        $data['links_pagination'] = pagination('admin/products', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->AdminModel->numShopproducts();
        $data['languages'] = $this->AdminModel->getLanguages();

        $this->load->view('_parts/header', $head);
        $this->load->view('products', $data);
        $this->load->view('_parts/footer');
    }

    public function convertCurrency()
    {
        if ($this->input->is_ajax_request()) {
            $amount = $_POST['sum'];
            if ($amount == null) {
                echo 'Please type a price';
                exit;
            }
            $from = $_POST['from'];
            $to = $_POST['to'];
            $url = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
            $data = file_get_contents($url);
            preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
            $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
            $this->saveHistory('Convert currency from ' . $from . ' to ' . $to . ' with amount ' . $amount);
            echo round($converted, 2);
        }
    }

    public function removeImage()
    {
        if ($this->input->is_ajax_request()) {
            $img = './attachments/shop_images/' . $_POST['folder'] . '/' . $_POST['image'];
            unlink($img);
        }
    }

    public function shop_categories()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Home Categories';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['shop_categories'] = $this->AdminModel->getShopCategories();
        $data['languages'] = $this->AdminModel->getLanguages();
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a shop categorie');
            $result = $this->AdminModel->deleteShopCategorie($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Home Categorie id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'Shop Categorie is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with Shop Categorie delete!');
            }
            redirect('admin/shop_categories');
        }
        if (isset($_POST['submit'])) {
            $this->saveHistory('Add a shop categorie');
            $result = $this->AdminModel->setShopCategorie($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'shop categorie is added!');
                $this->saveHistory('Added shop categorie');
            } else {
                $this->session->set_flashdata('result_add', 'Problem with Shop categorie add!');
            }
            redirect('admin/shop_categories');
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('shop_categories', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to shop categories');
    }

    public function languages()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $result = $this->AdminModel->deleteLanguage($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Delete language id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'Language is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with language delete!');
            }
            redirect('admin/languages');
        }
        if (isset($_GET['editLang'])) {
            $num = $this->AdminModel->countLangs($_GET['editLang']);
            if ($num == 0)
                redirect('admin/languages');
            $langFiles = $this->getLangFolderForEdit();
        }
        if (isset($_POST['goDaddyGo'])) {
            $this->saveLanguageFiles();
            redirect('admin/languages');
        }
        if (!is_writable('application/languages/')) {
            $data['writable'] = 'Languages folder is not writable!';
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Languages';
        $head['description'] = '!';
        if (isset($langFiles)) {
            $data['arrPhpFiles'] = $langFiles[0];
            $data['arrJsFiles'] = $langFiles[1];
        }
        $head['keywords'] = '';
        $data['languages'] = $this->AdminModel->getLanguages();

        if (isset($_POST['name']) && isset($_POST['abbr'])) {
            $dublicates = $this->AdminModel->countLangs($_POST['name'], $_POST['abbr']);
            if ($dublicates == 0) {
                $config['upload_path'] = './attachments/lang_flags/';
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('userfile')) {
                    $error = $this->upload->display_errors();
                    log_message('error', 'Language image upload error: ' . $error);
                } else {
                    $img = $this->upload->data();
                    if ($img['file_name'] != null)
                        $_POST['flag'] = $img['file_name'];
                }
                $result = $this->AdminModel->setLanguage($_POST);
                if ($result === true) {
                    $this->createLangFolders();
                    $this->session->set_flashdata('result_add', 'Language is added!');
                    $this->saveHistory('Create language - ' . $_POST['abbr']);
                } else {
                    $this->session->set_flashdata('result_add', 'Problem with language add!');
                }
            } else
                $this->session->set_flashdata('result_add', 'This language exsists!');
            redirect('admin/languages');
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('languages', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to languages');
    }

    private function saveLanguageFiles()
    {
        $i = 0;
        $prevFile = 'none';
        $phpFileInclude = "<?php \n";
        foreach ($_POST['php_files'] as $phpFile) {
            if ($phpFile != $prevFile && $i > 0) {
                savefile($prevFile, $phpFileInclude);
                $phpFileInclude = "<?php \n";
            }
            $phpFileInclude .= '$lang[\'' . htmlentities($_POST['php_keys'][$i]) . '\'] = \'' . htmlentities($_POST['php_values'][$i]) . '\';' . "\n";
            $prevFile = $phpFile;
            $i++;
        }
        savefile($phpFile, $phpFileInclude);


        $i = 0;
        $prevFile = 'none';
        $jsFileInclude = "var lang = { \n";
        foreach ($_POST['js_files'] as $jsFile) {
            if ($jsFile != $prevFile && $i > 0) {
                $jsFileInclude .= "};";
                savefile($prevFile, $jsFileInclude);
                $jsFileInclude = "var lang = { \n";
            }
            $jsFileInclude .= htmlentities($_POST['js_keys'][$i]) . ':' . '"' . htmlentities($_POST['js_values'][$i]) . '",' . "\n";
            $prevFile = $jsFile;
            $i++;
        }
        $jsFileInclude .= "};";
        savefile($jsFile, $jsFileInclude);
    }

    private function getLangFolderForEdit()
    {
        $langFiles = array();
        $files = rreadDir('application/language/' . $_GET['editLang'] . '/');
        $arrPhpFiles = $arrJsFiles = array();
        foreach ($files as $ext => $filesLang) {
            foreach ($filesLang as $fileLang) {
                if ($ext == 'php') {
                    require $fileLang;
                    if (isset($lang)) {
                        $arrPhpFiles[$fileLang] = $lang;
                        unset($lang);
                    }
                }
                if ($ext == 'js') {
                    $jsTrans = file_get_contents($fileLang);
                    preg_match_all('/(.+?)"(.+?)"/', $jsTrans, $PMA);
                    $arrJsFiles[$fileLang] = $PMA;
                    unset($PMA);
                }
            }
        }
        $langFiles[0] = $arrPhpFiles;
        $langFiles[1] = $arrJsFiles;
        return $langFiles;
    }

    private function createLangFolders()
    {
        $newLang = strtolower(trim($_POST['name']));
        if ($newLang != '') {
            $from = 'application/language/' . MY_DEFAULT_LANGUAGE_ABBR;
            $to = 'application/language/' . $newLang;
            rcopy($from, $to);
        }
    }

    public function adminUsers()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $result = $this->AdminModel->deleteAdminUser($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Delete user id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'User is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with user delete!');
            }
            redirect('admin/adminUsers');
        }
        if (isset($_GET['edit']) && !isset($_POST['username'])) {
            $_POST = $this->AdminModel->getAdminUsers($_GET['edit']);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Admin Users';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['users'] = $this->AdminModel->getAdminUsers();
        $this->form_validation->set_rules('username', 'User', 'trim|required');
        if (isset($_POST['edit']) && $_POST['edit'] == 0) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
        }
        if ($this->form_validation->run($this)) {
            $result = $this->AdminModel->setAdminUser($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'User is added!');
                $this->saveHistory('Create admin user - ' . $_POST['username']);
            } else {
                $this->session->set_flashdata('result_add', 'Problem with user add!');
                $this->saveHistory('Cant add admin user');
            }
            redirect('admin/adminUsers');
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('adminUsers', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Admin Users');
    }

    public function fileManager()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - File Manager';
        $head['description'] = '!';
        $head['keywords'] = '';

        $this->load->view('_parts/header', $head);
        $this->load->view('filemanager', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to File Manager');
    }

    public function orders($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Orders';
        $head['description'] = '!';
        $head['keywords'] = '';

        $order_by = null;
        if (isset($_GET['order_by']) && $_GET['order_by'] == 'id' && $_GET['order_by'] == 'processed') {
            $order_by = $_GET['order_by'];
        }
        $rowscount = $this->AdminModel->ordersCount();
        $data['orders'] = $this->AdminModel->orders(10, $page, $order_by);
        $data['links_pagination'] = pagination('admin/orders', $rowscount, 10, 3);
        if (isset($_POST['paypal_sandbox'])) {
            $this->AdminModel->setValueStore('paypal_sandbox', $_POST['paypal_sandbox']);
            $this->session->set_flashdata('paypal_sandbox', 'Public quantity visibility changed');
            $this->saveHistory('Change paypal to sandbox mode');
            redirect('admin/orders');
        }
        if (isset($_POST['paypal_email'])) {
            $this->AdminModel->setValueStore('paypal_email', $_POST['paypal_email']);
            $this->session->set_flashdata('paypal_email', 'Public quantity visibility changed');
            $this->saveHistory('Change paypal business email to: ' . $_POST['paypal_email']);
            redirect('admin/orders');
        }
        if (isset($_POST['paypal_currency'])) {
            $this->AdminModel->setValueStore('paypal_currency', $_POST['paypal_currency']);
            $this->session->set_flashdata('paypal_currency', 'Public quantity visibility changed');
            $this->saveHistory('Change paypal currency to: ' . $_POST['paypal_currency']);
            redirect('admin/orders');
        }
        $data['paypal_sandbox'] = $this->AdminModel->getValueStore('paypal_sandbox');
        $data['paypal_email'] = $this->AdminModel->getValueStore('paypal_email');
        $data['paypal_currency'] = $this->AdminModel->getValueStore('paypal_currency');
        $this->load->view('_parts/header', $head);
        $this->load->view('orders', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to orders page');
        }
    }

    public function querybuilder()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - QueryBuilder';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['query'])) {
            $this->saveHistory('Send query from querybuilder: ' . $_POST['query']);
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('querybuilder', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to QueryBuilder Page');
    }

    public function history($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - History';
        $head['description'] = '!';
        $head['keywords'] = '';

        $rowscount = $this->AdminModel->historyCount();
        $data['actions'] = $this->AdminModel->getHistory(20, $page);
        $data['links_pagination'] = pagination('admin/history', $rowscount, 20, 3);
        $data['history'] = $this->history;

        $this->load->view('_parts/header', $head);
        $this->load->view('history', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to History');
        }
    }

    public function settings()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Settings';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['uploadimage'])) {
            $config['upload_path'] = './assets/imgs/site-logo/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1500;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('sitelogo')) {
                $this->session->set_flashdata('resultSiteLogoPublish', $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $newImage = $data['upload_data']['file_name'];
                $this->AdminModel->setValueStore('sitelogo', $newImage);
                $this->saveHistory('Change site logo');
                $this->session->set_flashdata('resultSiteLogoPublish', 'New logo is set!');
            }
            redirect('admin/settings');
        }
        if (isset($_POST['naviText'])) {
            $this->AdminModel->setValueStore('navitext', $_POST['naviText']);
            $this->session->set_flashdata('resultNaviText', 'New navigation text is set!');
            $this->saveHistory('Change navigation text');
            redirect('admin/settings');
        }
        if (isset($_POST['footerCopyright'])) {
            $this->AdminModel->setValueStore('footercopyright', $_POST['footerCopyright']);
            $this->session->set_flashdata('resultFooterCopyright', 'New navigation text is set!');
            $this->saveHistory('Change footer copyright');
            redirect('admin/settings');
        }
        if (isset($_POST['contactsPage'])) {
            $this->AdminModel->setValueStore('contactspage', $_POST['contactsPage']);
            $this->session->set_flashdata('resultContactspage', 'Contacts page is updated!');
            $this->saveHistory('Change contacts page');
            redirect('admin/settings');
        }
        if (isset($_POST['footerContacts'])) {
            $this->AdminModel->setValueStore('footerContactAddr', $_POST['footerContactAddr']);
            $this->AdminModel->setValueStore('footerContactPhone', $_POST['footerContactPhone']);
            $this->AdminModel->setValueStore('footerContactEmail', $_POST['footerContactEmail']);
            $this->session->set_flashdata('resultfooterContacts', 'Contacts on footer are updated!');
            $this->saveHistory('Change footer contacts');
            redirect('admin/settings');
        }
        if (isset($_POST['footerSocial'])) {
            $this->AdminModel->setValueStore('footerSocialFacebook', $_POST['footerSocialFacebook']);
            $this->AdminModel->setValueStore('footerSocialTwitter', $_POST['footerSocialTwitter']);
            $this->AdminModel->setValueStore('footerSocialGooglePlus', $_POST['footerSocialGooglePlus']);
            $this->AdminModel->setValueStore('footerSocialPinterest', $_POST['footerSocialPinterest']);
            $this->AdminModel->setValueStore('footerSocialYoutube', $_POST['footerSocialYoutube']);
            $this->session->set_flashdata('resultfooterSocial', 'Social on footer are updated!');
            $this->saveHistory('Change footer contacts');
            redirect('admin/settings');
        }
        if (isset($_POST['googleMaps'])) {
            $this->AdminModel->setValueStore('googleMaps', $_POST['googleMaps']);
            $this->AdminModel->setValueStore('googleApi', $_POST['googleApi']);
            $this->session->set_flashdata('resultGoogleMaps', 'Google maps coordinates and api key are updated!');
            $this->saveHistory('Update Google Maps Coordinates and Api Key');
            redirect('admin/settings');
        }
        if (isset($_POST['footerAboutUs'])) {
            $this->AdminModel->setValueStore('footerAboutUs', $_POST['footerAboutUs']);
            $this->session->set_flashdata('resultFooterAboutUs', 'Footer about us text changed!');
            $this->saveHistory('Change footer about us info');
            redirect('admin/settings');
        }
        if (isset($_POST['contactsEmailTo'])) {
            $this->AdminModel->setValueStore('contactsEmailTo', $_POST['contactsEmailTo']);
            $this->session->set_flashdata('resultEmailTo', 'Email changed!');
            $this->saveHistory('Change where going emails from contact form');
            redirect('admin/settings');
        }
        if (isset($_POST['shippingOrder'])) {
            $this->AdminModel->setValueStore('shippingOrder', $_POST['shippingOrder']);
            $this->session->set_flashdata('shippingOrder', 'Shipping Order price chagned!');
            $this->saveHistory('Change Shipping free for order more than ' . $_POST['shippingOrder']);
            redirect('admin/settings');
        }
        if (isset($_POST['addJs'])) {
            $this->AdminModel->setValueStore('addJs', $_POST['addJs']);
            $this->session->set_flashdata('addJs', 'JavaScript code is added');
            $this->saveHistory('Add JS to website');
            redirect('admin/settings');
        }
        if (isset($_POST['publicQuantity'])) {
            $this->AdminModel->setValueStore('publicQuantity', $_POST['publicQuantity']);
            $this->session->set_flashdata('publicQuantity', 'Public quantity visibility changed');
            $this->saveHistory('Change publicQuantity visibility');
            redirect('admin/settings');
        }
        if (isset($_POST['publicDateAdded'])) {
            $this->AdminModel->setValueStore('publicDateAdded', $_POST['publicDateAdded']);
            $this->session->set_flashdata('publicDateAdded', 'Public date added visibility changed');
            $this->saveHistory('Change public date added visibility');
            redirect('admin/settings');
        }
        if (isset($_POST['finalCheckoutPage'])) {
            $this->AdminModel->setValueStore('finalCheckoutPage', $_POST['finalCheckoutPage']);
            $this->session->set_flashdata('finalCheckoutPage', 'Final checkout page visibility changed');
            $this->saveHistory('Change visibility of final checkout page');
            redirect('admin/settings');
        }
        $data['siteLogo'] = $this->AdminModel->getValueStore('sitelogo');
        $data['naviText'] = $this->AdminModel->getValueStore('navitext');
        $data['footerCopyright'] = $this->AdminModel->getValueStore('footercopyright');
        $data['contactsPage'] = $this->AdminModel->getValueStore('contactspage');
        $data['footerContactAddr'] = $this->AdminModel->getValueStore('footerContactAddr');
        $data['footerContactPhone'] = $this->AdminModel->getValueStore('footerContactPhone');
        $data['footerContactEmail'] = $this->AdminModel->getValueStore('footerContactEmail');

        $data['footerSocialFacebook'] = $this->AdminModel->getValueStore('footerSocialFacebook');
        $data['footerSocialTwitter'] = $this->AdminModel->getValueStore('footerSocialTwitter');
        $data['footerSocialGooglePlus'] = $this->AdminModel->getValueStore('footerSocialGooglePlus');
        $data['footerSocialPinterest'] = $this->AdminModel->getValueStore('footerSocialPinterest');
        $data['footerSocialYoutube'] = $this->AdminModel->getValueStore('footerSocialYoutube');

        $data['contactsEmailTo'] = $this->AdminModel->getValueStore('contactsEmailTo');
        $data['googleMaps'] = $this->AdminModel->getValueStore('googleMaps');
        $data['footerAboutUs'] = $this->AdminModel->getValueStore('footerAboutUs');
        $data['shippingOrder'] = $this->AdminModel->getValueStore('shippingOrder');
        $data['addJs'] = $this->AdminModel->getValueStore('addJs');
        $data['publicQuantity'] = $this->AdminModel->getValueStore('publicQuantity');
        $data['publicDateAdded'] = $this->AdminModel->getValueStore('publicDateAdded');
        $data['finalCheckoutPage'] = $this->AdminModel->getValueStore('finalCheckoutPage');
        $data['googleApi'] = $this->AdminModel->getValueStore('googleApi');
        $this->load->view('_parts/header', $head);
        $this->load->view('settings', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Settings Page');
    }

    public function styling()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Styling';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['newStyle'])) {
            $this->AdminModel->setValueStore('newStyle', $_POST['newStyle']);
            $this->saveHistory('Change site styling');
            redirect('admin/styling');
        }

        $data['newStyle'] = $this->AdminModel->getValueStore('newStyle');
        $this->load->view('_parts/header', $head);
        $this->load->view('styling', $data);
        $this->load->view('_parts/footer');
         $this->saveHistory('Go to Styling page');
    }

    private function saveHistory($activity)
    {
        if ($this->history === true) {
            $usr = $this->username;
            $this->AdminModel->setHistory($activity, $usr);
        }
    }

    private function createThumb()
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = './attachments/images/' . $this->upload->file_name;
        $config['new_image'] = './attachments/thumbs/' . $this->upload->file_name;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = FALSE;
        $config['thumb_marker'] = '';
        $config['width'] = $this->thumb_width;
        $config['height'] = $this->thumb_height;

        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            log_message('error', 'Thumb Upload Error: ' . $this->image_lib->display_errors());
        }
    }

    public function changePass()
    {  //called from ajax
        $this->login_check();
        $result = $this->AdminModel->changePass($_POST['new_pass'], $this->username);
        if ($result == true)
            echo 1;
        else
            echo 0;
        $this->saveHistory('Password change for user: ' . $this->username);
    }

    public function productstatusChange()
    { //called from ajax
        $this->login_check();
        $result = $this->AdminModel->productstatusChagne($_POST['id'], $_POST['to_status']);
        if ($result == true)
            echo 1;
        else
            echo 0;
        $this->saveHistory('Change product id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }

    public function changeOrderStatus()
    {
        $this->login_check();
        $result = $this->AdminModel->changeOrderStatus($_POST['the_id'], $_POST['to_status']);
        if ($result == true)
            echo 1;
        else
            echo 0;
        $this->saveHistory('Change order status on product Id ' . $_POST['the_id'] . ' to status ' . $_POST['to_status']);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin');
    }

    private function login_check()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin');
        }
        $this->username = $this->session->userdata('logged_in');
    }

    public function blog($page = 0)
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $this->AdminModel->deletePost($_GET['delete']);
            redirect('admin/blog');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Blog Posts';
        $head['description'] = '!';
        $head['keywords'] = '';


        if ($this->input->get('search') !== NULL) {
            $search = $this->input->get('search');
        } else {
            $search = null;
        }
        $data = array();
        $rowscount = $this->AdminModel->postsCount($search);
        $data['posts'] = $this->AdminModel->getPosts(null, $this->num_rows, $page, $search);
        $data['links_pagination'] = pagination('admin/blog', $rowscount, $this->num_rows, 3);
        $data['page'] = $page;

        $this->load->view('_parts/header', $head);
        $this->load->view('blog', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Blog');
    }

    public function blogPublish($id = 0)
    {
        $this->login_check();
        $trans_load = null;
        $is_update = false;
        if ($id > 0)
            $is_update = true;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->AdminModel->getOnePost($id);
            $trans_load = $this->AdminModel->getTranslations($id, 'blog');
        }
        if (isset($_POST['submit'])) {
            unset($_POST['submit']);
            $config['upload_path'] = './attachments/blog_images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
            }
            $img = $this->upload->data();
            if ($img['file_name'] != null) {
                $_POST['image'] = $img['file_name'];
            }
            $translations = array(
                'abbr' => $_POST['translations'],
                'title' => $_POST['title'],
                'description' => $_POST['description']
            );

            $flipped = array_flip($_POST['translations']);
            $_POST['title'] = $_POST['title'][$flipped[MY_DEFAULT_LANGUAGE_ABBR]];
            unset($_POST['description'], $_POST['translations']);
            $result = $this->AdminModel->setPost($_POST, $id);
            if ($result !== false) {
                $this->AdminModel->setBlogTranslations($translations, $result, $is_update);
                $this->session->set_flashdata('result_publish', 'Successful published!');
                redirect('admin/blog');
            } else {
                $this->session->set_flashdata('result_publish', 'Blog post publish error!');
            }
        }

        $data = array();
        $head = array();
        $data['id'] = $id;
        $head['title'] = 'Administration - Publish Blog Post';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['languages'] = $this->AdminModel->getLanguages();
        $data['trans_load'] = $trans_load;
        $this->load->view('_parts/header', $head);
        $this->load->view('blogPublish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Blog Publish');
    }

    public function getActivePages()
    {
        return $this->AdminModel->getPages(true, false);
    }

    public function pages()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Pages Manage';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['pages'] = $this->AdminModel->getPages(null, true);
        if (isset($_POST['pname'])) {
            $this->AdminModel->setPage($_POST['pname']);
            $this->saveHistory('Add new page with name - ' . $_POST['pname']);
            redirect('admin/pages');
        }
        if (isset($_GET['delete'])) {
            $this->AdminModel->deletePage($_GET['delete']);
            $this->saveHistory('Delete page');
            redirect('admin/pages');
        }
        $this->load->view('_parts/header', $head);
        $this->load->view('pages', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Pages manage');
    }

    public function pageEdit($page = null)
    {
        $this->login_check();
        if ($page == null)
            redirect('admin/pages');
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Pages Manage';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['page'] = $this->AdminModel->getOnePageForEdit($page);
        if (empty($data['page']))
            redirect('admin/pages');

        if (isset($_POST['updatePage'])) {
            $translations = array(
                'abbr' => $_POST['translations'],
                'name' => $_POST['name'],
                'description' => $_POST['description']
            );
            $this->AdminModel->setEditPageTranslations($translations, $_POST['pageId']);
            $this->saveHistory('Page ' . $_POST['pageId'] . ' updated!');
            redirect('admin/pageEdit/' . $page);
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('pageEdit', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Edit page - ' . $page);
    }

    public function changePageStatus()
    {
        $this->login_check();
        $result = $this->AdminModel->changePageStatus($_POST['id'], $_POST['status']);
        if ($result == true)
            echo 1;
        else
            echo 0;
        $this->saveHistory('Page status Changed');
    }

    public function emails($page = 0)
    {
        $this->login_check();
        if (isset($_POST['export'])) {
            $rowscount = $this->AdminModel->emailsCount();
            header("Content-Disposition: attachment; filename=online-shop-$rowscount-emails-export.txt");
            $all_emails = $this->AdminModel->getSuscribedEmails(0, 0);
            foreach ($all_emails->result() as $row) {
                echo $row->email . "\n";
            }
            exit;
        }
        if (isset($_GET['delete'])) {
            $data = $this->AdminModel->deleteEmail($_GET['delete']);
            $this->session->set_flashdata('emailDeleted', 'Email addres is deleted!');
            redirect('admin/emails');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Subscribed Emails';
        $head['description'] = '!';
        $head['keywords'] = '';
        $rowscount = $this->AdminModel->emailsCount();
        $data['links_pagination'] = pagination('admin/emails', $rowscount, 20, 3);
        $data['emails'] = $this->AdminModel->getSuscribedEmails(20, $page);
        $this->load->view('_parts/header', $head);
        $this->load->view('emails', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to Subscribed Emails');
        }
    }

}
