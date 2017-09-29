<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ShopCategories extends ADMIN_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Categories_model', 'Languages_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Home Categories';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['shop_categories'] = $this->Categories_model->getShopCategories($this->num_rows, $page);
        $data['languages'] = $this->Languages_model->getLanguages();
        $rowscount = $this->Categories_model->categoriesCount();
        $data['links_pagination'] = pagination('admin/shopcategories', $rowscount, $this->num_rows, 3);
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a shop categorie');
            $result = $this->Categories_model->deleteShopCategorie($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Home Categorie id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'Shop Categorie is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with Shop Categorie delete!');
            }
            redirect('admin/shopcategories');
        }
        if (isset($_POST['submit'])) {
            $result = $this->Categories_model->setShopCategorie($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'Shop categorie is added!');
                $this->saveHistory('Added shop categorie');
            } else {
                $this->session->set_flashdata('result_add', 'Problem with Shop categorie add!');
            }
            redirect('admin/shopcategories');
        }
        if (isset($_POST['editSubId'])) {
            $result = $this->Categories_model->editShopCategorieSub($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'Subcategory changed!');
                $this->saveHistory('Change subcategory for category id - ' . $_POST['editSubId']);
            } else {
                $this->session->set_flashdata('result_add', 'Problem with Shop category change!');
            }
            redirect('admin/shopcategories');
        }
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/shopcategories', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to shop categories');
    }

    /*
     * Called from ajax
     */

    public function editShopCategorie()
    {
        $this->login_check();
        $result = $this->Categories_model->editShopCategorie($_POST);
        $this->saveHistory('Edit shop categorie to ' . $_POST['name']);
    }

    /*
     * Called from ajax
     */

    public function changePosition()
    {
        $this->login_check();
        $result = $this->Categories_model->editShopCategoriePosition($_POST);
        $this->saveHistory('Edit shop categorie position ' . $_POST['name']);
    }

}
