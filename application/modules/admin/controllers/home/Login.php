<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends ADMIN_Controller
{

    public function index()
    {
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Login';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->load->view('_parts/header', $head);
        if ($this->session->userdata('logged_in')) {
            redirect('admin/home');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run($this)) {
                $result = $this->AdminModel->loginCheck($_POST);
                if (!empty($result)) {
                    $_SESSION['last_login'] = $result['last_login'];
                    $this->session->set_userdata('logged_in', $result['username']);
                    $this->saveHistory('User ' . $result['username'] . ' logged in');
                    redirect('admin/home');
                } else {
                    $this->saveHistory('Cant login with - User: ' . $_POST['username'] . ' and Pass: ' . $_POST['username']);
                    $this->session->set_flashdata('err_login', 'Wrong username or password!');
                    redirect('admin');
                }
            }
            $this->load->view('home/login');
        }
        $this->load->view('_parts/footer');
    }

}
