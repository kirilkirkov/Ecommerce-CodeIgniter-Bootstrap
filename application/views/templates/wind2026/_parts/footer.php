<footer class="border-t border-slate-200 bg-slate-950 text-slate-100">
    <div class="mx-auto max-w-7xl px-4 py-12">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-12">
            <div class="md:col-span-4">
                <div class="flex items-center gap-3">
                    <div class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    </div>
                    <div class="text-base font-semibold"><?= isset($navitext) && $navitext != null ? $navitext : $_SERVER['HTTP_HOST'] ?></div>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-slate-300"><?= $footerAboutUs ?></p>
            </div>

            <div class="md:col-span-2">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-200"><?= lang('pages') ?></h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a class="text-slate-300 hover:text-white" href="<?= base_url() ?>"><?= lang('home') ?></a></li>
                    <li><a class="text-slate-300 hover:text-white" href="<?= LANG_URL . '/checkout' ?>"><?= lang('checkout') ?></a></li>
                    <li><a class="text-slate-300 hover:text-white" href="<?= LANG_URL . '/contacts' ?>"><?= lang('contacts') ?></a></li>
                </ul>
            </div>

            <div class="md:col-span-3">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-200"><?= lang('categories') ?></h3>
                <?php if (!empty($footerCategories)) { ?>
                    <ul class="mt-4 space-y-2 text-sm">
                        <?php foreach ($footerCategories as $key => $categorie) { ?>
                            <li><a class="go-category text-slate-300 hover:text-white" href="javascript:void(0);" data-categorie-id="<?= $key ?>"><?= htmlspecialchars($categorie, ENT_QUOTES, 'UTF-8') ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p class="mt-4 text-sm text-slate-300"><?= lang('no_categories') ?></p>
                <?php } ?>
            </div>

            <div class="md:col-span-3">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-200"><?= lang('newsletter') ?></h3>
                <p class="mt-4 text-sm text-slate-300"><?= lang('email_address') ?></p>
                <form method="POST" id="subscribeForm" class="mt-3 flex flex-col gap-2">
                    <input type="text" class="w-full rounded-xl border border-slate-800 bg-slate-900/60 px-3 py-2 text-sm text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-white/10" name="subscribeEmail" placeholder="<?= lang('email_address') ?>">
                    <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-100" onclick="checkEmailField()" type="button">
                        <?= lang('subscribe') ?> <i class="fa fa-long-arrow-right"></i>
                    </button>
                </form>

                <div class="mt-6">
                    <div class="text-xs font-semibold uppercase tracking-wider text-slate-200"><?= lang('contacts') ?></div>
                    <div class="mt-3 space-y-2 text-sm text-slate-300">
                        <?php if ($footerContactAddr != '') { ?>
                            <div class="flex gap-2"><i class="fa fa-map-marker mt-0.5 w-4 text-slate-400" aria-hidden="true"></i><div><?= $footerContactAddr ?></div></div>
                        <?php } ?>
                        <?php if ($footerContactPhone != '') { ?>
                            <div class="flex gap-2"><i class="fa fa-phone mt-0.5 w-4 text-slate-400" aria-hidden="true"></i><div><?= $footerContactPhone ?></div></div>
                        <?php } ?>
                        <?php if ($footerContactEmail != '') { ?>
                            <div class="flex gap-2"><i class="fa fa-envelope mt-0.5 w-4 text-slate-400" aria-hidden="true"></i><a class="text-slate-300 hover:text-white" href="mailto:<?= $footerContactEmail ?>"><?= $footerContactEmail ?></a></div>
                        <?php } ?>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <?php if ($footerSocialFacebook != '') { ?><a class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-white hover:bg-white/15" href="<?= $footerSocialFacebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a><?php } ?>
                        <?php if ($footerSocialTwitter != '') { ?><a class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-white hover:bg-white/15" href="<?= $footerSocialTwitter ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a><?php } ?>
                        <?php if ($footerSocialGooglePlus != '') { ?><a class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-white hover:bg-white/15" href="<?= $footerSocialGooglePlus ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a><?php } ?>
                        <?php if ($footerSocialPinterest != '') { ?><a class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-white hover:bg-white/15" href="<?= $footerSocialPinterest ?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a><?php } ?>
                        <?php if ($footerSocialYoutube != '') { ?><a class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-white hover:bg-white/15" href="<?= $footerSocialYoutube ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-slate-800">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-6 text-sm text-slate-400 md:flex-row md:items-center md:justify-between">
            <p>
                <?= $footercopyright ?>
                <br>
                <!-- Please do not remove this referention -->
                Powered by <a class="text-slate-300 hover:text-white" href="https://github.com/kirilkirkov">Kiril Kirkov</a>
            </p>
            <div class="flex items-center gap-3 text-xl text-slate-300">
                <i class="fa fa-cc-visa" aria-hidden="true"></i>
                <i class="fa fa-cc-mastercard" aria-hidden="true"></i>
                <i class="fa fa-cc-amex" aria-hidden="true"></i>
                <i class="fa fa-cc-paypal" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</footer>
<?php if ($this->session->flashdata('emailAdded')) { ?>
    <script>
        $(document).ready(function () {
            ShowNotificator('alert-info', '<?= lang('email_added') ?>');
        });
    </script>
    <?php
}
echo $addJs;
?>
</div>
</div>
<div id="notificator" class="alert"></div>
<script>
var variable = {
    clearShoppingCartUrl: "<?= base_url('clearShoppingCart') ?>",
    manageShoppingCartUrl: "<?= base_url('manageShoppingCart') ?>",
    discountCodeChecker: "<?= base_url('discountCodeChecker') ?>"
};
</script>
<script src="<?= base_url('assets/js/system.js') ?>"></script>
<script src="<?= base_url('templatejs/mine.js') ?>"></script>
</body>
</html>
