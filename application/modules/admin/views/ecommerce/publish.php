<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Publish product</h1>
<hr>
<?php
$timeNow = time();
if (validation_errors()) {
    ?>
    <hr>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
    <hr>
    <?php
}
if ($this->session->flashdata('result_publish')) {
    ?>
    <hr>
    <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
    <hr>
    <?php
}
?>
<form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" value="<?= isset($_POST['folder']) ? $_POST['folder'] : $timeNow ?>" name="folder">
    <?php foreach ($languages->result() as $language) { ?>
        <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
    <?php } foreach ($languages->result() as $language) { ?>
        <div class="form-group"> 
            <label>Title (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
            <input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
        </div>
        <?php
    } $i = 0;
    ?>
    <div class="form-group">
        <a href="javascript:void(0);" class="btn btn-default" id="showSliderDescrption">Show Slider Description <span class="glyphicon glyphicon-circle-arrow-down"></span></a>
    </div>
    <div id="theSliderDescrption" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'style="display:block;"' : '' ?>>
        <?php
        foreach ($languages->result() as $language) {
            ?>
            <div class="form-group">
                <label for="basic_description<?= $i ?>">Slider Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <textarea name="basic_description[]" id="basic_description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['basic_description']) ? $trans_load[$language->abbr]['basic_description'] : '' ?></textarea>
                <script>
                    CKEDITOR.replace('basic_description<?= $i ?>');
                </script>
            </div>
            <?php
            $i++;
        }
        ?> 
    </div>
    <?php
    $i = 0;
    foreach ($languages->result() as $language) {
        ?>
        <div class="form-group">
            <label for="description<?= $i ?>">Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
            <textarea name="description[]" id="description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
            <script>
                CKEDITOR.replace('description<?= $i ?>');
            </script>
        </div>
        <?php
        $i++;
    }
    ?>
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/shop_images/' . $_POST['image'];
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['image'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Cover Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>
    <div class="form-group bordered-group">
        <div class="others-images-container">
            <?= $otherImgs ?>
        </div>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modalMoreImages" class="btn btn-default">Upload more images</a>
    </div>
    <div class="form-group for-shop">
        <label>Shop Categories</label>
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
    <?php
    $i = 0;
    foreach ($languages->result() as $language) {
        ?>
        <div class="form-group for-shop">
            <label>Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
            <input type="text" name="price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['price']) ? $trans_load[$language->abbr]['price'] : '' ?>" class="form-control">
        </div>
        <div class="form-group for-shop">
            <label>Old Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
            <input type="text" name="old_price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['old_price']) ? $trans_load[$language->abbr]['old_price'] : '' ?>" class="form-control">
        </div>
    <?php } ?>
    <div class="form-group for-shop">
        <label>Quantity</label>
        <input type="text" placeholder="number" name="quantity" value="<?= @$_POST['quantity'] ?>" class="form-control" id="quantity">
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
    <div class="form-group for-shop">
        <label>In Slider</label>
        <select class="selectpicker" name="in_slider">
            <option value="1" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 0 || !isset($_POST['in_slider']) ? 'selected' : '' ?>>No</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Position</label>
        <input type="text" placeholder="Position number" name="position" value="<?= @$_POST['position'] ?>" class="form-control">
    </div>
    <div class="form-group for-shop">
        <a class="btn btn-default btn-xs" data-target="#modalConvertor" data-toggle="modal" href="javascript:void(0)">Convert currency <span class="glyphicon glyphicon-euro"></span></a>
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>
<!-- Modal Convertor Currency -->
<div class="modal fade" id="modalConvertor" tabindex="-1" role="dialog" aria-labelledby="modalConvertor">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Convert currency</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="select_cur">Convert from:</label>
                    <br>
                    <input type="text" class="form-control" placeholder="Give a price.." id="sum" name="sum" style="margin-bottom:6px;">
                    <select class="selectpicker form-control" data-live-search="true" name="select_from_cur" id="select_from_cur">
                        <?php
                        $curr = currencies();
                        foreach ($curr as $key => $val) {
                            ?>
                            <option value="<?= $key ?>"><?= $val ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="select_cur">Convert to:</label>
                    <select class="selectpicker form-control" data-live-search="true" name="select_to_cur" id="select_to_cur">
                        <?php
                        $curr = currencies();
                        foreach ($curr as $key => $val) {
                            ?>
                            <option value="<?= $key ?>"><?= $val ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="text-center">
                    <img src="<?= base_url('assets/imgs/load.gif') ?>" alt="loading" class="loading-conv" style="display:none;">
                </div>
                <div id="new_currency" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="currency_ajax_convert('0')" class="btn btn-primary">Convert</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Upload More Images -->
<div class="modal fade" id="modalMoreImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload more images</h4>
            </div>
            <div class="modal-body">
                <form id="uploadImagesForm">
                    <input type="hidden" value="<?= isset($_POST['folder']) ? $_POST['folder'] : $timeNow ?>" name="folder">
                    <label for="others">Select images</label>
                    <input type="file" name="others[]" id="others" multiple />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default finish-upload">
                    <span class="finish-text">Finish</span>
                    <img src="<?= base_url('assets/imgs/load.gif') ?>" class="loadUploadOthers" alt="">
                </button>
            </div>
        </div>
    </div>
</div>