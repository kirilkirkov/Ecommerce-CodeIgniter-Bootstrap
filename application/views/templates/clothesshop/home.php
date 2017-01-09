<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$arrCategories = array();
foreach ($all_categories as $categorie) {
    if (isset($_GET['category']) && is_numeric($_GET['category']) && $_GET['category'] == $categorie['sub_for']) {
        $arrCategories[] = $categorie;
    }
    if (!isset($_GET['category']) || $_GET['category'] == '') {
        if ($categorie['sub_for'] == 0) {
            $arrCategories[] = $categorie;
        }
    }
}
?>
<div class="container">
    <div class="body">
        <?php if (count($sliderProducts) > 0) { ?>
            <div class="row row-of-slider">
                <div class="col-sm-8">
                    <div id="home-slider" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php
                            $i = 0;
                            while ($i < count($sliderProducts)) {
                                ?>
                                <li data-target="#home-slider" data-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></li>
                                <?php
                                $i++;
                            }
                            ?>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <?php
                            $i = 0;
                            foreach ($sliderProducts as $article) {
                                ?>
                                <div class="item <?= $i == 0 ? 'active' : '' ?>">
                                    <div class="absolute-texts">
                                        <h1>
                                            <a href="<?= LANG_URL . '/' . $article['url'] ?>">
                                                <?= character_limiter($article['title'], 100) ?>
                                            </a>
                                        </h1>
                                        <div class="description">
                                            <?= character_limiter(strip_tags($article['basic_description']), 150) ?>
                                        </div>
                                    </div>
                                    <img src="<?= base_url('attachments/shop_images/' . $article['image']) ?>" alt="" class="img-responsive">
                                </div>
                                <?php
                                $i++;
                            }
                            ?>
                        </div>
                        <div class="controls">
                            <a class="left carousel-control" href="#home-slider" role="button" data-slide="prev">
                                <i class="fa fa-2x fa-angle-left" aria-hidden="true"></i>
                            </a>
                            <a class="right carousel-control" href="#home-slider" role="button" data-slide="next">
                                <i class="fa fa-2x fa-angle-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <h2 class="hidden-xs"><?= lang('welcome') ?></h2>
                </div>
                <div class="col-sm-4">
                    <?= $load::getProducts($bestSellers, '', true) ?>
                </div>
            </div>
        <?php } ?>
        <div class="h-line"></div>
        <h3 class="part-label"><?= lang('categories') ?></h3>
        <?php if (isset($_GET['category']) && $_GET['category'] != '') { ?>
            <a href="javascript:void(0);" class="clear-filter" data-type-clear="category" data-toggle="tooltip" data-placement="top" title="<?= lang('clear_the_filter') ?>">
                <span class="hidden-xs">
                    <?= lang('clear_the_filter') ?>
                </span>
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
        <?php } ?>
        <a href="javascript:void(0)" id="show-xs-nav" class="visible-xs">
            <span class="show-sp"><?= lang('showXsNav') ?><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></span>
            <span class="hidde-sp"><?= lang('hideXsNav') ?><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></span>
        </a>
        <div class="categories">
            <?php if (!empty($arrCategories)) { ?>
                <ul class="list">
                    <?php
                    foreach ($arrCategories as $categorie) {
                        ?>
                        <li>
                            <a href="javascript:void(0);" data-categorie-id="<?= $categorie['id'] ?>" class="go-category left-side <?= isset($_GET['category']) && $_GET['category'] == $categorie['id'] ? 'selected' : '' ?>">
                                <span><?= $categorie['name'] ?></span>
                                <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            <?php } else { ?>
                <div class="alert alert-info"><?= lang('no_sub_categories') ?></div>
            <?php } ?>
        </div>
        <div class="h-line"></div>
        <?php if ($showBrands == 1) { ?>
            <h3 class="part-label"><?= lang('brands') ?></h3>
            <?php if (isset($_GET['brand_id']) && $_GET['brand_id'] != '') { ?>
                <a href="javascript:void(0);" class="clear-filter" data-type-clear="brand_id" data-toggle="tooltip" data-placement="right" title="<?= lang('clear_the_filter') ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
            <?php } ?>
            <div class="brands">
                <ul class="list">
                    <?php foreach ($brands as $brand) { ?>
                        <li>
                            <a href="javascript:void(0);" data-brand-id="<?= $brand['id'] ?>" class="brand <?= isset($_GET['brand_id']) && $_GET['brand_id'] == $brand['id'] ? 'selected' : '' ?>">
                                <span><?= $brand['name'] ?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="h-line"></div>
        <?php } ?>
        <h3 class="part-label"><?= lang('products') ?></h3>
        <div class="row products">
            <?php
            if (!empty($products)) {
                $load::getProducts($products, 'col-sm-4 col-md-3', false);
            } else {
                ?>
                <div class="col-xs-12">
                    <div class="alert alert-danger"><?= lang('no_products') ?></div>
                </div>
            <?php } ?>
        </div>
        <?= $links_pagination ?>
        <?php include 'bodyFooter.php' ?>
    </div>