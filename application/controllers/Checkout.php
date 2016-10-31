<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper(array('currency_convertor'));
        $vars['paypal_sandbox'] = $this->Admin_model->getValueStore('paypal_sandbox');
        $vars['paypal_email'] = $this->Admin_model->getValueStore('paypal_email');
        $vars['paypal_currency'] = $this->Admin_model->getValueStore('paypal_currency');
        $vars['currencyKey'] = $this->currencyKey;
        $this->load->vars($vars);
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
        if (isset($_POST['payment_type'])) {
            $errors = $this->userInfoValidate($_POST);
            if (!empty($errors)) {
                $this->session->set_flashdata('submit_error', $errors);
            } else {
                $result = $this->Articles_model->setOrder($_POST);
                if ($result == true) {
                    $new_request = true;
                }
            }
        }
        if ($new_request == true) { // send emails to users that want it (notify = 1)
            $emails = $this->Articles_model->getNotifyUsers();
            if (!empty($emails)) {
                $toEmails = implode(', ', $emails);
                $shopName = $this->config->item('base_url');
                $this->email->from($shopName, '');
                $this->email->to($toEmails);
                $this->email->subject('New order request to ' . $shopName);
                $this->email->message('You have new order request, go to your administration to proccess it!');
                $this->email->send();
            }
            /*
             * Else will clear after receive payment
             * We need products to send it to paypal
             */
            if ($_POST['payment_type'] == 'cashOnDelivery') {
                $this->clearShoppingCart();
            }
            if ($_POST['payment_type'] == 'PayPal') {
                @set_cookie('paypal', $result, 2678400); // $result is order id
            }
            redirect($this->lang_link . '/checkout?order_completed=true&payment_type=' . $_POST['payment_type']);
        }
        if (get_cookie('paypal') != null && !isset($_GET['payment_type'])) {
            redirect($this->lang_link . '/checkout?order_completed=true&payment_type=PayPal');
        }
        $data['bestSellers'] = $this->Articles_model->getbestSellers($this->my_lang);
        $this->render('checkout', $head, $data);
    }

    private function userInfoValidate($post)
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
        /*
          $post['post_code'] = preg_replace("/[^0-9]/", '', $post['post_code']);
          if (mb_strlen(trim($post['post_code'])) == 0) {
          $errors[] = lang('invalid_post_code');
          }
         */
        return $errors;
    }

    public function paypal_cancel()
    {
        if (get_cookie('paypal') == null) {
            redirect(base_url());
        }
        @delete_cookie('paypal');
        $orderId = get_cookie('paypal');
        $this->Articles_model->changePaypalOrderStatus($orderId, 'canceled');
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('checkout_parts/paypal_cancel', $head, $data);
    }

    public function paypal_success()
    {
        if (get_cookie('paypal') == null) {
            redirect(base_url());
        }
        @delete_cookie('paypal');
        $this->clearShoppingCart();
        $orderId = get_cookie('paypal');
        $this->Articles_model->changePaypalOrderStatus($orderId, 'payed');
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('checkout_parts/paypal_success', $head, $data);
    }

}
