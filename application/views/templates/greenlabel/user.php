<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="inner-nav">
    <div class="container">
        <a href="<?= LANG_URL ?>"><?= lang('home') ?></a> <span class="active"> > <?= lang('user_login') ?></span>
    </div>
</div>
<div class="container user-page">
    <div class="row">
        <div class="col-sm-4">
            <div class="loginmodal-container">
                <h1><?= lang('my_acc') ?></h1><br>
                <form method="POST" action="">
                    <input type="text" name="name" value="<?= $userInfo['name'] ?>" placeholder="Name">
                    <input type="text" name="phone" value="<?= $userInfo['phone'] ?>" placeholder="Phone">
                    <input type="text" name="email"  value="<?= $userInfo['email'] ?>" placeholder="Email">
                    <input type="password" name="pass" placeholder="Password (leave blank if no change)"> 
                    <input type="submit" name="update" class="login loginmodal-submit" value="<?= lang('update') ?>">
                    <a href="<?= LANG_URL . '/logout' ?>" class="login loginmodal-submit text-center"><?= lang('logout') ?></a>
                </form>
            </div>
        </div>
        <div class="col-sm-8">
            <?= lang('user_order_history') ?>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><?= lang('usr_order_id') ?></th>
                            <th><?= lang('usr_order_date') ?></th>
                            <th><?= lang('usr_order_address') ?></th>
                            <th><?= lang('usr_order_phone') ?></th>
                            <th><?= lang('user_order_products') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($orders_history)) {
                            foreach ($orders_history as $order) {
                                ?>
                                <tr>
                                    <td><?= $order['order_id'] ?></td>
                                    <td><?= date('d.m.Y', $order['date']) ?></td>
                                    <td><?= $order['address'] ?></td>
                                    <td><?= $order['phone'] ?></td>
                                    <td>    
                                        <?php
                                        $arr_products = unserialize($order['products']);
                                        foreach ($arr_products as $product_id => $product_quantity) {
                                            $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product_id, true);
                                            ?>
                                            <div style="word-break: break-all;">
                                                <div>
                                                    <img src="<?= base_url('attachments/shop_images/' . $productInfo['image']) ?>" alt="Product" style="width:100px; margin-right:10px;" class="img-responsive">
                                                </div>
                                                <a target="_blank" href="<?= base_url($productInfo['url']) ?>">
                                                    <?= base_url($productInfo['url']) ?> 
                                                </a> 
                                                <div style=" background-color: #f1f1f1; border-radius: 2px; padding: 2px 5px;"><b><?= lang('user_order_quantity') ?></b> <?= $product_quantity ?></div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <hr>
                                        <?php }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5"><?= lang('usr_no_orders') ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?= $links_pagination ?>
            </div>
        </div>
    </div>
</div>