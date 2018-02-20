<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function convertCurrency($amount, $from, $to)
{
    if ($from == $to) {
        return number_format(round($amount, 3), 2);
    }
    $data = file_get_contents("https://finance.google.com/finance/converter?a=$amount&from=$from&to=$to");
    preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
    $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
    return number_format(round($converted, 3), 2);
}
