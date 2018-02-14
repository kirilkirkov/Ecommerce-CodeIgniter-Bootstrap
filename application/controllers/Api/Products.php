<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Products extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->load->model(array('Api_model', 'admin/Products_model'));
    }

    /*
     * Get All Products
     */

    public function all_get($lang)
    {
        $products = $this->Api_model->getProducts($lang);

        // Check if the products data store contains products (in case the database result returns NULL)
        if ($products) {
            // Set the response and exit
            $this->response($products, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No products were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /*
     * Get One Product
     */

    public function one_get($lang, $id)
    {
        $product = $this->Api_model->getProduct($lang, $id);

        // Check if the products data store contains products (in case the database result returns NULL)
        if ($product) {
            // Set the response and exit
            $this->response($product, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No product were found'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

}
