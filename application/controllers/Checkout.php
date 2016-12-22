<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper(array('currency_convertor'));
        /*
         * Get Bank Account
         */
        $vars['bank_account'] = $this->AdminModel->getBankAccountSettings();
        $this->load->vars($vars);
    }

    public function index()
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Publicmodel->getSeo('page_checkout');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);

        /*
         *  Get Value Stores
         */
        $haveFinalPage = $this->AdminModel->getValueStore('finalCheckoutPage');
        $data['cashondelivery_visibility'] = $this->AdminModel->getValueStore('cashondelivery_visibility');
        $data['paypal_sandbox'] = $this->AdminModel->getValueStore('paypal_sandbox');
        $data['paypal_email'] = $this->AdminModel->getValueStore('paypal_email');
        $data['paypal_currency'] = $this->AdminModel->getValueStore('paypal_currency');

        $new_request = false;
        $fromFinalPage = false;
        if (isset($_POST['payment_type'])) {
            if (isset($_SESSION['final_step']) && isset($_POST['saveOrder'])) {
                $_POST = $_SESSION['final_step'];
                $fromFinalPage = true;
            }
            $errors = $this->userInfoValidate($_POST);
            if (!empty($errors)) {
                $this->session->set_flashdata('submit_error', $errors);
            } else {
                if ($haveFinalPage == true && $fromFinalPage == false) {
                    $_SESSION['final_step'] = $_POST;
                    redirect(LANG_URL . '/checkout/finalStep');
                } elseif ($haveFinalPage == false || $fromFinalPage == true) {
                    if (isset($_POST['saveOrder'])) {
                        unset($_POST['saveOrder']);
                        $_POST = $_SESSION['final_step'];
                        unset($_SESSION['final_step']);
                    }
                    $result = $this->Publicmodel->setOrder($_POST);
                    if ($result == true) {
                        $new_request = true;
                    }
                }
            }
        }
        /*
         * Send emails to users that want it
         * (notify = 1)
         */
        if ($new_request == true) {
            $emails = $this->Publicmodel->getNotifyUsers();
            if (!empty($emails)) {
                $toEmails = implode(', ', $emails);
                $shopName = $this->config->item('base_url');
                $to = $toEmails;
                $subject = 'New order request to ' . $shopName;
                $txt = 'You have new order request, go to your administration to proccess it!';
                $headers = "From: " . $shopName;
                mail($to, $subject, $txt, $headers);
            }
            /*
             * Else will clear after receive payment
             * We need products to send it to paypal
             */
            if ($_POST['payment_type'] == 'cashOnDelivery' || $_POST['payment_type'] == 'Bank') {
                $this->shoppingcart->clearShoppingCart();
            }
            if ($_POST['payment_type'] == 'Bank') {
                $_SESSION['order_id'] = $result;
            }
            if ($_POST['payment_type'] == 'PayPal') {
                @set_cookie('paypal', $result, 2678400); // $result is order id
            }
            unset($_SESSION['final_step']);
            redirect(LANG_URL . '/checkout?order_completed=true&payment_type=' . $_POST['payment_type']);
        }
        if (get_cookie('paypal') != null && !isset($_GET['payment_type'])) {
            redirect(LANG_URL . '/checkout?order_completed=true&payment_type=PayPal');
        }
        if (isset($_SESSION['final_step'])) {
            $_POST = $_SESSION['final_step'];
        }
        $data['bestSellers'] = $this->Publicmodel->getbestSellers();
        $this->render('checkout', $head, $data);
    }

    public function finalStep()
    {
        if (!isset($_SESSION['final_step'])) {
            redirect(base_url());
        }
        $data = array();
        $head = array();
        $arrSeo = $this->Publicmodel->getSeo('page_checkout');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $this->render('checkout_parts/final_step', $head, $data);
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
        $this->Publicmodel->changePaypalOrderStatus($orderId, 'canceled');
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
        $this->shoppingcart->clearShoppingCart();
        $orderId = get_cookie('paypal');
        $this->Publicmodel->changePaypalOrderStatus($orderId, 'payed');
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('checkout_parts/paypal_success', $head, $data);
    }

}
