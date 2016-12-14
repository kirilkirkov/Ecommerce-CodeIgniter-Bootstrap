<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>

<h1><img src="<?= base_url('assets/imgs/blogger.png') ?>" class="header-img" style="margin-top:-2px;"> Publish post</h1>
<hr>
<div class="row">
	<div class="col-sm-8 col-md-7">
		<?php if (validation_errors()) { ?>
			<hr>
			<div class="alert alert-danger"><?= validation_errors() ?></div>
			<hr>
		<?php }
		?>
		<?php if ($this->session->flashdata('result_publish')) { ?>
			<hr>
			<div class="alert alert-danger"><?= $this->session->flashdata('result_publish'); ?></div>
			<hr>
		<?php }
		?>
		<form method="POST" enctype="multipart/form-data">
		<?php foreach ($languages->result() as $language) { ?>
			<input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
		<?php }  foreach ($languages->result() as $language) { ?>
			<div class="form-group"> 
				<label>Title (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/'.$language->flag) ?>" alt="">)</label>
				<input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
			</div>
			<?php } $i=0; foreach ($languages->result() as $language) { ?>
			<div class="form-group">
			<label for="description<?=$i?>">Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/'.$language->flag) ?>" alt="">)</label>
			<textarea name="description[]" id="description<?=$i?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
			<script>
			CKEDITOR.replace('description<?=$i?>');
			</script>
		</div>
		<?php $i++;  } ?>
			<div class="form-group">
				<?php if (isset($_POST['image'])) { ?>
					<div><img class="img-responsive" src="<?= base_url('attachments/blog_images/' . $_POST['image']) ?>"></div>
					<label for="userfile">Choose another image:</label>
				<?php } else { ?>
					<label for="userfile">Upload image:</label>
				<?php } ?>
				<input type="file" id="userfile" name="userfile">
			</div>
			<button type="submit" name="submit" class="btn btn-default">Publish</button>
			<?php if ($id > 0) { ?>
				<a href="<?= base_url('admin/blog') ?>" class="btn btn-info">Cancel</a>
			<?php } ?>
		</form>
	</div>
</div>