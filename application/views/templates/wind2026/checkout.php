<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mx-auto max-w-7xl px-4 py-8" id="checkout-page">
    <?php if (isset($cartItems['array']) && $cartItems['array'] != null) { ?>
        <?php if ($shippingOrder != 0 && $shippingOrder != null) { ?>
            <div class="rounded-2xl bg-sky-50 p-4 ring-1 ring-sky-200">
                <div class="text-sm font-semibold text-slate-900"><?= lang('freeShippingHeader') ?></div>
                <div class="mt-2 text-sm text-slate-700">
                    <span class="font-semibold"><?= lang('promo') ?></span>
                    — <?= str_replace(array('%price%', '%currency%'), array($shippingOrder, CURRENCY), lang('freeShipping')) ?>!
                </div>
            </div>
        <?php } ?>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-center justify-between gap-4">
                        <h1 class="text-xl font-bold tracking-tight text-slate-900"><?= lang('checkout') ?></h1>
                        <a href="<?= LANG_URL . '/shopping-cart' ?>" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                            <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i><?= lang('shopping_cart') ?>
                        </a>
                    </div>

                    <?php if ($this->session->flashdata('submit_error')) { ?>
                        <div class="mt-4 rounded-2xl bg-rose-50 p-4 text-sm text-rose-900 ring-1 ring-rose-200">
                            <div class="font-semibold"><?= lang('finded_errors') ?></div>
                            <div class="mt-2 space-y-1">
                                <?php foreach ($this->session->flashdata('submit_error') as $error) { ?>
                                    <div><?= $error ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                    <form method="POST" id="goOrder" class="mt-6 space-y-6">
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wider text-slate-500"><?= lang('choose_payment') ?></label>
                            <select name="payment_type" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-900 outline-none focus:ring-2 focus:ring-slate-900/10">
                                <?php if ($cashondelivery_visibility == 1) { ?>
                                    <option value="cashOnDelivery"><?= lang('cash_on_delivery') ?></option>
                                <?php } ?>
                                <?php if (filter_var($paypal_email, FILTER_VALIDATE_EMAIL)) { ?>
                                    <option value="PayPal"><?= lang('paypal') ?></option>
                                <?php } ?>
                                <?php if (isset($bank_account['iban']) && $bank_account['iban'] != null) { ?>
                                    <option value="Bank"><?= lang('bank_payment') ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="firstNameInput" class="text-sm font-semibold text-slate-700"><?= lang('first_name') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                <input id="firstNameInput" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="first_name" value="<?= @$_POST['first_name'] ?>" type="text" placeholder="<?= lang('first_name') ?>">
                            </div>
                            <div>
                                <label for="lastNameInput" class="text-sm font-semibold text-slate-700"><?= lang('last_name') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                <input id="lastNameInput" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="last_name" value="<?= @$_POST['last_name'] ?>" type="text" placeholder="<?= lang('last_name') ?>">
                            </div>
                            <div>
                                <label for="emailAddressInput" class="text-sm font-semibold text-slate-700"><?= lang('email_address') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                <input id="emailAddressInput" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="email" value="<?= @$_POST['email'] ?>" type="text" placeholder="<?= lang('email_address') ?>">
                            </div>
                            <div>
                                <label for="phoneInput" class="text-sm font-semibold text-slate-700"><?= lang('phone') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                <input id="phoneInput" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="phone" value="<?= @$_POST['phone'] ?>" type="text" placeholder="<?= lang('phone') ?>">
                            </div>
                            <div class="md:col-span-2">
                                <label for="addressInput" class="text-sm font-semibold text-slate-700"><?= lang('address') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                <textarea id="addressInput" name="address" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" rows="3"><?= @$_POST['address'] ?></textarea>
                            </div>
                            <div>
                                <label for="cityInput" class="text-sm font-semibold text-slate-700"><?= lang('city') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                <input id="cityInput" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="city" value="<?= @$_POST['city'] ?>" type="text" placeholder="<?= lang('city') ?>">
                            </div>
                            <div>
                                <label for="postInput" class="text-sm font-semibold text-slate-700"><?= lang('post_code') ?></label>
                                <input id="postInput" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="post_code" value="<?= @$_POST['post_code'] ?>" type="text" placeholder="<?= lang('post_code') ?>">
                            </div>
                            <div class="md:col-span-2">
                                <label for="notesInput" class="text-sm font-semibold text-slate-700"><?= lang('notes') ?></label>
                                <textarea id="notesInput" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="notes" rows="3"><?= @$_POST['notes'] ?></textarea>
                            </div>
                        </div>

                        <?php if ($codeDiscounts == 1) { ?>
                            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                <label class="text-sm font-semibold text-slate-700"><?= lang('discount_code') ?></label>
                                <div class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center">
                                    <input class="w-full flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="discountCode" value="<?= @$_POST['discountCode'] ?>" placeholder="<?= lang('enter_discount_code') ?>" type="text">
                                    <a href="javascript:void(0);" class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-100" onclick="checkDiscountCode()">
                                        <?= lang('check_code') ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="rounded-2xl bg-white ring-1 ring-slate-200">
                            <div class="border-b border-slate-200 px-4 py-3 text-sm font-semibold text-slate-900"><?= lang('products') ?></div>
                            <div class="p-4 space-y-3">
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
                                            <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                                            <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">

                                            <a class="refresh-me add-to-cart inline-flex items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50 <?= $item['quantity'] <= $item['num_added'] ? 'disabled' : '' ?>" data-id="<?= $item['id'] ?>" href="javascript:void(0);">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </a>
                                            <span class="inline-flex min-w-[3rem] items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200">
                                                <?= $item['num_added'] ?>
                                            </span>
                                            <a class="inline-flex items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50" onclick="removeProduct(<?= $item['id'] ?>, true)" href="javascript:void(0);">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </a>
                                            <a href="<?= base_url('home/removeFromCart?delete-product=' . $item['id'] . '&back-to=checkout') ?>" class="inline-flex items-center justify-center rounded-xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-700">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="flex items-center justify-between border-t border-slate-200 pt-4 text-sm font-semibold text-slate-900">
                                    <div><?= lang('total') ?></div>
                                    <div>
                                        <span class="final-amount"><?= $cartItems['finalSum'] ?></span><?= CURRENCY ?>
                                        <input type="hidden" class="final-amount" name="final_amount" value="<?= $cartItems['finalSum'] ?>">
                                        <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
                                        <input type="hidden" name="discountAmount" value="">
                                    </div>
                                </div>

                                <?php
                                $total_parsed = str_replace(' ', '', str_replace(',', '', $cartItems['finalSum']));
                                if ((int)$shippingAmount > 0 && ((int)$shippingOrder > $total_parsed)) {
                                    ?>
                                    <div class="flex items-center justify-between text-sm font-semibold text-slate-900">
                                        <div><?= lang('shipping') ?></div>
                                        <div><span class="final-amount"><?= (int)$shippingAmount ?></span><?= CURRENCY ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </form>

                    <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <a href="<?= LANG_URL ?>" class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                            <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>
                            <?= lang('back_to_shop') ?>
                        </a>
                        <a href="javascript:void(0);" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" onclick="document.getElementById('goOrder').submit();">
                            <?= lang('custom_order') ?>
                            <i class="fa fa-arrow-right ml-2" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <aside class="lg:col-span-4">
                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold text-slate-900"><?= lang('best_sellers') ?></div>
                        <i class="fa fa-trophy text-slate-500" aria-hidden="true"></i>
                    </div>
                    <div class="mt-4">
                        <?= $load::getProducts($bestSellers, '', true) ?>
                    </div>
                </div>
            </aside>
        </div>
    <?php } else { ?>
        <div class="rounded-2xl bg-white p-6 text-sm text-slate-700 shadow-sm ring-1 ring-slate-200">
            <?= lang('no_products_in_cart') ?>
        </div>
    <?php } ?>
</div>

<?php if ($this->session->flashdata('deleted')) { ?>
    <script>
        $(document).ready(function () {
            ShowNotificator('alert-info', '<?= $this->session->flashdata('deleted') ?>');
        });
    </script>
<?php } ?>
<?php if ($codeDiscounts == 1 && isset($_POST['discountCode'])) { ?>
    <script>
        $(document).ready(function () {
            checkDiscountCode();
        });
    </script>
<?php } ?>