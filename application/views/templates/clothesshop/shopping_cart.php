<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container" id="shopping-cart">
    <div class="body">
        <h1><?= lang('shopping_cart') ?></h1>
        <hr>
        <?php
        if ($cartItems['array'] == null) {
            ?>
            <div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
            <?php
        } else {
            echo purchase_steps(1);
            ?>
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
                                    <a href="<?= base_url('home/removeFromCart?delete-product=' . $item['id'] . '&back-to=shopping-cart') ?>" class="btn btn-xs btn-danger remove-product">
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
            <a href="<?= LANG_URL ?>" class="btn cloth-bg-color go-shop">
                <i class="fa fa-angle-left" aria-hidden="true"></i> 
                <?= lang('back_to_shop') ?>
            </a>
            <a class="btn cloth-bg-color go-checkout" href="<?= LANG_URL . '/checkout' ?>">
                <?= lang('checkout') ?> 
                <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
            </a>
        <?php } ?>
        <div class="bottom-30"></div>
        <?php include 'bodyFooter.php' ?>
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
<?php } ?>