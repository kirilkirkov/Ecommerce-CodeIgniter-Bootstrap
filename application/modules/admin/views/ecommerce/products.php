<div id="products">
    <?php
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_publish')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
        <hr>
        <?php
    }
    $langs = $languages->result();
    ?>
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Products</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="well hidden-xs"> 
                <div class="row">
                    <div class="col-xs-4">
                        <select class="form-control selectpicker change-order-products">
                            <option <?= isset($_GET['orderby']) && $_GET['orderby'] == 'id=desc' ? 'selected=""' : '' ?> value="id=desc">Newest</option>
                            <option <?= isset($_GET['orderby']) && $_GET['orderby'] == 'id=asc' ? 'selected=""' : '' ?> value="id=asc">Latest</option>
                            <option <?= isset($_GET['orderby']) && $_GET['orderby'] == 'quantity=asc' ? 'selected=""' : '' ?> value="quantity=asc">Low Quantity</option>
                            <option <?= isset($_GET['orderby']) && $_GET['orderby'] == 'quantity=desc' ? 'selected=""' : '' ?> value="quantity=desc">High Quantity</option>
                        </select>
                    </div>
                    <div class="col-xs-8">
                    </div>
                </div>
            </div>
            <hr>
            <?php
            if ($products->result()) {
                foreach ($products->result() as $row) {
                    $u_path = 'attachments/shop_images/';
                    if ($row->image != null && file_exists($u_path . $row->image)) {
                        $image = base_url($u_path . $row->image);
                    } else {
                        $image = base_url('attachments/no-image.png');
                    }
                    ?>
                    <div class="row article <?= $row->visibility == 1 ? '' : 'invisible-status' ?>" data-article-id="<?= $row->id ?>">
                        <div class="col-sm-4">
                            <a href="#" class="article-image" style="position:relative;">
                                <img src="<?= $image ?>" class="img-responsive">
                                <div style="color: red;font-size: 40px;left: 10px;position: absolute;top: 20px;"><span class="glyphicon glyphicon-shopping-cart"></span></div>
                            </a>
                        </div>
                        <div class="col-sm-8">
                            <input type="hidden" value="<?= $row->visibility == 1 ? 0 : 1 ?>" id="to-status">
                            <h3 class="title"><?= $row->title ?></h3>
                            <div class="text-muted">
                                <div class="dropdown">
                                    <span class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="status-is-icon"><?= $row->visibility == 1 ? '<i class="fa fa-unlock"></i>' : '<i class="fa fa-lock"></i>' ?></span><span class="caret"></span></span>
                                    <span class="staus-is"><?= $row->visibility == 1 ? 'Visible' : 'Invisible' ?></span>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0);" onclick="changeProductStatus(<?= $row->id ?>)"><?= $row->visibility == 1 ? 'Make Invisible' : 'Make Visible' ?></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="description-article"><?= word_limiter(strip_tags($row->description), 70) ?></div>
                            <div>
                                <b>Quantity:</b> 
                                <?= $row->quantity ?>
                            </div>
                            <div>
                                <b>Procurements :</b> 
                                <?= $row->procurement ?>
                            </div>
                            <div>
                                <b>Product ID:</b> 
                                <u><?= $row->id ?></u>
                            </div>
                            <div class = "pull-right">
                                <a href="<?= base_url('admin/publish/' . $row->id) ?>" class="btn btn-info">Edit</a>
                                <a href="<?= base_url('admin/products?delete=' . $row->id) ?>"  class="btn btn-danger confirm-delete">Delete</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                }
                echo $links_pagination;
                ?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class ="alert alert-info">No products found!</div>
    <?php } ?>
</div>