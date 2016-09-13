<div id="categories">
    <h1>Categories</h1> 
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
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right"><b>+</b> Add new categories</a>
    <?php
    if ($categoiries->result()) {
        ?>
        <table class="table table-striped custab">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Articles</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <?php foreach ($categoiries->result() as $categorie) { ?>
                <tr>
                    <td><?= $categorie->id ?></td>
                    <td><?= $categorie->name ?></td>
                    <td><span class="badge"><?= $categorie->num ?></span></td>
                    <td class="text-center"><a class="btn btn-info btn-xs" href="javascript:void(0);" onclick="editid(<?= $categorie->id ?>, '<?= $categorie->name ?>')" data-toggle="modal" data-target="#add_edit_articles"><span class="glyphicon glyphicon-edit"></span> Edit</a> <a href="<?= base_url('admin/categories/?delete=' . $categorie->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure continue deleting?')"><span class="glyphicon glyphicon-remove"></span> Del</a></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No categories found!</div>
    <?php } ?>
    <!-- add edit articles -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add/Edit Categorie</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="0">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="checkbox" id="rename_all" style="display:none">
                            <label><input type="checkbox" name="rename_all" value="">Change category name to all articles</label>
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
    <script>
        function editid(id, name) {
            $('[name="id"]').val(id);
            $('[name="name"]').val(name);
            $("#rename_all").show();
            $('[name="rename_all"]').val(name);
        }
        $('#add_edit_articles').on('hidden.bs.modal', function () {
            $('[name="id"]').val(0);
            $('[name="name"]').val('');
            $("#rename_all").hide();
            $('[name="rename_all"]').attr('checked', false);
        });
    </script>
</div>
