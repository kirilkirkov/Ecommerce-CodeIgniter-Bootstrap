<footer>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3><?= lang('about_us') ?></h3>
                    <p><?= $footerAboutUs ?></p>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3><?= lang('pages') ?></h3>
                    <ul>
                        <li><a href="<?= base_url() ?>">» <?= lang('home') ?> </a></li>
                        <li><a href="<?= $lang_url . '/checkout' ?>">» <?= lang('checkout') ?> </a></li>
                        <li><a href="<?= $lang_url . '/contacts' ?>">» <?= lang('contacts') ?> </a></li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3><?= lang('categories') ?></h3>
                    <?php if (!empty($footerCategories)) { ?>
                        <ul>
                            <?php foreach ($footerCategories as $key => $categorie) { ?>
                                <li><a href="javascript:void(0);" data-categorie-id="<?= $key ?>" class="go-category"><?= $categorie ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p><?= lang('no_categories') ?></p>
                    <?php } ?>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3><?= lang('contacts') ?></h3>
                    <ul class="footer-icon">
                        <li><span><i class="fa fa-map-marker"></i></span> <?= $footerContactAddr ?></li>
                        <li><span><i class="fa fa-phone"></i></span> <?= $footerContactPhone ?></li>
                        <li><span><i class="fa fa-envelope"></i></span> <?= $footerContactEmail ?></li>
                    </ul>
                </div>
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
                    <h3><?= lang('newsletter') ?></h3>
                    <ul>
                        <li>
                            <div class="input-append newsletter-box text-center">
                                <form method="POST" id="subscribeForm">
                                    <input type="text" class="full text-center" name="subscribeEmail" placeholder="<?= lang('email_address') ?>">
                                    <button class="btn bg-gray" onclick="checkEmailField()" type="button"> <?= lang('subscribe') ?> <i class="fa fa-long-arrow-right"></i></button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <ul class="social">
                        <?php if ($footerSocialFacebook != '') { ?>
                            <li> <a href="<?= $footerSocialFacebook ?>"><i class=" fa fa-facebook"></i></a></li>
                        <?php } if ($footerSocialTwitter != '') { ?>
                            <li> <a href="<?= $footerSocialTwitter ?>"><i class="fa fa-twitter"></i></a></li>
                        <?php } if ($footerSocialGooglePlus != '') { ?>
                            <li> <a href="<?= $footerSocialGooglePlus ?>"><i class="fa fa-google-plus"></i></a></li>
                        <?php } if ($footerSocialPinterest != '') { ?>
                            <li> <a href="<?= $footerSocialPinterest ?>"><i class="fa fa-pinterest"></i></a></li>
                        <?php } if ($footerSocialYoutube != '') { ?>
                            <li> <a href="<?= $footerSocialYoutube ?>"><i class="fa fa-youtube"></i></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div> 
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"><?= $footerCopyright ?></p>
            <div class="pull-right">
                <ul class="nav nav-pills payments">
                    <li><i class="fa fa-cc-visa"></i></li>
                    <li><i class="fa fa-cc-mastercard"></i></li>
                    <li><i class="fa fa-cc-amex"></i></li>
                    <li><i class="fa fa-cc-paypal"></i></li>
                </ul> 
            </div>
        </div>
    </div>
</footer>
<?php if ($this->session->flashdata('emailAdded')) { ?>
    <script>
        $(document).ready(function () {
            ShowNotificator('alert-success', '<?= lang('email_added') ?>');
        });
    </script>
<?php }
echo $addedJs;
?>
</div>
</div>
<div id="notificator" class="alert"></div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/js/bootstrap-confirmation.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/js/bootstrap-select.min.js"></script>
<script src="<?= base_url('assets/js/placeholders.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/js/mine.js') ?>"></script>
</body>
</html>
