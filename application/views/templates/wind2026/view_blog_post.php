<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mx-auto max-w-7xl px-4 py-8">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <aside class="lg:col-span-4">
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200">
                <div class="text-sm font-semibold text-slate-900"><?= lang('archive') ?></div>
                <div class="mt-3 text-sm text-slate-700">
                    <?= $archives ?>
                </div>
                <a href="<?= LANG_URL . '/blog' ?>" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    <?= lang('go_back') ?>
                </a>
            </div>
        </aside>

        <main class="lg:col-span-8">
            <article class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="p-6">
                    <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <i class="fa fa-clock-o mr-1" aria-hidden="true"></i>
                        <?= date('M d, y', $article['time']) ?>
                    </div>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900"><?= $article['title'] ?></h1>
                </div>
                <div class="bg-slate-100">
                    <img src="<?= base_url('attachments/blog_images/' . $article['image']) ?>" class="h-auto w-full object-cover" alt="<?= $article['title'] ?>">
                </div>
                <div class="p-6">
                    <div class="prose prose-slate max-w-none text-sm">
                        <?= $article['description'] ?>
                    </div>
                </div>
            </article>
        </main>
    </div>
</div>