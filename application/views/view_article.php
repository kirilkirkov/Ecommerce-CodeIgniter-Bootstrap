<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container" id="view-article">
    <div class="row">
        <div class="col-sm-4">
            <img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" class="img-responsive the-image">
        </div>

        <div class="col-sm-8">

            <h1><?= $article['title'] ?></h1>

            <div class="table-responsive">
                <table class="table table-product-info">
                    <tr>
                        <td class="left"><b><?= lang('price') ?>:</b></td>
                        <td class="right"><?= $article['price'] . $currency ?></td>
                    </tr>
                    <?php if ($article['old_price'] != '') { ?>
                        <tr>
                            <td class="left"><b><?= lang('old_price') ?>:</b></td>
                            <td class="right"><?= $article['old_price'] . $currency ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="left"><b><?= lang('in_stock') ?>:</b></td>
                        <td class="right"><?= $article['quantity'] ?></td>
                    </tr>
                    <tr>
                        <td class="left"><b><?= lang('num_added_to_cart') ?>:</b></td>
                        <td class="right"><?php @$result=array_count_values($_SESSION['shopping_cart']); if(isset($result[$article['id']]))echo $result[$article['id']]; else echo 0; ?></td>
                    </tr>
                    <tr>
                        <td class="left"><b><?= lang('added_on') ?>:</b></td>
                        <td class="right"><?= date('m.d.Y', $article['time']) ?></td>
                    </tr>
                    <tr>
                        <td class="left"><b><?= lang('in_category') ?>:</b></td>
                        <td class="right"><?= $article['categorie_name'] ?></td>
                    </tr>
                    <tr>
                        <td class="left"></td>
                        <td class="right">
						<span class="add-to-cart">
                            <a href="javascript:void(0);" data-id="<?= $article['id'] ?>" class="btn btn-primary refresh-me"><?= lang('add_to_cart') ?></a>
							</span>
							<?php if(isset($result[$article['id']])) { ?>
                            <a href="javascript:void(0);" onclick="removeArticle(<?= $article['id'] ?>, true)" class="btn btn-danger"><?= lang('del_from_cart') ?></a>
							<?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2"><b><?= lang('description') ?>:</b></td>
                    </tr>
                </table>
            </div>
            <div id="description">
                <?= $article['description'] ?>
            </div>
        </div>
    </div>
	<div class="row orders-from-category" id="products-side">
	  <div class="col-xs-12 filter-sidebar">
                <div class="title">
                    <span><?= lang('oder_from_category') ?></span>
					</div>
					</div>
					<?php loop_articles($sameCagegoryArticles, $currency, 'col-sm-4 col-md-3'); ?>
	</div>
</div>
