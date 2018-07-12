<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auth extends VENDOR_Controller
{

    private $registerErrors = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Auth_model', 'Vendorprofile_model'));
    }

    public function index()
    {
        show_404();
    }

    public function login()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('user_login_page');
        $head['description'] = lang('open_your_account');
        $head['keywords'] = '';

        if (isset($_POST['login'])) {
            $result = $this->verifyVendorLogin();
            if ($result == false) {
                $this->session->set_flashdata('login_error', lang('login_vendor_error'));
                redirect(LANG_URL . '/vendor/login');
            } else {
                $remember_me = false;
                if (isset($_POST['remember_me'])) {
                    $remember_me = true;
                }
                $this->setLoginSession($_POST['u_email'], $remember_me);
                redirect(LANG_URL . '/vendor/me');
            }
        }
        $this->load->view('_parts/header_auth', $head);
        $this->load->view('auth/login', $data);
        $this->load->view('_parts/footer_auth');
    }

    private function verifyVendorLogin()
    {
        return $this->Auth_model->checkVendorExsists($_POST);
    }

    public function register()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('user_register_page');
        $head['description'] = lang('create_account');
        $head['keywords'] = '';
        if (isset($_POST['register'])) {
            $result = $this->registerVendor();
            if ($result == false) {
                $this->session->set_flashdata('error_register', $this->registerErrors);
                $this->session->set_flashdata('email', $_POST['u_email']);
                redirect(LANG_URL . '/vendor/register');
            } else {
                $this->setLoginSession($_POST['u_email'], false);
                redirect(LANG_URL . '/vendor/me');
            }
        }
        $this->load->view('_parts/header_auth', $head);
        $this->load->view('auth/register', $data);
        $this->load->view('_parts/footer_auth');
    }

    private function registerVendor()
    {
        $errors = array();
        if (mb_strlen(trim($_POST['u_password'])) == 0) {
            $errors[] = lang('please_enter_password');
        }
        if (mb_strlen(trim($_POST['u_password_repeat'])) == 0) {
            $errors[] = lang('please_repeat_password');
        }
        if ($_POST['u_password'] != $_POST['u_password_repeat']) {
            $errors[] = lang('passwords_dont_match');
        }
        if (!filter_var($_POST['u_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = lang('vendor_invalid_email');
        }
        $count_emails = $this->Auth_model->countVendorsWithEmail($_POST['u_email']);
        if ($count_emails > 0) {
            $errors[] = lang('vendor_email_is_taken');
        }
        if (!empty($errors)) {
            $this->registerErrors = $errors;
            return false;
        }
        $this->Auth_model->registerVendor($_POST);
        return true;
    }

    public function forgotten()
    {
        if (isset($_POST['u_email'])) {
            $vendor = $this->Vendorprofile_model->getVendorInfoFromEmail($_POST['u_email']);
            if ($vendor != null) {
                $myDomain = $this->config->item('base_url');
                $newPass = $this->Auth_model->updateVendorPassword($_POST['u_email']);
                $this->sendmail->sendTo($_POST['u_email'], 'Admin', 'New password for ' . $myDomain, 'Hello, your new password is ' . $newPass);
                $this->session->set_flashdata('login_error', lang('new_pass_sended'));
                redirect(LANG_URL . '/vendor/login');
            }
        }

        $data = array();
        $head = array();
        $head['title'] = lang('user_forgotten_page');
        $head['description'] = lang('recover_password');
        $head['keywords'] = '';

        $this->load->view('_parts/header_auth', $head);
        $this->load->view('auth/recover_pass', $data);
        $this->load->view('_parts/footer_auth');
    }

}
