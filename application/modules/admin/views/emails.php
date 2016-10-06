<h1><img src="<?= base_url('assets/imgs/email.png') ?>" class="header-img" style="margin-top:-3px;"> Subscribed</h1>
<p>Here are all subscribed emails of users</p>
<hr>
<?php if ($this->session->flashdata('emailDeleted')) { ?>
    <hr>
    <div class="alert alert-info"><?= $this->session->flashdata('emailDeleted') ?></div>
    <?php
}
?>
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custab">
        <thead>
            <tr>
                <th>Email</th>
                <th>Browser</th>
                <th>Ip</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($emails->result()) {
                foreach ($emails->result() as $email) {
                    ?>
                    <tr>
                        <td><?= $email->email ?></td>
                        <td><?= $email->browser ?></td>
                        <td><?= $email->ip ?></td>
                        <td><?= date('Y.m.d / H.m.s', $email->time) ?></td>
                        <td><a href="?delete=<?= $email->id ?>" class="btn-xs btn-danger confirm-delete">Delete</a></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="5">No emails found!</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php if ($emails->result()) { ?>
    <form method="POST"><input type="submit" name="export" value="Export" class="btn btn-default"></form>
<?php } ?>
<?= $links_pagination ?>