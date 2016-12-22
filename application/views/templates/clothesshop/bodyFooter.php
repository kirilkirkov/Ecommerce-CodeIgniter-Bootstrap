<div class="h-line"></div>
<div class="body-footer">
    <div class="row">
        <?php if ($footerAboutUs != '') { ?>
            <div class="col-sm-3">
                <h3><?= lang('about_us') ?></h3>
                <p><?= $footerAboutUs ?></p>
            </div>
        <?php } ?>
        <div class="col-sm-3">
            <h3><?= lang('social') ?></h3>
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
        <div class="col-sm-3">
            <h3><?= lang('newsletter') ?></h3>
            <ul>
                <li>
                    <div class="input-append newsletter-box text-center">
                        <form method="POST" id="subscribeForm">
                            <input type="text" class="full text-center" name="subscribeEmail" placeholder="<?= lang('email_address') ?>">
                            <button class="btn bg-red cloth-bg-color" onclick="checkEmailField()" type="button"> <?= lang('subscribe') ?> <i class="fa fa-long-arrow-right"></i></button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-sm-3">
            <h3><?= lang('contacts') ?></h3>
            <ul class="footer-icon">
                <?php if ($footerContactAddr != '') { ?>
                    <li>
                        <span class="pull-left"><i class="fa fa-map-marker"></i></span> 
                        <span class="pull-left f-cont-info"> <?= $footerContactAddr ?></span> 
                    </li>
                <?php }if ($footerContactPhone != '') { ?>
                    <li>
                        <span class="pull-left"><i class="fa fa-phone"></i></span> 
                        <span class="pull-left f-cont-info"> <?= $footerContactPhone ?></span> 
                    </li>
                <?php } if ($footerContactEmail != '') { ?>
                    <li>
                        <span class="pull-left"><i class="fa fa-envelope"></i></span> 
                        <span class="pull-left f-cont-info"><a href="mailto:<?= $footerContactEmail ?>"><?= $footerContactEmail ?></a></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>