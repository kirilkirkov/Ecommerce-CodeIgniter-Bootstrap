<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="mx-auto max-w-7xl px-4 py-8" id="home-page">
    <?php if (count($sliderProducts) > 0) { ?>
        <section class="rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-6 text-white shadow-xl">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight md:text-3xl"><?= lang('products') ?></h1>
                    <p class="mt-1 text-sm text-white/70"><?= lang('new') ?> · <?= lang('best_sellers') ?> · <?= lang('discounts') ?></p>
                </div>
                <a href="#products-side" class="hidden rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/10 hover:bg-white/15 md:inline-flex">
                    <?= lang('shop') ?>
                </a>
            </div>
            <div class="mt-6 flex snap-x snap-mandatory gap-4 overflow-x-auto pb-2">
                <?php foreach ($sliderProducts as $article) { ?>
                    <?php
                    $productImage = base_url('/attachments/no-image-frontend.png');
                    if (is_file('attachments/shop_images/' . $article['image'])) {
                        $productImage = base_url('/attachments/shop_images/' . $article['image']);
                    }
                    ?>
                    <article class="snap-start w-[18rem] shrink-0 overflow-hidden rounded-2xl bg-white/5 ring-1 ring-inset ring-white/10">
                        <a href="<?= LANG_URL . '/' . $article['url'] ?>" class="block">
                            <img src="<?= $productImage ?>" class="h-40 w-full object-cover" alt="<?= htmlentities($article['title']) ?>">
                        </a>
                        <div class="p-4">
                            <a href="<?= LANG_URL . '/' . $article['url'] ?>" class="block text-sm font-semibold text-white hover:text-white/80">
                                <?= character_limiter($article['title'], 70) ?>
                            </a>
                            <div class="mt-2 flex items-center justify-between">
                                <div class="text-sm font-bold"><?= $article['price'] . CURRENCY ?></div>
                                <div class="flex items-center gap-2">
                                    <?php if ($hideBuyButtonsOfOutOfStock == 0 || (int)$article['quantity'] > 0) { ?>
                                        <a class="add-to-cart inline-flex items-center justify-center rounded-xl bg-white px-3 py-2 text-xs font-semibold text-slate-900 hover:bg-slate-100" data-goto="<?= base_url('checkout') ?>" href="javascript:void(0);" data-id="<?= $article['id'] ?>">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        </a>
                                    <?php } ?>
                                    <a class="inline-flex items-center justify-center rounded-xl bg-white/10 px-3 py-2 text-xs font-semibold text-white ring-1 ring-inset ring-white/10 hover:bg-white/15" href="<?= LANG_URL . '/' . $article['url'] ?>">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        </section>
    <?php } ?>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-12">
        <aside class="lg:col-span-3">
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-900"><?= lang('categories') ?></div>
                    <?php if (isset($_GET['category']) && $_GET['category'] != '') { ?>
                        <a href="javascript:void(0);" class="clear-filter text-sm font-semibold text-slate-600 hover:text-slate-900" data-type-clear="category">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                    <?php } ?>
                </div>

                <a href="javascript:void(0)" id="show-xs-nav" class="mt-3 inline-flex w-full items-center justify-between rounded-xl bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 lg:hidden">
                    <span class="show-sp"><?= lang('showXsNav') ?> <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                    <span class="hidde-sp hidden"><?= lang('hideXsNav') ?> <i class="fa fa-angle-up" aria-hidden="true"></i></span>
                </a>

                <div id="nav-categories" class="mt-4">
                    <?php
                    function loop_tree($pages, $is_recursion = false)
                    {
                        ?>
                        <ul class="<?= $is_recursion === true ? 'ml-4 mt-2 space-y-1' : 'space-y-1' ?>">
                            <?php foreach ($pages as $page) {
                                $children = (isset($page['children']) && !empty($page['children']));
                                ?>
                                <li>
                                    <a href="javascript:void(0);" data-categorie-id="<?= $page['id'] ?>" class="go-category block rounded-xl px-3 py-2 text-sm font-medium <?= isset($_GET['category']) && $_GET['category'] == $page['id'] ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50' ?>">
                                        <?= htmlspecialchars($page['name'], ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                    <?php if ($children === true) {
                                        loop_tree($page['children'], true);
                                    } ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php
                    }
                    loop_tree($home_categories);
                    ?>
                </div>
            </div>

            <?php if ($showBrands == 1) { ?>
                <div class="mt-6 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold text-slate-900"><?= lang('brands') ?></div>
                        <?php if (isset($_GET['brand_id']) && $_GET['brand_id'] != '') { ?>
                            <a href="javascript:void(0);" class="clear-filter text-sm font-semibold text-slate-600 hover:text-slate-900" data-type-clear="brand_id">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        <?php } ?>
                    </div>
                    <div class="mt-3 space-y-1">
                        <?php foreach ($brands as $brand) { ?>
                            <a href="javascript:void(0);" data-brand-id="<?= $brand['id'] ?>" class="brand block rounded-xl px-3 py-2 text-sm font-medium <?= isset($_GET['brand_id']) && $_GET['brand_id'] == $brand['id'] ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50' ?>">
                                <?= $brand['name'] ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($showOutOfStock == 1) { ?>
                <div class="mt-6 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold text-slate-900"><?= lang('store') ?></div>
                        <?php if (isset($_GET['in_stock']) && $_GET['in_stock'] != '') { ?>
                            <a href="javascript:void(0);" class="clear-filter text-sm font-semibold text-slate-600 hover:text-slate-900" data-type-clear="in_stock">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        <?php } ?>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="javascript:void(0);" data-in-stock="1" class="in-stock block rounded-xl px-3 py-2 text-sm font-medium <?= isset($_GET['in_stock']) && $_GET['in_stock'] == '1' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50' ?>">
                            <?= lang('in_stock') ?> (<?= $countQuantities['in_stock'] ?>)
                        </a>
                        <a href="javascript:void(0);" data-in-stock="0" class="in-stock block rounded-xl px-3 py-2 text-sm font-medium <?= isset($_GET['in_stock']) && $_GET['in_stock'] == '0' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50' ?>">
                            <?= lang('out_of_stock') ?> (<?= $countQuantities['out_of_stock'] ?>)
                        </a>
                    </div>
                </div>
            <?php } ?>

            <?php if ($shippingOrder != 0 && $shippingOrder != null) { ?>
                <div class="mt-6 rounded-2xl bg-sky-50 p-4 ring-1 ring-sky-200">
                    <div class="text-sm font-semibold text-slate-900"><?= lang('freeShippingHeader') ?></div>
                    <div class="mt-2 text-sm text-slate-700">
                        <span class="font-semibold"><?= lang('promo') ?></span>
                        — <?= str_replace(array('%price%', '%currency%'), array($shippingOrder, CURRENCY), lang('freeShipping')) ?>!
                    </div>
                </div>
            <?php } ?>
        </aside>

        <main class="lg:col-span-9" id="products-side">
            <div class="flex flex-col gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 md:flex-row md:items-center md:justify-between">
                <div class="text-sm font-semibold text-slate-900"><?= lang('products') ?></div>
                <div class="flex flex-col gap-2 md:flex-row md:items-center">
                    <select class="order w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10 md:w-auto" data-order-to="order_new">
                        <option <?= isset($_GET['order_new']) && $_GET['order_new'] == "desc" ? 'selected' : '' ?> <?= !isset($_GET['order_new']) || $_GET['order_new'] == "" ? 'selected' : '' ?> value="desc"><?= lang('new') ?></option>
                        <option <?= isset($_GET['order_new']) && $_GET['order_new'] == "asc" ? 'selected' : '' ?> value="asc"><?= lang('old') ?></option>
                    </select>
                    <select class="order w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10 md:w-auto" data-order-to="order_price">
                        <option label="<?= lang('not_selected') ?>"></option>
                        <option <?= isset($_GET['order_price']) && $_GET['order_price'] == "asc" ? 'selected' : '' ?> value="asc"><?= lang('price_low') ?></option>
                        <option <?= isset($_GET['order_price']) && $_GET['order_price'] == "desc" ? 'selected' : '' ?> value="desc"><?= lang('price_high') ?></option>
                    </select>
                    <select class="order w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10 md:w-auto" data-order-to="order_procurement">
                        <option label="<?= lang('not_selected') ?>"></option>
                        <option <?= isset($_GET['order_procurement']) && $_GET['order_procurement'] == "desc" ? 'selected' : '' ?> value="desc"><?= lang('procurement_desc') ?></option>
                        <option <?= isset($_GET['order_procurement']) && $_GET['order_procurement'] == "asc" ? 'selected' : '' ?> value="asc"><?= lang('procurement_asc') ?></option>
                    </select>
                </div>
            </div>

            <?php if (!empty($products)) { ?>
                <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <?php foreach ($products as $article) { ?>
                        <?php
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

                                <div class="mt-3 flex gap-2">
                                    <?php if ($hideBuyButtonsOfOutOfStock == 0 || (int)$article['quantity'] > 0) { ?>
                                        <a href="javascript:void(0);" class="add-to-cart inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800" data-goto="<?= LANG_URL . '/shopping-cart' ?>" data-id="<?= $article['id'] ?>">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            <?= lang('add_to_cart') ?>
                                        </a>
                                        <a href="javascript:void(0);" class="add-to-cart inline-flex items-center justify-center rounded-xl bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-100" data-goto="<?= LANG_URL . '/checkout' ?>" data-id="<?= $article['id'] ?>">
                                            <i class="fa fa-bolt" aria-hidden="true"></i>
                                        </a>
                                    <?php } else { ?>
                                        <div class="flex-1 rounded-xl bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-200">
                                            <?= lang('out_of_stock_product') ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <script>
                    $(document).ready(function () {
                        ShowNotificator('alert-info', '<?= lang('no_results') ?>');
                    });
                </script>
            <?php } ?>

            <?php if ($links_pagination != '') { ?>
                <div class="mt-8 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                    <?= $links_pagination ?>
                </div>
            <?php } ?>
        </main>
    </div>
</div>