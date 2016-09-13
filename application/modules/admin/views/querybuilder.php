<h1>QueryBuilder</h1>
<hr>
<?php
$success_query = false;
if (isset($_POST['query'])) {
    $DB = $this->load->database($_POST['database'], TRUE);
    $DB->initialize();
    $result = $DB->query($_POST['query']);
    $arr = array();
    if ($result !== true && $result !== false) {
        foreach ($result->result_array() as $row) {
            $arr[] = $row;
        }
        if (!empty($arr)) {
            $table_head = array_keys($arr[0]);
        }
    }
    if ($result === true) {
        $success_query = true;
    }
}
if ($success_query === true) {
    ?>
    <div class="alert alert-success">Success query! ;)</div>
<?php } elseif ($success_query === true) { ?>
    <div class="alert alert-info">Broken query! ;)</div>
<?php } ?>
<div class="alert alert-danger">Set database name in option menu!</div>
<form role="form" method="POST">
    <div class="form-group">
        <label for="text">Query:</label>
        <input type="text" placeholder="show tables" value="<?= isset($_POST['query']) ? $_POST['query'] : '' ?>" name="query" class="form-control" id="text">
    </div>
    <div class="form-group">
        <label for="database">to Database:</label>
        <select class="form-control" name="database" id="database">
            <option <?= isset($_POST['database']) && $_POST['database'] == 'default' ? 'selected' : '' ?> value="default">DbName</option>
        </select>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
<br><br>
<?php if (!empty($arr)) { ?>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered table-striped custab">
            <thead>
                <tr>
                    <?php foreach ($table_head as $th) { ?>
                        <th><?= $th ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arr as $tr) { ?>
                    <tr>
                        <?php foreach ($tr as $td) { ?>
                            <td><?= $td ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <p class="text-info">No results!</p>
<?php } ?>
