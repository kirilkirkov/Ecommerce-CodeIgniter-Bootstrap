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

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Home Categories';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['shop_categories'] = $this->AdminModel->getShopCategories();
        $data['languages'] = $this->AdminModel->getLanguages();
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a shop categorie');
            $result = $this->AdminModel->deleteShopCategorie($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Home Categorie id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'Shop Categorie is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with Shop Categorie delete!');
            }
            redirect('admin/shopcategories');
        }
        if (isset($_POST['submit'])) {
            $result = $this->AdminModel->setShopCategorie($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'Shop categorie is added!');
                $this->saveHistory('Added shop categorie');
            } else {
                $this->session->set_flashdata('result_add', 'Problem with Shop categorie add!');
            }
            redirect('admin/shopcategories');
        }
        if (isset($_POST['editSubId'])) {
            $result = $this->AdminModel->editShopCategorieSub($_POST);
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
        $result = $this->AdminModel->editShopCategorie($_POST);
        $this->saveHistory('Edit shop categorie to ' . $_POST['name']);
    }

}
