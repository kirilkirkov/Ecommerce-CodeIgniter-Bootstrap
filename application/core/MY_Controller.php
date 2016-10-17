<?php

class MY_Controller extends MX_Controller
{

    public $my_lang;
    public $my_lang_full;
    public $def_lang;
    public $lang_link;
    public $lang_url;
    public $all_langs;
    private $sum_values = 0;
    public $currency;
    public $nonDynPages = array();
    private $dynPages = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Admin_model');
        $this->setLanguage();
        $this->getActivePages();
        $this->lang_url = rtrim(base_url($this->lang_link), '/');
        $this->checkForPostRequests();
        $this->setReferrer();
    }

    public function render($view, $head, $data = null, $footer = null)
    {
        $head['cartItems'] = $this->getCartItems();
        $head['sumOfItems'] = $this->sum_values;
        $vars = $this->loadVars();
        $this->load->vars($vars);
        $this->load->view('_parts/header', $head);
        $this->load->view($view, $data);
        $this->load->view('_parts/footer', $footer);
    }

    private function loadVars()
    {
        $vars = array();
        $vars['lang_url'] = $this->lang_url;
        $vars['currency'] = $this->currency;
        $vars['nonDynPages'] = $this->nonDynPages;
        $vars['dynPages'] = $this->dynPages;
        $vars['footerCategories'] = $this->Articles_model->getFooterCategories($this->my_lang);
        $vars['sitelogo'] = $this->Admin_model->getValueStore('sitelogo');
        $vars['naviText'] = htmlentities($this->Admin_model->getValueStore('navitext'));
        $vars['footerCopyright'] = htmlentities($this->Admin_model->getValueStore('footercopyright'));
        $vars['contactsPage'] = $this->Admin_model->getValueStore('contactspage');
        $vars['footerContactAddr'] = htmlentities($this->Admin_model->getValueStore('footerContactAddr'));
        $vars['footerContactPhone'] = htmlentities($this->Admin_model->getValueStore('footerContactPhone'));
        $vars['footerContactEmail'] = htmlentities($this->Admin_model->getValueStore('footerContactEmail'));
        $vars['googleMaps'] = $this->Admin_model->getValueStore('googleMaps');
        $vars['footerAboutUs'] = $this->Admin_model->getValueStore('footerAboutUs');
        $vars['footerSocialFacebook'] = $this->Admin_model->getValueStore('footerSocialFacebook');
        $vars['footerSocialTwitter'] = $this->Admin_model->getValueStore('footerSocialTwitter');
        $vars['footerSocialGooglePlus'] = $this->Admin_model->getValueStore('footerSocialGooglePlus');
        $vars['footerSocialPinterest'] = $this->Admin_model->getValueStore('footerSocialPinterest');
        $vars['footerSocialYoutube'] = $this->Admin_model->getValueStore('footerSocialYoutube');
        $vars['addedJs'] = $this->Admin_model->getValueStore('addJs');
        return $vars;
    }

    public function getCartItems()
    {
        if ((!isset($_SESSION['shopping_cart']) || empty($_SESSION['shopping_cart'])) && get_cookie('shopping_cart') != NULL) {
            $_SESSION['shopping_cart'] = unserialize(get_cookie('shopping_cart'));
        } elseif (!isset($_SESSION['shopping_cart']) || empty($_SESSION['shopping_cart'])) {
            return 0;
        }
        $result['array'] = $this->Articles_model->getShopItems(array_unique($_SESSION['shopping_cart']), $this->my_lang);
        if (empty($result['array'])) {
            unset($_SESSION['shopping_cart']);
            @delete_cookie('shopping_cart');
            return 0;
        }
        $count_articles = array_count_values($_SESSION['shopping_cart']);
        $this->sum_values = array_sum($count_articles);
        $finalSum = 0;

        foreach ($result['array'] as &$article) {
            $article['num_added'] = $count_articles[$article['id']];
            $article['sum_price'] = $article['price'] * $count_articles[$article['id']];
            $finalSum = $finalSum + $article['sum_price'];
            $article['sum_price'] = number_format($article['sum_price'], 2);
            $article['price'] = $article['price'] != '' ? number_format($article['price'], 2) : 0;
        }
        $result['finalSum'] = number_format($finalSum, 2);
        return $result;
    }

    private function setLanguage()
    { //set language of site
        $langs = $this->Admin_model->getLanguages();
        $have = 0;
        $def_lang = $this->config->item('language');
        $def_lang_abbr = $this->def_lang = $this->config->item('language_abbr');
        $this->currency = $this->config->item('currency');
        if ($this->uri->segment(1) == $def_lang_abbr) {
            redirect(base_url());
        }
        foreach ($langs->result() as $lang) {
            $this->all_langs[$lang->abbr]['name'] = $lang->name;
            $this->all_langs[$lang->abbr]['flag'] = $lang->flag;
            if ($lang->abbr == $this->uri->segment(1)) {
                $this->session->set_userdata('lang', $lang->name);
                $this->session->set_userdata('lang_abbr', $lang->abbr);
                $this->currency = $lang->currency;
                $have = 1;
            }
        }
        if ($have == 0)
            $this->session->unset_userdata('lang');

        if ($this->session->userdata('lang') !== NULL) {
            $this->lang->load("site", $this->session->userdata('lang'));
        } else {
            $this->session->set_userdata('lang', $def_lang);
            $this->session->set_userdata('lang_abbr', $def_lang_abbr);
            $this->lang->load("site", $def_lang);
        }
        $this->my_lang = $this->session->userdata('lang_abbr');
        $this->my_lang_full = $this->session->userdata('lang');

        $this->my_lang != $this->def_lang ? $this->lang_link = $this->my_lang . '/' : $this->lang_link = '';
    }

    public function clearShoppingCart()
    {
        unset($_SESSION['shopping_cart']);
        @delete_cookie('shopping_cart');
        if ($this->input->is_ajax_request()) {
            echo 1;
        }
    }

    private function getActivePages()
    {
        $activeP = $this->Admin_model->getPages(true);
        $this->nonDynPages = $this->config->item('no_dynamic_pages');
        $dynPages = getTextualPages($activeP);
        $this->dynPages = $this->Articles_model->getDynPagesLangs($dynPages, $this->my_lang);
    }

    private function checkForPostRequests()
    {
        if (isset($_POST['subscribeEmail'])) {
            $arr = array();
            $arr['browser'] = $_SERVER['HTTP_USER_AGENT'];
            $arr['ip'] = $_SERVER['REMOTE_ADDR'];
            $arr['time'] = time();
            $arr['email'] = $_POST['subscribeEmail'];
            if (filter_var($arr['email'], FILTER_VALIDATE_EMAIL) && !$this->session->userdata('email_added')) {
                $this->session->set_userdata('email_added', 1);
                $res = $this->Articles_model->setSubscribe($arr);
                $this->session->set_flashdata('emailAdded', lang('email_added'));
            }
            if (!headers_sent()) {
                redirect();
            } else {
                echo 'window.location = "' . base_url() . '"';
            }
        }
    }

    private function setReferrer()
    {
        if ($this->session->userdata('referrer') == null) {
            if (!isset($_SERVER['HTTP_REFERER']))
                $ref = 'Direct';
            else
                $ref = $_SERVER['HTTP_REFERER'];
            $this->session->set_userdata('referrer', $ref);
        }
    }

}
