<div class="auth-page">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4"> 
            <div class="vendor-login">
                <h1><?= lang('user_forgotten_page') ?></h1><br>
                <form method="POST" action="">
                    <input type="text" name="u_email" placeholder="<?= lang('email') ?>"> 
                    <input type="submit" name="login" class="login submit" value="<?= lang('send_me_new_pass') ?>">
                </form>
            </div>
        </div>
    </div>
</div>