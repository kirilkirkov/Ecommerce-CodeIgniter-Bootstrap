<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="inner-nav">
    <div class="container">
        <?= lang('home') ?> <span class="active"> > <?= lang('shop') ?></span>
    </div>
</div>
<div class="container" id="view-product">
    <div class="row top-part">
        <div class="col-sm-4">
            <div <?= $product['folder'] != null ? 'style="margin-bottom:20px;"' : '' ?>>
                <img src="<?= base_url('/attachments/shop_images/' . $product['image']) ?>" style="width:auto; height:auto;" data-num="0" class="other-img-preview img-responsive img-thumbnail img-sl the-image" alt="<?= str_replace('"', "'", $product['title']) ?>">
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
            <div class="product-info">
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
                            <div>
                                <a href="javascript:void(0);" data-id="<?= $product['id'] ?>" data-goto="<?= LANG_URL . '/checkout' ?>" class="add-to-cart btn-add">
                                    <span class="text-to-bg"><?= lang('buy_now') ?></span>
                                </a>
                            </div>
                            <a href="javascript:void(0);" data-id="<?= $product['id'] ?>" data-goto="<?= LANG_URL . '/shopping-cart' ?>" class="add-to-cart btn-add">
                                <span class="text-to-bg"><?= lang('add_to_cart') ?></span>
                            </a>
                        <?php } else { ?>
                            <div class="alert alert-info"><?= lang('out_of_stock_product') ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 border-bottom"></div>
                </div> 
            </div>
        </div>
    </div> 
    <div id="description">
        <div class="header">
            <span class="title"><?= lang('description') ?></span>
        </div>
        <?= $product['description'] ?>
    </div>
    <div class="row orders-from-category" id="products-side">
        <h2><?= lang('oder_from_category') ?></h2>
        <?php
        if (!empty($sameCagegoryProducts)) {
            foreach ($sameCagegoryProducts as $prod) {
                ?>
                <div class="col-sm-6 col-md-4 product-inner">
                    <a href="<?= LANG_URL . '/' . $prod['url'] ?>">
                        <img src="<?= base_url('attachments/shop_images/' . $prod['image']) ?>" alt="" class="img-responsive">
                    </a>
                    <h3><?= $prod['title'] ?></h3>
                    <span class="price"><?= $prod['price'] . CURRENCY ?></span>
                    <a class="add-to-cart" data-goto="<?= LANG_URL . '/checkout' ?>" href="javascript:void(0);" data-id="<?= $prod['id'] ?>">
                        <?= lang('add_to_cart') ?>
                    </a>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-info"><?= lang('no_same_category_products') ?></div>
            <?php
        }
        ?> 
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
</div>
<script src="<?= base_url('assets/js/image-preveiw.js') ?>"></script>