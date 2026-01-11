<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mx-auto max-w-7xl px-4 py-8" id="shopping-cart">
    <div class="flex items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900"><?= lang('shopping_cart') ?></h1>
            <p class="mt-1 text-sm text-slate-600"><?= lang('checkout_top_header') ?></p>
        </div>
        <a href="<?= LANG_URL ?>" class="hidden rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-slate-50 md:inline-flex">
            <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>
            <?= lang('back_to_shop') ?>
        </a>
    </div>

    <?php if (!isset($cartItems['array']) || $cartItems['array'] == null) { ?>
        <div class="mt-6 rounded-2xl bg-white p-6 text-sm text-slate-700 shadow-sm ring-1 ring-slate-200">
            <?= lang('no_products_in_cart') ?>
        </div>
    <?php } else { ?>
        <div class="mt-6 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
            <div class="space-y-3">
                <?php foreach ($cartItems['array'] as $item) { ?>
                    <?php
                    $productImage = base_url('/attachments/no-image-frontend.png');
                    if (is_file('attachments/shop_images/' . $item['image'])) {
                        $productImage = base_url('/attachments/shop_images/' . $item['image']);
                    }
                    ?>
                    <div class="flex flex-col gap-3 rounded-2xl bg-slate-50 p-3 ring-1 ring-inset ring-slate-200 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-3">
                            <a href="<?= LANG_URL . '/' . $item['url'] ?>" class="h-16 w-16 shrink-0 overflow-hidden rounded-xl bg-white ring-1 ring-slate-200">
                                <img class="h-full w-full object-cover" src="<?= $productImage ?>" alt="">
                            </a>
                            <div class="min-w-0">
                                <a href="<?= LANG_URL . '/' . $item['url'] ?>" class="block truncate text-sm font-semibold text-slate-900 hover:text-slate-700"><?= $item['title'] ?></a>
                                <div class="mt-1 text-xs text-slate-600">
                                    <?= $item['price'] . CURRENCY ?> · <?= lang('total') ?>: <?= $item['sum_price'] . CURRENCY ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <a class="refresh-me add-to-cart inline-flex items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50 <?= $item['quantity'] <= $item['num_added'] ? 'disabled' : '' ?>" data-id="<?= $item['id'] ?>" href="javascript:void(0);">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                            <span class="inline-flex min-w-[3rem] items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200">
                                <?= $item['num_added'] ?>
                            </span>
                            <a class="inline-flex items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50" onclick="removeProduct(<?= $item['id'] ?>, true)" href="javascript:void(0);">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </a>

                            <a href="<?= base_url('home/removeFromCart?delete-product=' . $item['id'] . '&back-to=shopping-cart') ?>" class="inline-flex items-center justify-center rounded-xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-700">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="mt-4 flex flex-col gap-3 border-t border-slate-200 pt-4 md:flex-row md:items-center md:justify-between">
                <div class="text-sm font-semibold text-slate-900">
                    <?= lang('total') ?>:
                    <span class="ml-1 font-bold"><?= $cartItems['finalSum'] . CURRENCY ?></span>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row">
                    <a href="<?= LANG_URL ?>" class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                        <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>
                        <?= lang('back_to_shop') ?>
                    </a>
                    <a class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" href="<?= LANG_URL . '/checkout' ?>">
                        <?= lang('checkout') ?>
                        <i class="fa fa-credit-card-alt ml-2" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php
if ($this->session->flashdata('deleted')) {
    ?>
    <script>
        $(document).ready(function () {
            ShowNotificator('alert-info', '<?= $this->session->flashdata('deleted') ?>');
        });
    </script>
<?php } ?>