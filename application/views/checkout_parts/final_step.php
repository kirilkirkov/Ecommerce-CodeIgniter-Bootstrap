<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <h1>
        <?= lang('you_choose_payment') ?>
        <?php if ($_SESSION['final_step']['payment_type'] == 'cashOnDelivery') { ?>
            <u><?= lang('cash_on_delivery') ?></u>
        <?php } elseif ($_SESSION['final_step']['payment_type'] == 'PayPal') { ?>
            <img src="<?= base_url('assets/imgs/paypal.png') ?>" alt="paypal" style="width:100px;">
        <?php } ?>
    </h1>
    <hr>
    <div class="row">
        <div class="col-sm-6 final-left-col">
            <div class="order-info">
                <h3><?= lang('first_name') ?></h3>
                <span class=""><?= $_SESSION['final_step']['first_name'] ?></span>
            </div>
            <div class="order-info">
                <h3><?= lang('last_name') ?></h3>
                <span class=""><?= $_SESSION['final_step']['last_name'] ?></span>
            </div>
            <div class="order-info">
                <h3><?= lang('email_address') ?></h3>
                <span class=""><?= $_SESSION['final_step']['email'] ?></span>
            </div>
            <div class="order-info">
                <h3><?= lang('phone') ?></h3>
                <span class=""><?= $_SESSION['final_step']['phone'] ?></span>
            </div>
            <div class="order-info">
                <h3><?= lang('address') ?></h3>
                <span class=""><?= $_SESSION['final_step']['address'] ?></span>
            </div>
            <div class="order-info">
                <h3><?= lang('city') ?></h3>
                <span class=""><?= $_SESSION['final_step']['city'] ?></span>
            </div>
            <div class="order-info">
                <h3><?= lang('post_code') ?></h3>
                <span class=""><?= $_SESSION['final_step']['post_code'] ?></span>
            </div>
            <div class="order-info">
                <h3><?= lang('notes') ?></h3>
                <span class=""><?= $_SESSION['final_step']['notes'] ?></span>
            </div>
        </div>
        <div class="col-sm-6">
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
                                <td>
                                    <img class="product-image" src="<?= base_url('/attachments/shop_images/' . $item['image']) ?>" alt="">
                                </td>
                                <td><a href="<?= base_url($item['url']) ?>"><?= $item['title'] ?></a></td>
                                <td>
                                    <?= $item['num_added'] ?>
                                </td>
                                <td><?= $item['price'] . $currency ?></td>
                                <td><?= $item['sum_price'] . $currency ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-right"><?= lang('total') ?></td>
                            <td><?= $cartItems['finalSum'] . $currency ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <form method="POST" action="<?= base_url('checkout') ?>" class="final-step-form">
        <input type="hidden" name="saveOrder" value="1">
        <a href="<?= base_url('checkout') ?>" class="btn btn-lg btn-primary"><?= lang('order_correction') ?></a>
        <input type="submit" value="<?= lang('final_step') ?>" class="btn btn-lg btn-primary">
    </form>
</div>