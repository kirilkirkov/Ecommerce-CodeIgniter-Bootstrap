<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Adminusers extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_users_model');
    }

    public function index()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $result = $this->Admin_users_model->deleteAdminUser($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Delete user id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'User is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with user delete!');
            }
            redirect('admin/adminusers');
        }
        if (isset($_GET['edit']) && !isset($_POST['username'])) {
            $_POST = $this->Admin_users_model->getAdminUsers($_GET['edit']);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Admin Users';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['users'] = $this->Admin_users_model->getAdminUsers();
        $this->form_validation->set_rules('username', 'User', 'trim|required');
        if (isset($_POST['edit']) && $_POST['edit'] == 0) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
        }
        if ($this->form_validation->run($this)) {
            $result = $this->Admin_users_model->setAdminUser($_POST);
            if ($result === true) {
                $this->session->set_flashdata('result_add', 'User is added!');
                $this->saveHistory('Create admin user - ' . $_POST['username']);
            } else {
                $this->session->set_flashdata('result_add', 'Problem with user add!');
                $this->saveHistory('Cant add admin user');
            }
            redirect('admin/adminusers');
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/adminUsers', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Admin Users');
    }

}
