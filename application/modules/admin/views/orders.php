<?php
if (!empty($cash_on_delivery))
    $table_head = array_keys($cash_on_delivery[0]);
?>
<div class="table-responsive">
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> <u>Orders</u> - Cash On Delivery</h1>
    <hr>
    <?php if (!empty($cash_on_delivery)) { ?>
        <div style="margin-bottom:10px;">
            <select class="selectpicker changeOrder">
                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id' ? 'selected' : '' ?> value="id">Order by new</option>
                <option <?= (isset($_GET['order_by']) && $_GET['order_by'] == 'processed') || !isset($_GET['order_by']) ? 'selected' : '' ?> value="processed">Order by not processed</option>
            </select>
        </div>
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
                            if ($key == 'processed' && $td == 0)
                                $params = 'class="bg-danger" data-action-id="' . $id . '"';
                            elseif ($key == 'processed' && $td == 1)
                                $params = 'class="bg-success" data-action-id="' . $id . '"';
                            elseif ($key == 'processed' && $td == 2)
                                $params = 'class="bg-warning" data-action-id="' . $id . '"';
                            ?>
                            <td <?= $params ?>>
                                <?php
                                if ($key == 'products') {
                                    $arr_products = unserialize($td);
                                    foreach ($arr_products as $product_id => $product_quantity) {
                                        ?>
                                        <div>
                                            <a data-toggle="tooltip" data-placement="top" title="Click to preview" target="_blank" href="<?= base_url('preview_' . $product_id) ?>">Product ID: 
                                                <b class="product-<?= $id ?>"><?= $product_id ?></b></a>
                                        </div>
                                        <div>Quantity:  <b><?= $product_quantity ?></b></div>
                                        <hr>
                                        <?php
                                    }
                                } else {
                                    if ($key == 'date')
                                        $td = date('d.M.Y / H:m:s', $td);
                                    if ($key == 'processed') {
                                        if ($td == 0)
                                            $type = 'No';
                                        if ($td == 1)
                                            $type = 'Yes';
                                        if ($td == 2)
                                            $type = 'Rejected';
                                        ?>
                                        <div class="status text-center" style="padding:5px; font-size:16px;">
                                            -- <b><?= $type ?></b> --
                                        </div>
                                        <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeStatus(<?= $id ?>, 1)" class="btn btn-success btn-xs">processed</a></div>
                                        <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeStatus(<?= $id ?>, 0)" class="btn btn-danger btn-xs">no processed</a></div>
                                        <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeStatus(<?= $id ?>, 2)" class="btn btn-warning btn-xs">rejected</a></div>
                                        <?php
                                    }
                                    echo $td;
                                }
                                ?> 
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?= $links_pagination ?>
    <?php } else { ?>
        <div class="alert alert-info">No orders to the moment!</div>
    <?php } ?>
</div>
<script>
    function changeStatus(id, to_status) {
        $.post("<?= base_url('changeOrderStatus') ?>", {the_id: id, to_status: to_status}, function (data) {
            if (data == '1') {
                if (to_status == 0) {
                    $('[data-action-id="' + id + '"] div.status b').text('No');
                    $('[data-action-id="' + id + '"]').removeClass().addClass('bg-danger');
                }
                if (to_status == 1) {
                    $('[data-action-id="' + id + '"] div.status b').text('Yes');
                    $('[data-action-id="' + id + '"]').removeClass().addClass('bg-success');
                }
                if (to_status == 2) {
                    $('[data-action-id="' + id + '"] div.status b').text('Rejected');
                    $('[data-action-id="' + id + '"]').removeClass().addClass('bg-warning');
                }
            }
        });
    }

    $(".changeOrder").change(function () {
        window.location.href = '<?= base_url('admin/orders') ?>?order_by=' + $(this).val();
    });
</script>