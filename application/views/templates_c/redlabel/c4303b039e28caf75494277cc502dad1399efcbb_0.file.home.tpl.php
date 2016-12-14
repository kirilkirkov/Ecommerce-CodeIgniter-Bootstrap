<?php
/* Smarty version 3.1.30, created on 2016-12-14 16:24:46
  from "/var/www/html/shop/application/views/templates/redlabel/home.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5851562e4e9353_82931080',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c4303b039e28caf75494277cc502dad1399efcbb' => 
    array (
      0 => '/var/www/html/shop/application/views/templates/redlabel/home.tpl',
      1 => 1481721250,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5851562e4e9353_82931080 (Smarty_Internal_Template $_smarty_tpl) {
echo '<?php
';?>defined('BASEPATH') OR exit('No direct script access allowed');
if (count($sliderProducts) > 0) {
    <?php echo '?>';?>
    <div id="home-slider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php echo '<?php
            ';?>$i = 0;
            while ($i < count($sliderProducts)) {
                <?php echo '?>';?>
                <li data-target="#home-slider" data-slide-to="0" class="<?php echo '<?=';?> $i == 0 ? 'active' : '' <?php echo '?>';?>"></li>
                <?php echo '<?php
                ';?>$i++;
            }
            <?php echo '?>';?>
        </ol>
        <div class="container">
            <div class="carousel-inner" role="listbox">
                <?php echo '<?php
                ';?>$i = 0;
                foreach ($sliderProducts as $article) {
                    <?php echo '?>';?>
                    <div class="item <?php echo '<?=';?> $i == 0 ? 'active' : '' <?php echo '?>';?>">
                        <div class="row">
                            <div class="col-sm-6 left-side">
                                <a href="<?php echo '<?=';?> LANG_URL . '/' . $article['url'] <?php echo '?>';?>">
                                    <img src="<?php echo '<?=';?> base_url('attachments/shop_images/' . $article['image']) <?php echo '?>';?>" class="img-responsive" alt="">
                                </a>
                            </div>
                            <div class="col-sm-6 right-side">
                                <h3 class="text-right">
                                    <a href="<?php echo '<?=';?> LANG_URL . '/' . $article['url'] <?php echo '?>';?>">
                                        <?php echo '<?=';?> character_limiter($article['title'], 100) <?php echo '?>';?>
                                    </a>
                                </h3>
                                <div class="description text-right">
                                    <?php echo '<?=';?> character_limiter(strip_tags($article['basic_description']), 150) <?php echo '?>';?>
                                </div>
                                <div class="price text-right"><?php echo '<?=';?> $article['price'] . CURRENCY <?php echo '?>';?></div>
                                <div class="xs-center">
                                    <a class="option add-to-cart" data-goto="<?php echo '<?=';?> base_url('checkout') <?php echo '?>';?>" href="javascript:void(0);" data-id="<?php echo '<?=';?> $article['id'] <?php echo '?>';?>">
                                        <img src="<?php echo '<?=';?> base_url('assets/imgs/shopping-cart-icon-515.png') <?php echo '?>';?>" alt="">
                                        <?php echo '<?=';?> lang('buy_now') <?php echo '?>';?>
                                    </a>
                                    <a class="option right-5" href="<?php echo '<?=';?> LANG_URL . '/' . $article['url'] <?php echo '?>';?>">
                                        <img src="<?php echo '<?=';?> base_url('assets/imgs/info.png') <?php echo '?>';?>" alt="">
                                        <?php echo '<?=';?> lang('details') <?php echo '?>';?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo '<?php
                    ';?>$i++;
                }
                <?php echo '?>';?>
            </div>
        </div>
        <a class="left carousel-control" href="#home-slider" role="button" data-slide="prev"></a>
        <a class="right carousel-control" href="#home-slider" role="button" data-slide="next"></a>
    </div>
<?php echo '<?php ';?>} <?php echo '?>';?>
<div class="container" id="home-page">
    <div class="row">
        <div class="col-md-3">
            <div class="filter-sidebar">
                <div class="title">
                    <span><?php echo '<?=';?> lang('categories') <?php echo '?>';?></span>
                    <?php echo '<?php ';?>if (isset($_GET['category']) && $_GET['category'] != '') { <?php echo '?>';?>
                        <a href="javascript:void(0);" class="clear-filter" data-type-clear="category" data-toggle="tooltip" data-placement="right" title="<?php echo '<?=';?> lang('clear_the_filter') <?php echo '?>';?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                    <?php echo '<?php ';?>} <?php echo '?>';?>
                </div>
                <a href="javascript:void(0)" id="show-xs-nav" class="visible-xs visible-sm">
                    <span class="show-sp"><?php echo '<?=';?> lang('showXsNav') <?php echo '?>';?><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i></span>
                    <span class="hidde-sp"><?php echo '<?=';?> lang('hideXsNav') <?php echo '?>';?><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i></span>
                </a>
                <div id="nav-categories">
                    <?php echo '<?php

                    ';?>function loop_tree($pages, $is_recursion = false)
                    {
                        <?php echo '?>';?>
                        <ul class="<?php echo '<?=';?> $is_recursion === true ? 'children' : 'parent' <?php echo '?>';?>">
                            <?php echo '<?php
                            ';?>foreach ($pages as $page) {
                                $children = false;
                                if (isset($page['children']) && !empty($page['children'])) {
                                    $children = true;
                                }
                                <?php echo '?>';?>
                                <li>
                                    <?php echo '<?php ';?>if ($children === true) {
                                        <?php echo '?>';?>
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                    <?php echo '<?php ';?>} else { <?php echo '?>';?>
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>
                                    <?php echo '<?php ';?>} <?php echo '?>';?>
                                    <a href="javascript:void(0);" data-categorie-id="<?php echo '<?=';?> $page['id'] <?php echo '?>';?>" class="go-category left-side <?php echo '<?=';?> isset($_GET['category']) && $_GET['category'] == $page['id'] ? 'selected' : '' <?php echo '?>';?>"><?php echo '<?=';?> $page['name'] <?php echo '?>';?></a>
                                    <?php echo '<?php
                                    ';?>if ($children === true) {
                                        loop_tree($page['children'], true);
                                    } else {
                                        <?php echo '?>';?>
                                    </li>
                                    <?php echo '<?php
                                ';?>}
                            }
                            <?php echo '?>';?>
                        </ul>
                        <?php echo '<?php
                        ';?>if ($is_recursion === true) {
                            <?php echo '?>';?>
                            </li>
                            <?php echo '<?php
                        ';?>}
                    }

                    loop_tree($home_categories);
                    <?php echo '?>';?>
                </div>
            </div>
            <?php echo '<?php ';?>if ($showOutOfStock == 1) { <?php echo '?>';?>
                <div class="filter-sidebar">
                    <div class="title">
                        <span><?php echo '<?=';?> lang('store') <?php echo '?>';?></span>
                        <?php echo '<?php ';?>if (isset($_GET['in_stock']) && $_GET['in_stock'] != '') { <?php echo '?>';?>
                            <a href="javascript:void(0);" class="clear-filter" data-type-clear="in_stock" data-toggle="tooltip" data-placement="right" title="<?php echo '<?=';?> lang('clear_the_filter') <?php echo '?>';?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                        <?php echo '<?php ';?>} <?php echo '?>';?>
                    </div>
                    <ul>
                        <li>
                            <a href="javascript:void(0);" data-in-stock="1" class="in-stock <?php echo '<?=';?> isset($_GET['in_stock']) && $_GET['in_stock'] == '1' ? 'selected' : '' <?php echo '?>';?>"><?php echo '<?=';?> lang('in_stock') <?php echo '?>';?> (<?php echo '<?=';?> $countQuantities['in_stock'] <?php echo '?>';?>)</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-in-stock="0" class="in-stock <?php echo '<?=';?> isset($_GET['in_stock']) && $_GET['in_stock'] == '0' ? 'selected' : '' <?php echo '?>';?>"><?php echo '<?=';?> lang('out_of_stock') <?php echo '?>';?> (<?php echo '<?=';?> $countQuantities['out_of_stock'] <?php echo '?>';?>)</a>
                        </li>
                    </ul>
                </div>
            <?php echo '<?php ';?>} if ($shippingOrder != 0 && $shippingOrder != null) { <?php echo '?>';?>
                <div class="filter-sidebar">
                    <div class="title">
                        <span><?php echo '<?=';?> lang('freeShippingHeader') <?php echo '?>';?></span>
                    </div>
                    <div class="oaerror info">
                        <strong><?php echo '<?=';?> lang('promo') <?php echo '?>';?></strong> - <?php echo '<?=';?> str_replace(array('%price%', '%currency%'), array($shippingOrder, CURRENCY), lang('freeShipping')) <?php echo '?>';?>!
                    </div>
                </div>
            <?php echo '<?php ';?>} <?php echo '?>';?>
        </div>
        <div class="col-md-9 eqHeight" id="products-side">
            <div class="alone title">
                <span><?php echo '<?=';?> lang('products') <?php echo '?>';?></span>
            </div>
            <div class="product-sort gradient-color">
                <div class="row">
                    <div class="ord col-sm-4">
                        <div class="form-group">
                            <select class="selectpicker order form-control" data-order-to="order_new">
                                <option <?php echo '<?=';?> isset($_GET['order_new']) && $_GET['order_new'] == "desc" ? 'selected' : '' <?php echo '?>';?> <?php echo '<?=';?> !isset($_GET['order_new']) || $_GET['order_new'] == "" ? 'selected' : '' <?php echo '?>';?> value="desc"><?php echo '<?=';?> lang('new') <?php echo '?>';?> </option>
                                <option <?php echo '<?=';?> isset($_GET['order_new']) && $_GET['order_new'] == "asc" ? 'selected' : '' <?php echo '?>';?> value="asc"><?php echo '<?=';?> lang('old') <?php echo '?>';?> </option>
                            </select>
                        </div>
                    </div>
                    <div class="ord col-sm-4">
                        <div class="form-group">
                            <select class="selectpicker order form-control" data-order-to="order_price" title="<?php echo '<?=';?> lang('price_title') <?php echo '?>';?>..">
                                <option label="<?php echo '<?=';?> lang('not_selected') <?php echo '?>';?>"></option>
                                <option <?php echo '<?=';?> isset($_GET['order_price']) && $_GET['order_price'] == "asc" ? 'selected' : '' <?php echo '?>';?> value="asc"><?php echo '<?=';?> lang('price_low') <?php echo '?>';?> </option>
                                <option <?php echo '<?=';?> isset($_GET['order_price']) && $_GET['order_price'] == "desc" ? 'selected' : '' <?php echo '?>';?> value="desc"><?php echo '<?=';?> lang('price_high') <?php echo '?>';?> </option>
                            </select>
                        </div>
                    </div>
                    <div class="ord col-sm-4">
                        <div class="form-group">
                            <select class="selectpicker order form-control" data-order-to="order_procurement" title="<?php echo '<?=';?> lang('procurement_title') <?php echo '?>';?>..">
                                <option label="<?php echo '<?=';?> lang('not_selected') <?php echo '?>';?>"></option>
                                <option <?php echo '<?=';?> isset($_GET['order_procurement']) && $_GET['order_procurement'] == "desc" ? 'selected' : '' <?php echo '?>';?> value="desc"><?php echo '<?=';?> lang('procurement_desc') <?php echo '?>';?> </option>
                                <option <?php echo '<?=';?> isset($_GET['order_procurement']) && $_GET['order_procurement'] == "asc" ? 'selected' : '' <?php echo '?>';?> value="asc"><?php echo '<?=';?> lang('procurement_asc') <?php echo '?>';?> </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo '<?php
            ';?>if (!empty($products)) {
                $load::getProducts($products, 'col-sm-4 col-md-3', false);
            } else {
                <?php echo '?>';?>
                <?php echo '<script'; ?>
>
                    $(document).ready(function () {
                        ShowNotificator('alert-info', '<?php echo '<?=';?> lang('no_results') <?php echo '?>';?>');
                    });
                <?php echo '</script'; ?>
>
                <?php echo '<?php
            ';?>}
            <?php echo '?>';?>
        </div>
    </div>
    <?php echo '<?php ';?>if ($links_pagination != '') { <?php echo '?>';?>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <?php echo '<?=';?> $links_pagination <?php echo '?>';?>
            </div>
        </div>
    <?php echo '<?php ';?>} <?php echo '?>';?>
</div><?php }
}
