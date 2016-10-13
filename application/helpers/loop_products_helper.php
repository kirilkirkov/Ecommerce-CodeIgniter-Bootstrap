<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function loop_products($products, $currency, $classes = '', $carousel = false, $lang_url)
{
    if ($carousel == true) {
        ?>
        <div class="carousel slide" id="small_carousel" data-ride="carousel" data-interval="3000">
            <ol class="carousel-indicators">
                <?php
                $i = 0;
                while ($i < count($products)) {
                    if ($i == 0)
                        $active = 'active';
                    else
                        $active = '';
                    ?>
                    <li data-target="#small_carousel" data-slide-to="<?= $i ?>" class="<?= $active ?>"></li>
                    <?php
                    $i++;
                }
                ?>
            </ol>
            <div class="carousel-inner">
                <?php
            }
            $i = 0;
            foreach ($products as $article) {
                if ($i == 0 && $carousel == true)
                    $active = 'active';
                else
                    $active = '';
                ?>
                <div class="product-list column-h <?= $carousel == true ? 'item' : '' ?> <?= $classes ?> <?= $active ?>">
                    <div class="inner">
                        <div class="img-container">
                            <a href="<?= $lang_url . '/' . $article['url'] ?>">
                                <img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" alt="">
                            </a>
                        </div>
                        <h2>
                            <a href="<?= $lang_url . '/' . $article['url'] ?>"><?= $article['title'] ?></a>
                        </h2>
                        <div class="price">
                            <span class="underline"><?= lang('price') ?>: <span><?= $article['price'] != '' ? number_format($article['price'], 2) : 0 ?><?= $currency ?></span></span>
                            <?php
                            if ($article['old_price'] != '' && $article['old_price'] != 0) {
                                $percent = $article['old_price'] / $article['price'];
                                $percent_friendly = number_format($percent * 100, 2) . '%';
                                ?>
                                <span class="price-down"><?= $percent_friendly ?></span>
                            <?php } ?>
                        </div>
                        <?php if ($article['old_price'] != '') { ?>
                            <div class="price-discount">
                                <?= lang('old_price') ?>: <span><?= number_format($article['old_price'], 2) . $currency ?></span>
                            </div>
                        <?php } ?>
                        <div class="quantity">
                            <?= lang('in_stock') ?>: <span><?= $article['quantity'] ?></span>
                        </div>
                        <div class="add-to-cart">
                            <a href="javascript:void(0);" class="add-to-cart" data-id="<?= $article['id'] ?>">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                <img src="<?= base_url('assets/imgs/ajax-loader.gif') ?>" alt="Loding">
                                <?= lang('add_to_cart') ?></a>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            }
            if ($carousel == true)
                echo '</div></div>';
        }
        