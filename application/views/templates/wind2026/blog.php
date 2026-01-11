<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mx-auto max-w-7xl px-4 py-8" id="blog">
    <div class="flex items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900"><?= lang('latest_blog') ?></h1>
            <p class="mt-1 text-sm text-slate-600"><?= lang('search') ?> · <?= lang('archive') ?></p>
        </div>
        <a href="<?= LANG_URL ?>" class="hidden rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50 md:inline-flex">
            <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i><?= lang('home') ?>
        </a>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-12">
        <aside class="lg:col-span-4">
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <div class="text-sm font-semibold text-slate-900"><?= lang('search') ?></div>
                <form method="GET" action="" class="mt-3 flex gap-2">
                    <input type="text" class="w-full flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" value="<?= isset($_GET['find']) ? htmlspecialchars($_GET['find']) : '' ?>" name="find" placeholder="<?= lang('search') ?>" />
                    <button class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>

            <div class="mt-6 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <div class="text-sm font-semibold text-slate-900"><?= lang('archive') ?></div>
                <div class="mt-3 text-sm text-slate-700">
                    <?= $archives ?>
                </div>
            </div>

            <div class="mt-6 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-900"><?= lang('best_sellers') ?></div>
                    <i class="fa fa-trophy text-slate-500" aria-hidden="true"></i>
                </div>
                <div class="mt-4">
                    <?= $load::getProducts($bestSellers, '', true) ?>
                </div>
            </div>
        </aside>

        <main class="lg:col-span-8">
            <?php if (!empty($posts)) { ?>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <?php foreach ($posts as $post) { ?>
                        <article class="group overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 hover:shadow-md">
                            <a href="<?= LANG_URL . '/blog/' . $post['url'] ?>" class="block">
                                <div class="relative h-48 bg-slate-100">
                                    <img src="<?= base_url('attachments/blog_images/' . $post['image']) ?>" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]" alt="<?= $post['title'] ?>">
                                </div>
                            </a>
                            <div class="p-5">
                                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    <i class="fa fa-clock-o mr-1" aria-hidden="true"></i>
                                    <?= date('M d, y', $post['time']) ?>
                                </div>
                                <a href="<?= LANG_URL . '/blog/' . $post['url'] ?>" class="mt-2 block text-base font-semibold text-slate-900 hover:text-slate-700">
                                    <?= character_limiter($post['title'], 85) ?>
                                </a>
                                <p class="mt-3 text-sm leading-relaxed text-slate-600">
                                    <?= character_limiter(strip_tags($post['description']), 240) ?>
                                </p>
                                <div class="mt-4">
                                    <a class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" href="<?= LANG_URL . '/blog/' . $post['url'] ?>">
                                        <?= lang('read_mode') ?>
                                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="rounded-2xl bg-white p-6 text-sm text-slate-700 shadow-sm ring-1 ring-slate-200">
                    <?= lang('no_posts') ?>
                </div>
            <?php } ?>

            <?php if (trim($links_pagination) != '') { ?>
                <div class="mt-8 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                    <?= $links_pagination ?>
                </div>
            <?php } ?>
        </main>
    </div>
</div>