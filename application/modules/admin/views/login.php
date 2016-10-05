<style>
    body {
        background-image:url('/assets/imgs/login-bg.png');
        background-position: bottom  right;
        background-repeat: no-repeat;
        background-color:#548fd0;
    }
    .avatar {background-image:url('/assets/imgs/login-cover.png')}
</style>
<div class="container">
    <div class="login-container">
        <div id="output">       
            <?php
            if ($this->session->flashdata('err_login')) {
                ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('err_login') ?></div>
                <?php
            }
            ?></div>
        <div class="avatar"></div>
        <div class="form-box">
            <form action="" method="POST">
                <input type="text" name="username" placeholder="username">
                <input type="password" name="password" placeholder="password">
                <button class="btn btn-info btn-block login" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        var username = $("input[name=username]");
        var password = $("input[name=password]");
        $('button[type="submit"]').click(function (e) {
            if (username.val() == "" || password.val() == "") {
                e.preventDefault();
                $("#output").addClass("alert alert-danger animated fadeInUp").html("Please.. enter all fields ;)");
            }
        });
    });
</script>