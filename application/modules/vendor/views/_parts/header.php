<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= $description ?>">
        <title><?= $title ?></title>
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/materialdesignicons.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/vendors.css') ?>">
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <nav class="navbar navbar-blue">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <i class="fa fa-lg fa-bars"></i>
                        </button>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="<?= LANG_URL . '/vendor/me' ?>"><i class="fa fa-home"></i> <?= lang('vendor_home') ?></a></li>
                        </ul>
                        <form method="POST" action="<?= LANG_URL . '/vendor/me' ?>" class="vendor-update">
                            <input type="text" class="form-control" value="<?= $vendor_name ?>" name="vendor_name" placeholder="<?= lang('vendor_name') ?>">
                            <input type="text" class="form-control" value="<?= $vendor_url ?>" name="vendor_url" placeholder="<?= lang('vendor_url') ?>">
                            <button type="submit" name="saveVendorDetails" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?= LANG_URL . '/vendor/logout' ?>"><?= lang('vendor_logout') ?></a></li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-3 col-md-3 col-lg-2 left-side">
                            <ul>
                                <li>
                                    <a href="<?= LANG_URL . '/vendor/me' ?>" aria-expanded="false">
                                        <i class="mdi mdi-gauge"></i>
                                        <span class="hide-menu"><?= lang('vendor_dashboard') ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= LANG_URL . '/vendor/add/product' ?>" aria-expanded="false">
                                        <i class="mdi mdi-plus"></i>
                                        <span class="hide-menu"><?= lang('vendor_add_product') ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= LANG_URL . '/vendor/products' ?>" aria-expanded="false">
                                        <i class="mdi mdi-format-list-bulleted"></i>
                                        <span class="hide-menu"><?= lang('vendor_products') ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= LANG_URL . '/vendor/orders' ?>" aria-expanded="false">
                                        <i class="mdi mdi-cart-plus"></i>
                                        <span class="hide-menu"><?= lang('vendor_orders') ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-9 col-md-9 col-lg-10 col-sm-offset-3 col-md-offset-3 col-lg-offset-2 right-side">
                            <div class="page-titles">
                                <h2><?= $title ?></h2>
                            </div>