<h1>Pages Manager</h1>
<hr>
<?php if(!empty($pages)) {
	?>
	<ul class="list-none">
	<?php
	foreach($pages as $page) {
		?>
		<li data-id="<?= $page['id'] ?>">
		<span class="status"><?php $page['enabled'] == 1 ? $status = 'green' : $status = 'red'; ?><i class="fa fa-circle <?= $status ?>" aria-hidden="true"></i></span>
		<a href="javascript:void(0);" onclick="change(<?= $page['id'] ?>)"><?= $page['name'] ?></a>
		</li>
		<?php
	}?>
	</ul>
	<?php
} ?>
<script>
function change(id) {
	var myI = $('li[data-id="'+id+'"] i');
	if(myI.hasClass('red')) {
		myI.removeClass('red').addClass('green');
		var status = 1;
	} else if(myI.hasClass('green')) {
		myI.removeClass('green').addClass('red');
		var status = 0;
	}
	
	$.post("<?= base_url('changePageStatus') ?>", { id: id, status: status},function(data){
        if(data == '1') {
			return true;
		}
		return false;
    });
}
</script>