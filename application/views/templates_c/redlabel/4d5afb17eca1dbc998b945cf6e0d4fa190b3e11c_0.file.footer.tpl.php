<?php
/* Smarty version 3.1.30, created on 2016-12-14 16:24:46
  from "/var/www/html/shop/application/views/templates/redlabel/_parts/footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5851562e4ffa05_30661455',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d5afb17eca1dbc998b945cf6e0d4fa190b3e11c' => 
    array (
      0 => '/var/www/html/shop/application/views/templates/redlabel/_parts/footer.tpl',
      1 => 1481721250,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5851562e4ffa05_30661455 (Smarty_Internal_Template $_smarty_tpl) {
?>
<footer>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 f-col">
                    <h3><?php echo '<?=';?> lang('about_us') <?php echo '?>';?></h3>
                    <p><?php echo '<?=';?> $footerAboutUs <?php echo '?>';?></p>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 f-col">
                    <h3><?php echo '<?=';?> lang('pages') <?php echo '?>';?></h3>
                    <ul>
                        <li><a href="<?php echo '<?=';?> base_url() <?php echo '?>';?>">» <?php echo '<?=';?> lang('home') <?php echo '?>';?> </a></li>
                        <li><a href="<?php echo '<?=';?> LANG_URL . '/checkout' <?php echo '?>';?>">» <?php echo '<?=';?> lang('checkout') <?php echo '?>';?> </a></li>
                        <li><a href="<?php echo '<?=';?> LANG_URL . '/contacts' <?php echo '?>';?>">» <?php echo '<?=';?> lang('contacts') <?php echo '?>';?> </a></li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 f-col">
                    <h3><?php echo '<?=';?> lang('categories') <?php echo '?>';?></h3>
                    <?php echo '<?php ';?>if (!empty($footerCategories)) { <?php echo '?>';?>
                        <ul>
                            <?php echo '<?php ';?>foreach ($footerCategories as $key => $categorie) { <?php echo '?>';?>
                                <li><a href="javascript:void(0);" data-categorie-id="<?php echo '<?=';?> $key <?php echo '?>';?>" class="go-category"><?php echo '<?=';?> $categorie <?php echo '?>';?></a></li>
                            <?php echo '<?php ';?>} <?php echo '?>';?>
                        </ul>
                    <?php echo '<?php ';?>} else { <?php echo '?>';?>
                        <p><?php echo '<?=';?> lang('no_categories') <?php echo '?>';?></p>
                    <?php echo '<?php ';?>} <?php echo '?>';?>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 f-col">
                    <h3><?php echo '<?=';?> lang('contacts') <?php echo '?>';?></h3>
                    <ul class="footer-icon">
                        <?php echo '<?php ';?>if ($footerContactAddr != '') { <?php echo '?>';?>
                            <li>
                                <span class="pull-left"><i class="fa fa-map-marker"></i></span> 
                                <span class="pull-left f-cont-info"> <?php echo '<?=';?> $footerContactAddr <?php echo '?>';?></span> 
                            </li>
                        <?php echo '<?php ';?>}if ($footerContactPhone != '') { <?php echo '?>';?>
                            <li>
                                <span class="pull-left"><i class="fa fa-phone"></i></span> 
                                <span class="pull-left f-cont-info"> <?php echo '<?=';?> $footerContactPhone <?php echo '?>';?></span> 
                            </li>
                        <?php echo '<?php ';?>} if ($footerContactEmail != '') { <?php echo '?>';?>
                            <li>
                                <span class="pull-left"><i class="fa fa-envelope"></i></span> 
                                <span class="pull-left f-cont-info"><a href="mailto:<?php echo '<?=';?> $footerContactEmail <?php echo '?>';?>"><?php echo '<?=';?> $footerContactEmail <?php echo '?>';?></a></span>
                            </li>
                        <?php echo '<?php ';?>} <?php echo '?>';?>
                    </ul>
                </div>
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 f-col">
                    <h3><?php echo '<?=';?> lang('newsletter') <?php echo '?>';?></h3>
                    <ul>
                        <li>
                            <div class="input-append newsletter-box text-center">
                                <form method="POST" id="subscribeForm">
                                    <input type="text" class="full text-center" name="subscribeEmail" placeholder="<?php echo '<?=';?> lang('email_address') <?php echo '?>';?>">
                                    <button class="btn bg-gray" onclick="checkEmailField()" type="button"> <?php echo '<?=';?> lang('subscribe') <?php echo '?>';?> <i class="fa fa-long-arrow-right"></i></button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <ul class="social">
                        <?php echo '<?php ';?>if ($footerSocialFacebook != '') { <?php echo '?>';?>
                            <li> <a href="<?php echo '<?=';?> $footerSocialFacebook <?php echo '?>';?>"><i class=" fa fa-facebook"></i></a></li>
                        <?php echo '<?php ';?>} if ($footerSocialTwitter != '') { <?php echo '?>';?>
                            <li> <a href="<?php echo '<?=';?> $footerSocialTwitter <?php echo '?>';?>"><i class="fa fa-twitter"></i></a></li>
                        <?php echo '<?php ';?>} if ($footerSocialGooglePlus != '') { <?php echo '?>';?>
                            <li> <a href="<?php echo '<?=';?> $footerSocialGooglePlus <?php echo '?>';?>"><i class="fa fa-google-plus"></i></a></li>
                        <?php echo '<?php ';?>} if ($footerSocialPinterest != '') { <?php echo '?>';?>
                            <li> <a href="<?php echo '<?=';?> $footerSocialPinterest <?php echo '?>';?>"><i class="fa fa-pinterest"></i></a></li>
                        <?php echo '<?php ';?>} if ($footerSocialYoutube != '') { <?php echo '?>';?>
                            <li> <a href="<?php echo '<?=';?> $footerSocialYoutube <?php echo '?>';?>"><i class="fa fa-youtube"></i></a></li>
                        <?php echo '<?php ';?>} <?php echo '?>';?>
                    </ul>
                </div>
            </div> 
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"><?php echo '<?=';?> $footerCopyright <?php echo '?>';?></p>
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
<?php echo '<?php ';?>if ($this->session->flashdata('emailAdded')) { <?php echo '?>';?>
    <?php echo '<script'; ?>
>
        $(document).ready(function () {
            ShowNotificator('alert-info', '<?php echo '<?=';?> lang('email_added') <?php echo '?>';?>');
        });
    <?php echo '</script'; ?>
>
    <?php echo '<?php
';?>}
echo $addedJs;
<?php echo '?>';?>
</div>
</div>
<div id="notificator" class="alert"></div>
<?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo '<?=';?> base_url('assets/js/bootstrap-confirmation.min.js') <?php echo '?>';?>"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/js/bootstrap-select.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo '<?=';?> base_url('assets/js/placeholders.min.js') <?php echo '?>';?>"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo '<?=';?> base_url('assets/js/bootstrap-datepicker.min.js') <?php echo '?>';?>"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo '<?=';?> base_url('assets/js/mine.js') <?php echo '?>';?>"><?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
