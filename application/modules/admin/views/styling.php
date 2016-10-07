<script src="<?= base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/pages-styling.png') ?>" class="header-img" style="margin-top:-3px;">Styling</h1>
<hr>
<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Site Logo</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('resultSiteLogoPublish')) { ?>
                    <div class="alert alert-info"><?= print_r($this->session->flashdata('resultSiteLogoPublish')) ?></div>
                <?php } ?>
                <img src="<?= base_url('assets/imgs/site-logo/' . $siteLogo) ?>" alt="Logo is deleted. Upload new!" class="img-responsive">
                <hr>
                <?= form_open_multipart('admin/styling') ?>
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
                    <div class="input-group">
                        <input class="form-control" name="googleMaps" value="<?= $googleMaps ?>" type="text">
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
</div>