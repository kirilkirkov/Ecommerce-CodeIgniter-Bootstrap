<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Products extends VENDOR_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Products_model');
    }

    public function index($page = 0)
    {
        if (isset($_GET['delete'])) {
            $this->Products_model->deleteProduct($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'product is deleted!');
            $this->saveHistory('Delete product id - ' . $_GET['delete']);
            redirect('admin/products');
        }
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_products');
        $head['description'] = lang('vendor_products');
        $head['keywords'] = '';
        $rowscount = $this->Products_model->productsCount($this->vendor_id);
        $data['products'] = $this->Products_model->getproducts($this->num_rows, $page, $this->vendor_id);
        $data['links_pagination'] = pagination('vendor/products', $rowscount, $this->num_rows, MY_LANGUAGE_ABBR == MY_DEFAULT_LANGUAGE_ABBR ? 3 : 4);
        $this->load->view('_parts/header', $head);
        $this->load->view('products', $data);
        $this->load->view('_parts/footer');
    }

    public function deleteProduct($id)
    {
        $this->Products_model->deleteProduct($id, $this->vendor_id);
        $this->session->set_flashdata('result_delete', lang('vendor_product_deleted'));
        redirect(LANG_URL . '/vendor/products');
    }

    public function logout()
    {
        unset($_SESSION['logged_vendor']);
        delete_cookie('logged_vendor');
        redirect(LANG_URL . '/vendor/login');
    }

}
