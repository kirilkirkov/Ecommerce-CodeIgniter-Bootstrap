<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="inner-nav">
    <div class="container">
        <a href="<?= LANG_URL ?>"><?= lang('home') ?></a> <span class="active"> > <?= lang('user_login') ?></span>
    </div>
</div>
<div class="container user-page">
<div class="row">
<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
<div class="loginmodal-container">
<h1><?= lang('my_acc') ?></h1><br>
<form method="POST" action="">
<input type="text" name="name" value="<?= $userInfo['name'] ?>" placeholder="Name">
<input type="text" name="phone" value="<?= $userInfo['phone'] ?>" placeholder="Phone">
<input type="text" name="email"  value="<?= $userInfo['email'] ?>" placeholder="Email">
<input type="password" name="pass" placeholder="Password (leave blank if no change)"> 
<input type="submit" name="update" class="login loginmodal-submit" value="<?= lang('update') ?>">
<a href="<?= LANG_URL.'/logout' ?>" class="login loginmodal-submit text-center"><?= lang('logout') ?></a>
</form>
</div>
</div>
</div>
</div>