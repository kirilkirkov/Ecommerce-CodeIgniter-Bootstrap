<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container blog-inner">
    <div class="body">
        <div class="row bottom-30">
            <div class="col-sm-3 left-col-archive">
                <?= $archives ?>
                <a href="<?= LANG_URL . '/blog' ?>" class="btn btn-default"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> <?= lang('go_back') ?></a>
            </div>
            <div class="col-sm-9">
                <h1><?= $article['title'] ?></h1>
                <span class="blog-preview-time">
                    <i class="fa fa-clock-o"></i>
                    <?= date('M d, y', $article['time']) ?>
                </span>
                <div class="thumbnail blog-detail-thumb">
                    <img src="<?= base_url('attachments/blog_images/' . $article['image']) ?>" alt="<?= $article['title'] ?>">
                </div>
                <div class="blog-description">
                    <?= $article['description'] ?>
                </div>
            </div>
        </div>
        <?php include 'bodyFooter.php' ?>
    </div>
</div>