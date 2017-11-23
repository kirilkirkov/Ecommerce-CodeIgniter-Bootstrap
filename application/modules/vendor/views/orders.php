<link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">
<div class="content orders-page">
    <table class="table">
        <thead class="blue-grey lighten-4">
            <tr>
                <th>#</th>
                <th><?= lang('time_created') ?></th>
                <th><?= lang('order_type') ?></th>
                <th><?= lang('phone') ?></th>
                <th><?= lang('status') ?></th>
                <th class="text-right"><i class="fa fa-list" aria-hidden="true"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($orders as $order) {
                ?>
                <tr>
                    <td><?= $order['order_id'] ?></td>
                    <td><?= date('d.m.Y', $order['date']) ?></td>
                    <td><?= $order['payment_type'] ?></td>
                    <td><?= $order['phone'] ?></td>
                    <td>
                        <select class="selectpicker change-ord-status" data-ord-id="<?= $order['id'] ?>" data-style="btn-green"> 
                            <option <?= $order['processed'] == 0 ? 'selected="selected"' : '' ?> value="0"><?= lang('new') ?></option>
                            <option <?= $order['processed'] == 1 ? 'selected="selected"' : '' ?> value="1"><?= lang('processed') ?></option>
                            <option <?= $order['processed'] == 2 ? 'selected="selected"' : '' ?> value="2"><?= lang('rejected') ?></option>
                        </select>
                    </td>
                    <td class="text-right">
                        <a href="javascript:void(0);" class="btn btn-sm btn-green show-more" data-show-tr="<?= $i ?>">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                <tr class="tr-more" data-tr="<?= $i ?>">
                    <td colspan="6">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul>
                                    <li>
                                        <b><?= lang('first_name') ?></b> <span><?= $order['first_name'] ?></span>
                                    </li>
                                    <li>
                                        <b><?= lang('last_name') ?></b> <span><?= $order['last_name'] ?></span>
                                    </li>
                                    <li>
                                        <b><?= lang('email') ?></b> <span><?= $order['email'] ?></span>
                                    </li>
                                    <li>
                                        <b><?= lang('phone') ?></b> <span><?= $order['phone'] ?></span>
                                    </li>
                                    <li>
                                        <b><?= lang('address') ?></b> <span><?= $order['address'] ?></span>
                                    </li>
                                    <li>
                                        <b><?= lang('city') ?></b> <span><?= $order['city'] ?></span>
                                    </li>
                                    <li>
                                        <b><?= lang('post_code') ?></b> <span><?= $order['post_code'] ?></span>
                                    </li>
                                    <li>
                                        <b><?= lang('notes') ?></b> <span><?= $order['notes'] ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                $product = unserialize($order['products']);
                                foreach ($product as $prod_id => $prod_qua) {
                                    $productInfo = modules::run('vendor/orders/getProductInfo', $prod_id, $order['vendor_id']);
                                    ?>
                                    <div class="product">
                                        <a href="" target="_blank">
                                            <img src="<?= base_url('/attachments/shop_images/' . $productInfo['image']) ?>" alt="">
                                            <div class="info">
                                                <span class="qiantity">
                                                    <b><?= lang('quantity') ?></b> <?= $prod_qua ?>
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>
<script src="<?= base_url('assets/bootstrap-select-1.12.1/js/bootstrap-select.min.js') ?>"></script>