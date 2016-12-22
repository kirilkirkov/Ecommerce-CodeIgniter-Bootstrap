<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Three steps
 * 1 - your order
 * 2 - checkout type
 * 3 - success order
 */

function purchase_steps($step1 = null, $step2 = null, $step3 = null)
{
    if ($step1 == 1) {
        $icon1 = 'ok.png';
        $class1 = 'step-bg-ok';
    } else {
        $icon1 = 'no.png';
        $class1 = 'step-bg-not-ok';
    }
    if ($step2 == 2) {
        $icon2 = 'ok.png';
        $class2 = 'step-bg-ok';
    } else {
        $icon2 = 'no.png';
        $class2 = 'step-bg-not-ok';
    }
    if ($step3 == 3) {
        $icon3 = 'ok.png';
        $class3 = 'step-bg-ok';
    } else {
        $icon3 = 'no.png';
        $class3 = 'step-bg-not-ok';
    }
    ?>
    <div class="row steps">
        <div class="col-sm-4 step <?= $class1 ?>">
            <img src="<?= base_url('assets/imgs/' . $icon1) ?>" alt="Ok"> <?= lang('step_your_order') ?>
        </div>
        <div class="col-sm-4 step <?= $class2 ?>">
            <img src="<?= base_url('assets/imgs/' . $icon2) ?>" alt="Ok"> <?= lang('step_payment_method') ?>
        </div>
        <div class="col-sm-4 step <?= $class3 ?>">
            <img src="<?= base_url('assets/imgs/' . $icon3) ?>" alt="Ok"> <?= lang('step_success_prod') ?>
        </div>
    </div>
    <?php
}
