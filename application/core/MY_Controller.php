<?php

class MY_Controller extends MX_Controller
{

    public $nonDynPages = array();
    private $dynPages = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('AdminModel');
        $this->getActivePages();
        $this->checkForPostRequests();
        $this->setReferrer();
    }

    public function render($view, $head, $data = null, $footer = null)
    {
        $head['cartItems'] = $this->shoppingcart->getCartItems();
        $head['sumOfItems'] = $this->shoppingcart->sumValues;
        $vars = $this->loadVars();
        $this->load->vars($vars);
        $this->load->view('_parts/header', $head);
        $this->load->view($view, $data);
        $this->load->view('_parts/footer', $footer);
    }

    private function loadVars()
    {
        $vars = array();
        $vars['nonDynPages'] = $this->nonDynPages;
        $vars['dynPages'] = $this->dynPages;
        $vars['footerCategories'] = $this->Publicmodel->getFooterCategories();
        $vars['sitelogo'] = $this->AdminModel->getValueStore('sitelogo');
        $vars['naviText'] = htmlentities($this->AdminModel->getValueStore('navitext'));
        $vars['footerCopyright'] = htmlentities($this->AdminModel->getValueStore('footercopyright'));
        $vars['contactsPage'] = $this->AdminModel->getValueStore('contactspage');
        $vars['footerContactAddr'] = htmlentities($this->AdminModel->getValueStore('footerContactAddr'));
        $vars['footerContactPhone'] = htmlentities($this->AdminModel->getValueStore('footerContactPhone'));
        $vars['footerContactEmail'] = htmlentities($this->AdminModel->getValueStore('footerContactEmail'));
        $vars['footerAboutUs'] = $this->AdminModel->getValueStore('footerAboutUs');
        $vars['footerSocialFacebook'] = $this->AdminModel->getValueStore('footerSocialFacebook');
        $vars['footerSocialTwitter'] = $this->AdminModel->getValueStore('footerSocialTwitter');
        $vars['footerSocialGooglePlus'] = $this->AdminModel->getValueStore('footerSocialGooglePlus');
        $vars['footerSocialPinterest'] = $this->AdminModel->getValueStore('footerSocialPinterest');
        $vars['footerSocialYoutube'] = $this->AdminModel->getValueStore('footerSocialYoutube');
        $vars['addedJs'] = $this->AdminModel->getValueStore('addJs');
        $vars['publicQuantity'] = $this->AdminModel->getValueStore('publicQuantity');
        $vars['moreInfoBtn'] = $this->AdminModel->getValueStore('moreInfoBtn');
        $vars['allLanguages'] = $this->getAllLangs();
        $vars['load'] = $this->loop;
        $vars['cookieLaw'] = $this->Publicmodel->getCookieLaw();
        return $vars;
    }

    private function getAllLangs()
    {
        $arr = array();
        $langs = $this->AdminModel->getLanguages();
        foreach ($langs->result() as $lang) {
            $arr[$lang->abbr]['name'] = $lang->name;
            $arr[$lang->abbr]['flag'] = $lang->flag;
        }
        return $arr;
    }

    private function getActivePages()
    {
        $activeP = $this->AdminModel->getPages(true);
        $dynPages = $this->config->item('no_dynamic_pages');
        $actDynPages = [];
        foreach ($activeP as $acp) {
            if (($key = array_search($acp, $dynPages)) !== false) {
                $actDynPages[] = $acp;
            }
        }
        $this->nonDynPages = $actDynPages;
        $dynPages = getTextualPages($activeP);
        $this->dynPages = $this->Publicmodel->getDynPagesLangs($dynPages);
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
                $res = $this->Publicmodel->setSubscribe($arr);
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
            if (!isset($_SERVER['HTTP_REFERER'])) {
                $ref = 'Direct';
            } else {
                $ref = $_SERVER['HTTP_REFERER'];
            }
            $this->session->set_userdata('referrer', $ref);
        }
    }

}
