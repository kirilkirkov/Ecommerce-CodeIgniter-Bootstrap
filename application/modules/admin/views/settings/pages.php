<h1><img src="<?= base_url('assets/imgs/webpages.jpg') ?>" class="header-img" style="margin-top:-3px;"> Pages Manager</h1>
<p>Here you can control which pages you want to have</p>
<hr>
<div class="row">
    <div class="col-sm-6 col-md-4">
        <a href="javascript:void(0);" data-toggle="modal" data-target="#addPage" class="btn btn-default" style="margin-bottom:10px;">Add page</a>
        <?php if (!empty($pages)) {
            ?>
            <ul class="list-group list-none">
                <?php
                foreach ($pages as $page) {
                    ?>
                    <li class="list-group-item" data-id="<?= $page['id'] ?>">
                        <a href="javascript:void(0);" class="text-uppercase" onclick="changeTextualPageStatus(<?= $page['id'] ?>)"><span class="glyphicon glyphicon-off"></span> <?= $page['name'] ?></a>
                        <span class="status pull-right"><?php $page['enabled'] == 1 ? $status = 'green' : $status = 'red'; ?><i class="fa fa-circle <?= $status ?>" aria-hidden="true"></i></span>
                        <?php if ($page['name'] != 'blog') { ?>
                            <a href="?delete=<?= $page['id'] ?>" style="margin-right:5px;" class="btn btn-xs btn-danger pull-right confirm-delete"><span class="glyphicon glyphicon-remove"></span></a>
                        <?php } ?>
                    </li>
                <?php }
                ?>
            </ul>
        <?php }
        ?>
    </div>
</div>
<div class="modal fade" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Page</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pname">Page name</label>
                        <input type="text" name="pname" class="form-control" id="pname">
                    </div>
                    <div class="alert alert-warning">This page will be only textually</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>