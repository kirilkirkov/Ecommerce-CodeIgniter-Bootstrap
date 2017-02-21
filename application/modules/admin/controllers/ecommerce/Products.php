<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Products extends ADMIN_Controller
{

    private $num_rows = 10;

    public function index($page = 0)
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

        unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for product title - ' . $search_title);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category = null;
        if ($this->input->get('category') !== NULL) {
            $category = $this->input->get('category');
            $_SESSION['filter']['category '] = $category;
            $this->saveHistory('Search for product code - ' . $category);
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->AdminModel->productsCount($search_title, $category);
        $data['products'] = $this->AdminModel->getproducts($this->num_rows, $page, $search_title, $orderby, $category);
        $data['links_pagination'] = pagination('admin/products', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->AdminModel->numShopproducts();
        $data['languages'] = $this->AdminModel->getLanguages();
        $data['shop_categories'] = $this->AdminModel->getShopCategories(null, null, 2);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/products', $data);
        $this->load->view('_parts/footer');
    }

    public function getProductInfo($id)
    {
        $this->login_check();
        return $this->AdminModel->getOneProduct($id);
    }

    /*
     * called from ajax
     */

    public function productStatusChange()
    {
        $this->login_check();
        $result = $this->AdminModel->productStatusChange($_POST['id'], $_POST['to_status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change product id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }

}
