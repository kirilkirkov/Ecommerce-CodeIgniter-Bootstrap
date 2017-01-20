<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                rrmdir($dir . DIRECTORY_SEPARATOR . $file);
                rmdir($dir);
            }
        }
    } else if (file_exists($dir)) {
        unlink($dir);
    }
}
