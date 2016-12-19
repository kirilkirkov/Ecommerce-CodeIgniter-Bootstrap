<footer>
    <div class="container">
        <span class="footer-text"><?= $footerCopyright ?></span>
    </div>
</footer>
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
</div>
</div>
<div id="notificator" class="alert"></div>
<script src="<?= base_url('templatejs/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/placeholders.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= base_url('templatejs/mine.js') ?>"></script>
</body>
</html>
