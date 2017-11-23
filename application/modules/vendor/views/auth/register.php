<div class="auth-page">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4"> 
            <?php
            if ($this->session->flashdata('error_register')) {
                ?>
                <div class="alert alert-danger"><?= implode('<br>', $this->session->flashdata('error_register')) ?></div>
                <?php
            }
            ?>
            <div class="vendor-login">
                <h1><?= lang('user_register_page') ?></h1><br>
                <form method="POST" action="">
                    <input type="text" name="u_email" value="<?= $this->session->flashdata('email') ? $this->session->flashdata('email') : '' ?>" placeholder="<?= lang('email') ?>">
                    <input type="password" name="u_password" placeholder="<?= lang('password') ?>">
                    <input type="password" name="u_password_repeat" placeholder="<?= lang('password_repeat') ?>">
                    <input type="submit" name="register" class="login submit" value="<?= lang('register_me') ?>">
                </form>
            </div>
        </div>
    </div>
</div>