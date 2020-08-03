<?php
$timeNow = time();
?>
<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php
        if ($this->session->flashdata('result_publish')) {
            ?> 
            <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div> 
            <?php
        }
        ?>
        <div class="content">
            <form class="form-box" action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" value="<?= isset($_POST['folder']) ? htmlspecialchars($_POST['folder']) : $timeNow ?>" name="folder">
                <div class="form-group available-translations">
                    <b>Languages</b>
                    <?php foreach ($languages as $language) { ?>
                        <button type="button" data-locale-change="<?= $language->abbr ?>" class="btn btn-default locale-change text-uppercase <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'active' : '' ?>">
                            <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">
                            <?= $language->abbr ?>
                        </button>
                    <?php } ?>
                </div>
                <?php
                $i = 0;
                foreach ($languages as $language) {
                    ?>
                    <div class="locale-container locale-container-<?= $language->abbr ?>" <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'style="display:block;"' : '' ?>>
                        <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
                        <div class="form-group">
                            <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="<?= $language->name ?>" class="language">
                            <input type="text" name="title[]" placeholder="<?= lang('vendor_product_name') ?>" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
                        </div> 
                        <label><?= lang('vendor_product_description') ?> <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="<?= $language->name ?>"></label>
                        <div class="form-group">
                            <textarea class="form-control" name="description[]" id="description<?= $i ?>"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
                        </div>
                        <script>
                            CKEDITOR.replace('description<?= $i ?>');
                            CKEDITOR.config.entities = false;
                        </script>
                        <div class="form-group">
                            <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="" class="language">
                            <input type="text" name="price[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['price']) ? $trans_load[$language->abbr]['price'] : '' ?>" placeholder="<?= lang('vendor_price') ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="" class="language">
                            <input type="text" name="old_price[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['old_price']) ? $trans_load[$language->abbr]['old_price'] : '' ?>" placeholder="<?= lang('vendor_old_price') ?>" class="form-control">
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                ?>
                <div class="form-group bordered-group">
                    <?php
                    if (isset($_POST['image']) && $_POST['image'] != null) {
                        $image = 'attachments/shop_images/' . htmlspecialchars($_POST['image']);
                        if (!file_exists($image)) {
                            $image = 'attachments/no-image.png';
                        }
                        ?>
                        <p><?= lang('vendor_current_image') ?></p>
                        <div>
                            <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
                        </div>
                        <input type="hidden" name="old_image" value="<?= htmlspecialchars($_POST['image']) ?>">
                        <?php if (isset($_GET['to_lang'])) { ?>
                            <input type="hidden" name="image" value="<?= htmlspecialchars($_POST['image']) ?>">
                            <?php
                        }
                    }
                    ?>
                    <label><?= lang('vendor_cover_image') ?></label>
                    <input type="file" name="userfile">
                </div>
                <div class="form-group bordered-group">
                    <div class="others-images-container">
                        <?= $otherImgs ?>
                    </div>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#modalMoreImages" class="btn btn-default"><?= lang('vendor_up_more_imgs') ?></a>
                </div>
                <div class="form-group">
                    <label><?= lang('vendor_select_category') ?></label>
                    <select class="selectpicker form-control show-tick show-menu-arrow" name="shop_categorie">
                        <?php foreach ($shop_categories as $key_cat => $shop_categorie) { ?>
                            <option <?= isset($_POST['shop_categorie']) && $_POST['shop_categorie'] == $key_cat ? 'selected=""' : '' ?> value="<?= $key_cat ?>">
                                <?php
                                foreach ($shop_categorie['info'] as $nameAbbr) {
                                    if ($nameAbbr['abbr'] == $this->config->item('language_abbr')) {
                                        echo $nameAbbr['name'];
                                    }
                                }
                                ?>
                            </option>
                        <?php } ?>
                    </select>
                </div> 
                <?php if ($showBrands == 1) { ?>
                    <div class="form-group for-shop">
                        <label>Brand</label>
                        <select class="selectpicker" name="brand_id">
                            <?php foreach ($brands as $brand) { ?>
                                <option <?= isset($_POST['brand_id']) && $_POST['brand_id'] == $brand['id'] ? 'selected' : '' ?> value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <input type="text" placeholder="<?= lang('vendor_quantity') ?>" name="quantity" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="<?= lang('vendor_position') ?>" name="position" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['position']) : '' ?>" class="form-control">
                </div>
                <button type="submit" name="setProduct" class="btn btn-green"><?= lang('vendor_submit_product') ?></button>
            </form> 
        </div>
    </div>
</div>
<!-- Modal Upload More Images -->
<div class="modal fade" id="modalMoreImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= lang('vendor_up_more_imgs') ?></h4>
            </div>
            <div class="modal-body">
                <form id="uploadImagesForm">
                    <input type="hidden" value="<?= isset($_POST['folder']) ? htmlspecialchars($_POST['folder']) : $timeNow ?>" name="folder">
                    <label for="others"><?= lang('vendor_select_images') ?></label>
                    <input type="file" name="others[]" id="others" multiple />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default finish-upload">
                    <span class="finish-text"><?= lang('finish') ?></span>
                    <img src="<?= base_url('assets/imgs/load.gif') ?>" class="loadUploadOthers" alt="">
                </button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/bootstrap-select-1.12.1/js/bootstrap-select.min.js') ?>"></script>
