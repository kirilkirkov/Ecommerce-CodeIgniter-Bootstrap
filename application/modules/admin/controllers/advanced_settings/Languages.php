<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Languages extends ADMIN_Controller
{

    public function index()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $result = $this->AdminModel->deleteLanguage($_GET['delete']);
            if ($result == true) {
                $this->saveHistory('Delete language id - ' . $_GET['delete']);
                $this->session->set_flashdata('result_delete', 'Language is deleted!');
            } else {
                $this->session->set_flashdata('result_delete', 'Problem with language delete!');
            }
            redirect('admin/languages');
        }
        if (isset($_GET['editLang'])) {
            $num = $this->AdminModel->countLangs($_GET['editLang']);
            if ($num == 0) {
                redirect('admin/languages');
            }
            $langFiles = $this->getLangFolderForEdit();
        }
        if (isset($_POST['goDaddyGo'])) {
            $this->saveLanguageFiles();
            redirect('admin/languages');
        }
        if (!is_writable('application' . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR)) {
            $data['writable'] = 'Languages folder is not writable!';
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Languages';
        $head['description'] = '!';
        if (isset($langFiles)) {
            $data['arrPhpFiles'] = $langFiles[0];
            $data['arrJsFiles'] = $langFiles[1];
        }
        $head['keywords'] = '';
        $data['languages'] = $this->AdminModel->getLanguages();

        if (isset($_POST['name']) && isset($_POST['abbr'])) {
            $dublicates = $this->AdminModel->countLangs($_POST['name'], $_POST['abbr']);
            if ($dublicates == 0) {
                $config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'lang_flags' . DIRECTORY_SEPARATOR . '';
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('userfile')) {
                    $error = $this->upload->display_errors();
                    log_message('error', 'Language image upload error: ' . $error);
                } else {
                    $img = $this->upload->data();
                    if ($img['file_name'] != null) {
                        $_POST['flag'] = $img['file_name'];
                    }
                }
                $result = $this->AdminModel->setLanguage($_POST);
                if ($result === true) {
                    $this->createLangFolders();
                    $this->session->set_flashdata('result_add', 'Language is added!');
                    $this->saveHistory('Create language - ' . $_POST['abbr']);
                } else {
                    $this->session->set_flashdata('result_add', 'Problem with language add!');
                }
            } else
                $this->session->set_flashdata('result_add', 'This language exsists!');
            redirect('admin/languages');
        }
        $data['max_input_vars'] = ini_get('max_input_vars');
        $this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/languages', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to languages');
    }

    private function saveLanguageFiles()
    {
        $i = 0;
        $prevFile = 'none';
        $phpFileInclude = "<?php \n";
        foreach ($_POST['php_files'] as $phpFile) {
            if ($phpFile != $prevFile && $i > 0) {
                savefile($prevFile, $phpFileInclude);
                $phpFileInclude = "<?php \n";
            }
            $phpFileInclude .= '$lang[\'' . htmlentities($_POST['php_keys'][$i]) . '\'] = \'' . htmlentities($_POST['php_values'][$i]) . '\';' . "\n";
            $prevFile = $phpFile;
            $i++;
        }
        savefile($phpFile, $phpFileInclude);


        $i = 0;
        $prevFile = 'none';
        $jsFileInclude = "var lang = { \n";
        foreach ($_POST['js_files'] as $jsFile) {
            if ($jsFile != $prevFile && $i > 0) {
                $jsFileInclude .= "};";
                savefile($prevFile, $jsFileInclude);
                $jsFileInclude = "var lang = { \n";
            }
            $jsFileInclude .= htmlentities($_POST['js_keys'][$i]) . ':' . '"' . htmlentities($_POST['js_values'][$i]) . '",' . "\n";
            $prevFile = $jsFile;
            $i++;
        }
        $jsFileInclude .= "};";
        savefile($jsFile, $jsFileInclude);
    }

    private function getLangFolderForEdit()
    {
        $langFiles = array();
        $files = rreadDir('application' . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR . '' . $_GET['editLang'] . DIRECTORY_SEPARATOR);
        $arrPhpFiles = $arrJsFiles = array();
        foreach ($files as $ext => $filesLang) {
            foreach ($filesLang as $fileLang) {
                if ($ext == 'php') {
                    require $fileLang;
                    if (isset($lang)) {
                        $arrPhpFiles[$fileLang] = $lang;
                        unset($lang);
                    }
                }
                if ($ext == 'js') {
                    $jsTrans = file_get_contents($fileLang);
                    preg_match_all('/(.+?)"(.+?)"/', $jsTrans, $PMA);
                    $arrJsFiles[$fileLang] = $PMA;
                    unset($PMA);
                }
            }
        }
        $langFiles[0] = $arrPhpFiles;
        $langFiles[1] = $arrJsFiles;
        return $langFiles;
    }

    private function createLangFolders()
    {
        $newLang = strtolower(trim($_POST['name']));
        if ($newLang != '') {
            $from = 'application' . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR . MY_DEFAULT_LANGUAGE_NAME;
            $to = 'application' . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR . $newLang;
            rcopy($from, $to);
        }
    }

}
