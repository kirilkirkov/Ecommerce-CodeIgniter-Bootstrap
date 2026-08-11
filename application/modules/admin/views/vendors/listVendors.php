<div id="users">
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-3px;"> Admin Vendors List</h1>
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
    <div class="well hidden-xs">
        <div class="row">
            <form method="GET" action="">
                <div class="col-sm-3">
                    <label>Status:</label>
                    <select name="status" class="form-control selectpicker" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option <?= isset($_GET['status']) && $_GET['status'] == '1' ? 'selected=""' : '' ?> value="1">Approved</option>
                        <option <?= isset($_GET['status']) && $_GET['status'] == '0' ? 'selected=""' : '' ?> value="0">Pending</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
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
                        <th>Status</th>
                        <th>Sold products amount</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <?php foreach ($vendors->result() as $vendor) { ?>
                    <tr>
                        <td><?= $vendor->id ?></td>
                        <td><?= isset($vendor->name) ? htmlspecialchars($vendor->name, ENT_QUOTES, 'UTF-8') : 'Vendor name is empty' ?></td>
                        <td><?= $vendor->email ?></td>
                        <td>
                            <?php if ($vendor->status == 1) { ?>
                                <span class="label label-success">Approved</span>
                            <?php } else { ?>
                                <span class="label label-warning">Pending</span>
                            <?php } ?>
                        </td>
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
                                    $product = unserialize($order['products'], ["allowed_classes" => false]);
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
                        <td class="text-center">
                            <div>
                                <?php if ($vendor->status == 0) { ?>
                                    <a href="?approve=<?= $vendor->id ?>">Approve</a>
                                <?php } ?>
                                <a href="?edit=<?= $vendor->id ?>">Edit</a>
                                <a href="?delete=<?= $vendor->id ?>" class="confirm-delete">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No vendors found!</div>
    <?php } ?>

    <!-- edit vendor -->
    <div class="modal fade" id="edit_vendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Vendor</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit" value="<?= isset($_GET['edit']) ? (int)$_GET['edit'] : '0' ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : '' ?>" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : '' ?>" id="email">
                        </div>
                        <div class="form-group">
                            <label for="url">Url</label>
                            <input type="text" name="url" class="form-control" value="<?= isset($_POST['url']) ? htmlspecialchars($_POST['url'], ENT_QUOTES, 'UTF-8') : '' ?>" id="url">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" value="" placeholder="Leave empty to keep current password" id="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
<?php if (isset($_GET['edit'])) { ?>
        $(document).ready(function () {
            $("#edit_vendor").modal('show');
        });
<?php } ?>
</script>