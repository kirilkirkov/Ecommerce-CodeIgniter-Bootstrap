<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ShoppingCart extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->Model('Articles_model');
    }

    public function index()
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Articles_model->getSeo('page_shoppingcart', $this->my_lang);
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $this->render('shopping_cart', $head, $data);
    }

}
