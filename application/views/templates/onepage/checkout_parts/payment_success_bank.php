<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="body">
        <?php
        if (isset($_SESSION['order_id'])) {
            ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2"><b class="bg-info"><?= lang('bank_recipient_name') ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?= $bank_account != null ? $bank_account['name'] : '' ?></td>
                        </tr>
                        <tr>
                            <td><b class="bg-info"><?= lang('bank_iban') ?></b></td>
                            <td><b class="bg-info"><?= lang('bank_bic') ?></b></td>
                        </tr>
                        <tr>
                            <td><?= $bank_account != null ? $bank_account['iban'] : '' ?></td>
                            <td><?= $bank_account != null ? $bank_account['bic'] : '' ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b class="bg-info"><?= lang('bank_name') ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?= $bank_account != null ? $bank_account['bank'] : '' ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b class="bg-info"><?= lang('bank_reason') ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?= lang('the_reason') ?> - <?= $_SESSION['order_id'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?= lang('final_amount_for_pay') ?> <?= $_SESSION['final_amount'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>