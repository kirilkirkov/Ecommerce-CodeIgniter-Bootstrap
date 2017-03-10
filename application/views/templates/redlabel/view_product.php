<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container" id="view-product">
    <div class="row">
        <div class="col-sm-4">
            <div <?= $product['folder'] != null ? 'style="margin-bottom:20px;"' : '' ?>>
                <img src="<?= base_url('/attachments/shop_images/' . $product['image']) ?>" style="width:auto; height:auto;" data-num="0" class="other-img-preview img-responsive img-sl the-image" alt="<?= str_replace('"', "'", $product['title']) ?>">
            </div>
            <?php
            if ($product['folder'] != null) {
                $dir = "attachments/shop_images/" . $product['folder'] . '/';
                ?>
                <div class="row">
                    <?php
                    if (is_dir($dir)) {
                        if ($dh = opendir($dir)) {
                            $i = 1;
                            while (($file = readdir($dh)) !== false) {
                                if (is_file($dir . $file)) {
                                    ?>
                                    <div class="col-xs-4 col-sm-6 col-md-4 text-center">
                                        <img src="<?= base_url($dir . $file) ?>" data-num="<?= $i ?>" class="other-img-preview img-sl img-thumbnail the-image" alt="<?= str_replace('"', "'", $product['title']) ?>">
                                    </div>
                                    <?php
                                    $i++;
                                }
                            }
                            closedir($dh);
                        }
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="col-sm-8">
            <h1><?= $product['title'] ?></h1>
            <div class="row row-info">
                <div class="col-sm-6"><b><?= lang('price') ?>:</b></div>
                <div class="col-sm-6"><?= $product['price'] . CURRENCY ?></div>
                <div class="col-sm-12 border-bottom"></div>
            </div>
            <?php if ($product['old_price'] != '') { ?>
                <div class="row row-info">
                    <div class="col-sm-6"><b><?= lang('old_price') ?>:</b></div>
                    <div class="col-sm-6"><?= $product['old_price'] . CURRENCY ?></div>
                    <div class="col-sm-12 border-bottom"></div>
                </div>
            <?php } if ($publicQuantity == 1) { ?>
                <div class="row row-info">
                    <div class="col-sm-6">
                        <b><?= lang('in_stock') ?>:</b>
                    </div>
                    <div class="col-sm-6"><?= $product['quantity'] ?></div>
                    <div class="col-sm-12 border-bottom"></div>
                </div>
            <?php } ?>
            <div class="row row-info">
                <div class="col-sm-6"><b><?= lang('num_added_to_cart') ?>:</b></div>
                <div class="col-sm-6"><?php
                    @$result = array_count_values($_SESSION['shopping_cart']);
                    if (isset($result[$product['id']]))
                        echo $result[$product['id']];
                    else
                        echo 0;
                    ?></div>
                <div class="col-sm-12 border-bottom"></div>
            </div>
            <?php if ($publicDateAdded == 1) { ?>
                <div class="row row-info">
                    <div class="col-sm-6"><b><?= lang('added_on') ?>:</b></div>
                    <div class="col-sm-6"><?= date('m.d.Y', $product['time']) ?></div>
                    <div class="col-sm-12 border-bottom"></div>
                </div>
            <?php } ?>
            <div class="row row-info">
                <div class="col-sm-6"><b><?= lang('in_category') ?>:</b></div>
                <div class="col-sm-6">
                    <a href="javascript:void(0);" class="go-category btn-blue-round" data-categorie-id="<?= $product['shop_categorie'] ?>">
                        <?= $product['categorie_name'] ?>
                    </a>
                </div>
                <div class="col-sm-12 border-bottom">

                </div>
            </div>
            <div class="row row-info">
                <div class="col-sm-6"></div>
                <div class="col-sm-6 manage-buttons">
                    <?php if ($product['quantity'] > 0) { ?>
                        <a href="javascript:void(0);" data-id="<?= $product['id'] ?>" data-goto="<?= LANG_URL . '/checkout' ?>" class="add-to-cart btn-add">
                            <span class="text-to-bg"><?= lang('buy_now') ?></span>
                        </a>
                        <a href="javascript:void(0);" data-id="<?= $product['id'] ?>" data-goto="<?= LANG_URL . '/shopping-cart' ?>" class="add-to-cart btn-add">
                            <span class="text-to-bg"><?= lang('add_to_cart') ?></span>
                        </a>
                    <?php } else { ?>
                        <div class="alert alert-info"><?= lang('out_of_stock_product') ?></div>
                    <?php } ?>
                </div>
                <div class="col-sm-12 border-bottom"></div>
            </div>
            <div class="row row-info">
                <div class="col-xs-12"><b><?= lang('description') ?>:</b></div>
            </div>
            <div id="description">
                <?= $product['description'] ?>
            </div>
        </div>
    </div>
    <div class="row orders-from-category" id="products-side">
        <div class="filter-sidebar">
            <div class="title">
                <span><?= lang('oder_from_category') ?></span>
            </div>
        </div>
        <?php
        if (!empty($sameCagegoryProducts)) {
            $load::getProducts($sameCagegoryProducts, 'col-sm-4 col-md-3', false);
        } else {
            ?>
            <div class="alert alert-info"><?= lang('no_same_category_products') ?></div>
            <?php
        }
        ?>
    </div>
</div>
<div id="modalImagePreview" class="modal">
    <div class="image-preview-container">
        <div class="modal-content">
            <div class="inner-prev-container">
                <img id="img01" alt="">
                <span class="close">&times;</span>
                <span class="img-series"></span>
            </div>
        </div>
        <a href="javascript:void(0);" class="inner-next"></a>
        <a href="javascript:void(0);" class="inner-prev"></a>
    </div>
    <div id="caption"></div>
</div>
<script src="<?= base_url('assets/js/image-preveiw.js') ?>"></script>