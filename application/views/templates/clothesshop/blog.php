<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container" id="blog">
    <div class="body">
        <div class="row bottom-30 eqHeight">
            <div class="col-sm-4 col-md-3">
                <div class="blog-home-left-categ">
                    <?= $archives ?>
                </div>
                <div id="search-input-blog">
                    <div class="input-group col-md-12">
                        <form method="GET" action="">
                            <input type="text" class="search-query form-control" value="<?= isset($_GET['find']) ? $_GET['find'] : '' ?>" name="find" placeholder="<?= lang('search') ?>" />
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </span>
                        </form>
                    </div>
                </div>
                <div class="filter-sidebar">
                    <div class="title cloth-bg-color">
                        <span><?= lang('best_sellers') ?></span>
                    </div>
                    <?= $load::getProducts($bestSellers, '', true) ?>
                </div>
            </div>
            <div class="col-sm-8 col-md-9">
                <div class="alone title cloth-bg-color">
                    <span><?= lang('latest_blog') ?></span>
                </div>
                <div class="row">
                    <?php
                    if (!empty($posts)) {
                        foreach ($posts as $post) {
                            ?>
                            <div class="col-md-6 blog-col">
                                <div class="thumbnail blog-list">
                                    <a href="<?= LANG_URL . '/blog/' . $post['url'] ?>" class="img-container">
                                        <img src="<?= base_url('attachments/blog_images/' . $post['image']) ?>" alt="<?= $post['title'] ?>">
                                    </a>
                                    <div class="caption">
                                        <h5>
                                            <?= character_limiter($post['title'], 85) ?>
                                        </h5>
                                        <small>
                                            <span>
                                                <i class="fa fa-clock-o"></i>
                                                <?= date('M d, y', $post['time']) ?>
                                            </span>
                                        </small>
                                        <p class="description"><?= character_limiter(strip_tags($post['description']), 300) ?></p>
                                        <a class="btn btn-blog cloth-bg-color pull-right" href="<?= LANG_URL . '/blog/' . $post['url'] ?>">
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
        <?php include 'bodyFooter.php' ?>
    </div>
</div>