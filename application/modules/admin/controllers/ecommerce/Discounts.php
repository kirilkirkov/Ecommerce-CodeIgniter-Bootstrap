<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Discounts extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Discounts_model', 'Home_admin_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Discounts';
        $head['description'] = '!';
        $head['keywords'] = '';
        if (isset($_POST['code'])) {
            $this->setDiscountCode();
        }
        if ($this->session->flashdata('post')) {
            $_POST = $this->session->flashdata('post');
        }
        if (isset($_GET['edit'])) {
            $_POST = $this->Discounts_model->getDiscountCodeInfo($_GET['edit']);
            if (empty($_POST)) {
                redirect('admin/discounts');
            }
            $_POST['valid_from_date'] = date('d.m.Y', $_POST['valid_from_date']);
            $_POST['valid_to_date'] = date('d.m.Y', $_POST['valid_to_date']);
            $_POST['update'] = $_POST['id'];
        }
        if (isset($_GET['tostatus']) && isset($_GET['codeid'])) {
            $this->Discounts_model->changeCodeDiscountStatus($_GET['codeid'], $_GET['tostatus']);
            redirect('admin/discounts');
        }
        if (isset($_POST['codeDiscounts'])) {
            $this->Home_admin_model->setValueStore('codeDiscounts', $_POST['codeDiscounts']);
            redirect('admin/discounts');
        }
        $data['codeDiscounts'] = $this->Home_admin_model->getValueStore('codeDiscounts');
        $rowscount = $this->Discounts_model->discountCodesCount();
        $data['discountCodes'] = $this->Discounts_model->getDiscountCodes($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/discounts', $rowscount, $this->num_rows, 3);

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/discounts', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to discounts page');
        }
    }

    private function setDiscountCode()
    {
        $isValid = $this->validateCode();
        if ($isValid === true) {
            if ($_POST['update'] == 0) {
                $this->Discounts_model->setDiscountCode($_POST);
            } else {
                $this->Discounts_model->updateDiscountCode($_POST);
            }
            $this->session->set_flashdata('success', 'Changes are saved');
        } else {
            $this->session->set_flashdata('error', $isValid);
            $this->session->set_flashdata('post', $_POST);
        }
        redirect('admin/discounts');
    }

    private function validateCode()
    {
        $errors = array();
        if ($_POST['type'] != 'percent' && $_POST['type'] != 'float') {
            $errors[] = 'Type of discount is not valid!';
        }
        if ((float) $_POST['amount'] == 0) {
            $errors[] = 'Discount amount is 0!';
        }
        if (mb_strlen(trim($_POST['code'])) < 3) {
            $errors[] = 'Discount code is lower than 3 symbols!';
        } else {
            $isFree = $this->Discounts_model->discountCodeTakenCheck($_POST);
            if ($isFree === false) {
                $errors[] = 'Discount code taken!';
            }
        }
        if (strtotime($_POST['valid_from_date']) === false) {
            $errors[] = 'From date is invalid!';
        }
        if (strtotime($_POST['valid_to_date']) === false) {
            $errors[] = 'To date is invalid!';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

}
