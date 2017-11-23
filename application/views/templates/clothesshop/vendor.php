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