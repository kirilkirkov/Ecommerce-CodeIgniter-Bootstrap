<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends ADMIN_Controller
{

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Home';
        $head['description'] = '';
        $head['keywords'] = '';
        $data['newOrdersCount'] = $this->AdminModel->ordersCount(true);
        $data['lowQuantity'] = $this->AdminModel->countLowQuantityProducts();
        $data['lastSubscribed'] = $this->AdminModel->lastSubscribedEmailsCount();
        $data['activity'] = $this->AdminModel->getHistory(10, 0);
        $data['mostSold'] = $this->AdminModel->getMostSoldProducts();
        $data['byReferral'] = $this->AdminModel->getReferralOrders();
        $data['ordersByPaymentType'] = $this->AdminModel->getOrdersByPaymentType();
        $data['ordersByMonth'] = $this->AdminModel->getOrdersByMonth();
        $this->load->view('_parts/header', $head);
        $this->load->view('home/home', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to home page');
    }

    /*
     * Called from ajax
     */

    public function changePass()
    {
        $this->login_check();
        $result = $this->AdminModel->changePass($_POST['new_pass'], $this->username);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Password change for user: ' . $this->username);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin');
    }

}
