<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mx-auto max-w-7xl px-4 py-8" id="vendor-page">
    <div class="rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8 text-white shadow-xl">
        <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <div class="text-xs font-semibold uppercase tracking-wider text-white/70"><?= lang('vendor') ?></div>
                <h1 class="mt-1 text-2xl font-bold tracking-tight md:text-3xl"><?= $vendorInfo['name'] ?></h1>
            </div>
            <a href="<?= LANG_URL ?>" class="inline-flex items-center justify-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/10 hover:bg-white/15">
                <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i><?= lang('back_to_shop') ?>
            </a>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-12">
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

            <div class="mt-6">
                <?php if (!empty($products)) { ?>
                    <?= $load::getProducts($products, '', false) ?>
                <?php } else { ?>
                    <script>
                        $(document).ready(function () {
                            ShowNotificator('alert-info', '<?= lang('no_results') ?>');
                        });
                    </script>
                <?php } ?>
            </div>

            <?php if ($links_pagination != '') { ?>
                <div class="mt-8 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                    <?= $links_pagination ?>
                </div>
            <?php } ?>
        </main>
    </div>
</div>