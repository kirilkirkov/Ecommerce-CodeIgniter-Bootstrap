<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <?php
    $sandbox = '.';
    if ($paypal_sandbox == 1) {
        $sandbox = '.sandbox.';
    }
    if (!empty($cartItems['array'])) {
        ?>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <img src="<?= base_url('template/imgs/paypal.png') ?>" class="img-responsive paypal-image">
            </div>
        </div>
        <div class="alert alert-info text-center"><?= lang('you_choose_paypal') ?></div>
        <hr>
        <form action="https://www<?= $sandbox ?>paypal.com/cgi-bin/webscr" method="post" target="_top" class="paypal-form text-center">
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" value="<?= $paypal_email ?>" name="business">
            <input type="hidden" name="upload" value="1">
            <?php
            $discount = $_SESSION['discountAmount'] / count($cartItems['array']); // discount for each item
            $i = 1;
            foreach ($cartItems['array'] as $item) {
                ?>
                <input type="hidden" name="item_name_<?= $i ?>" value="<?= $item['title'] ?>">
                <input type="hidden" name="amount_<?= $i ?>" value="<?= convertCurrency($item['price'], CURRENCY_KEY, $paypal_currency) ?>">
                <input type="hidden" name="discount_amount_<?= $i ?>" value="<?= convertCurrency($discount, CURRENCY_KEY, $paypal_currency) ?>">
                <input type="hidden" name="quantity_<?= $i ?>" value="<?= $item['num_added'] ?>">
                <?php
                $i++;
            }
            ?> 
            <input type="hidden" name="currency_code" value="<?= $paypal_currency ?>">
            <input type="hidden" value="utf-8" name="charset">
            <input type="hidden" value="<?= base_url('checkout/paypal_success') ?>" name="return">
            <input type="hidden" value="<?= base_url('checkout/paypal_cancel') ?>" name="cancel_return">
            <input type="hidden" value="authorization" name="paymentaction">
            <a href="<?= base_url('checkout/paypal_cancel') ?>" class="btn btn-lg btn-danger btm-10"><?= lang('cancel_payment') ?></a>
            <button type="submit" class="btn btn-lg btn-success btm-10"><?= lang('go_to_paypal') ?> <i class="fa fa-cc-paypal" aria-hidden="true"></i></button>
        </form>
        <?php
    } else {
        redirect(base_url());
    }
    ?>
</div>