<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mx-auto max-w-3xl px-4 py-14">
    <div class="rounded-3xl bg-white p-8 text-center shadow-sm ring-1 ring-slate-200">
        <div class="mx-auto inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-600 text-white">
            <i class="fa fa-check" aria-hidden="true"></i>
        </div>
        <h1 class="mt-5 text-2xl font-bold tracking-tight text-slate-900"><?= lang('order_confirmed') ?></h1>
        <p class="mt-2 text-sm text-slate-600"><?= lang('thank_you_for_order') ?></p>
        <div class="mt-6">
            <a href="<?= LANG_URL ?>" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                <?= lang('back_to_shop') ?>
                <i class="fa fa-arrow-right ml-2" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>