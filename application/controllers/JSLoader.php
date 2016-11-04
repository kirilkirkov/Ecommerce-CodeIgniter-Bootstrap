<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* Set internal character encoding to UTF-8 */
mb_internal_encoding("UTF-8");

class JSLoader extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
    }

    public function file($file = null)
    {
        if (!$file) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        $contents = file_get_contents('./application/language/' . MY_LANGUAGE_FULL_NAME . '/js/' . $file);
        if (!$contents) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        echo $contents;
    }

}
