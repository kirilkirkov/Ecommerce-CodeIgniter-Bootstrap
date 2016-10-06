<div id="languages">
    <h1><img src="<?= base_url('assets/imgs/small-globe.png') ?>" class="header-img" style="margin-top:-3px;"> Languages</h1> 
    <hr>
    <?php if (validation_errors()) { ?>
        <hr>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_add')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    ?>
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add new language</a>
    <?php
    if ($languages->result()) {
        ?>
        <table class="table table-striped custab">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Image</th>
                    <th>Abbr</th>
                    <th>Name</th>
                    <th>Currency</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <?php foreach ($languages->result() as $language) { ?>
                <tr>
                    <td><?= $language->id ?></td>
                    <td><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="No country flag" style="width:16px; height:11px;"></td>
                    <td><?= $language->abbr ?></td>
                    <td><?= $language->name ?></td>
                    <td><?= $language->currency ?></td>
                    <td class="text-center">
                        <?php if ($def_lang != $language->abbr) { ?>
                            <a href="<?= base_url('admin/languages/?delete=' . $language->id) ?>" class="btn btn-danger btn-xs confirm-delete"><span class="glyphicon glyphicon-remove"></span> Del</a>
                        <?php } else { ?>
                            is default
                        <?php } ?>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No languages found!</div>
    <?php } ?>
    <div class="alert alert-warning">
        <b>How to add language in 3 easy steps</b>
        <ul>
            <li>Add languages here (set Abbrevation, Name, and Image)</li>
            <li>Copy some of language folders in /application/languages/ and rename it to new language, chage laguages in array</li>
            <li>Edit articles and set new languages in fields</li>
        </ul>
    </div>
    <!-- add edit languages -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Language</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="abbr">Abbrevation</label>
                            <input type="text" name="abbr" class="form-control" id="abbr">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="currency">Currency</label>
                            <input type="text" name="currency" class="form-control" id="currency">
                        </div>
                        <div class="form-group">
                            <input type="file" name="userfile"">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>