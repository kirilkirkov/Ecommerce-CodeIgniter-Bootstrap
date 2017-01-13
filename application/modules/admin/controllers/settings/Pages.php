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

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Pages Manage';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['pages'] = $this->AdminModel->getPages(null, true);
        if (isset($_POST['pname'])) {
            $this->AdminModel->setPage($_POST['pname']);
            $this->saveHistory('Add new page with name - ' . $_POST['pname']);
            redirect('admin/pages');
        }
        if (isset($_GET['delete'])) {
            $this->AdminModel->deletePage($_GET['delete']);
            $this->saveHistory('Delete page');
            redirect('admin/pages');
        }
        $this->load->view('_parts/header', $head);
        $this->load->view('settings/pages', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Pages manage');
    }

}
