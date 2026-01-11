<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    #map { height: 420px; width: 100%; }
</style>

<div class="mx-auto max-w-7xl px-4 py-8" id="contacts">
    <div class="rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8 text-white shadow-xl">
        <h1 class="text-2xl font-bold tracking-tight md:text-3xl"><?= lang('contact_us') ?></h1>
        <p class="mt-2 text-sm text-white/70"><?= lang('contact_us_feel_free') ?></p>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-12">
        <div class="lg:col-span-8">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <?php if ($this->session->flashdata('resultSend')) { ?>
                    <div class="mb-5 rounded-2xl bg-sky-50 p-4 text-sm text-slate-800 ring-1 ring-sky-200">
                        <?= $this->session->flashdata('resultSend') ?>
                    </div>
                <?php } ?>

                <form method="POST" action="" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label for="name" class="text-sm font-semibold text-slate-700"><?= lang('name') ?></label>
                            <input type="text" name="name" id="name" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" placeholder="<?= lang('name') ?>" required="required" />
                        </div>
                        <div>
                            <label for="email" class="text-sm font-semibold text-slate-700"><?= lang('email_address') ?></label>
                            <input type="email" name="email" id="email" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" placeholder="<?= lang('email_address') ?>" required="required" />
                        </div>
                        <div class="md:col-span-2">
                            <label for="subject" class="text-sm font-semibold text-slate-700"><?= lang('subject') ?></label>
                            <input type="text" name="subject" id="subject" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" placeholder="<?= lang('subject') ?>" />
                        </div>
                        <div class="md:col-span-2">
                            <label for="message" class="text-sm font-semibold text-slate-700"><?= lang('message') ?></label>
                            <textarea name="message" id="message" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" rows="7" required="required" placeholder="<?= lang('message') ?>"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800" id="btnContactUs">
                            <?= lang('send_message') ?>
                            <i class="fa fa-paper-plane ml-2" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="text-sm font-semibold text-slate-900"><?= lang('our_office') ?></div>
                <div class="prose prose-slate mt-3 max-w-none text-sm">
                    <?= html_entity_decode($contactspage) ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (trim($googleApi) != null && trim($googleMaps) != null) { ?>
        <div class="mt-6 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
            <div id="map"></div>
        </div>
        <?php $coordinates = explode(',', $googleMaps); ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=<?= $googleApi ?>"></script>
        <script>
            function initialize() {
                var myLatlng = new google.maps.LatLng(<?= $coordinates[0] ?>, <?= $coordinates[1] ?>);
                var mapOptions = { zoom: 10, center: myLatlng };
                var map = new google.maps.Map(document.getElementById("map"), mapOptions);
                var marker = new google.maps.Marker({ position: myLatlng, title: "Here we are!" });
                marker.setMap(map);
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    <?php } ?>
</div>