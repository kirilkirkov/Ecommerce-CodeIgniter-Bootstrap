<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
<div id="contacts">
    <div id="map"></div>
    <div class="container">
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
                <div class="contact-form">
                    <legend><?= lang('contact_details') ?></legend>
                    <form method="POST" action=""> 
                        <div class="form-group">
                            <label for="name">
                                <?= lang('name') ?></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required="required" />
                        </div>
                        <div class="form-group">
                            <label for="email">
                                <?= lang('email_address') ?></label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required="required" />
                        </div>
                        <div class="form-group">
                            <label for="subject">
                                <?= lang('subject') ?></label>
                            <input type="text" name="subject" class="form-control" >
                        </div> 
                        <div class="form-group">
                            <label for="name">
                                <?= lang('message') ?></label>
                            <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                                      placeholder="<?= lang('message') ?>"></textarea>
                        </div>  
                        <button type="submit" class="btn btn-black" id="btnContactUs">
                            <?= lang('send_message') ?>
                        </button> 
                    </form> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-details">
                    <legend><?= lang('contact_details') ?></legend>
                    <address>
                        <?= $contactspage ?>
                    </address>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (trim($googleApi) != null && trim($googleMaps) != null) {
        $coordinates = explode(',', $googleMaps);
        ?>
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
</div>