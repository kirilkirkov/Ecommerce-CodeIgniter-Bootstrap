<div id="languages">
    <h1><img src="<?= base_url('assets/imgs/small-globe.png') ?>" class="header-img" style="margin-top:-3px;"> Languages</h1> 
    <hr>
    <?php
    if (isset($writable)) {
        ?>
        <div class="alert alert-danger"><?= $writable ?></div>
        <?php
    }
    if (validation_errors()) {
        ?>
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
    if (!isset($writable)) {
        ?>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#addLanguage" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add new language</a>
        <?php
    }
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
                    <td><?= strtoupper($language->abbr) ?></td>
                    <td><?= ucfirst($language->name) ?></td>
                    <td><?= $language->currency ?></td>
                    <td class="text-center">
                        <?php if (MY_DEFAULT_LANGUAGE_ABBR != $language->abbr) { ?>
                            <a href="<?= base_url('admin/languages/?delete=' . $language->id) ?>" class="btn btn-danger btn-xs confirm-delete"><span class="glyphicon glyphicon-remove"></span> Delete</a>
                        <?php } else { ?>
                            Its default
                        <?php } ?>
                        <a href="<?= base_url('admin/languages/?editLang=' . $language->name) ?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No languages found!</div>
    <?php } ?>
    <div class="alert alert-warning">
        <b>How to add language in 2 easy steps</b>
        <ul>
            <li>Add languages here (set Abbrevation, Name, and Image)</li>
            <li>Edit added language and set values</li>
        </ul>
    </div>

    <?php
    if (isset($_GET['editLang'])) {
        ?>
        <form method="POST" id="saveLang">
            <input type="hidden" name="goDaddyGo" value="">
            <div class="alert alert-info"><span class="glyphicon glyphicon-alert"></span> Now you edit language: <b><?= ucfirst($_GET['editLang']) ?></b></div>
            <?php
            $o = 1;
            $countValuesForEdit = 0;
            foreach ($arrPhpFiles as $phpFile => $langFinal) {
                if (!empty($langFinal)) {
                    foreach ($langFinal as $key => $val) {
                        ?>
                        <div class="divLangs">
                            <span><b><?= $o ?>.</b> <?= $val ?></span>
                            <input type="hidden" name="php_files[]" value="<?= $phpFile ?>">
                            <input type="hidden" name="php_keys[]" value="<?= $key ?>">
                            <input type="text" value="<?= $val ?>" class="form-control" name="php_values[]">
                        </div>
                        <?php
                        $o++;
                        $countValuesForEdit++;
                    }
                }
            }

            foreach ($arrJsFiles as $jsFile => $langFinal) {
                $i = 0;
                foreach ($langFinal[1] as $aaIam) {
                    ?>
                    <div class="divLangs">
                        <span><b><?= $o ?>.</b> <?= $langFinal[2][$i] ?></span>
                        <input type="hidden" name="js_files[]" value="<?= $jsFile ?>">
                        <input type="hidden" name="js_keys[]" value="<?= trim(str_replace(':', '', $aaIam)) ?>">
                        <input type="text" class="form-control" value="<?= $langFinal[2][$i] ?>" name="js_values[]">
                    </div>
                    <?php
                    $i++;
                    $o++;
                    $countValuesForEdit++;
                }
            }
            if ($countValuesForEdit * 6 > $max_input_vars) {
                ?>
                <div class="alert alert-danger">
                    You can't edit this language because the
                    server have restriction for <b>max_input_vars</b>, it must be more than
                    <b><?= $countValuesForEdit * 6 ?></b> and now is <b><?= $max_input_vars ?></b>.<br>
                    Please contact your system administrator.
                </div>
            <?php } else { ?>
                <a href="javascript:void(0);" data-form-id="saveLang" style="margin-left: 10px;" class="btn btn-lg btn-info confirm-save">Save me</a>
            <?php } ?>
            <a href="<?= base_url('admin/languages') ?>" class="btn btn-lg btn-default">Cancel</a>
        </form>
        <?php
    }
    ?>

    <!-- add edit languages -->
    <div class="modal fade" id="addLanguage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                            <label class="control-label">Currency key:</label>
                            <select class="selectpicker form-control" data-live-search="true" name="currencyKey">
                                <?php
                                $curr = currencies();
                                foreach ($curr as $key => $val) {
                                    ?>
                                    <option value="<?= $key ?>"><?= $key ?></option>
                                <?php } ?>
                            </select>
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