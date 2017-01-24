<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/settings-page.png') ?>" class="header-img" style="margin-top:-3px;">Settings</h1>
<hr>
<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Site Logo</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultSiteLogoPublish')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultSiteLogoPublish') ?></div>
                <?php } ?>
                <img src="<?= base_url('attachments/site_logo/' . $siteLogo) ?>" alt="Logo is deleted. Upload new!" class="img-responsive">
                <hr>
                <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">
                    <input type="file" name="sitelogo" size="20" />
                    <input type="submit" value="Upload New" name="uploadimage" class="btn btn-default" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Navigation Text</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultNaviText')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultNaviText') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="input-group">
                        <input class="form-control" name="naviText" value="<?= $naviText ?>" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn-default" value="" type="submit">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Footer Text</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultFooterCopyright')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultFooterCopyright') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="input-group">
                        <input class="form-control" name="footerCopyright" value="<?= $footerCopyright ?>" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn-default" value="" placeholder="Find product.." type="submit">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Contacts page</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultContactspage')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultContactspage') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <textarea name="contactsPage" id="contacts-page"><?= $contactsPage ?></textarea></div>
                    <div class="form-group">
                        <button class="btn btn-default" value="" placeholder="Find product.." type="submit">
                            Update <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            CKEDITOR.replace('contacts-page');
        </script>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Contacts footer</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultfooterContacts')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultfooterContacts') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="form-group" style="position: relative;">
                        <input type="text" style="padding-left:25px;" class="form-control" name="footerContactAddr" value="<?= $footerContactAddr ?>">
                        <i class="fa fa-map-marker" style="position: absolute;top:10px;left:10px;"></i>
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-phone" style="position: absolute;top:10px;left:10px;"></i>
                        <input type="text" style="padding-left:25px;" class="form-control" name="footerContactPhone" value="<?= $footerContactPhone ?>">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-envelope" style="position: absolute;top:10px;left:10px;"></i>
                        <input type="text" style="padding-left:25px;" class="form-control" name="footerContactEmail" value="<?= $footerContactEmail ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" name="footerContacts" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Google Maps</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultGoogleMaps')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultGoogleMaps') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input class="form-control" placeholder="Direction: 42.676250, 23.371063" name="googleMaps" value="<?= $googleMaps ?>" type="text" style="margin-bottom:10px;">
                    <input class="form-control" placeholder="Api key" name="googleApi" value="<?= $googleApi ?>" type="text" style="margin-bottom:10px;">
                    <button class="btn btn-default" value="" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Footer about us</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultFooterAboutUs')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultFooterAboutUs') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="input-group">
                        <input class="form-control" name="footerAboutUs" value="<?= $footerAboutUs ?>" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn-default" value="" type="submit">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Social media links</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultfooterSocial')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultfooterSocial') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="form-group" style="position: relative;">
                        <input type="text" style="padding-left:25px;" class="form-control" name="footerSocialFacebook" value="<?= $footerSocialFacebook ?>">
                        <i class="fa fa-facebook" style="position: absolute;top:10px;left:10px;"></i>
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-twitter" style="position: absolute;top:10px;left:10px;"></i>
                        <input type="text" style="padding-left:25px;" class="form-control" name="footerSocialTwitter" value="<?= $footerSocialTwitter ?>">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-google-plus" style="position: absolute;top:10px;left:10px;"></i>
                        <input type="text" style="padding-left:25px;" class="form-control" name="footerSocialGooglePlus" value="<?= $footerSocialGooglePlus ?>">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-pinterest" style="position: absolute;top:10px;left:10px;"></i>
                        <input type="text" style="padding-left:25px;" class="form-control" name="footerSocialPinterest" value="<?= $footerSocialPinterest ?>">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <i class="fa fa-youtube" style="position: absolute;top:10px;left:10px;"></i>
                        <input type="text" style="padding-left:25px;" class="form-control" name="footerSocialYoutube" value="<?= $footerSocialYoutube ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" name="footerSocial" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Send email from contact form to:</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultEmailTo')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultEmailTo') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="input-group">
                        <input class="form-control" name="contactsEmailTo" value="<?= $contactsEmailTo ?>" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn-default" value="" type="submit">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Free Shipping for order equal or more than:</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('shippingOrder')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('shippingOrder') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="input-group">
                        <input class="form-control" name="shippingOrder" value="<?= $shippingOrder ?>" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn-default" value="" type="submit">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Add google or other JavaScript to site</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('addJs')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('addJs') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <textarea style="margin-bottom:5px;" name="addJs" class="form-control"><?= $addJs ?></textarea>
                    <button class="btn btn-default" value="" type="submit">
                        Add the code
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Public quantity visability</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('publicQuantity')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('publicQuantity') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="publicQuantity" value="<?= $publicQuantity ?>">
                    <input <?= $publicQuantity == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="publicQuantity" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Public date added visability</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('publicDateAdded')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('publicDateAdded') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="publicDateAdded" value="<?= $publicDateAdded ?>">
                    <input <?= $publicDateAdded == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="publicDateAdded" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Show in list out of stock products</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('outOfStock')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('outOfStock') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="outOfStock" value="<?= $outOfStock ?>">
                    <input <?= $outOfStock == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="outOfStock" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Show 'More information' button in products list</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('moreInfoBtn')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('moreInfoBtn') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="moreInfoBtn" value="<?= $moreInfoBtn ?>">
                    <input <?= $moreInfoBtn == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="moreInfoBtn" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Show brands</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('showBrands')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('showBrands') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="showBrands" value="<?= $showBrands ?>">
                    <input <?= $showBrands == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="showBrands" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Show in slider products to list</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('showInSlider')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('showInSlider') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="showInSlider" value="<?= $showInSlider ?>">
                    <input <?= $showInSlider == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="showInSlider" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Cookie Law Notification</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('cookieNotificator')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('cookieNotificator') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="visibility" value="<?= isset($cookieLawInfo['cookieInfo']['visibility']) ? $cookieLawInfo['cookieInfo']['visibility'] : '0' ?>">
                    <label>Enable:</label>
                    <input <?= isset($cookieLawInfo['cookieInfo']['visibility']) && $cookieLawInfo['cookieInfo']['visibility'] == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="visibility" class="toggle-changer" type="checkbox">
                    <hr>
                    <?php foreach ($languages->result() as $language) { ?>
                        <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
                    <?php } foreach ($languages->result() as $language) { ?>
                        <div class="form-group">
                            <label for="message-cookie-law">Message (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                            <input type="text" name="message[]" value="<?= isset($cookieLawInfo['cookieTranslate'][$language->abbr]['message']) ? $cookieLawInfo['cookieTranslate'][$language->abbr]['message'] : '' ?>" class="form-control" id="message-cookie-law">
                        </div>
                    <?php } foreach ($languages->result() as $language) {
                        ?>
                        <div class="form-group">
                            <label for="btn-cookie-law">Button Text (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                            <input type="text" name="button_text[]" value="<?= isset($cookieLawInfo['cookieTranslate'][$language->abbr]['button_text']) ? $cookieLawInfo['cookieTranslate'][$language->abbr]['button_text'] : '' ?>" class="form-control" id="btn-cookie-law">
                        </div>
                    <?php } foreach ($languages->result() as $language) { ?>
                        <div class="form-group">
                            <label for="learn_more">Learn More (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">):</label>
                            <input type="text" name="learn_more[]" value="<?= isset($cookieLawInfo['cookieTranslate'][$language->abbr]['learn_more']) ? $cookieLawInfo['cookieTranslate'][$language->abbr]['learn_more'] : '' ?>" class="form-control" id="learn_more">
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="link-cookie-law"><i class="fa fa-link" aria-hidden="true"></i> Link to learn more (the law):</label>
                        <input type="text" name="link" value="<?= isset($cookieLawInfo['cookieInfo']['link']) ? $cookieLawInfo['cookieInfo']['link'] : '' ?>" class="form-control" id="link-cookie-law">
                    </div>
                    <div class="form-group">
                        <label>Theme choose:</label>
                        <input type="hidden" name="theme" value="<?= isset($cookieLawInfo['cookieInfo']['theme']) ? $cookieLawInfo['cookieInfo']['theme'] : '' ?>">
                        <div class="row cookie-law-themes bg-info">
                            <?php foreach ($law_themes as $theme) { ?>
                                <div class="col-sm-6">
                                    <a href="javascript:void(0);" class="select-law-theme" data-law-theme="<?= str_replace('.png', '', $theme) ?>">
                                        <img src="<?= base_url('assets/imgs/cookie-law-themes/' . $theme) ?>" class="img-responsive theme" alt="<?= $theme ?>">
                                        <img src="<?= base_url('assets/imgs/ok-themes.png') ?>" <?=
                                        isset($cookieLawInfo['cookieInfo']['theme']) &&
                                        $cookieLawInfo['cookieInfo']['theme'] == str_replace('.png', '', $theme) ? 'style="display:block;"' : ''
                                        ?> class="ok" alt="CHOOSED">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <button class="btn btn-default" name="setCookieLaw" value="" type="submit">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>