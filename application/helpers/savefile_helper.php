<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function savefile($file, $info)
{
    $file = fopen($file, "w");
    fwrite($file, $info);
    fclose($file);
}
