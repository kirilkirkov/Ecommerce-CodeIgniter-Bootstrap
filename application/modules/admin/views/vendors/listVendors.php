<div id="users">
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-3px;"> Admin Vendors List</h1> 
    <hr>
    <div class="clearfix"></div>
    <?php
    if ($vendors->result()) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Sold products amount</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <?php foreach ($vendors->result() as $vendor) { ?>
                    <tr>
                        <td><?= $vendor->id ?></td>
                        <td><?= isset($vendor->name) ? $vendor->name : 'Vendor name is empty' ?></td>
                        <td><?= $vendor->email ?></td>
                        <td>
                            <?php
                             $orders = $controller->getVendorOrders($vendor->id); 
                             if(!count($orders)) {
                                ?>
                                <span class="label label-danger">No orders</span>
                                <?php
                             } else {
                                $countSales = 0;
                                foreach($orders as $order) {
                                    $product = unserialize($order['products']);
                                    foreach ($product as $key => $value) {
                                        $countSales += (int)$value;
                                    }
                                ?>
                                <span class="label label-success"><?= $countSales ?></span>
                            <?php }
                             }
                            ?>    
                        </td>
                        <td><?= $vendor->created_at ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No vendors found!</div>
    <?php } ?>
</div>