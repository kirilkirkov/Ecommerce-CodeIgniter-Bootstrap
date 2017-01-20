<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function rreaddir($dir, &$array = array())
{
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            if (is_file($dir . $file)) {
                $path_info = pathinfo($dir . $file);
                $ext = strtolower($path_info['extension']);
                if ($ext == 'php' || $ext == 'js') {
                    $array[$ext][] = $dir . $file;
                }
            } elseif (is_dir($dir . $file)) {
                rreadDir($dir . $file . DIRECTORY_SEPARATOR, $array);
            }
        }
    }
    return $array;
}
