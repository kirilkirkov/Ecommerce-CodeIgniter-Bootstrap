<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function getTextualPages($activePages)
{
    $ci = & get_instance();
    $arr = $ci->config->item('no_dynamic_pages');
    $withDuplicates = array_merge($activePages, $arr);
    if (empty($activePages)) {
        return $activePages;
    }
    return array_diff($withDuplicates, array_diff_assoc($withDuplicates, array_unique($withDuplicates)));
}
