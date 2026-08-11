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

        if (isset($_GET['delete'])) {
            $this->Vendors_model->deleteVendor($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Vendor is deleted!');
            $this->saveHistory('Delete vendor id - ' . $_GET['delete']);
            redirect('admin/listvendors');
        }

        if (isset($_GET['edit']) && !isset($_POST['name'])) {
            $_POST = $this->Vendors_model->getVendors($_GET['edit'])->row_array();
            $_POST['edit'] = $_GET['edit'];
        }

        $data = array();
        $head = array();
        $head['title'] = 'Administration - Admin Vendors';
        $head['description'] = '!';
        $head['keywords'] = '';
        $id = null;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('url', 'Url', 'trim|required');
        if ($this->input->method() === 'post' && $this->form_validation->run($this)) {
            $this->Vendors_model->setVendor($_POST);
            $this->session->set_flashdata('result_add', 'Vendor is updated!');
            $this->saveHistory('Update vendor id - ' . $_POST['edit']);
            redirect('admin/listvendors');
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
