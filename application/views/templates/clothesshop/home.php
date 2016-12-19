<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
                                <li data-target="#home-slider" data-slide-to="0" class="<?= $i == 0 ? 'active' : '' ?>"></li>
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
                                <div class="item <?= $i == 0 ? 'active' : '' ?>" style="background-image:url('<?= base_url('attachments/shop_images/' . $article['image']) ?>');">
                                    <h1>
                                        <a href="<?= LANG_URL . '/' . $article['url'] ?>">
                                            <?= character_limiter($article['title'], 100) ?>
                                        </a>
                                    </h1>
                                    <div class="description">
                                        <?= character_limiter(strip_tags($article['basic_description']), 150) ?>
                                    </div>
                                </div>
                                <?php
                                $i++;
                            }
                            ?>
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
        <h3 class="categories-label"><?= lang('categories') ?></h3>
        <div class="categories">
            <?php

            function loop_tree($pages, $is_recursion = false)
            {
                ?>
                <ul class="list">
                    <?php
                    foreach ($pages as $page) {
                        $children = false;
                        if (isset($page['children']) && !empty($page['children'])) {
                            $children = true;
                        }
                        ?>
                        <li class="<?= $is_recursion === true ? 'children' : 'parent' ?>">
                            <a href="javascript:void(0);" data-categorie-id="<?= $page['id'] ?>" class="go-category left-side <?= isset($_GET['category']) && $_GET['category'] == $page['id'] ? 'selected' : '' ?>">
                                <?= $page['name'] ?>
                                <?php if ($children == true) { ?>
                                    <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                <?php } ?>
                            </a>
                            <?php
                            if ($children === true) {
                                loop_tree($page['children'], true);
                            } else {
                                ?>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <?php
                if ($is_recursion === true) {
                    ?>
                    </li>
                    <?php
                }
            }

            loop_tree($home_categories);
            ?>
        </div>
        <div class="h-line"></div>
        <h3 class="products-label"><?= lang('products') ?></h3>
        <div class="row products">
            <?php
            if (!empty($products)) {
                $load::getProducts($products, 'col-sm-4 col-md-3', false);
            } else {
                ?>
            <?php } ?>
        </div>
        <?= $links_pagination ?>
        <div class="h-line"></div>
        <div class="body-footer">
            <?php include 'bodyFooter.php' ?>
        </div>
    </div>