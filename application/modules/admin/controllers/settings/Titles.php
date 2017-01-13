<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Titles extends ADMIN_Controller
{

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Titles / Descriptions';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['save'])) {
            $translations = array(
                'pages' => $_POST['pages'],
                'abbr' => $_POST['translations'],
                'title' => $_POST['title'],
                'description' => $_POST['description']
            );
            $this->AdminModel->setSeoPageTranslations($translations);
            $this->saveHistory('Changed Titles / Descriptions');
            $this->session->set_flashdata('result_publish', 'Saved successful!');
            redirect('admin/titles');
        }

        $data['seo_trans'] = $this->AdminModel->getSeoTranslations();
        $data['languages'] = $this->AdminModel->getLanguages();
        $data['seo_pages'] = $this->AdminModel->getSeoPages();
        $this->load->view('_parts/header', $head);
        $this->load->view('settings/titles', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Titles / Descriptions page');
    }

}
