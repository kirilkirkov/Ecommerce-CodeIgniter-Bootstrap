<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (count($sliderProducts) > 0) {
    ?>
    <div id="home-slider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            $i = 0;
            while ($i < count($sliderProducts)) {
                ?>
                <li data-target="#home-slider" data-slide-to="0" class="<?= $i == 0 ? 'active' : '' ?>"></li>
                <?php
                $i++;
            }
            ?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <?php
            $i = 0;
            foreach ($sliderProducts as $article) {
                ?>
                <div class="item <?= $i == 0 ? 'active' : '' ?>" style="background-image: url('<?= base_url('attachments/shop_images/' . $article['image']) ?>')">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>
                                    <a href="<?= LANG_URL . '/' . $article['url'] ?>">
                                        <?= character_limiter($article['title'], 100) ?>
                                    </a>
                                </h3>
                                <div class="description">
                                    <?= character_limiter(strip_tags($article['basic_description']), 150) ?>
                                </div>
                                <a class="option add-to-cart" data-goto="<?= LANG_URL . '/checkout' ?>" href="javascript:void(0);" data-id="<?= $article['id'] ?>">
                                    <?= lang('buy_now') ?>
                                </a>
                            </div>
                            <div class="col-sm-6">

                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            }
            ?>
        </div>
        <a class="left carousel-control" href="#home-slider" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
        <a class="right carousel-control" href="#home-slider" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
<?php } ?>
<div class="home-banners">
    <div class="single-banner pull-left">
        <a href="#"><img src="<?= base_url('attachments/banners/1.jpg') ?>" alt="" /></a>
    </div>
    <div class="single-banner pull-right">
        <a href="#"><img src="<?= base_url('attachments/banners/2.jpg') ?>" alt="" /></a>
    </div>
    <div class="clearfix"></div>
</div>
<div class="new-products">
    <div class="container">
        <h3><?= lang('new_products') ?></h3> 
        <div class="row">
            <div class="col-md-12">
                <div class="carousel slide multi-item-carousel home-carousel" id="theCarousel">
                    <div class="carousel-inner">
                        <?php
                        $i = 0;
                        foreach ($newProducts as $product) {
                            ?>
                            <div class="item <?= $i == 0 ? 'active' : '' ?>">
                                <div class="col-xs-12 col-sm-4">
                                    <a href="<?= LANG_URL . '/' . $product['url'] ?>">
                                        <img src="<?= base_url('attachments/shop_images/' . $product['image']) ?>" class="img-responsive">
                                        <h1><?= $product['title'] ?></h1>
                                        <span class="price"><?= $product['price'] ?> &#8377;</span>
                                    </a>
                                    <a class="add-to-cart"  href="<?= LANG_URL . '/' . $product['url'] ?>">
                                        <?= lang('add_to_cart') ?>
                                    </a>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                    <a class="left carousel-control" href="#theCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                    <a class="right carousel-control" href="#theCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="blog-posts">
    <div class="container">
        <h3><?= lang('blog_posts') ?></h3> 
        <div class="row">
            <div class="col-md-12">
                <div class="carousel slide multi-item-carousel" id="theCarousel1">
                    <div class="carousel-inner">
                        <?php
                        $i = 0;
                        foreach ($lastBlogs as $post) {
                            ?>
                            <div class="item <?= $i == 0 ? 'active' : '' ?>">
                                <div class="col-xs-12 col-sm-4">
                                    <a href="<?= LANG_URL . '/blog/' . $post['url'] ?>">
                                        <img src="<?= base_url('attachments/blog_images/' . $post['image']) ?>" class="img-responsive">
                                        <span class="time"><?= date('M d, Y', $post['time']) ?></span>
                                        <h1><?= character_limiter($post['title'], 85) ?></h1>
                                        <p class="description"><?= character_limiter(strip_tags($post['description']), 300) ?></p>
                                        <span class="read-more"><?= lang('read_more') ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                                    </a> 
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                    <a class="left carousel-control" href="#theCarousel1" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                    <a class="right carousel-control" href="#theCarousel1" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>