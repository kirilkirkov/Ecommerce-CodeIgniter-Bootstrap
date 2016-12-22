<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/css/nice-select.css') ?>" rel="stylesheet">
<div class="container" id="checkout-page">
    <div class="body">
        <?php
        if (isset($_GET['order_completed'])) {
            if (isset($_GET['payment_type']) && $_GET['payment_type'] == 'cashOnDelivery') {
                ?>
                <?= purchase_steps(1, 2, 3) ?>
                <div class="alert alert-success"><?= lang('c_o_d_order_completed') ?>!</div>
                <a href="<?= base_url() ?>" class="btn btn-default"><i class="fa fa-angle-left" aria-hidden="true"></i> <?= lang('go_back') ?></a>
                <div class="bottom-30"></div>               
                <?php
            } elseif (isset($_GET['payment_type']) && $_GET['payment_type'] == 'PayPal') {
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
                        $i = 1;
                        foreach ($cartItems['array'] as $item) {
                            ?>
                            <input type="hidden" name="item_name_<?= $i ?>" value="<?= $item['title'] ?>">
                            <input type="hidden" name="amount_<?= $i ?>" value="<?= convertCurrency($item['price'], CURRENCY_KEY, $paypal_currency) ?>">
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
                <?php } else {
                    ?>
                    <div class="alert alert-info"><?= lang('no_products') ?></div>
                    <?php
                }
            } elseif (isset($_GET['payment_type']) && $_GET['payment_type'] == 'Bank') {
                if (isset($_SESSION['order_id'])) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="2"><b class="bg-info"><?= lang('bank_recipient_name') ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?= $bank_account != null ? $bank_account['name'] : '' ?></td>
                                </tr>
                                <tr>
                                    <td><b class="bg-info"><?= lang('bank_iban') ?></b></td>
                                    <td><b class="bg-info"><?= lang('bank_bic') ?></b></td>
                                </tr>
                                <tr>
                                    <td><?= $bank_account != null ? $bank_account['iban'] : '' ?></td>
                                    <td><?= $bank_account != null ? $bank_account['bic'] : '' ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b class="bg-info"><?= lang('bank_name') ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?= $bank_account != null ? $bank_account['bank'] : '' ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b class="bg-info"><?= lang('bank_reason') ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?= lang('the_reason') ?> - <?= $_SESSION['order_id'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info"><?= lang('no_products') ?></div>
                <?php } ?>
                <a href="<?= base_url() ?>" class="btn btn-default"><i class="fa fa-angle-left" aria-hidden="true"></i> <?= lang('go_back') ?></a>
                <div class="bottom-30"></div>
            <?php } ?>
            <?php include 'bodyFooter.php' ?>
        </div>
    </div>
<?php } elseif ($cartItems['array'] != null) { ?>
    <?= purchase_steps(1, 2) ?>
    <div class="row bottom-30">
        <div class="col-sm-9 left-side">
            <form method="POST" id="goOrder">
                <input type="hidden" name="referrer" value="<?= $this->session->userdata('referrer') ?>">
                <div class="title alone cloth-bg-color">
                    <span><?= lang('checkout') ?></span>
                </div>
                <?php
                if ($this->session->flashdata('submit_error')) {
                    ?>
                    <hr>
                    <div class="alert alert-danger"><h4><span class="glyphicon glyphicon-alert"></span> <?= lang('finded_errors') ?></h4><?php
                        foreach ($this->session->flashdata('submit_error') as $error)
                            echo $error . '<br>';
                        ?>
                    </div>
                    <hr>
                    <?php
                }
                ?>
                <div class="row payment-type-box">
                    <div class="col-xs-12">
                        <span class="top-header"><?= lang('choose_payment') ?>:</span>
                        <select class="payment-type" data-style="btn-blue" name="payment_type">
                            <?php if ($cashondelivery_visibility == 1) { ?>
                                <option value="cashOnDelivery"><?= lang('cash_on_delivery') ?> </option>
                            <?php } if (filter_var($paypal_email, FILTER_VALIDATE_EMAIL)) { ?>
                                <option value="PayPal"><?= lang('paypal') ?> </option>
                            <?php } if ($bank_account['iban'] != null) { ?>
                                <option value="Bank"><?= lang('bank_payment') ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="firstNameInput"><?= lang('first_name') ?> (<sup><?= lang('requires') ?></sup>)</label>
                        <input id="firstNameInput" class="form-control" name="first_name" value="<?= @$_POST['first_name'] ?>" type="text" placeholder="<?= lang('first_name') ?>">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="lastNameInput"><?= lang('last_name') ?> (<sup><?= lang('requires') ?></sup>)</label>
                        <input id="lastNameInput" class="form-control" name="last_name" value="<?= @$_POST['last_name'] ?>" type="text" placeholder="<?= lang('last_name') ?>">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="emailAddressInput"><?= lang('email_address') ?> (<sup><?= lang('requires') ?></sup>)</label>
                        <input id="emailAddressInput" class="form-control" name="email" value="<?= @$_POST['email'] ?>" type="text" placeholder="<?= lang('email_address') ?>">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="phoneInput"><?= lang('phone') ?> (<sup><?= lang('requires') ?></sup>)</label>
                        <input id="phoneInput" class="form-control" name="phone" value="<?= @$_POST['phone'] ?>" type="text" placeholder="<?= lang('phone') ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="addressInput"><?= lang('address') ?> (<sup><?= lang('requires') ?></sup>)</label>
                        <textarea id="addressInput" name="address" class="form-control" rows="3"><?= @$_POST['address'] ?></textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="cityInput"><?= lang('city') ?> (<sup><?= lang('requires') ?></sup>)</label>
                        <input id="cityInput" class="form-control" name="city" value="<?= @$_POST['city'] ?>" type="text" placeholder="<?= lang('city') ?>">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="postInput"><?= lang('post_code') ?></label>
                        <input id="postInput" class="form-control" name="post_code" value="<?= @$_POST['post_code'] ?>" type="text" placeholder="<?= lang('post_code') ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="notesInput"><?= lang('notes') ?></label>
                        <textarea id="notesInput" class="form-control" name="notes" rows="3"><?= @$_POST['notes'] ?></textarea>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-products">
                        <thead>
                            <tr>
                                <th><?= lang('product') ?></th>
                                <th><?= lang('title') ?></th>
                                <th><?= lang('quantity') ?></th>
                                <th><?= lang('price') ?></th>
                                <th><?= lang('total') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems['array'] as $item) { ?>
                                <tr>
                                    <td class="relative">
                                        <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                                        <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
                                        <img class="product-image" src="<?= base_url('/attachments/shop_images/' . $item['image']) ?>" alt="">
                                        <a href="<?= base_url('home/removeFromCart?delete-product=' . $item['id'] . '&back-to=checkout') ?>" class="btn btn-xs btn-danger remove-product">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td><a href="<?= LANG_URL . '/' . $item['url'] ?>"><?= $item['title'] ?></a></td>
                                    <td>
                                        <a class="btn btn-xs btn-primary refresh-me add-to-cart" data-id="<?= $item['id'] ?>" href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </a>
                                        <span class="quantity-num">
                                            <?= $item['num_added'] ?>
                                        </span>
                                        <a class="btn  btn-xs btn-danger" onclick="removeProduct(<?= $item['id'] ?>, true)" href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </a>
                                    </td>
                                    <td><?= $item['price'] . CURRENCY ?></td>
                                    <td><?= $item['sum_price'] . CURRENCY ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" class="text-right"><?= lang('total') ?></td>
                                <td><?= $cartItems['finalSum'] . CURRENCY ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
            <div>
                <a href="<?= LANG_URL ?>" class="btn cloth-bg-color go-shop">
                    <i class="fa fa-angle-left" aria-hidden="true"></i> 
                    <?= lang('back_to_shop') ?>
                </a>

                <a href="javascript:void(0);" class="btn cloth-bg-color go-order" onclick="document.getElementById('goOrder').submit();" class="pull-left">
                    <?= lang('custom_order') ?> 
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-sm-3"> 
            <div class="filter-sidebar">
                <div class="title cloth-bg-color">
                    <span><?= lang('best_sellers') ?></span>
                </div>
                <?= $load::getProducts($bestSellers, '', true) ?>
            </div>
        </div>
    </div>
    <?php include 'bodyFooter.php' ?>
    </div>
    </div>
<?php } else { ?>
    <div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
<?php } ?>
<?php
if ($this->session->flashdata('deleted')) {
    ?>
    <script>
        $(document).ready(function () {
            ShowNotificator('alert-info', '<?= $this->session->flashdata('deleted') ?>');
        });
    </script>
<?php } ?>
<script src="<?= base_url('assets/js/jquery.nice-select.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('select').niceSelect();
    });
</script>