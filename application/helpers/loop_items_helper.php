<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function loop_items($cartItems, $currency, $lang_url)
{
    if (!empty($cartItems['array'])) {
        ?>
        <li class="cleaner text-right">
            <a href="javascript:void(0);" class="" onclick="clearCart()">
                <?= lang('clear_all') ?>
            </a>
        </li>
        <li class="divider"></li>
        <?php
        foreach ($cartItems['array'] as $cartItem) {
            ?>
            <li class="shop-item" data-artticle-id="<?= $cartItem['id'] ?>">
                <span class="num_added hidden"><?= $cartItem['num_added'] ?></span>
                <div class="item">
                    <div class="item-in">
                        <div class="left-side">
                            <img src="<?= base_url('/attachments/shop_images/' . $cartItem['image']) ?>" alt="" />
                        </div>
                        <div class="right-side">
                            <a href="<?= $lang_url . '/' . $cartItem['url'] ?>" class="item-info">
                                <span><?= $cartItem['title'] ?></span>
                                <span class="prices"><?= $cartItem['num_added'] == 1 ? $cartItem['price'] : '<span class="num-added-single">' . $cartItem['num_added'] . '</span> x <span class="price-single">' . $cartItem['price'] . '</span> - <span class="sum-price-single">' . $cartItem['sum_price'] . '</span>' ?></span>
                                <span class="currency"><?= $currency ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="item-x-absolute">
                        <button class="btn btn-xs btn-danger pull-right" onclick="removeArticle(<?= $cartItem['id'] ?>)">x</button>
                    </div>
                </div>
            </li>
            <?php
        }
        ?>
        <li class="divider"></li>
        <li class="text-center">
            <a class="go-checkout btn btn-default btn-sm" href="<?= $lang_url . '/checkout' ?>">
                <?= !empty($cartItems['array']) ? '<i class="fa fa-check"></i> ' . lang('checkout') . ' - <span class="finalSum">' . $cartItems['finalSum'] . '</span>' . $currency : '<span class="no-for-pay">' . lang('no_for_pay') . '</span>' ?>
            </a>
        </li>
    <?php } else {
        ?>
        <li class="text-center"><?= lang('no_products') ?></li>
        <?php
    }
}
