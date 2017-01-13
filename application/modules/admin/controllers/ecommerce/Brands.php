<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Brands extends ADMIN_Controller
{

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Brands';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['name'])) {
            $this->AdminModel->setBrand($_POST['name']);
            redirect('admin/brands');
        }

        if (isset($_GET['delete'])) {
            $this->AdminModel->deleteBrand($_GET['delete']);
            redirect('admin/brands');
        }

        $data['brands'] = $this->AdminModel->getBrands();

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/brands', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to brands page');
    }

}
