<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<div class="row">
    <div class="col-sm-8">
        <form method="POST" action="">
            <input type="hidden" name="pageId" value="<?= $page[0]['id'] ?>">
            <?php foreach ($page as $p) { ?>
                <input type="hidden" name="translations[]" value="<?= $p['abbr'] ?>">
            <?php } foreach ($page as $p) { ?>
                <div class="form-group">
                    <label for="name">Name in menu (<?= $p['lname'] ?><img src="<?= base_url('attachments/lang_flags/' . $p['flag']) ?>" alt="">)</label>
                    <input type="text" name="name[]" class="form-control" value="<?= $p['name'] ?>" id="name">
                </div>
            <?php } ?>
            <?php
            $i = 1;
            foreach ($page as $p) {
                ?>
                <div class="form-group">
                    <label>Page content (<?= $p['lname'] ?><img src="<?= base_url('attachments/lang_flags/' . $p['flag']) ?>" alt="">)</label>
                    <textarea name="description[]" id="description<?= $i ?>" rows="200" class="form-control"><?= $p['description'] ?></textarea>
                    <script>
                        CKEDITOR.replace('description<?= $i ?>');
                    </script>
                </div>
                <?php
                $i++;
            }
            ?>
            <button type="submit" name="updatePage" class="btn btn-lg btn-default">Update</button>
        </form>
    </div>
</div>