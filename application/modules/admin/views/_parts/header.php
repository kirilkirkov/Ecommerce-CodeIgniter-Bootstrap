<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= $description ?>">
        <title><?= $title ?></title>
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.9.4/css/bootstrap-select.min.css') ?>">
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
                                <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Home</a></li>
                                <li><a href="<?= base_url() ?>" target="_blank"><i class="glyphicon glyphicon-star"></i> Open site</a></li>
                                <li>
                                    <a href="javascript:void(0);" style="margin-left:-10px;" class="h-settings"><i class="fa fa-lg fa-cogs"></i> Settings</a>
                                    <div class="relative">
                                        <div class="settings">
                                            <div class="panel panel-primary" >
                                                <div class="panel-heading">
                                                    <div class="panel-title">Settings</div>
                                                </div>     
                                                <div class="panel-body">
                                                    <label>Change my password</label> <span class="bg-success" id="pass_result">Changed!</span>
                                                    <form class="form-inline" role="form">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="New password" name="new_pass">
                                                        </div>
                                                        <a href="javascript:void(0);" onclick="changePass()" class="btn btn-sm btn-primary">Update</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?= base_url('admin/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </div>
                    </nav>
                <?php } ?>
                <div class="container-fluid">
                    <div class="row">
                        <?php if ($this->session->userdata('logged_in')) { ?>
                            <div class="col-sm-3 col-md-3 col-lg-2 left-side navbar-default">
                                <ul class="sidebar-menu">
                                    <li class="sidebar-search">
                                        <div class="input-group custom-search-form">
                                            <form method="GET" action="<?= base_url('admin/products') ?>">
                                                <div class="input-group">
                                                    <input class="form-control" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" type="text" placeholder="Search in products...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" value="" placeholder="Find product.." type="submit">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                    <li class="header">MAGAZINE</li>
                                    <li><a href="<?= base_url('admin/publish') ?>" <?= urldecode(uri_string()) == 'admin/publish' ? 'class="active"' : '' ?>><i class="fa fa-edit"></i> Publish product</a></li>
                                    <li><a href="<?= base_url('admin/products') ?>" <?= urldecode(uri_string()) == 'admin/products' ? 'class="active"' : '' ?>><i class="fa fa-files-o"></i> Products</a></li>
                                    <li><a href="<?= base_url('admin/shop_categories') ?>" <?= urldecode(uri_string()) == 'admin/shop_categories' ? 'class="active"' : '' ?>><i class="fa fa-list-alt"></i> Shop Categories</a></li>
                                    <li><a href="<?= base_url('admin/orders') ?>" <?= urldecode(uri_string()) == 'admin/orders' ? 'class="active"' : '' ?>><i class="fa fa-money" aria-hidden="true"></i> Orders</a></li>
                                    <?php if (in_array('blog', $activePages)) { ?>
                                        <li class="header">BLOG</li>
                                        <li><a href="<?= base_url('admin/blogPublish') ?>" <?= urldecode(uri_string()) == 'admin/blogPublish' ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> Publish post</a></li>
                                        <li><a href="<?= base_url('admin/blog') ?>" <?= urldecode(uri_string()) == 'admin/blog' ? 'class="active"' : '' ?>><i class="fa fa-th" aria-hidden="true"></i> Posts</a></li>
                                    <?php } ?>
                                    <?php if (!empty($textualPages)) { ?>
                                        <li class="header">TEXTUAL PAGES</li>
                                        <?php foreach ($textualPages as $textualPage) { ?>
                                            <li><a href="<?= base_url('admin/pageEdit/' . $textualPage) ?>" <?= strpos(urldecode(uri_string()), 'pageEdit') ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> <?= strtoupper($textualPage) ?></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <li class="header">SETTINGS</li>
                                    <li><a href="<?= base_url('admin/styling') ?>" <?= urldecode(uri_string()) == 'admin/styling' ? 'class="active"' : '' ?>><i class="fa fa-laptop" aria-hidden="true"></i> Styling / Settings</a></li>
                                    <li><a href="<?= base_url('admin/pages') ?>" <?= urldecode(uri_string()) == 'admin/pages' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i> Active Pages</a></li>
                                    <li><a href="<?= base_url('admin/emails') ?>" <?= urldecode(uri_string()) == 'admin/emails' ? 'class="active"' : '' ?>><i class="fa fa-envelope-o" aria-hidden="true"></i> Subscribed Emails</a></li>
                                    <li><a href="<?= base_url('admin/history') ?>" <?= urldecode(uri_string()) == 'admin/history' ? 'class="active"' : '' ?>><i class="fa fa-history"></i> Activity History</a></li>
                                    <li class="header">ADVANCED SETTINGS</li>
                                    <li><a href="<?= base_url('admin/languages') ?>" <?= urldecode(uri_string()) == 'admin/languages' ? 'class="active"' : '' ?>><i class="fa fa-globe"></i> Languages</a></li>
                                    <li><a href="<?= base_url('admin/filemanager') ?>" <?= urldecode(uri_string()) == 'admin/filemanager' ? 'class="active"' : '' ?>><i class="fa fa-file-code-o"></i> File Manager</a></li>
                                    <li><a href="<?= base_url('admin/adminusers') ?>" <?= urldecode(uri_string()) == 'admin/adminusers' ? 'class="active"' : '' ?>><i class="fa fa-user" aria-hidden="true"></i> Admin Users</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-9 col-md-9 col-lg-10 col-sm-offset-3 col-md-offset-3 col-lg-offset-2">
                            <?php } else { ?>
                                <div class="">
                                <?php } ?>

