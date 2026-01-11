<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$productImage = base_url('/attachments/no-image-frontend.png');
if (is_file('attachments/shop_images/' . $product['image'])) {
    $productImage = base_url('/attachments/shop_images/' . $product['image']);
}
$addedCount = 0;
if (isset($_SESSION['shopping_cart']) && is_array($_SESSION['shopping_cart'])) {
    $result = array_count_values($_SESSION['shopping_cart']);
    if (isset($result[$product['id']])) {
        $addedCount = $result[$product['id']];
    }
}
?>

<div class="mx-auto max-w-7xl px-4 py-8" id="view-product">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-6">
            <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-center bg-slate-50 p-6">
                    <img src="<?= $productImage; ?>" data-num="0" class="other-img-preview img-sl the-image h-[520px] w-auto max-w-full object-contain" alt="<?= str_replace('"', "'", $product['title']) ?>">
                </div>
            </div>

            <?php if ($product['folder'] != null) { ?>
                <?php $dir = "attachments/shop_images/" . $product['folder'] . '/'; ?>
                <div class="mt-4 grid grid-cols-3 gap-3">
                    <?php
                    if (is_dir($dir)) {
                        if ($dh = opendir($dir)) {
                            $i = 1;
                            while (($file = readdir($dh)) !== false) {
                                if (is_file($dir . $file)) {
                                    ?>
                                    <button type="button" class="overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 hover:ring-slate-300">
                                        <div class="flex items-center justify-center bg-slate-50 p-2">
                                            <img src="<?= base_url($dir . $file) ?>" data-num="<?= $i ?>" class="other-img-preview img-sl the-image h-24 w-auto max-w-full object-contain" alt="<?= str_replace('"', "'", $product['title']) ?>">
                                        </div>
                                    </button>
                                    <?php
                                    $i++;
                                }
                            }
                            closedir($dh);
                        }
                    }
                    ?>
                </div>
            <?php } ?>

            <div class="mt-6 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <?php include rtrim(APPPATH, '/') . '/views/main/social_share.php'; ?>
            </div>
        </div>

        <div class="lg:col-span-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-start justify-between gap-4">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900"><?= $product['title'] ?></h1>
                    <a href="<?= LANG_URL ?>" class="hidden rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50 md:inline-flex">
                        <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i><?= lang('back_to_shop') ?>
                    </a>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <div class="inline-flex items-baseline gap-2 rounded-2xl bg-slate-950 px-4 py-3 text-white">
                        <div class="text-xs font-semibold uppercase tracking-wider text-white/70"><?= lang('price') ?></div>
                        <div class="text-xl font-bold"><?= $product['price'] . CURRENCY ?></div>
                    </div>
                    <?php if ($product['old_price'] != '') { ?>
                        <div class="text-sm text-slate-500 line-through"><?= $product['old_price'] . CURRENCY ?></div>
                    <?php } ?>
                    <?php if ($publicQuantity == 1) { ?>
                        <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            <?= lang('in_stock') ?>: <?= $product['quantity'] ?>
                        </div>
                    <?php } ?>
                    <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                        <?= lang('num_added_to_cart') ?>: <?= $addedCount ?>
                    </div>
                    <?php if ($publicDateAdded == 1) { ?>
                        <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            <?= lang('added_on') ?>: <?= date('m.d.Y', $product['time']) ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="mt-5 flex flex-wrap items-center gap-2">
                    <div class="text-sm font-semibold text-slate-700"><?= lang('in_category') ?>:</div>
                    <a href="javascript:void(0);" class="go-category inline-flex items-center rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50" data-categorie-id="<?= $product['shop_categorie'] ?>">
                        <?= $product['categorie_name'] ?>
                    </a>
                </div>

                <div class="mt-6 flex flex-col gap-2 sm:flex-row">
                    <?php if ($product['quantity'] > 0) { ?>
                        <a href="javascript:void(0);" data-id="<?= $product['id'] ?>" data-goto="<?= LANG_URL . '/shopping-cart' ?>" class="add-to-cart inline-flex flex-1 items-center justify-center gap-2 rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <?= lang('add_to_cart') ?>
                        </a>
                        <a href="javascript:void(0);" data-id="<?= $product['id'] ?>" data-goto="<?= LANG_URL . '/checkout' ?>" class="add-to-cart inline-flex items-center justify-center rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                            <i class="fa fa-bolt" aria-hidden="true"></i>
                            <?= lang('buy_now') ?>
                        </a>
                    <?php } else { ?>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">
                            <?= lang('out_of_stock_product') ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="mt-8 border-t border-slate-200 pt-6">
                    <div class="text-sm font-semibold text-slate-900"><?= lang('description') ?></div>
                    <div id="description" class="prose prose-slate mt-3 max-w-none text-sm">
                        <?= $product['description'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10" id="products-side">
        <div class="flex items-center justify-between">
            <div class="text-sm font-semibold text-slate-900"><?= lang('oder_from_category') ?></div>
        </div>
        <div class="mt-4">
            <?php if (!empty($sameCagegoryProducts)) { ?>
                <?= $load::getProducts($sameCagegoryProducts, '', false) ?>
            <?php } else { ?>
                <div class="rounded-2xl bg-white p-6 text-sm text-slate-700 shadow-sm ring-1 ring-slate-200">
                    <?= lang('no_same_category_products') ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div id="modalImagePreview" class="modal">
    <div class="image-preview-container">
        <div class="modal-content">
            <div class="inner-prev-container">
                <img id="img01" alt="">
                <span class="close">&times;</span>
                <span class="img-series"></span>
            </div>
        </div>
        <a href="javascript:void(0);" class="inner-next"></a>
        <a href="javascript:void(0);" class="inner-prev"></a>
    </div>
    <div id="caption"></div>
</div>
<script src="<?= base_url('assets/js/image-preveiw.js') ?>"></script>
