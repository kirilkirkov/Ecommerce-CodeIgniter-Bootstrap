<?php
if ($this->session->flashdata('result_delete')) {
    ?> 
    <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div> 
    <?php
}
?>
<div class="content">
    <div class="row"> 
        <?php
        foreach ($products as $row) {
            $u_path = 'attachments/shop_images/';
            if ($row->image != null && file_exists($u_path . $row->image)) {
                $image = base_url($u_path . $row->image);
            } else {
                $image = base_url('attachments/no-image.png');
            }
            ?>
            <div class="col-md-4 col-lg-3">
                <div class="product-list"> 
                    <div class="img-container">
                        <img src="<?= $image ?>" class="img-fluid" alt="No image">
                        <a>
                            <div class="mask"></div>
                        </a>
                    </div> 
                    <div class="product-body">
                        <h4><strong><a href=""><?= $row->title ?></a></strong></h4> 
                        <p class="product-text">
                            <?= word_limiter(strip_tags($row->description), 120) ?>
                        </p> 
                        <div class="product-footer">
                            <div class="text-center price"><?= $row->price ?></div>
                            <div class="buttons">
                                <a href="<?= LANG_URL . '/vendor/edit/product/' . $row->id ?>" class="btn btn-green btn-sm">
                                    <?= lang('edit') ?>
                                </a>
                                <a href="<?= LANG_URL . '/vendor/delete/product/' . $row->id ?>" onclick="return confirm('<?= lang('vendor_sure_to_del_product') ?>')" class="btn btn-green btn-sm ">
                                    <?= lang('delete') ?>
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        <?php } ?> 
    </div>
    <?= $links_pagination ?>
</div>