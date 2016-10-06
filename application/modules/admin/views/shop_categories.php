<div id="languages">
    <h1><img src="<?= base_url('assets/imgs/categories.jpg') ?>" class="header-img" style="margin-top:-2px;"> Shop Categories</h1> 
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
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add shop categorie</a>
    <?php
    if (!empty($shop_categories)) {
        ?>
        <table class="table table-striped custab">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>SubCategorie</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <?php foreach ($shop_categories as $key_cat=>$shop_categorie) {
            	$aa = '';
				foreach($shop_categorie['info'] as $ff) {
					$aa .= '<div>['.$ff['abbr'].']'.$ff['name'].'</div>';
				}
            	?>
                <tr>
                    <td><?= $key_cat ?></td>
                    <td><?= $aa ?></td>
                    <td><?php foreach($shop_categorie['sub'] as $sub) {
                    ?>
                    <div><?= $sub ?></div>
                    	<?php } 
                    ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('admin/shop_categories/?delete=' .$key_cat) ?>" class="btn btn-danger btn-xs confirm-delete"><span class="glyphicon glyphicon-remove"></span> Del</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No shop categories found!</div>
    <?php } ?>
    
        <!-- add edit home categorie -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Categorie for magazine</h4>
                    </div>
                    <div class="modal-body">
                    <?php foreach ($languages->result() as $language) { ?>
	<input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
	           <?php } foreach ($languages->result() as $language) { ?>
                        <div class="form-group">
                            <label>Name (<?= $language->name ?>)</label>
                            <input type="text" name="categorie_name[]" class="form-control">
                        </div>
                 <?php } ?>
                 		<div class="form-group">
						  <label>Sub Categorie?</label>
						  <select class="form-control" name="sub_for">
						   <option value="">None</option>
						  <?php foreach ($shop_categories as $key_cat=>$shop_categorie) {
						  	$aa = '';
						  	foreach($shop_categorie['info'] as $ff) {
						  		$aa .= '['.$ff['abbr'].']'.$ff['name'].'/';
						  	}
						  	?>
						    <option value="<?= $key_cat ?>"><?= $aa ?></option>
						    <?php } ?>
						  </select>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>