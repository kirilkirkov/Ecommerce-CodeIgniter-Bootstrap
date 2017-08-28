<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/css/nice-select.css') ?>" rel="stylesheet">
<div class="container" id="checkout-page">
    <div class="body">
        <?php if ($cartItems['array'] != null) { ?>
            <?= purchase_steps(1, 2) ?>
            <div class="row bottom-30">
                <div class="col-sm-9 left-side">
                    <form method="POST" id="goOrder">
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
                        <?php if ($codeDiscounts == 1) { ?>
                            <div class="discount">
                                <label><?= lang('discount_code') ?></label>
                                <input class="form-control" name="discountCode" value="<?= @$_POST['discountCode'] ?>" placeholder="<?= lang('enter_discount_code') ?>" type="text">
                                <a href="javascript:void(0);" class="btn btn-default" onclick="checkDiscountCode()"><?= lang('check_code') ?></a>
                            </div>
                        <?php } ?>
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
                                        <td>
                                            <span class="final-amount"><?= $cartItems['finalSum'] ?></span><?= CURRENCY ?>
                                            <input type="hidden" class="final-amount" name="final_amount" value="<?= $cartItems['finalSum'] ?>">
                                            <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
                                            <input type="hidden" name="discountAmount" value="">
                                        </td>
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
                        <a href="javascript:void(0);" class="btn cloth-bg-color go-order" onclick="document.getElementById('goOrder').submit();">
                            <?= lang('custom_order') ?> 
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                        <div class="visible-xs bottom-30"></div>
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
            <?php
            include 'bodyFooter.php';
        } else {
            ?>
            <div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
            <?php
        }
        ?>
    </div>
</div>
<?php
if ($this->session->flashdata('deleted')) {
    ?>
<script>
$(document).ready(function () {
    ShowNotificator('alert-info', '<?= $this->session->flashdata('deleted') ?>');
});
</script>
<?php } if ($codeDiscounts == 1 && isset($_POST['discountCode'])) {
    ?>
<script>
$(document).ready(function () {
    checkDiscountCode();
});
</script>
<?php } ?>
<script src="<?= base_url('assets/js/jquery.nice-select.min.js') ?>"></script>
<script>
$(document).ready(function () {
    $('select').niceSelect();
});
</script>