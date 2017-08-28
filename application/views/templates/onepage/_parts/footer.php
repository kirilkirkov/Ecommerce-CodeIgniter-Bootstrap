<div id="notificator" class="alert"></div>
<div class="footer">
    <div class="extra">
        <div class="extra-inner">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                       asd
                    </div>
                    <div class="col-sm-3">
                       asd
                    </div> 
                    <div class="col-sm-3">
                     asd
                    </div>
                    <div class="col-sm-3">
                       asd
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="bottom-inner">
            <div class="container">
                <span>pminvoice.com © 2017</span>
            </div>
        </div>
    </div>
</div> 
<?php if ($this->session->flashdata('emailAdded')) { ?>
<script>
    $(document).ready(function () {
        ShowNotificator('alert-info', '<?= lang('email_added') ?>');
    });
</script>
<?php
}
echo $addedJs;
?>
<script src="<?= base_url('templatejs/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/placeholders.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script>
var variable = {
    clearShoppingCartUrl: "<?= base_url('clearShoppingCart') ?>",
    manageShoppingCartUrl: "<?= base_url('manageShoppingCart') ?>",
    discountCodeChecker: "<?= base_url('discountCodeChecker') ?>"
};
</script>
<script src="<?= base_url('assets/js/system.js') ?>"></script>
<script src="<?= base_url('templatejs/jquery.visible.min.js') ?>"></script>
<script src="<?= base_url('templatejs/mine.js') ?>"></script>
</body>
</html>
