<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TextualPages extends ADMIN_Controller
{

    public function pageEdit($page = null)
    {
        $this->login_check();
        if ($page == null) {
            redirect('admin/pages');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Pages Manage';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['page'] = $this->AdminModel->getOnePageForEdit($page);
        if (empty($data['page'])) {
            redirect('admin/pages');
        }
        if (isset($_POST['updatePage'])) {
            $translations = array(
                'abbr' => $_POST['translations'],
                'name' => $_POST['name'],
                'description' => $_POST['description']
            );
            $this->AdminModel->setEditPageTranslations($translations, $_POST['pageId']);
            $this->saveHistory('Page ' . $_POST['pageId'] . ' updated!');
            redirect('admin/pageedit/' . $page);
        }

        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/pageEdit', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Edit page - ' . $page);
    }

    public function changePageStatus()
    {
        $this->login_check();
        $result = $this->AdminModel->changePageStatus($_POST['id'], $_POST['status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Page status Changed');
    }

}
