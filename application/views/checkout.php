<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container" id="checkout-page">
    <?php
    if (isset($_GET['order_completed'])) {
        ?>
        <div class="alert alert-success"><?= lang('order_completed') ?></div>
        <a href="<?= base_url() ?>" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> <?= lang('go_back') ?></a>
    </div>
<?php } elseif ($cartItems['array'] != null) { ?>
    <div class="row">
        <div class="col-sm-9 left-side">
            <form method="POST" id="goOrder">
                <input type="hidden" name="referrer" value="<?= $this->session->userdata('referrer') ?>">
                <div class="title alone">
                    <span><?= lang('checkout') ?></span>
                </div>
                <?php
                if ($this->session->flashdata('submit_error')) {
                    ?>
                    <hr>
                    <div class="alert alert-danger"><h4><span class="glyphicon glyphicon-alert"></span> <?= lang('finded_errors') ?></h4><?php
                        foreach ($this->session->flashdata('submit_error') as $error)
                            echo $error . '<br>';
                        ?></div>
                    <hr>
                    <?php
                }
                ?>
                <select class="selectpicker payment-type" data-style="btn-blue" name="payment_type">
                    <option value="1"><?= lang('cash_on_delivery') ?> </option>
                </select>

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
                        <label for="postInput"><?= lang('post_code') ?> (<sup><?= lang('requires') ?></sup>)</label>
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
                                    <td>
                                        <input type="hidden" name="product_id[]" value="<?= $item['product_id'] ?>">
                                        <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
                                        <img class="product-image" src="<?= base_url('/attachments/shop_images/' . $item['image']) ?>" alt="">
                                    </td>
                                    <td><a href="<?= base_url($item['url']) ?>"><?= $item['title'] ?></a></td>
                                    <td><?= $item['num_added'] ?></td>
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
            </form>
            <div>
                <a href="<?= $lang_url ?>" class="btn btn-primary pull-left"><span class="glyphicon glyphicon-circle-arrow-left"></span> <?= lang('back_to_shop') ?></a>
                <a href="javascript:void(0);" class="btn btn-primary pull-right" onclick="document.getElementById('goOrder').submit();" class="pull-left"><?= lang('custom_order') ?> <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-sm-3"> 
            <div class="filter-sidebar">
                <div class="title">
                    <span><?= lang('best_sellers') ?></span>
                    <i class="fa fa-trophy" aria-hidden="true"></i>
                </div>
                <?php loop_products($bestSellers, $currency, '', true, $lang_url, $publicQuantity); ?>
            </div>
        </div>
    </div>
    </div>
<?php } else { ?>
    <div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
<?php } ?>