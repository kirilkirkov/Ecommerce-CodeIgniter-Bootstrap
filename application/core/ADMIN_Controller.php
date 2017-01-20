<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ADMIN_Controller extends MX_Controller
{

    protected $username;
    protected $activePages;
    protected $allowed_img_types;
    protected $history;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->helper(
                array(
                    'file',
                    'pagination',
                    'except_letters',
                    'currencies',
                    'rcopy',
                    'rrmdir',
                    'rreadDir',
                    'savefile'
                )
        );
        $this->history = $this->config->item('admin_history');
        $this->activePages = $vars['activePages'] = $this->getActivePages();
        $numNotPreviewOrders = $this->AdminModel->newOrdersCheck();
        $this->allowed_img_types = $this->config->item('allowed_img_types');
        $vars['textualPages'] = getTextualPages($this->activePages);
        $vars['nonDynPages'] = $this->config->item('no_dynamic_pages');
        $vars['numNotPreviewOrders'] = $numNotPreviewOrders;
        $vars['warnings'] = $this->warningChecker();
        $vars['showBrands'] = $this->AdminModel->getValueStore('showBrands');
        $this->load->vars($vars);
    }

    protected function login_check()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin');
        }
        $this->username = $this->session->userdata('logged_in');
    }

    protected function saveHistory($activity)
    {
        if ($this->history === true) {
            $usr = $this->username;
            $this->AdminModel->setHistory($activity, $usr);
        }
    }

    public function getActivePages()
    {
        return $this->AdminModel->getPages(true, false);
    }

    private function warningChecker()
    {
        $errors = array();

        // Check application/language folder is writable
        if (!is_writable('.' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'language')) {
            $errors[] = 'Language folder is not writable!';
        }

        // Check application/logs folder is writable
        if (!is_writable('.' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'logs')) {
            $errors[] = 'Logs folder is not writable!';
        }

        // Check attachments folder is writable
        if (!is_writable('.' . DIRECTORY_SEPARATOR . 'attachments')) {
            $errors[] = 'Attachments folder is not writable!';
        } else {
            /*
             *  Check attachment directories exsists..
             *  ..and create him if no exsists
             */
            if (!file_exists('.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'blog_images')) {
                $old = umask(0);
                mkdir('.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'blog_images', 0777, true);
                umask($old);
            }
            if (!file_exists('.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'lang_flags')) {
                $old = umask(0);
                mkdir('.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'lang_flags', 0777, true);
                umask($old);
            }
            if (!file_exists('.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images')) {
                $old = umask(0);
                mkdir('.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images', 0777, true);
                umask($old);
            }
            if (!file_exists('.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'site_logo')) {
                $old = umask(0);
                mkdir('.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'site_logo', 0777, true);
                umask($old);
            }
        }
        return $errors;
    }

}
