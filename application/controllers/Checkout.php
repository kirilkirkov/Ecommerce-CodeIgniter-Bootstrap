<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    public function index()
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Articles_model->getSeo('page_checkout', $this->my_lang);
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $new_request = false;
        if (isset($_POST['payment_type']) && $_POST['payment_type'] == 1) { // Cash On Delivery
            $errors = $this->cashOnDeliveryValidate($_POST);
            if (!empty($errors)) {
                $this->session->set_flashdata('submit_error', $errors);
            } else {

                $this->Articles_model->setOrder($_POST);
                $new_request = true;
            }
        }
        if ($new_request == true) { // send emails to users that want it (notify = 1)
            $mails = $this->Articles_model->getNotifyUsers();
            if (!empty($mails)) {
                $to_emails = implode(', ', $mails);
                $this->email->from('The Online Shop', '');
                $this->email->to($to_emails);

                $this->email->subject('New order request');
                $this->email->message('You have new order request, go to your administration to proccess it!');

                $this->email->send();
            }
            $this->clearShoppingCart(); // clear items
            redirect($this->lang_link . '/checkout?order_completed');
        }
        $data['bestSellers'] = $this->Articles_model->getbestSellers($this->my_lang);
        $this->render('checkout', $head, $data);
    }

    private function cashOnDeliveryValidate($post)
    {
        $errors = array();
        if (mb_strlen(trim($post['first_name'])) == 0) {
            $errors[] = lang('first_name_empty');
        }
        if (mb_strlen(trim($post['last_name'])) == 0) {
            $errors[] = lang('last_name_empty');
        }
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = lang('invalid_email');
        }
        $post['phone'] = preg_replace("/[^0-9]/", '', $post['phone']);
        if (mb_strlen(trim($post['phone'])) == 0) {
            $errors[] = lang('invalid_phone');
        }
        if (mb_strlen(trim($post['address'])) == 0) {
            $errors[] = lang('address_empty');
        }
        if (mb_strlen(trim($post['city'])) == 0) {
            $errors[] = lang('invalid_city');
        }
        $post['post_code'] = preg_replace("/[^0-9]/", '', $post['post_code']);
        if (mb_strlen(trim($post['post_code'])) == 0) {
            $errors[] = lang('invalid_post_code');
        }
        return $errors;
    }

}
