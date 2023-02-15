<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= $description ?>">
        <title><?= $title ?></title>
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">
        <link href="<?= base_url('assets/css/custom-admin.css') ?>" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <?php if ($this->session->userdata('logged_in')) { ?>
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-lg fa-bars"></i>
                            </button>
                        </div>
                        <div id="navbar" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> <?= lang('home') ?></a></li>
                                <li><a href="<?= base_url() ?>" target="_blank"><i class="glyphicon glyphicon-star"></i> <?= lang('production') ?></a></li>
                                <li>
                                    <a href="javascript:void(0);" class="h-settings"><i class="fa fa-key" aria-hidden="true"></i><?= lang('pass_change') ?></a>
                                    <div class="relative">
                                        <div class="settings">
                                            <div class="panel panel-primary" >
                                                <div class="panel-heading">
                                                    <div class="panel-title"><?= lang('security') ?></div>
                                                </div>     
                                                <div class="panel-body">
                                                    <label><?= lang('change_my_password') ?></label> <span class="bg-success" id="pass_result"><?= lang('changed') ?>!</span>
                                                    <form class="form-inline" role="form">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control new-pass-field" placeholder="<?= lang('new_password'); ?>" name="new_pass">
                                                            <span class="input-group-btn">
                                                                <a href="javascript:void(0);" onclick="changePass()" class="btn btn-primary"><?= lang('update'); ?></a>
                                                            </span>
                                                        </div>
                                                        <hr>
                                                        <span><?= lang('password_strength'); ?>:</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-default generate-pwd"><?= lang('generate_password'); ?></button> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="javascript:void(0);" data-toggle="modal" data-target="#modalCalculator"><i class="fa fa-calculator" aria-hidden="true"></i> <?= lang('calculator'); ?></a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?= base_url('admin/logout') ?>"><i class="fa fa-sign-out"></i> <?= lang('logout'); ?></a></li>
                            </ul>
                        </div>
                    </nav>
                <?php } ?>
                <div class="container-fluid">
                    <div class="row">
                        <?php if ($this->session->userdata('logged_in')) { ?>
                            <div class="col-sm-3 col-md-3 col-lg-2 left-side navbar-default">
                                <div class="show-menu">
                                    <a id="show-xs-nav" class="visible-xs" href="javascript:void(0)">
                                        <span class="show-sp">
                                            <?= lang('show_menu'); ?>
                                            <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                                        </span>
                                        <span class="hidde-sp">
                                            <?= lang('hide_menu'); ?>
                                            <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </div>
                                <ul class="sidebar-menu">
                                    <li class="sidebar-search">
                                        <div class="input-group custom-search-form">
                                            <form method="GET" action="<?= base_url('admin/products') ?>">
                                                <div class="input-group">
                                                    <input class="form-control" name="search_title" value="<?= isset($_GET['search_title']) ? htmlspecialchars($_GET['search_title']) : '' ?>" type="text" placeholder="<?= lang('search_in_products') ?>...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" value="" placeholder="<?= lang('find_product'); ?>.." type="submit">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                    <li class="header"><?= lang('ECOMMERCE') ?></li>
                                    <li><a href="<?= base_url('admin/publish') ?>" <?= urldecode(uri_string()) == 'admin/publish' ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> <?= lang('publish_product') ?></a></li>
                                    <li><a href="<?= base_url('admin/products') ?>" <?= urldecode(uri_string()) == 'admin/products' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> <?= lang('products') ?></a></li>
                                    <?php if ($showBrands == 1) { ?>
                                        <li><a href="<?= base_url('admin/brands') ?>" <?= urldecode(uri_string()) == 'admin/brands' ? 'class="active"' : '' ?>><i class="fa fa-registered" aria-hidden="true"></i> <?= lang('brands') ?></a></li>
                                    <?php } ?>
                                    <li><a href="<?= base_url('admin/shopcategories') ?>" <?= urldecode(uri_string()) == 'admin/shopcategories' ? 'class="active"' : '' ?>><i class="fa fa-list-alt" aria-hidden="true"></i> <?= lang('shop_categories') ?></a></li>
                                    <li>
                                        <a href="<?= base_url('admin/orders') ?>" <?= urldecode(uri_string()) == 'admin/orders' ? 'class="active"' : '' ?>>
                                            <i class="fa fa-money" aria-hidden="true"></i> <?= lang('orders') ?> 
                                            <?php if ($numNotPreviewOrders > 0) { ?>
                                                <img src="<?= base_url('assets/imgs/exlamation-hi.png') ?>" style="position: absolute; right:10px; top:7px;" alt="">
                                            <?php } ?>
                                        </a>
                                    </li>
                                    <li><a href="<?= base_url('admin/discounts') ?>" <?= urldecode(uri_string()) == 'admin/discounts' ? 'class="active"' : '' ?>><i class="fa fa-percent" aria-hidden="true"></i> <?= lang('discount_codes') ?></a></li>
                                    <?php if (in_array('blog', $activePages)) { ?>
                                        <li class="header"><?= lang('blog') ?></li>
                                        <li><a href="<?= base_url('admin/blogpublish') ?>" <?= urldecode(uri_string()) == 'admin/blogpublish' ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> <?= lang('publish_post') ?></a></li>
                                        <li><a href="<?= base_url('admin/blog') ?>" <?= urldecode(uri_string()) == 'admin/blog' ? 'class="active"' : '' ?>><i class="fa fa-th" aria-hidden="true"></i> <?= lang('posts') ?></a></li>
                                    <?php } ?>
                                    <?php
                                    if (!empty($textualPages)) {
                                        foreach ($nonDynPages as $nonDynPage) {
                                            if (($key = array_search($nonDynPage, $textualPages)) !== false) {
                                                unset($textualPages[$key]);
                                            }
                                        }
                                        ?>
                                        <li class="header"><?= lang('TEXTUAL_PAGES') ?></li>
                                        <?php foreach ($textualPages as $textualPage) { ?>
                                            <li><a href="<?= base_url('admin/pageedit/' . $textualPage) ?>" <?= strpos(urldecode(uri_string()), $textualPage) ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> <?= strtoupper($textualPage) ?></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <li class="header"><?= lang('SETTINGS') ?></li>
                                    <li><a href="<?= base_url('admin/settings') ?>" <?= urldecode(uri_string()) == 'admin/settings' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> <?= lang('SETTINGS') ?></a></li>
                                    <li><a href="<?= base_url('admin/styling') ?>" <?= urldecode(uri_string()) == 'admin/styling' ? 'class="active"' : '' ?>><i class="fa fa-laptop" aria-hidden="true"></i> <?= lang('styling') ?></a></li>
                                    <li><a href="<?= base_url('admin/templates') ?>" <?= urldecode(uri_string()) == 'admin/templates' ? 'class="active"' : '' ?>><i class="fa fa-binoculars" aria-hidden="true"></i> <?= lang('templates') ?></a></li>
                                    <li><a href="<?= base_url('admin/titles') ?>" <?= urldecode(uri_string()) == 'admin/titles' ? 'class="active"' : '' ?>><i class="fa fa-font" aria-hidden="true"></i> <?= lang('titles_/_descriptions') ?></a></li>
                                    <li><a href="<?= base_url('admin/pages') ?>" <?= urldecode(uri_string()) == 'admin/pages' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i> <?= lang('active_pages') ?></a></li>
                                    <li><a href="<?= base_url('admin/emails') ?>" <?= urldecode(uri_string()) == 'admin/emails' ? 'class="active"' : '' ?>><i class="fa fa-envelope-o" aria-hidden="true"></i> <?= lang('subscribed_emails') ?></a></li>
                                    <li><a href="<?= base_url('admin/history') ?>" <?= urldecode(uri_string()) == 'admin/history' ? 'class="active"' : '' ?>><i class="fa fa-history" aria-hidden="true"></i> <?= lang('activity_history') ?></a></li>
                                    <li class="header"><?= lang('ADVANCED_SETTINGS') ?></li>
                                    <li><a href="<?= base_url('admin/languages') ?>" <?= urldecode(uri_string()) == 'admin/languages' ? 'class="active"' : '' ?>><i class="fa fa-globe" aria-hidden="true"></i> <?= lang('languages') ?></a></li>
                                    <li><a href="<?= base_url('admin/filemanager') ?>" <?= urldecode(uri_string()) == 'admin/filemanager' ? 'class="active"' : '' ?>><i class="fa fa-file-code-o" aria-hidden="true"></i> <?= lang('file_manager') ?></a></li>
                                    <li><a href="<?= base_url('admin/adminusers') ?>" <?= urldecode(uri_string()) == 'admin/adminusers' ? 'class="active"' : '' ?>><i class="fa fa-user" aria-hidden="true"></i> <?= lang('admin_users') ?></a></li>
                                </ul>
                            </div>
                            <div class="col-sm-9 col-md-9 col-lg-10 col-sm-offset-3 col-md-offset-3 col-lg-offset-2">
                                <?php if ($warnings != null) { ?>
                                    <div class="alert alert-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        <?= lang('there_are_some_errors_that_you_must_fix') ?>!
                                        <ol>
                                            <?php foreach ($warnings as $warning) { ?>
                                                <li><?= $warning ?></li>
                                            <?php } ?>
                                        </ol>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div>
                                <?php } ?>

