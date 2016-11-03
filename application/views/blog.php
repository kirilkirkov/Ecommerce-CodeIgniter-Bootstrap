<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container" id="blog">
    <div class="row eqHeight">
        <div class="col-sm-4 col-md-3">
            <div class="blog-home-left-categ">
                <?= $archives ?>
            </div>
            <div class="filter-sidebar">
                <div class="title">
                    <span><?= lang('best_sellers') ?></span>
                    <i class="fa fa-trophy" aria-hidden="true"></i>
                </div>
                <?php loop_products($bestSellers, $currency, '', true, $lang_url, $publicQuantity); ?>
            </div>
        </div>
        <div class="col-sm-8 col-md-9">
            <div class="alone title">
                <span><?= lang('latest_blog') ?></span>
            </div>
            <div class="row">
                <?php
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        ?>
                        <div class="col-md-6 blog-col column-h">
                            <div class="thumbnail blog-list">
                                <a href="<?= $lang_url . '/blog/' . $post['url'] ?>">
                                    <img src="<?= base_url('attachments/blog_images/' . $post['image']) ?>" alt="<?= $post['title'] ?>">
                                </a>
                                <div class="caption">
                                    <h5><?= $post['title'] ?></h5>
                                    <small>
                                        <span>
                                            <i class="fa fa-clock-o"></i>
                                            <?= date('M d, y', $post['time']) ?>
                                        </span>
                                    </small>
                                    <p><?= character_limiter(strip_tags($post['description']), 300) ?></p>
                                    <a class="btn btn-blog pull-right" href="<?= $lang_url . '/blog/' . $post['url'] ?>">
                                        <i class="fa fa-long-arrow-right"></i>
                                        <?= lang('read_mode') ?>
                                    </a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-info"><?= lang('no_posts') ?></div>
                <?php } ?>
            </div>
            <?= $links_pagination ?>
        </div>
    </div>
</div>