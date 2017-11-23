<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Orders extends VENDOR_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Orders_model', 'Products_model'));
    }

    public function index($page = 0)
    {

        $data = array();
        $head = array();
        $head['title'] = lang('vendor_orders');
        $head['description'] = lang('vendor_orders');
        $head['keywords'] = '';
        $rowscount = $this->Orders_model->ordersCount($this->vendor_id);
        $data['orders'] = $this->Orders_model->orders($this->num_rows, $page, $this->vendor_id);
        $this->load->view('_parts/header', $head);
        $this->load->view('orders', $data);
        $this->load->view('_parts/footer');
    }

    public function getProductInfo($product_id, $vendor_id)
    {
        return $this->Products_model->getOneProduct($product_id, $vendor_id);
    }

    public function changeOrdersOrderStatus()
    {
        $result = $this->Orders_model->changeOrderStatus($_POST['the_id'], $_POST['to_status']);
        if ($result == false) {
            echo '0';
        } else {
            echo '1';
        }
    }

}
