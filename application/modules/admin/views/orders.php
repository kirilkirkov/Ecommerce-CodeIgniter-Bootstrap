<?php
if(!empty($cash_on_delivery)) $table_head = array_keys($cash_on_delivery[0]);
?>
<div class="table-responsive">
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> <u>Orders</u> - Cash On Delivery</h1>
	<hr>
	<div style="margin-bottom:10px;">
	<select class="selectpicker changeOrder">
	<option <?= isset($_GET['order_by']) && $_GET['order_by']=='id' ? 'selected' : '' ?> value="id">Order by new</option>
	<option <?= isset($_GET['order_by']) && $_GET['order_by']=='processed' ? 'selected' : '' ?> value="processed">Order by not processed</option>
	</select>
	</div>
	<?php if(!empty($cash_on_delivery)) { ?>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<tr>
				<?php foreach ($table_head as $th) { ?>
					<th><?= $th ?></th>
				<?php } ?> 
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($cash_on_delivery as $tr) {
				$id = $tr['id'];
				?>
				<tr>
					<?php
					foreach ($tr as $key => $td) {
						$params = '';
						if($key == 'processed' && $td == 0) $params='class="bg-danger" data-action-id="'.$id.'"'; elseif($key == 'processed' && $td == 1) $params='class="bg-success" data-action-id="'.$id.'"';
						?>
						<td <?= $params ?>>
						<?php
						if($key == 'products') {
							$arr_products = unserialize($td);
							foreach($arr_products as $product_id => $product_quantity) {
							?>
							<div>Product ID: <b class="product-<?= $id ?>"><?=$product_id?></b></div>
							<div>Quantity:  <b><?=$product_quantity?></b></div>
							<hr>
							<?php
							}
						} else {
							if($key == 'date') $td = date('d.M.Y / H:m:s', $td);
							if($key == 'processed' && $td == 0) $td = '<div>No</div> <input type="hidden" value="'.$td.'" id="id-'.$id.'"> <a href="javascript:void(0);" onclick="changeStatus('.$id.')" class="btn btn-primary btn-xs">change</a>';
							if($key == 'processed' && $td == 1) $td = '<div>Yes</div> <input type="hidden" value="'.$td.'" id="id-'.$id.'"> <a href="javascript:void(0);" onclick="changeStatus('.$id.')" class="btn btn-primary btn-xs">change</a>';
						?>
						<?= $td ?>
						<?php }?> 
					</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
	<div class="alert alert-info">No orders to the moment!</div>
	<?php } ?>
</div>
<script>
function changeStatus(id) {
	var status = $('#id-'+id);
	var new_status;
	if(status.val() == 0) { 
		new_status = 1;
	} else {
		new_status = 0;
	}
	$.post("<?= base_url('changeOrderStatus') ?>", { the_id: id, to_status: new_status},function(data){
        if(data == '1') {
			var status = $('#id-'+id);
			if(status.val() == 0) {
				$('[data-action-id="'+id+'"] div').text('Yes');
				$('[data-action-id="'+id+'"]').removeClass( "bg-danger" ).addClass( "bg-success" );
				status.val(1);
			} else {
				$('[data-action-id="'+id+'"] div').text('No');
				$('[data-action-id="'+id+'"]').removeClass( "bg-success" ).addClass( "bg-danger" );
				status.val(0);
			}
		}
    });
}

$(".changeOrder").change(function() {
  window.location.href = '<?= base_url('admin/orders') ?>?order_by='+$(this).val();
});
</script>