<h1><img src="<?= base_url('assets/imgs/template-admin-logo.png') ?>" class="header-img" style="margin-top:-2px;"> Templates</h1>
<hr>
<form id="saveTemplate" method="POST" action="">
    <input type="hidden" name="template" class="template-name" value="">
</form>
<div class="row">
    <?php foreach ($templates as $template) { ?>
        <div class="col-sm-4">
            <a href="javascript:void(0);" data-form-id="saveTemplate" data-template-name="<?= $template ?>" class="confirm-save choose-template">
                <img src="<?= base_url('Loader/templateCssImage/screenshot.png/' . $template ) ?>" alt="Template Name: <?= $template ?>" class="img-responsive img-thumbnail">
                <?php if ($seleced_template == $template) { ?>
                    <img class="selected-template" alt="CHOOSED" src="<?= base_url('assets/imgs/ok-themes.png') ?>">
                <?php } ?>
            </a>
        </div>
    <?php } ?>
</div>