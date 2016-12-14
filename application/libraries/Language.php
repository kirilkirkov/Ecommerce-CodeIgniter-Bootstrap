<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Language
{

    protected $CI;
    private $urlAbbrevation;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('AdminModel');
        $this->CI->load->model('Publicmodel');
        $this->urlAbbrevation = strtolower($this->CI->uri->segment(1));
        $this->setLanguage();
    }

    private function setLanguage()
    {
        $defaultLanguageName = $language = $this->CI->config->item('language');
        $defaultLanguageAbbr = $myLanguage = strtolower($this->CI->config->item('language_abbr'));
        $currency = $this->CI->config->item('currency');
        $currencyKey = $this->CI->config->item('currencyKey');
        $langLinkStart = '';
        /*
         * If try to select default language
         * Go refresh clean url.. to dont have duplicate pages for google!
         * Else get the language
         */
        if ($this->urlAbbrevation == $defaultLanguageAbbr) {
            redirect(base_url());
        } else {
            $myLang = $this->CI->Publicmodel->getOneLanguage($this->urlAbbrevation);
            if ($myLang != null) {
                $myLanguage = $myLang['abbr'];
                $language = $myLang['name'];
                $currency = $myLang['currency'];
                $currencyKey = $myLang['currencyKey'];
                $langLinkStart = $myLanguage . '/';
            }
        }
        $this->CI->lang->load("site", $language);

        define('MY_LANGUAGE_FULL_NAME', $language);
        define('MY_LANGUAGE_ABBR', $myLanguage);
        define('MY_DEFAULT_LANGUAGE_ABBR', $defaultLanguageAbbr);
        define('MY_DEFAULT_LANGUAGE_NAME', $defaultLanguageName);
        define('CURRENCY', $currency);
        define('CURRENCY_KEY', $currencyKey);
        define('LANG_URL', rtrim(base_url($langLinkStart), '/'));
    }

}
