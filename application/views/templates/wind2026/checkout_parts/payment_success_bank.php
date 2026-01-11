<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mx-auto max-w-3xl px-4 py-14">
    <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
        <div class="flex items-start gap-4">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-white">
                <i class="fa fa-university" aria-hidden="true"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900"><?= lang('bank_payment') ?></h1>
                <p class="mt-1 text-sm text-slate-600"><?= lang('final_amount_for_pay') ?> <?= isset($_SESSION['final_amount']) ? $_SESSION['final_amount'] : '' ?></p>
            </div>
        </div>

        <?php if (isset($_SESSION['order_id'])) { ?>
            <div class="mt-6 rounded-2xl bg-slate-50 p-4 ring-1 ring-inset ring-slate-200">
                <div class="grid grid-cols-1 gap-3 text-sm text-slate-800">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500"><?= lang('bank_recipient_name') ?></div>
                        <div class="mt-1 font-semibold"><?= $bank_account != null ? $bank_account['name'] : '' ?></div>
                    </div>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500"><?= lang('bank_iban') ?></div>
                            <div class="mt-1 font-mono text-sm"><?= $bank_account != null ? $bank_account['iban'] : '' ?></div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500"><?= lang('bank_bic') ?></div>
                            <div class="mt-1 font-mono text-sm"><?= $bank_account != null ? $bank_account['bic'] : '' ?></div>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500"><?= lang('bank_name') ?></div>
                        <div class="mt-1"><?= $bank_account != null ? $bank_account['bank'] : '' ?></div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-500"><?= lang('bank_reason') ?></div>
                        <div class="mt-1 font-semibold"><?= lang('the_reason') ?> - <?= $_SESSION['order_id'] ?></div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-end">
            <a href="<?= LANG_URL ?>" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                <?= lang('back_to_shop') ?>
                <i class="fa fa-arrow-right ml-2" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>