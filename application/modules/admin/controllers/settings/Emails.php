<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Emails extends ADMIN_Controller
{

    private $num_rows = 20;

    public function index($page = 0)
    {
        $this->login_check();
        if (isset($_POST['export'])) {
            $rowscount = $this->AdminModel->emailsCount();
            header("Content-Disposition: attachment; filename=online-shop-$rowscount-emails-export.txt");
            $all_emails = $this->AdminModel->getSuscribedEmails(0, 0);
            foreach ($all_emails->result() as $row) {
                echo $row->email . "\n";
            }
            exit;
        }
        if (isset($_GET['delete'])) {
            $data = $this->AdminModel->deleteEmail($_GET['delete']);
            $this->session->set_flashdata('emailDeleted', 'Email addres is deleted!');
            redirect('admin/emails');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Subscribed Emails';
        $head['description'] = '!';
        $head['keywords'] = '';
        $rowscount = $this->AdminModel->emailsCount();
        $data['links_pagination'] = pagination('admin/emails', $rowscount, $this->num_rows, 3);
        $data['emails'] = $this->AdminModel->getSuscribedEmails($this->num_rows, $page);
        $this->load->view('_parts/header', $head);
        $this->load->view('settings/emails', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to Subscribed Emails');
        }
    }

}
