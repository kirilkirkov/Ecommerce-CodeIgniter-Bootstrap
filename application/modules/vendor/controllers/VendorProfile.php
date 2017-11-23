<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class VendorProfile extends VENDOR_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vendorprofile_model');
    }

    public function index()
    {

        $data = array();
        $head = array();
        $head['title'] = lang('vendor_dashboard');
        $head['description'] = lang('vendor_home_page');
        $head['keywords'] = '';
        $data['ordersByMonth'] = $this->Vendorprofile_model->getOrdersByMonth($this->vendor_id);
        $this->load->view('_parts/header', $head);
        $this->load->view('home', $data);
        $this->load->view('_parts/footer');
    }

    public function logout()
    {
        unset($_SESSION['logged_vendor']);
        delete_cookie('logged_vendor');
        redirect(LANG_URL . '/vendor/login');
    }

}
