<?php if ($this->session->flashdata('update_vend_err')) { ?>
    <div class="alert alert-danger"><?= implode('<br>', $this->session->flashdata('update_vend_err')) ?></div>
<?php } ?>
<?php if ($this->session->flashdata('update_vend_details')) { ?>
    <div class="alert alert-success"><?= $this->session->flashdata('update_vend_details') ?></div>
<?php } ?>
<div class="content">
    <script src="<?= base_url('assets/highcharts/highcharts.js') ?>"></script>
    <div id="container-by-month" style="min-width: 310px; height: 400px; margin: 0 auto;"></div>
    <script>
        /*
         * Chart for orders by mount/year 
         */
        $(function () {
            Highcharts.chart('container-by-month', {
                title: {
                    text: 'Monthly Orders',
                    x: -20
                },
                subtitle: {
                    text: 'Source: Orders table',
                    x: -20
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Orders'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                tooltip: {
                    valueSuffix: ' Orders'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [
<?php foreach ($ordersByMonth['years'] as $year) { ?>
                        {
                            name: '<?= $year ?>',
                            data: [<?= implode(',', $ordersByMonth['orders'][$year]) ?>]
                        },
<?php } ?>
                ]
            });
        });
    </script>
</div>