<?php
/* Smarty version 3.1.30, created on 2016-12-14 17:12:58
  from "/var/www/html/shop/application/views/templates/redlabel/_parts/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5851617a7d2a51_19568645',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '764d8c3aaa681a82277fc158f7c1d0f3f431ead8' => 
    array (
      0 => '/var/www/html/shop/application/views/templates/redlabel/_parts/header.tpl',
      1 => 1481728375,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5851617a7d2a51_19568645 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="<?php echo $_smarty_tpl->tpl_vars['myLanguageAbbr']->value;?>
">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
        <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
">
        <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
">
        <?php echo $_smarty_tpl->tpl_vars['metaOgImage']->value;?>

        <?php echo $_smarty_tpl->tpl_vars['bootstrapCss']->value;?>

        <?php echo $_smarty_tpl->tpl_vars['bootstrapSelectCss']->value;?>

        <?php echo $_smarty_tpl->tpl_vars['bootstrapDatePickerCss']->value;?>

        <link href="<?php echo '<?=';?> base_url('assets/css/custom.css') <?php echo '?>';?>" rel="stylesheet">
        <link href="<?php echo '<?=';?> base_url('cssloader/theme.css') <?php echo '?>';?>" rel="stylesheet">
        <?php echo $_smarty_tpl->tpl_vars['jqueryJs']->value;?>

        <?php echo $_smarty_tpl->tpl_vars['languageJs']->value;?>

        <?php echo '<?php ';?>if ($cookieLaw != false) { <?php echo '?>';?>
         
            <?php echo '<script'; ?>
 type="text/javascript">
                window.cookieconsent_options = {"message": "<?php echo '<?'; ?>
= $cookieLaw['message'] <?php echo '?>'; ?>
", "dismiss": "<?php echo '<?'; ?>
= $cookieLaw['button_text'] <?php echo '?>'; ?>
", "learnMore": "<?php echo '<?'; ?>
= $cookieLaw['learn_more'] <?php echo '?>'; ?>
", "link": "<?php echo '<?'; ?>
= $cookieLaw['link'] <?php echo '?>'; ?>
", "theme": "<?php echo '<?'; ?>
= $cookieLaw['theme'] <?php echo '?>'; ?>
"};
            <?php echo '</script'; ?>
>
            <?php echo '<script'; ?>
 type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"><?php echo '</script'; ?>
>
         
        <?php echo '<?php ';?>} <?php echo '?>';?>
        <!--[if lt IE 9]>
          <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"><?php echo '</script'; ?>
>
          <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <div id="languages-bar">
                    <div class="container">
                        <?php echo '<?php
                        ';?>$num_langs = count($allLanguages);
                        if ($num_langs > 0) {
                        <?php echo '?>';?>
                        <ul class="pull-left">
                            <?php echo '<?php
                            ';?>$i = 1;
                            $lang_last = '';
                            foreach ($allLanguages as $key_lang => $lang) {
                            <?php echo '?>';?>
                            <li <?php echo '<?=';?> $i == $num_langs ? 'class="last-item"' : '' <?php echo '?>';?>>
                                <img src="<?php echo '<?=';?> base_url('attachments/lang_flags/' . $lang['flag']) <?php echo '?>';?>" alt="Language-<?php echo '<?=';?> MY_LANGUAGE_ABBR <?php echo '?>';?>"><a href="<?php echo '<?=';?> base_url($key_lang) <?php echo '?>';?>"><?php echo '<?=';?> $lang['name'] <?php echo '?>';?></a>
                            </li>
                            <?php echo '<?php
                            ';?>$i++;
                            }
                            <?php echo '?>';?>
                        </ul>
                        <?php echo '<?php ';?>} <?php echo '?>';?>
                        <div class="phone pull-right">
                            <?php echo '<?php
                            ';?>if ($footerContactPhone != '') {
                            <?php echo '?>';?>
                            <img src="<?php echo '<?=';?> base_url('assets/imgs/Phone-icon.png') <?php echo '?>';?>" alt="Call us">
                            <?php echo '<?php
                            ';?>echo $footerContactPhone;
                            }
                            <?php echo '?>';?>
                        </div>
                    </div>
                </div>
                <div id="top-part">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-lg-4 left">
                                <a href="<?php echo '<?=';?> base_url() <?php echo '?>';?>">
                                    <img src="<?php echo '<?=';?> base_url('assets/imgs/site-logo/' . $sitelogo) <?php echo '?>';?>" class="site-logo" alt="<?php echo '<?=';?> $_SERVER['HTTP_HOST'] <?php echo '?>';?>">
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-5 col-lg-5">
                                <div class="input-group" id="adv-search">
                                    <input type="text" value="<?php echo '<?=';?> isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' <?php echo '?>';?>" id="search_in_title" class="form-control" placeholder="<?php echo '<?=';?> lang('search_by_keyword_title') <?php echo '?>';?>" />
                                    <div class="input-group-btn">
                                        <div class="btn-group" role="group">
                                            <div class="dropdown dropdown-lg">
                                                <button type="button" class="button-more dropdown-toggle mine-color" data-toggle="dropdown" aria-expanded="false"><?php echo '<?=';?> lang('more') <?php echo '?>';?> <span class="caret"></span></button>
                                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <form class="form-horizontal" method="GET" action="<?php echo '<?=';?> LANG_URL <?php echo '?>';?>" id="bigger-search">
                                                        <input type="hidden" name="category" value="<?php echo '<?=';?> isset($_GET['category']) ? $_GET['category'] : '' <?php echo '?>';?>">
                                                        <input type="hidden" name="in_stock" value="<?php echo '<?=';?> isset($_GET['in_stock']) ? $_GET['in_stock'] : '' <?php echo '?>';?>">
                                                        <input type="hidden" name="search_in_title" value="<?php echo '<?=';?> isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' <?php echo '?>';?>">
                                                        <input type="hidden" name="order_new" value="<?php echo '<?=';?> isset($_GET['order_new']) ? $_GET['order_new'] : '' <?php echo '?>';?>">
                                                        <input type="hidden" name="order_price" value="<?php echo '<?=';?> isset($_GET['order_price']) ? $_GET['order_price'] : '' <?php echo '?>';?>">
                                                        <input type="hidden" name="order_procurement" value="<?php echo '<?=';?> isset($_GET['order_procurement']) ? $_GET['order_procurement'] : '' <?php echo '?>';?>">
                                                        <div class="form-group">
                                                            <label for="quantity_more"><?php echo '<?=';?> lang('quantity_more_than') <?php echo '?>';?></label>
                                                            <input type="text" value="<?php echo '<?=';?> isset($_GET['quantity_more']) ? $_GET['quantity_more'] : '' <?php echo '?>';?>" name="quantity_more" id="quantity_more" placeholder="<?php echo '<?=';?> lang('type_a_number') <?php echo '?>';?>" class="form-control">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="added_after"><?php echo '<?=';?> lang('added_after') <?php echo '?>';?></label>
                                                                    <div class="input-group date">
                                                                        <input type="text" value="<?php echo '<?=';?> isset($_GET['added_after']) ? $_GET['added_after'] : '' <?php echo '?>';?>" name="added_after" id="added_after" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="added_before"><?php echo '<?=';?> lang('added_before') <?php echo '?>';?></label>
                                                                    <div class="input-group date">
                                                                        <input type="text" value="<?php echo '<?=';?> isset($_GET['added_before']) ? $_GET['added_before'] : '' <?php echo '?>';?>" name="added_before" id="added_before" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="search_in_body"><?php echo '<?=';?> lang('search_by_keyword_body') <?php echo '?>';?></label>
                                                            <input class="form-control" value="<?php echo '<?=';?> isset($_GET['search_in_body']) ? $_GET['search_in_body'] : '' <?php echo '?>';?>" name="search_in_body" id="search_in_body" type="text" />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="price_from"><?php echo '<?=';?> lang('price_from') <?php echo '?>';?></label>
                                                                    <input type="text" value="<?php echo '<?=';?> isset($_GET['price_from']) ? $_GET['price_from'] : '' <?php echo '?>';?>" name="price_from" id="price_from" class="form-control" placeholder="<?php echo '<?=';?> lang('type_a_number') <?php echo '?>';?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="price_to"><?php echo '<?=';?> lang('price_to') <?php echo '?>';?></label>
                                                                    <input type="text" name="price_to" value="<?php echo '<?=';?> isset($_GET['price_to']) ? $_GET['price_to'] : '' <?php echo '?>';?>" id="price_to" class="form-control" placeholder="<?php echo '<?=';?> lang('type_a_number') <?php echo '?>';?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-inner-search">
                                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                        </button>
                                                        <a class="btn btn-default" id="clear-form" href="javascript:void(0);"><?php echo '<?=';?> lang('clear_form') <?php echo '?>';?></a>
                                                    </form>
                                                </div>
                                            </div>
                                            <button type="button" onclick="submitForm()" class="btn-go-search mine-color">
                                                <img src="<?php echo '<?=';?> base_url('assets/imgs/search-ico.png') <?php echo '?>';?>" alt="Search">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="basket-box">
                                    <table>
                                        <tr>
                                            <td>
                                                <img src="<?php echo '<?=';?> base_url('assets/imgs/green-basket.png') <?php echo '?>';?>" class="green-basket" alt="">
                                            </td>
                                            <td>
                                                <div class="center">
                                                    <h4><?php echo '<?=';?> lang('your_basket') <?php echo '?>';?></h4>
                                                    <a href="<?php echo '<?=';?> LANG_URL . '/checkout' <?php echo '?>';?>"><?php echo '<?=';?> lang('checkout_top_header') <?php echo '?>';?></a> |
                                                    <a href="<?php echo '<?=';?> LANG_URL . '/shopping-cart' <?php echo '?>';?>"><?php echo '<?=';?> lang('shopping_cart_only') <?php echo '?>';?></a>
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="shop-dropdown">
                                                    <li class="dropdown text-center">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> 
                                                            <div><span class="sumOfItems"><?php echo '<?=';?> $cartItems['array'] == 0 ? 0 : $sumOfItems <?php echo '?>';?></span> <?php echo '<?=';?> lang('items') <?php echo '?>';?></div>
                                                            <img src="<?php echo '<?=';?> base_url('assets/imgs/shopping-cart-icon-515.png') <?php echo '?>';?>" alt="">
                                                            <span class="caret"></span>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-right dropdown-cart" role="menu">
                                                            <?php echo '<?=';?> $load::getCartItems($cartItems) <?php echo '?>';?>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>        
                        </div>
                    </div>
                </div>
                <nav class="navbar gradient-color">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <?php echo '<?php ';?>if ($naviText != null) { <?php echo '?>';?>
                            <a class="navbar-brand" href="<?php echo '<?=';?> base_url() <?php echo '?>';?>"><?php echo '<?=';?> $naviText <?php echo '?>';?></a>
                            <?php echo '<?php ';?>} <?php echo '?>';?>
                        </div>
                        <div id="navbar" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav" style="<?php echo '<?=';?> $naviText == null ? 'margin-left:-15px;' : '' <?php echo '?>';?>">
                                <li<?php echo '<?=';?> uri_string() == '' || uri_string() == MY_LANGUAGE_ABBR ? ' class="active"' : '' <?php echo '?>';?>><a href="<?php echo '<?=';?> LANG_URL <?php echo '?>';?>"><?php echo '<?=';?> lang('home') <?php echo '?>';?></a></li>
                                <?php echo '<?php
                                ';?>if (!empty($nonDynPages)) {
                                foreach ($nonDynPages as $addonPage) {
                                <?php echo '?>';?>
                                <li<?php echo '<?=';?> uri_string() == $addonPage || uri_string() == MY_LANGUAGE_ABBR . '/' . $addonPage ? ' class="active"' : '' <?php echo '?>';?>><a href="<?php echo '<?=';?> LANG_URL . '/' . $addonPage <?php echo '?>';?>"><?php echo '<?=';?> mb_ucfirst(lang($addonPage)) <?php echo '?>';?></a></li>
                                <?php echo '<?php
                                ';?>}
                                }
                                if (!empty($dynPages)) {
                                foreach ($dynPages as $addonPage) {
                                <?php echo '?>';?>
                                <li<?php echo '<?=';?> urldecode(uri_string()) == 'page/' . $addonPage['pname'] || uri_string() == MY_LANGUAGE_ABBR . '/' . 'page/' . $addonPage['pname'] ? ' class="active"' : ''
                                    <?php echo '?>';?>><a href="<?php echo '<?=';?> LANG_URL . '/page/' . $addonPage['pname'] <?php echo '?>';?>"><?php echo '<?=';?> mb_ucfirst($addonPage['lname']) <?php echo '?>';?></a></li>
                                <?php echo '<?php
                                ';?>}
                                }
                                <?php echo '?>';?>
                                <li<?php echo '<?=';?> uri_string() == 'checkout' || uri_string() == MY_LANGUAGE_ABBR . '/checkout' ? ' class="active"' : '' <?php echo '?>';?>><a href="<?php echo '<?=';?> LANG_URL . '/checkout' <?php echo '?>';?>"><?php echo '<?=';?> lang('checkout') <?php echo '?>';?></a></li>
                                <li<?php echo '<?=';?> uri_string() == 'shopping-cart' || uri_string() == MY_LANGUAGE_ABBR . '/shopping-cart' ? ' class="active"' : '' <?php echo '?>';?>><a href="<?php echo '<?=';?> LANG_URL . '/shopping-cart' <?php echo '?>';?>"><?php echo '<?=';?> lang('shopping_cart') <?php echo '?>';?></a></li>
                                <li<?php echo '<?=';?> uri_string() == 'contacts' || uri_string() == MY_LANGUAGE_ABBR . '/contacts' ? ' class="active"' : '' <?php echo '?>';?>><a href="<?php echo '<?=';?> LANG_URL . '/contacts' <?php echo '?>';?>"><?php echo '<?=';?> lang('contacts') <?php echo '?>';?></a></li>
                            </ul>
                        </div>
                    </div>
                </nav><?php }
}
