<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>
<div class="container" id="contacts">
    <div class="body">
        <div class="jumbotron jumbotron-sm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h1 class="h1">
                            <?= lang('contact_us') ?> <small><?= lang('contact_us_feel_free') ?></small></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <?php
                if ($this->session->flashdata('resultSend')) {
                    ?>
                    <hr>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultSend') ?></div>
                    <hr>
                <?php }
                ?>
                <div class="well well-sm">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        <?= lang('name') ?></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required="required" />
                                </div>
                                <div class="form-group">
                                    <label for="email">
                                        <?= lang('email_address') ?></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required="required" /></div>
                                </div>
                                <div class="form-group">
                                    <label for="subject">
                                        <?= lang('subject') ?></label>
                                    <input type="text" name="subject" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        <?= lang('message') ?></label>
                                    <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                                              placeholder="<?= lang('message') ?>"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn cloth-bg-color pull-right" id="btnContactUs">
                                    <?= lang('send_message') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <form>
                    <legend><i class="fa fa-info" aria-hidden="true"></i> <?= lang('our_office') ?></legend>
                    <address>
                        <?= $contactsPage ?>
                    </address>
                </form>
            </div>
        </div>
        <?php if (trim($googleApi) != null && trim($googleMaps) != null) { ?>
            <div id="map"></div>
            <?php $coordinates = explode(',', $googleMaps); ?>
            <script src="https://maps.googleapis.com/maps/api/js?key=<?= $googleApi ?>"></script>
            <script>
                function initialize() {
                    var myLatlng = new google.maps.LatLng(<?= $coordinates[0] ?>, <?= $coordinates[1] ?>);
                    var mapOptions = {
                        zoom: 10,
                        center: myLatlng
                    }
                    var map = new google.maps.Map(document.getElementById("map"), mapOptions);
                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        title: "Here we are!"
                    });
                    marker.setMap(map);
                }
                google.maps.event.addDomListener(window, 'load', initialize);
            </script>
        <?php } ?>
        <div class="bottom-30"></div>
        <?php include 'bodyFooter.php' ?>
    </div>
</div>