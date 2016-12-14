<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function rcopy($from, $to)
{
    if (file_exists($to))
        rrmdir($to);
    if (is_dir($from)) {
        mkdir($to, 0777, true);
        $files = scandir($from);
        foreach ($files as $file)
            if ($file != "." && $file != "..")
                rcopy("$from/$file", "$to/$file");
    }
    else if (file_exists($from))
        copy($from, $to);
    chmod($to, 0777);
}
