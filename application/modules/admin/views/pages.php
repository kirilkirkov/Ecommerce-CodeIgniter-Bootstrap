<h1>Pages Manager</h1>
<p>Here you can control which pages you want to have</p>
<hr>
<div class="row">
    <div class="col-sm-4">
        <?php if (!empty($pages)) {
            ?>
            <ul class="list-group list-none">
                <?php
                foreach ($pages as $page) {
                    ?>
                    <li class="list-group-item" data-id="<?= $page['id'] ?>">
                        <a href="javascript:void(0);" class="text-uppercase" onclick="change(<?= $page['id'] ?>)"><span class="glyphicon glyphicon-off"></span> <?= $page['name'] ?></a>
                        <span class="status pull-right"><?php $page['enabled'] == 1 ? $status = 'green' : $status = 'red'; ?><i class="fa fa-circle <?= $status ?>" aria-hidden="true"></i></span>
                    </li>
                <?php }
                ?>
            </ul>
        <?php }
        ?>
    </div>
</div>
<script>
    function change(id) {
        var myI = $('li[data-id="' + id + '"] i');
        if (myI.hasClass('red')) {
            myI.removeClass('red').addClass('green');
            var status = 1;
        } else if (myI.hasClass('green')) {
            myI.removeClass('green').addClass('red');
            var status = 0;
        }

        $.post("<?= base_url('changePageStatus') ?>", {id: id, status: status}, function (data) {
            if (data == '1') {
                return true;
            }
            return false;
        });
    }
</script>