<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <meta name="description" content="<?= $description ?>">
        <meta name="keywords" content="<?= $keywords ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
        <link href="<?= base_url('templatecss/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('templatecss/custom.css') ?>" rel="stylesheet">
        <link href="<?= base_url('cssloader/theme.css') ?>" rel="stylesheet">
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('loadlanguage/all.js') ?>"></script>
        <?php if ($cookieLaw != false) { ?>
            <script type="text/javascript">
                window.cookieconsent_options = {"message": "<?= $cookieLaw['message'] ?>", "dismiss": "<?= $cookieLaw['button_text'] ?>", "learnMore": "<?= $cookieLaw['learn_more'] ?>", "link": "<?= $cookieLaw['link'] ?>", "theme": "<?= $cookieLaw['theme'] ?>"};
            </script>
            <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
        <?php } ?>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <header>
                    <div class="languages-bar">
                        <div class="container">
                            <?php
                            $num_langs = count($allLanguages);
                            if ($num_langs > 0) {
                                ?>
                                <ul class="pull-left">
                                    <?php
                                    $i = 1;
                                    $lang_last = '';
                                    foreach ($allLanguages as $key_lang => $lang) {
                                        ?>
                                        <li <?= $i == $num_langs ? 'class="last-item"' : '' ?>>
                                            <img src="<?= base_url('attachments/lang_flags/' . $lang['flag']) ?>" alt="Language-<?= MY_LANGUAGE_ABBR ?>"><a href="<?= base_url($key_lang) ?>"><?= $lang['name'] ?></a>
                                        </li>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row logo-and-search">
                            <div class="col-sm-5 logo-col">
                                <a href="<?= base_url() ?>">
                                    <img src="<?= base_url('attachments/site_logo/' . $sitelogo) ?>" class="site-logo" alt="<?= $_SERVER['HTTP_HOST'] ?>">
                                </a>
                            </div>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="bag-info">
                                            <img src="<?= base_url('template/imgs/white-bag.png') ?>" alt="Search">
                                            <a class="my-basket dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                <?= lang('your_basket') ?>
                                                <span class="sum-scope">
                                                    (<span class="sumOfItems"><?= $cartItems['array'] == 0 ? lang('empty') : $sumOfItems ?></span>)
                                                </span>
                                                <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right dropdown-cart" role="menu">
                                                <?= $load::getCartItems($cartItems) ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <form method="GET" id="bigger-search" class="search" action="<?= LANG_URL ?>">
                                            <div class="input-group">
                                                <input type="text" id="search_in_title" value="<?= isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' ?>" class="form-control" placeholder="<?= lang('search_for') ?>...">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-red cloth-bg-color" onclick="submitForm()" type="button">
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                    </button>
                                                </span>
                                                <div class="dropdown">
                                                    <a class="advanced-search-btn dropdown-toggle" href="javascript:void(0);" id="dropdownsearch" data-toggle="dropdown">
                                                        <i class="fa fa-2x fa-caret-down cloth-color" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right advanced-search-menu" role="menu" aria-labelledby="dropdownsearch">
                                                        <input type="hidden" name="category" value="<?= isset($_GET['category']) ? $_GET['category'] : '' ?>">
                                                        <input type="hidden" name="in_stock" value="<?= isset($_GET['in_stock']) ? $_GET['in_stock'] : '' ?>">
                                                        <input type="hidden" name="search_in_title" value="<?= isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' ?>">
                                                        <input type="hidden" name="order_new" value="<?= isset($_GET['order_new']) ? $_GET['order_new'] : '' ?>">
                                                        <input type="hidden" name="order_price" value="<?= isset($_GET['order_price']) ? $_GET['order_price'] : '' ?>">
                                                        <input type="hidden" name="order_procurement" value="<?= isset($_GET['order_procurement']) ? $_GET['order_procurement'] : '' ?>">
                                                        <input type="hidden" name="brand_id" value="<?= isset($_GET['brand_id']) ? $_GET['brand_id'] : '' ?>">
                                                        <div class="form-group">
                                                            <label for="quantity_more"><?= lang('quantity_more_than') ?></label>
                                                            <input type="text" value="<?= isset($_GET['quantity_more']) ? $_GET['quantity_more'] : '' ?>" name="quantity_more" id="quantity_more" placeholder="<?= lang('type_a_number') ?>" class="form-control">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="added_after"><?= lang('added_after') ?></label>
                                                                    <div class="input-group date">
                                                                        <input type="text" value="<?= isset($_GET['added_after']) ? $_GET['added_after'] : '' ?>" name="added_after" id="added_after" class="form-control">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="added_before"><?= lang('added_before') ?></label>
                                                                    <div class="input-group date">
                                                                        <input type="text" value="<?= isset($_GET['added_before']) ? $_GET['added_before'] : '' ?>" name="added_before" id="added_before" class="form-control">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="search_in_body"><?= lang('search_by_keyword_body') ?></label>
                                                            <input class="form-control" value="<?= isset($_GET['search_in_body']) ? $_GET['search_in_body'] : '' ?>" name="search_in_body" id="search_in_body" type="text" />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="price_from"><?= lang('price_from') ?></label>
                                                                    <input type="text" value="<?= isset($_GET['price_from']) ? $_GET['price_from'] : '' ?>" name="price_from" id="price_from" class="form-control" placeholder="<?= lang('type_a_number') ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="price_to"><?= lang('price_to') ?></label>
                                                                    <input type="text" name="price_to" value="<?= isset($_GET['price_to']) ? $_GET['price_to'] : '' ?>" id="price_to" class="form-control" placeholder="<?= lang('type_a_number') ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-inner-search cloth-bg-color">
                                                            <i class="fa fa-search" aria-hidden="true"></i>
                                                        </button>
                                                        <a class="btn btn-default" id="clear-form" href="javascript:void(0);"><?= lang('clear_form') ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar cloth">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <?php if ($naviText != null) { ?>
                                    <a class="navbar-brand visible-xs" href="<?= base_url() ?>"><?= $naviText ?></a>
                                <?php } ?>
                            </div>
                            <div id="navbar" class="navbar-collapse collapse">
                                <ul class="nav navbar-nav">
                                    <li<?= uri_string() == '' || uri_string() == MY_LANGUAGE_ABBR ? ' class="active"' : '' ?>><a href="<?= LANG_URL ?>"><?= lang('home') ?></a></li>
                                    <li class="dropdown dropdown-more">
                                        <a class="dropdown-toggle parent" data-toggle="dropdown" href="#">
                                            <?= lang('others') ?>	
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">                                   
                                            <?php
                                            if (!empty($nonDynPages)) {
                                                foreach ($nonDynPages as $addonPage) {
                                                    ?>
                                                    <li<?= uri_string() == $addonPage || uri_string() == MY_LANGUAGE_ABBR . '/' . $addonPage ? ' class="active"' : '' ?>><a href="<?= LANG_URL . '/' . $addonPage ?>"><?= mb_ucfirst(lang($addonPage)) ?></a></li>
                                                    <?php
                                                }
                                            }
                                            if (!empty($dynPages)) {
                                                foreach ($dynPages as $addonPage) {
                                                    ?>
                                                    <li<?= urldecode(uri_string()) == 'page/' . $addonPage['pname'] || uri_string() == MY_LANGUAGE_ABBR . '/' . 'page/' . $addonPage['pname'] ? ' class="active"' : ''
                                                    ?>><a href="<?= LANG_URL . '/page/' . $addonPage['pname'] ?>"><?= mb_ucfirst($addonPage['lname']) ?></a></li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </ul>
                                    <li<?= uri_string() == 'checkout' || uri_string() == MY_LANGUAGE_ABBR . '/checkout' ? ' class="active"' : '' ?>><a href="<?= LANG_URL . '/checkout' ?>"><?= lang('checkout') ?></a></li>
                                    <li<?= uri_string() == 'shopping-cart' || uri_string() == MY_LANGUAGE_ABBR . '/shopping-cart' ? ' class="active"' : '' ?>><a href="<?= LANG_URL . '/shopping-cart' ?>"><?= lang('shopping_cart') ?></a></li>
                                    <li<?= uri_string() == 'contacts' || uri_string() == MY_LANGUAGE_ABBR . '/contacts' ? ' class="active"' : '' ?>><a href="<?= LANG_URL . '/contacts' ?>"><?= lang('contacts') ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </header>