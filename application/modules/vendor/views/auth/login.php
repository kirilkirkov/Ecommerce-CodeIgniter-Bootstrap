<div class="auth-page">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4"> 
            <?php
            if ($this->session->flashdata('login_error')) {
                ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('login_error') ?></div>
                <?php
            }
            ?>
            <div class="vendor-login">
                <h1><?= lang('login_to_your_acc') ?></h1><br>
                <form method="POST" action="">
                    <input type="text" name="u_email" placeholder="<?= lang('email') ?>">
                    <input type="password" name="u_password" placeholder="<?= lang('password') ?>">
                    <div class="checkbox">
                        <label><input type="checkbox" name="remember_me"><?= lang('remember_me') ?></label>
                    </div>
                    <input type="submit" name="login" class="login submit" value="<?= lang('u_login') ?>">
                </form>
                <div class="login-help">
                    <a href="<?= LANG_URL . '/vendor/register' ?>"><?= lang('register_me') ?></a> - <a href="<?= LANG_URL . '/vendor/forgotten-password' ?>"><?= lang('forgot_pass') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>