<h1><img src="<?= base_url('assets/imgs/seo_titles_descript.png') ?>" class="header-img" style="margin-top:-3px;">Titles / Descriptions</h1>
<hr>
<div class="row">
    <div class="col-sm-4 col-md-6">
        <?php
        if ($this->session->flashdata('result_publish')) {
            ?>
            <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
            <hr>
            <?php
        }
        ?>
        <form action="" method="POST">
            <?php
            foreach ($languages->result() as $language) {
                ?>
                <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
                <?php
            }
            foreach ($seo_pages as $page) {
                ?>
                <input type="hidden" name="pages[]" value="<?= $page['name'] ?>">
                <?php
            }
            foreach ($seo_pages as $page) {
                ?>
                <h4 class="bg-info"><?= $page['name'] ?></h4>
                <?php
                foreach ($languages->result() as $language) {
                    ?>
                    <div class="form-group"> 
                        <label>Title (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                        <input type="text" name="title[]" value="<?= @$seo_trans['page_' . $page['name']][$language->abbr]['title'] ?>" class="form-control">
                    </div>
                    <?php
                }
                foreach ($languages->result() as $language) {
                    ?>
                    <div class="form-group"> 
                        <label>Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                        <input type="text" name="description[]" value="<?= @$seo_trans['page_' . $page['name']][$language->abbr]['description'] ?>" class="form-control">
                    </div>
                    <?php
                }
            }
            ?>
            <input type="submit" name="save" value="Save" class="btn btn-default" style="margin-bottom: 10px;">
        </form>
        <div class="alert alert-warning">If you add new page with controller or in controller methor.. insert her name in table <b>seo_pages</b>!</div>
    </div>
</div>