<?php if($this->config->item('show_social_share_btns') === true) { ?>
<div class="social-media-product-share">
    <div><?= lang('social_share') ?></div>
    <?php 
        $social_width = '50';
        $social_height = '50';
    ?>
    <a href="https://facebook.com/sharer/sharer.php?u=<?= current_url() ?>" target="_blank">
        <?php
            include rtrim(APPPATH, '/') . '/views/main/svg/facebook.php';
        ?>
    </a>
    <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>" target="_blank">
        <?php
            include rtrim(APPPATH, '/') . '/views/main/svg/twitter.php';
        ?>
    </a>
</div>
<?php } ?>