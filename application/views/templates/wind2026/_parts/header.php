<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" /> 
        <meta name="description" content="<?= $description ?>" />
        <meta name="keywords" content="<?= $keywords ?>" />
        <meta property="og:title" content="<?= $title ?>" />
        <meta property="og:description" content="<?= $description ?>" />
        <meta property="og:url" content="<?= LANG_URL ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="<?= isset($image) && !is_null($image) ? $image : base_url('assets/img/site-overview.png') ?>" />
        <title><?= $title ?></title>
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>" />
        <link href="<?= base_url('templatecss/custom.css') ?>" rel="stylesheet" />
        <link href="<?= base_url('cssloader/theme.css') ?>" rel="stylesheet" />
        <script>
            // Tailwind CSS v4.1 (CDN). Preflight is disabled to avoid conflicts with Bootstrap 3.
            window.tailwind = window.tailwind || {};
            window.tailwind.config = {
                corePlugins: { preflight: false },
                theme: {
                    extend: {
                        fontFamily: {
                            sans: [
                                'ui-sans-serif',
                                'system-ui',
                                '-apple-system',
                                'Segoe UI',
                                'Roboto',
                                'Helvetica Neue',
                                'Arial',
                                'Noto Sans',
                                'sans-serif'
                            ]
                        }
                    }
                }
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4.1.0"></script>
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
    <body class="bg-slate-50 text-slate-900 font-sans antialiased">
        <a style="display:none !important;" id="kk-refer-gh" href="https://github.com/kirilkirkov">Kiril Kirkov</a>
        <div id="wrapper">
            <div id="content">
                <?php if ($multiVendor == 1) { ?>
                    <div id="top-user-panel" class="bg-white/70 backdrop-blur border-b border-slate-200">
                        <div class="container py-2">
                            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                                <a href="<?= LANG_URL . '/vendor/register' ?>" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                                    <?= lang('register_me') ?>
                                </a>
                                <form class="form-inline flex flex-col gap-2 md:flex-row md:items-center md:justify-end" method="POST" action="<?= LANG_URL . '/vendor/login' ?>">
                                    <div class="form-group">
                                        <input type="email" name="u_email" class="form-control rounded-xl border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-900/10" placeholder="<?= lang('email') ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="u_password" class="form-control rounded-xl border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-900/10" placeholder="<?= lang('password') ?>">
                                    </div>
                                    <div class="checkbox text-sm text-slate-700">
                                        <label><input type="checkbox" name="remember_me"> <?= lang('remember_me') ?></label>
                                    </div>
                                    <button type="submit" name="login" class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                                        <?= lang('u_login') ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div id="languages-bar" class="bg-slate-950 text-slate-100">
                    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2">
                        <?php
                        $num_langs = count($allLanguages);
                        if ($num_langs > 0) {
                            ?>
                            <ul class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                <?php
                                $i = 1;
                                foreach ($allLanguages as $key_lang => $lang) {
                                    ?>
                                    <li <?= $i == $num_langs ? 'class="last-item"' : '' ?>>
                                        <a class="inline-flex items-center gap-2 text-sm text-slate-100/90 hover:text-white" href="<?= base_url($key_lang) ?>">
                                            <img src="<?= base_url('attachments/lang_flags/' . $lang['flag']) ?>" alt="Language-<?= MY_LANGUAGE_ABBR ?>" class="h-[11px] w-[16px]">
                                            <span><?= $lang['name'] ?></span>
                                        </a>
                                    </li>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </ul>
                        <?php } ?>
                        <div class="text-sm font-semibold text-slate-100/90">
                            <?php if ($footerContactPhone != '') { ?>
                                <span class="mr-1"><i class="fa fa-phone"></i></span>
                                <?= $footerContactPhone ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <header class="relative z-50 border-b border-slate-200 bg-white/80 backdrop-blur">
                    <div class="mx-auto max-w-7xl px-4 py-4">
                        <!-- Row layout: mobile (logo+cart on top, search below), desktop (logo | search | cart) -->
                        <div class="grid grid-cols-12 items-center gap-3">
                            <div class="col-span-6 md:col-span-3">
                                <a href="<?= base_url() ?>" class="inline-flex items-center gap-3">
                                    <img src="<?= base_url('attachments/site_logo/' . $sitelogo) ?>" class="h-11 w-auto max-w-full md:h-14" alt="<?= $_SERVER['HTTP_HOST'] ?>">
                                    <?php if ($navitext != null) { ?>
                                        <span class="hidden text-sm font-semibold text-slate-700 md:inline"><?= $navitext ?></span>
                                    <?php } ?>
                                </a>
                            </div>

                            <div class="col-span-6 flex justify-end md:col-span-3 md:order-3">
                                <div class="relative" data-wind-dropdown="true">
                                    <button
                                        type="button"
                                        data-wind-toggle="dropdown"
                                        data-wind-target="#wind-cart-panel"
                                        class="inline-flex items-center gap-3 rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-slate-50"
                                    >
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-900 text-white">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        </span>
                                        <span class="hidden lg:inline"><?= lang('shopping_cart') ?></span>
                                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-bold text-slate-900">
                                            <span class="sumOfItems"><?= is_numeric($cartItems) && (int)$cartItems == 0 ? 0 : $sumOfItems ?></span>
                                        </span>
                                    </button>

                                    <div
                                        id="wind-cart-panel"
                                        data-wind-dropdown-panel="true"
                                        class="hidden absolute right-0 z-50 mt-2 w-96 max-w-[calc(100vw-2rem)] rounded-2xl bg-white shadow-xl ring-1 ring-slate-200"
                                    >
                                        <ul class="dropdown-cart max-h-[70vh] overflow-auto">
                                            <?= $load::getCartItems($cartItems) ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 md:order-2">
                                <div class="relative" data-wind-dropdown="true">
                                    <div class="flex items-center gap-2 rounded-2xl bg-slate-50 p-2 ring-1 ring-inset ring-slate-200 shadow-sm">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white text-slate-600 ring-1 ring-inset ring-slate-200">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </span>
                                        <input
                                            type="text"
                                            value="<?= isset($_GET['search_in_title']) ? htmlspecialchars($_GET['search_in_title']) : '' ?>"
                                            id="search_in_title"
                                            class="search-field-header w-full flex-1 bg-transparent px-2 py-2 text-sm outline-none placeholder:text-slate-500"
                                            placeholder="<?= lang('search_by_keyword_title') ?>"
                                        />

                                        <button
                                            type="button"
                                            data-wind-toggle="dropdown"
                                            data-wind-target="#wind-adv-search"
                                            class="hidden items-center gap-2 rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50 sm:inline-flex"
                                        >
                                            <i class="fa fa-sliders" aria-hidden="true"></i>
                                            <?= lang('more') ?>
                                        </button>

                                        <button
                                            type="button"
                                            onclick="submitForm()"
                                            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
                                        >
                                            <?= lang('search') ?>
                                        </button>
                                    </div>

                                    <div
                                        id="wind-adv-search"
                                        data-wind-dropdown-panel="true"
                                        class="hidden absolute left-0 right-0 z-50 mt-2 w-full max-w-full rounded-2xl bg-white p-4 shadow-xl ring-1 ring-slate-200"
                                    >
                                        <form method="GET" action="<?= isset($vendor_url) ? $vendor_url : LANG_URL ?>" id="bigger-search" class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                            <input type="hidden" name="category" value="<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>">
                                            <input type="hidden" name="in_stock" value="<?= isset($_GET['in_stock']) ? htmlspecialchars($_GET['in_stock']) : '' ?>">
                                            <input type="hidden" name="search_in_title" value="<?= isset($_GET['search_in_title']) ? htmlspecialchars($_GET['search_in_title']) : '' ?>">
                                            <input type="hidden" name="order_new" value="<?= isset($_GET['order_new']) ? htmlspecialchars($_GET['order_new']) : '' ?>">
                                            <input type="hidden" name="order_price" value="<?= isset($_GET['order_price']) ? htmlspecialchars($_GET['order_price']) : '' ?>">
                                            <input type="hidden" name="order_procurement" value="<?= isset($_GET['order_procurement']) ? htmlspecialchars($_GET['order_procurement']) : '' ?>">
                                            <input type="hidden" name="brand_id" value="<?= isset($_GET['brand_id']) ? htmlspecialchars($_GET['brand_id']) : '' ?>">

                                            <div class="md:col-span-2">
                                                <label for="quantity_more" class="text-xs font-semibold text-slate-700"><?= lang('quantity_more_than') ?></label>
                                                <input type="number" value="<?= isset($_GET['quantity_more']) ? htmlspecialchars($_GET['quantity_more']) : '' ?>" name="quantity_more" id="quantity_more" placeholder="<?= lang('type_a_number') ?>" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
                                            </div>

                                            <div>
                                                <label for="added_after" class="text-xs font-semibold text-slate-700"><?= lang('added_after') ?></label>
                                                <input type="date" value="<?= isset($_GET['added_after']) ? htmlspecialchars($_GET['added_after']) : '' ?>" name="added_after" id="added_after" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
                                            </div>
                                            <div>
                                                <label for="added_before" class="text-xs font-semibold text-slate-700"><?= lang('added_before') ?></label>
                                                <input type="date" value="<?= isset($_GET['added_before']) ? htmlspecialchars($_GET['added_before']) : '' ?>" name="added_before" id="added_before" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
                                            </div>

                                            <div class="md:col-span-2">
                                                <label for="search_in_body" class="text-xs font-semibold text-slate-700"><?= lang('search_by_keyword_body') ?></label>
                                                <input value="<?= isset($_GET['search_in_body']) ? htmlspecialchars($_GET['search_in_body']) : '' ?>" name="search_in_body" id="search_in_body" type="text" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" />
                                            </div>

                                            <div>
                                                <label for="price_from" class="text-xs font-semibold text-slate-700"><?= lang('price_from') ?></label>
                                                <input type="text" value="<?= isset($_GET['price_from']) ? htmlspecialchars($_GET['price_from']) : '' ?>" name="price_from" id="price_from" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" placeholder="<?= lang('type_a_number') ?>">
                                            </div>
                                            <div>
                                                <label for="price_to" class="text-xs font-semibold text-slate-700"><?= lang('price_to') ?></label>
                                                <input type="text" name="price_to" value="<?= isset($_GET['price_to']) ? htmlspecialchars($_GET['price_to']) : '' ?>" id="price_to" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" placeholder="<?= lang('type_a_number') ?>">
                                            </div>

                                            <div class="md:col-span-2 flex items-center justify-between gap-3 pt-2">
                                                <a id="clear-form" class="text-sm font-semibold text-slate-600 hover:text-slate-900" href="javascript:void(0);">
                                                    <?= lang('clear_form') ?>
                                                </a>
                                                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                                                    <?= lang('search') ?>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center">
                            <button
                                type="button"
                                data-wind-toggle="collapse"
                                data-wind-target="#wind-mobile-nav"
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50 md:hidden"
                            >
                                <i class="fa fa-bars" aria-hidden="true"></i>
                                Menu
                            </button>

                            <nav class="hidden md:flex mx-auto flex-wrap items-center gap-6">
                                <?php
                                $navLinks = [];
                                $navLinks[] = ['href' => LANG_URL, 'label' => lang('home'), 'active' => (uri_string() == '' || uri_string() == MY_LANGUAGE_ABBR)];
                                if (!empty($nonDynPages)) {
                                    foreach ($nonDynPages as $addonPage) {
                                        $navLinks[] = [
                                            'href' => LANG_URL . '/' . $addonPage,
                                            'label' => mb_ucfirst(lang($addonPage)),
                                            'active' => (uri_string() == $addonPage || uri_string() == MY_LANGUAGE_ABBR . '/' . $addonPage)
                                        ];
                                    }
                                }
                                if (!empty($dynPages)) {
                                    foreach ($dynPages as $addonPage) {
                                        $navLinks[] = [
                                            'href' => LANG_URL . '/page/' . $addonPage['pname'],
                                            'label' => mb_ucfirst($addonPage['lname']),
                                            'active' => (urldecode(uri_string()) == 'page/' . $addonPage['pname'] || uri_string() == MY_LANGUAGE_ABBR . '/' . 'page/' . $addonPage['pname'])
                                        ];
                                    }
                                }
                                $navLinks[] = ['href' => LANG_URL . '/checkout', 'label' => lang('checkout'), 'active' => (uri_string() == 'checkout' || uri_string() == MY_LANGUAGE_ABBR . '/checkout')];
                                $navLinks[] = ['href' => LANG_URL . '/shopping-cart', 'label' => lang('shopping_cart'), 'active' => (uri_string() == 'shopping-cart' || uri_string() == MY_LANGUAGE_ABBR . '/shopping-cart')];
                                $navLinks[] = ['href' => LANG_URL . '/contacts', 'label' => lang('contacts'), 'active' => (uri_string() == 'contacts' || uri_string() == MY_LANGUAGE_ABBR . '/contacts')];
                                foreach ($navLinks as $l) {
                                    ?>
                                    <a
                                        href="<?= $l['href'] ?>"
                                        class="<?= $l['active'] ? 'text-slate-900 border-slate-900' : 'text-slate-600 border-transparent hover:text-slate-900 hover:border-slate-300' ?> inline-flex items-center border-b-2 pb-1 text-sm font-semibold transition-colors"
                                    >
                                        <?= $l['label'] ?>
                                    </a>
                                    <?php
                                }
                                ?>
                            </nav>
                        </div>

                        <nav id="wind-mobile-nav" class="hidden md:hidden mt-3">
                            <div class="grid gap-2 rounded-2xl bg-white p-3 shadow-sm ring-1 ring-slate-200">
                                <?php foreach ($navLinks as $l) { ?>
                                    <a
                                        href="<?= $l['href'] ?>"
                                        class="<?= $l['active'] ? 'bg-slate-900 text-white' : 'text-slate-900 hover:bg-slate-50' ?> rounded-xl px-3 py-2 text-sm font-semibold"
                                    >
                                        <?= $l['label'] ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </nav>
                    </div>
                </header>