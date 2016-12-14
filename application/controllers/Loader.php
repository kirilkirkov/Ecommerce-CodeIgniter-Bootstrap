<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* Set internal character encoding to UTF-8 */
mb_internal_encoding("UTF-8");

class Loader extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
    }

    public function jsFile($file = null)
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

    public function cssStyle()
    {
        $this->load->Model('admin/AdminModel');
        $style = $this->AdminModel->getValueStore('newStyle');
        if ($style == null) {
            $style = file_get_contents('./assets/css/default-gradient.css');
            if (!$style) {
                header('HTTP/1.1 404 Not Found');
                return;
            }
        }
        header("Content-type: text/css; charset: UTF-8");
        echo $style;
    }

}
