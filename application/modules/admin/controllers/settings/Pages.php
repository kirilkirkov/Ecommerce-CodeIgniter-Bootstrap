<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pages extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pages_model');
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Pages Manage';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['pages'] = $this->Pages_model->getPages(null, true);
        if (isset($_POST['pname'])) {
            $this->Pages_model->setPage($_POST['pname']);
            $this->saveHistory('Add new page with name - ' . $_POST['pname']);
            redirect('admin/pages');
        }
        if (isset($_GET['delete'])) {
            $this->Pages_model->deletePage($_GET['delete']);
            $this->saveHistory('Delete page');
            redirect('admin/pages');
        }
        $this->load->view('_parts/header', $head);
        $this->load->view('settings/pages', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Pages manage');
    }

}
