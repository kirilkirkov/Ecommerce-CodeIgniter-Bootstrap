<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* Set internal character encoding to UTF-8 */
mb_internal_encoding("UTF-8");

class Loader extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
    }

    /*
     * Load language javascript file
     */

    public function jsFile($file = null)
    {
        $contents = file_get_contents('./application/language/' . MY_LANGUAGE_FULL_NAME . '/js/' . $file);
        if (!$contents) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        echo $contents;
    }

    /*
     * Load css generated from administration -> styles
     */

    public function cssStyle()
    {
        $this->load->Model('admin/AdminModel');
        $style = $this->AdminModel->getValueStore('newStyle');
        if ($style == null) {
            $template = $this->template;
            $style = file_get_contents(VIEWS_DIR . $template . '/assets/css/default-gradient.css');
            if (!$style) {
                header('HTTP/1.1 404 Not Found');
                return;
            }
        }
        header("Content-type: text/css; charset: UTF-8");
        echo $style;
    }

    /*
     * Load css file for template
     * Can call css file in folder /assets/css/ with templatecss/filename.css
     */

    public function templateCss($file)
    {
        $template = $this->template;
        $style = file_get_contents(VIEWS_DIR . $template . '/assets/css/' . $file);
        if (!$style) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        header("Content-type: text/css; charset: UTF-8");
        echo $style;
    }

    /*
     * Load js file for template
     * Can call css file in folder /assets/js/ with templatecss/filename.js
     */

    public function templateJs($file)
    {
        $template = $this->template;
        $js = file_get_contents(VIEWS_DIR . $template . '/assets/js/' . $file);
        if (!$js) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        echo $js;
    }

    /*
     * Load images comming with template in folder /assets/imgs/
     * Can call from view with template/imgs/filename.jpg
     */

    public function templateCssImage($file, $template = null)
    {
        if ($template == null) {
            $template = $this->template;
        } else {
            $template = '/templates/' . $template . '/';
        }
        $path = VIEWS_DIR . $template . '/assets/imgs/' . $file;
        $img = file_get_contents($path);
        if (!$img) {
            header('HTTP/1.1 404 Not Found');
            return;
        }
        $image_mime = mime_content_type($path);
        header('Content-Type: ' . $image_mime . '  charset: UTF-8');
        echo $img;
    }

}
