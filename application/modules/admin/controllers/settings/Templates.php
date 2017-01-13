<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Templates extends ADMIN_Controller
{

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Templates';
        $head['description'] = '!';
        $head['keywords'] = '';
        if (isset($_POST['template'])) {
            $this->AdminModel->setValueStore('template', $_POST['template']);
            redirect('admin/templates');
        }
        $templates = scandir(TEMPLATES_DIR);
        foreach ($templates as $template) {
            if ($template != "." && $template != "..") {
                $data['templates'][] = $template;
            }
        }
        $data['seleced_template'] = $this->AdminModel->getValueStore('template');
        $this->load->view('_parts/header', $head);
        $this->load->view('settings/templates', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Templates Page');
    }

}
