<style>
    body {
        background: -webkit-linear-gradient(90deg, #6b70ff 10%, #353889 90%);
        background: -moz-linear-gradient(90deg, #6b70ff 10%, #353889 90%);
        background: -ms-linear-gradient(90deg, #6b70ff 10%, #353889 90%);
        background: -o-linear-gradient(90deg, #6b70ff 10%, #353889 90%);
        background: linear-gradient(90deg, #6b70ff 10%, #353889 90%);
        font-family: 'Open Sans', sans-serif!important;
        padding-top:100px;
    }
</style>
<div class="container">
    <div class="login-alerts">
        <?php if(validation_errors()) { ?>
            <div class="alert alert-danger"><?= validation_errors() ?></div>
            <?php
        }
        if($this->session->flashdata('err_login')) {
            ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('err_login'); ?></div>
            <?php
        }
        ?>
    </div>  
    <div class = "row">
        <div class = "col-md-12">
            <div class = "well login-box">
                <form action = "" method = "POST">
                    <legend>Login</legend>
                    <div class = "form-group">
                        <label for="username">Username</label>
                        <input value="" id="username" placeholder="Username" name="username" type="text" class="form-control" />
                    </div>
                    <div class = "form-group">
                        <label for="password">Password</label>
                        <input id="password" value="" placeholder="Password" name="password" type="password" class="form-control" />
                    </div>
                    <div class = "form-group text-center">
                        <a href="<?= base_url() ?>" class="btn btn-danger btn-cancel-action">Cancel</a>
                        <input type="submit" class="btn btn-success btn-login-submit" value="Login" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>