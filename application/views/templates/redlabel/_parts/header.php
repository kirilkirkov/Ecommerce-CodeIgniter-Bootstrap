<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <meta name="description" content="<?= $description ?>">
        <meta name="keywords" content="<?= $keywords ?>">
        <meta property="og:image" content="<?= base_url('assets/img/site-overview.png') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">
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
                <div id="languages-bar">
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
                        <div class="phone pull-right">
                            <?php
                            if ($footerContactPhone != '') {
                                ?>
                                <img src="<?= base_url('template/imgs/Phone-icon.png') ?>" alt="Call us">
                                <?php
                                echo $footerContactPhone;
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="top-part">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-lg-4 left">
                                <a href="<?= base_url() ?>">
                                    <img src="<?= base_url('attachments/site_logo/' . $sitelogo) ?>" class="site-logo" alt="<?= $_SERVER['HTTP_HOST'] ?>">
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-5 col-lg-5">
                                <div class="input-group" id="adv-search">
                                    <input type="text" value="<?= isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' ?>" id="search_in_title" class="form-control" placeholder="<?= lang('search_by_keyword_title') ?>" />
                                    <div class="input-group-btn">
                                        <div class="btn-group" role="group">
                                            <div class="dropdown dropdown-lg">
                                                <button type="button" class="button-more dropdown-toggle mine-color" data-toggle="dropdown" aria-expanded="false"><?= lang('more') ?> <span class="caret"></span></button>
                                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <form class="form-horizontal" method="GET" action="<?= LANG_URL ?>" id="bigger-search">
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
                                                                        <input type="text" value="<?= isset($_GET['added_after']) ? $_GET['added_after'] : '' ?>" name="added_after" id="added_after" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="added_before"><?= lang('added_before') ?></label>
                                                                    <div class="input-group date">
                                                                        <input type="text" value="<?= isset($_GET['added_before']) ? $_GET['added_before'] : '' ?>" name="added_before" id="added_before" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
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
                                                        <button type="submit" class="btn btn-inner-search">
                                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                        </button>
                                                        <a class="btn btn-default" id="clear-form" href="javascript:void(0);"><?= lang('clear_form') ?></a>
                                                    </form>
                                                </div>
                                            </div>
                                            <button type="button" onclick="submitForm()" class="btn-go-search mine-color">
                                                <img src="<?= base_url('template/imgs/search-ico.png') ?>" alt="Search">
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
                                                <img src="<?= base_url('template/imgs/green-basket.png') ?>" class="green-basket" alt="">
                                            </td>
                                            <td>
                                                <div class="center">
                                                    <h4><?= lang('your_basket') ?></h4>
                                                    <a href="<?= LANG_URL . '/checkout' ?>"><?= lang('checkout_top_header') ?></a> |
                                                    <a href="<?= LANG_URL . '/shopping-cart' ?>"><?= lang('shopping_cart_only') ?></a>
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="shop-dropdown">
                                                    <li class="dropdown text-center">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> 
                                                            <div><span class="sumOfItems"><?= $cartItems['array'] == 0 ? 0 : $sumOfItems ?></span> <?= lang('items') ?></div>
                                                            <img src="<?= base_url('template/imgs/shopping-cart-icon-515.png') ?>" alt="">
                                                            <span class="caret"></span>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-right dropdown-cart" role="menu">
                                                            <?= $load::getCartItems($cartItems) ?>
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
                            <?php if ($naviText != null) { ?>
                                <a class="navbar-brand" href="<?= base_url() ?>"><?= $naviText ?></a>
                            <?php } ?>
                        </div>
                        <div id="navbar" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav" style="<?= $naviText == null ? 'margin-left:-15px;' : '' ?>">
                                <li<?= uri_string() == '' || uri_string() == MY_LANGUAGE_ABBR ? ' class="active"' : '' ?>><a href="<?= LANG_URL ?>"><?= lang('home') ?></a></li>
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
                                <li<?= uri_string() == 'checkout' || uri_string() == MY_LANGUAGE_ABBR . '/checkout' ? ' class="active"' : '' ?>><a href="<?= LANG_URL . '/checkout' ?>"><?= lang('checkout') ?></a></li>
                                <li<?= uri_string() == 'shopping-cart' || uri_string() == MY_LANGUAGE_ABBR . '/shopping-cart' ? ' class="active"' : '' ?>><a href="<?= LANG_URL . '/shopping-cart' ?>"><?= lang('shopping_cart') ?></a></li>
                                <li<?= uri_string() == 'contacts' || uri_string() == MY_LANGUAGE_ABBR . '/contacts' ? ' class="active"' : '' ?>><a href="<?= LANG_URL . '/contacts' ?>"><?= lang('contacts') ?></a></li>
                            </ul>
                        </div>
                    </div>
                </nav>