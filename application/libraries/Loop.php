<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loop
{

    private static $CI;

    public function __construct()
    {
        self::$CI = & get_instance();
    }

    static function getCartItems($cartItems)
    {
        if (!empty($cartItems['array'])) {
            $template = null;
            if (self::$CI && isset(self::$CI->config)) {
                $template = self::$CI->config->item('template');
            }
            if ($template === 'wind2026') {
                ?>
                <li class="px-4 pt-4 pb-2">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold text-slate-900"><?= lang('shopping_cart') ?></div>
                        <button type="button" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-800" onclick="clearCart()">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                            <?= lang('clear_all') ?>
                        </button>
                    </div>
                </li>
                <li class="px-4"><div class="h-px bg-slate-200"></div></li>
                <?php
                foreach ($cartItems['array'] as $cartItem) {
                    ?>
                    <li class="px-4 py-3" data-artticle-id="<?= $cartItem['id'] ?>">
                        <span class="num_added hidden"><?= $cartItem['num_added'] ?></span>
                        <div class="flex gap-3">
                            <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-slate-100 ring-1 ring-slate-200">
                                <?php
                                $productImage = base_url('/attachments/no-image-frontend.png');
                                if (is_file('attachments/shop_images/' . $cartItem['image'])) {
                                    $productImage = base_url('/attachments/shop_images/' . $cartItem['image']);
                                }
                                ?>
                                <img src="<?= $productImage; ?>" class="h-full w-full object-cover" alt="<?= htmlentities($cartItem['title']) ?>" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <a href="<?= LANG_URL . '/' . $cartItem['url'] ?>" class="block truncate text-sm font-semibold text-slate-900 hover:text-slate-700">
                                    <?= $cartItem['title'] ?>
                                </a>
                                <div class="mt-1 text-xs text-slate-600">
                                    <?=
                                    $cartItem['num_added'] == 1
                                        ? $cartItem['price']
                                        : '<span class="num-added-single">' . $cartItem['num_added'] . '</span> × <span class="price-single">' . $cartItem['price'] . '</span> · <span class="sum-price-single">' . $cartItem['sum_price'] . '</span>'
                                    ?>
                                    <span class="currency"><?= CURRENCY ?></span>
                                </div>
                            </div>
                            <div class="shrink-0">
                                <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-50 text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-100" onclick="removeProduct(<?= $cartItem['id'] ?>)">
                                    <span class="sr-only">Remove</span>
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <?php
                }
                ?>
                <li class="px-4"><div class="h-px bg-slate-200"></div></li>
                <li class="px-4 py-4">
                    <a class="flex items-center justify-between rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800" href="<?= LANG_URL . '/checkout' ?>">
                        <span><?= lang('checkout') ?></span>
                        <span><span class="finalSum"><?= $cartItems['finalSum'] ?></span><?= CURRENCY ?></span>
                    </a>
                </li>
                <?php
                return;
            }
            ?>
            <li class="cleaner text-right">
                <a href="javascript:void(0);" class="btn-blue-round" onclick="clearCart()">
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
                                <?php 
                                    $productImage = base_url('/attachments/no-image-frontend.png');
                                    if(is_file('attachments/shop_images/' . $cartItem['image'])) {
                                        $productImage = base_url('/attachments/shop_images/' . $cartItem['image']);
                                    }
                                ?>
                                <img src="<?= $productImage; ?>" alt="<?= htmlentities($cartItem['title']) ?>" />
                            </div>
                            <div class="right-side">
                                <a href="<?= LANG_URL . '/' . $cartItem['url'] ?>" class="item-info">
                                    <span><?= $cartItem['title'] ?></span>
                                    <span class="prices">
                                        <?=
                                        $cartItem['num_added'] == 1 ? $cartItem['price'] : '<span class="num-added-single">'
                                                . $cartItem['num_added'] . '</span> x <span class="price-single">'
                                                . $cartItem['price'] . '</span> - <span class="sum-price-single">'
                                                . $cartItem['sum_price'] . '</span>'
                                        ?>
                                    </span>
                                    <span class="currency"><?= CURRENCY ?></span>
                                </a>
                            </div>
                        </div>
                        <div class="item-x-absolute">
                            <button class="btn btn-xs btn-danger pull-right" onclick="removeProduct(<?= $cartItem['id'] ?>)">
                                x
                            </button>
                        </div>
                    </div>
                </li>
                <?php
            }
            ?>
            <li class="divider"></li>
            <li class="text-center">
                <a class="go-checkout btn btn-default btn-sm" href="<?= LANG_URL . '/checkout' ?>">
                    <?=
                    !empty($cartItems['array']) ? '<i class="fa fa-check"></i> '
                            . lang('checkout') . ' - <span class="finalSum">' . $cartItems['finalSum']
                            . '</span>' . CURRENCY : '<span class="no-for-pay">' . lang('no_for_pay') . '</span>'
                    ?>
                </a>
            </li>
        <?php } else {
            ?>
            <li class="text-center"><?= lang('no_products') ?></li>
            <?php
        }
    }

    static public function getProducts($products, $classes = '', $carousel = false)
    {
        $template = null;
        if (self::$CI && isset(self::$CI->config)) {
            $template = self::$CI->config->item('template');
        }
        if ($template === 'wind2026') {
            if (empty($products)) {
                return;
            }
            if ($carousel === true) {
                $carouselId = 'wind-carousel-' . substr(md5(uniqid('', true)), 0, 8);
                ?>
                <div class="relative">
                    <button
                        type="button"
                        class="absolute left-2 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-2xl bg-white text-slate-900 shadow-sm ring-1 ring-slate-200 hover:bg-slate-50 md:inline-flex"
                        data-wind-carousel-btn="prev"
                        data-wind-carousel-target="#<?= $carouselId ?>"
                        aria-label="Prev"
                    >
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                    </button>
                    <button
                        type="button"
                        class="absolute right-2 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-2xl bg-white text-slate-900 shadow-sm ring-1 ring-slate-200 hover:bg-slate-50 md:inline-flex"
                        data-wind-carousel-btn="next"
                        data-wind-carousel-target="#<?= $carouselId ?>"
                        aria-label="Next"
                    >
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </button>

                    <div
                        id="<?= $carouselId ?>"
                        class="flex snap-x snap-mandatory gap-4 overflow-x-auto pb-2 pr-6"
                        style="scrollbar-width: none;"
                    >
                    <?php
                    foreach ($products as $article) {
                        $backgroundImageFile = base_url('/attachments/no-image-frontend.png');
                        if (is_file('attachments/shop_images/' . $article['image'])) {
                            $backgroundImageFile = base_url('/attachments/shop_images/' . $article['image']);
                        }
                        $productUrl = $article['vendor_url'] == null ? LANG_URL . '/' . $article['url'] : LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'];
                        $hasOld = ($article['old_price'] != '' && $article['old_price'] != 0 && $article['price'] != '' && $article['price'] != 0);
                        ?>
                        <article class="snap-start w-[16rem] shrink-0 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 hover:shadow-md">
                            <a href="<?= $productUrl ?>" class="block">
                                <div class="relative h-40 bg-slate-100">
                                    <img src="<?= htmlentities($backgroundImageFile) ?>" class="h-full w-full object-cover" alt="<?= htmlentities($article['title']) ?>">
                                    <?php if ($hasOld) {
                                        $percent_friendly = number_format((($article['old_price'] - $article['price']) / $article['old_price']) * 100) . '%';
                                        ?>
                                        <div class="absolute left-3 top-3 rounded-full bg-rose-600 px-3 py-1 text-xs font-bold text-white"><?= $percent_friendly ?></div>
                                    <?php } ?>
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="<?= $productUrl ?>" class="block text-sm font-semibold text-slate-900 hover:text-slate-700">
                                    <?= character_limiter($article['title'], 55) ?>
                                </a>
                                <div class="mt-2 flex items-baseline justify-between gap-2">
                                    <div class="text-sm font-bold text-slate-900">
                                        <?= $article['price'] != '' ? number_format($article['price'], 2) : 0 ?><?= CURRENCY ?>
                                    </div>
                                    <?php if ($hasOld) { ?>
                                        <div class="text-xs text-slate-500 line-through">
                                            <?= number_format($article['old_price'], 2) . CURRENCY ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (self::$CI->load->get_var('hideBuyButtonsOfOutOfStock') == 0 || (int)$article['quantity'] > 0) { ?>
                                    <div class="mt-3 flex gap-2">
                                        <a href="javascript:void(0);" class="add-to-cart inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800" data-goto="<?= LANG_URL . '/shopping-cart' ?>" data-id="<?= $article['id'] ?>">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            <?= lang('add_to_cart') ?>
                                        </a>
                                        <a href="javascript:void(0);" class="add-to-cart inline-flex items-center justify-center rounded-xl bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-100" data-goto="<?= LANG_URL . '/checkout' ?>" data-id="<?= $article['id'] ?>">
                                            <i class="fa fa-bolt" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </article>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <?php
                return;
            }
            ?>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php
                foreach ($products as $article) {
                    $backgroundImageFile = base_url('/attachments/no-image-frontend.png');
                    if (is_file('attachments/shop_images/' . $article['image'])) {
                        $backgroundImageFile = base_url('/attachments/shop_images/' . $article['image']);
                    }
                    $productUrl = $article['vendor_url'] == null ? LANG_URL . '/' . $article['url'] : LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'];
                    $hasOld = ($article['old_price'] != '' && $article['old_price'] != 0 && $article['price'] != '' && $article['price'] != 0);
                    ?>
                    <article class="group overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 hover:shadow-md">
                        <a href="<?= $productUrl ?>" class="block">
                            <div class="relative h-52 bg-slate-100">
                                <img src="<?= htmlentities($backgroundImageFile) ?>" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]" alt="<?= htmlentities($article['title']) ?>">
                                <?php if ($hasOld) {
                                    $percent_friendly = number_format((($article['old_price'] - $article['price']) / $article['old_price']) * 100) . '%';
                                    ?>
                                    <div class="absolute left-3 top-3 rounded-full bg-rose-600 px-3 py-1 text-xs font-bold text-white"><?= $percent_friendly ?></div>
                                <?php } ?>
                            </div>
                        </a>
                        <div class="p-4">
                            <a href="<?= $productUrl ?>" class="block text-sm font-semibold text-slate-900 hover:text-slate-700">
                                <?= character_limiter($article['title'], 70) ?>
                            </a>
                            <div class="mt-2 flex items-baseline justify-between gap-2">
                                <div class="text-sm font-bold text-slate-900">
                                    <?= $article['price'] != '' ? number_format($article['price'], 2) : 0 ?><?= CURRENCY ?>
                                </div>
                                <?php if ($hasOld) { ?>
                                    <div class="text-xs text-slate-500 line-through">
                                        <?= number_format($article['old_price'], 2) . CURRENCY ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if (self::$CI->load->get_var('hideBuyButtonsOfOutOfStock') == 0 || (int)$article['quantity'] > 0) { ?>
                                <div class="mt-3 flex gap-2">
                                    <a href="javascript:void(0);" class="add-to-cart inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800" data-goto="<?= LANG_URL . '/shopping-cart' ?>" data-id="<?= $article['id'] ?>">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <?= lang('add_to_cart') ?>
                                    </a>
                                    <a href="javascript:void(0);" class="add-to-cart inline-flex items-center justify-center rounded-xl bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-100" data-goto="<?= LANG_URL . '/checkout' ?>" data-id="<?= $article['id'] ?>">
                                        <i class="fa fa-bolt" aria-hidden="true"></i>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <div class="mt-3 rounded-xl bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-200">
                                    <?= lang('out_of_stock_product') ?>
                                </div>
                            <?php } ?>
                        </div>
                    </article>
                    <?php
                }
                ?>
            </div>
            <?php
            return;
        }
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
                <div class="carousel-inner products">
                    <?php
                }
                $i = 0;
                foreach ($products as $article) {
                    if ($i == 0 && $carousel == true) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
                    <div class="product-list <?= $carousel == true ? 'item' : '' ?> <?= $classes ?> <?= $active ?>">
                        <div class="inner">
                            <div class="img-container">
                                <?php 
                                    $backgroundImageFile = base_url('/attachments/no-image-frontend.png');
                                    if(is_file('attachments/shop_images/' . $article['image'])) {
                                        $backgroundImageFile = base_url('/attachments/shop_images/' . $article['image']);
                                    }
                                ?>
                                <a href="<?= $article['vendor_url'] == null ? LANG_URL . '/' . $article['url'] : LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>" style="background-image:url('<?= htmlentities($backgroundImageFile) ?>')"></a>
                            </div>
                            <h2>
                                <a href="<?= $article['vendor_url'] == null ? LANG_URL . '/' . $article['url'] : LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>"><?= character_limiter($article['title'], 70) ?></a>
                            </h2>
                            <div class="price">
                                <span class="underline"><?= lang('price') ?>: <span><?= $article['price'] != '' ? number_format($article['price'], 2) : 0 ?><?= CURRENCY ?></span></span>
                                <?php
                                if ($article['old_price'] != '' && $article['old_price'] != 0 && $article['price'] != '' && $article['price'] != 0) {
                                    $percent_friendly = number_format((($article['old_price'] - $article['price']) / $article['old_price']) * 100) . '%';
                                    ?>
                                    <span class="price-down"><?= $percent_friendly ?></span>
                                <?php } ?>
                            </div>
                            <div class="price-discount <?= $article['old_price'] == '' ? 'invisible' : '' ?>">
                                <?= lang('old_price') ?>: <span><?= $article['old_price'] != '' ? number_format($article['old_price'], 2) . CURRENCY : '' ?></span>
                            </div>
                            <?php if (self::$CI->load->get_var('publicQuantity') == 1) { ?>
                                <div class="quantity">
                                    <?= lang('in_stock') ?>: <span><?= $article['quantity'] ?></span>
                                </div>
                            <?php } if (self::$CI->load->get_var('moreInfoBtn') == 1) { ?>
                                <a href="<?= $article['vendor_url'] == null ? LANG_URL . '/' . $article['url'] : LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>" class="info-btn gradient-color">
                                    <span class="text-to-bg"><?= lang('info_product_list') ?></span>
                                </a>
                            <?php } 
                            if (self::$CI->load->get_var('hideBuyButtonsOfOutOfStock') == 0 || (int)$article['quantity'] > 0) {
                                $hasRefresh = false;
                                if(self::$CI->load->get_var('refreshAfterAddToCart') == 1) {
                                    $hasRefresh = true;
                                }
                            ?>
                            <div class="add-to-cart">
                                <a href="javascript:void(0);" class="add-to-cart btn-add <?= $hasRefresh === true ? 'refresh-me' : '' ?>" data-goto="<?= LANG_URL . '/shopping-cart' ?>" data-id="<?= $article['id'] ?>">
                                    <img class="loader" src="<?= base_url('assets/imgs/ajax-loader.gif') ?>" alt="Loding">
                                    <span class="text-to-bg"><?= lang('add_to_cart') ?></span>
                                </a>
                            </div>
                            <div class="add-to-cart">
                                <a href="javascript:void(0);" class="add-to-cart btn-add more-blue" data-goto="<?= LANG_URL . '/checkout' ?>" data-id="<?= $article['id'] ?>">
                                    <img class="loader" src="<?= base_url('assets/imgs/ajax-loader.gif') ?>" alt="Loding">
                                    <span class="text-to-bg"><?= lang('buy_now') ?></span>
                                </a>
                            </div>
                            <?php } else { ?>
                            <div>
                                Product is out of stock
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                if ($carousel == true) {
                    ?>
                </div>
                <a class="left carousel-control" href="#small_carousel" role="button" data-slide="prev">
                    <i class="fa fa-5x fa-angle-left" aria-hidden="true"></i>
                </a>
                <a class="right carousel-control" href="#small_carousel" role="button" data-slide="next">
                    <i class="fa fa-5x fa-angle-right" aria-hidden="true"></i>
                </a>
            </div>
            <?php
        }
    }

}
