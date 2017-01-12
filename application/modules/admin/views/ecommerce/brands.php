<h1><img src="<?= base_url('assets/imgs/brands.jpg') ?>" class="header-img" style="margin-top:-3px;"> Brands</h1>
<hr>
<div class="row">
    <div class="col-sm-6 col-md-4">
        <a href="javascript:void(0);" data-toggle="modal" data-target="#addPage" class="btn btn-default" style="margin-bottom:10px;">Add brand</a>
        <?php if (!empty($brands)) {
            ?>
            <ul class="list-group list-none">
                <?php
                foreach ($brands as $brand) {
                    ?>
                    <li class="list-group-item">
                        <?= $brand['name'] ?>
						<a href="?delete=<?= $brand['id'] ?>" class="pull-right confirm-delete">X</a>
                    </li>
                <?php }
                ?>
            </ul>
        <?php } else {
        ?>
		<div class="alert alert-info">No brands added!</div>
		<?php } ?>
    </div>
</div>
<div class="modal fade" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add new brand</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Brand name</label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>