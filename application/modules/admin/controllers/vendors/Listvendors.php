<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Listvendors extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vendors_model');
    }

    public function index()
    {
        $this->login_check();

        $data = array();
        $head = array();
        $head['title'] = 'Administration - Admin Vendors';
        $head['description'] = '!';
        $head['keywords'] = '';
        $id = null;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        $data['vendors'] = $this->Vendors_model->getVendors($id);
        $data['controller'] = $this;
        
        $this->load->view('_parts/header', $head);
        $this->load->view('vendors/listVendors', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Admin Vendors List');
    }

    public function getVendorOrders($id)
    {
        return $this->Vendors_model->getVendorOrders($id);
    }
}
