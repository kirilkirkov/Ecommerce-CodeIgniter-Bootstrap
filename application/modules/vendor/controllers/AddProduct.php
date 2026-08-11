<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class AddProduct extends VENDOR_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Products_model',
            'admin/Languages_model',
            'admin/Categories_model',
            'admin/Home_admin_model',
            'admin/Brands_model'
        ));
    }

    public function index($id = 0)
    {
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Products_model->getOneProduct($id, $this->vendor_id);
            $trans_load = $this->Products_model->getTranslations($id);
        }
        if (isset($_POST['setProduct'])) {
            $_POST['image'] = $this->uploadImage();
            $_POST['vendor_id'] = $this->vendor_id;
            $requiresApproval = $id == 0 && $this->Home_admin_model->getValueStore('requireProductApproval') == 1;
            $result = $this->Products_model->setProduct($_POST, $id, $requiresApproval ? 2 : 1);
            if ($result === true) {
                $result_msg = $requiresApproval ? lang('vendor_product_pending_approval') : lang('vendor_product_published');
            } else {
                $result_msg = lang('vendor_product_publish_err');
            }
            $this->session->set_flashdata('result_publish', $result_msg);
            redirect(LANG_URL . '/vendor/products');
        }
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_add_product');
        $head['description'] = lang('vendor_add_product');
        $head['keywords'] = '';
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories();
        $data['otherImgs'] = $this->loadOthersImages();
        $data['showBrands'] = $this->Home_admin_model->getValueStore('showBrands');
        if($data['showBrands'] == 1) {
            $data['brands'] = $this->Brands_model->getBrands();
        }
        $data['trans_load'] = $trans_load;
        $this->load->view('_parts/header', $head);
        $this->load->view('add_product', $data);
        $this->load->view('_parts/footer');
    }

    private function uploadImage()
    {
        $config['upload_path'] = './attachments/shop_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }

    /*
     * called from ajax
     */

    public function do_upload_others_images()
    {
        if ($this->input->is_ajax_request()) {
            $base_dir = realpath('./attachments/shop_images');
            if ($base_dir === false) {
                return;
            }
            $folder = basename($_POST['folder'] ?? '');
            if ($folder === '' || $folder === '.') {
                return;
            }
            $upath = $base_dir . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR;
            if (!file_exists($upath)) {
                mkdir($upath, 0755);
            }
            $resolved_dir = realpath($upath);
            if ($resolved_dir === false || strpos($resolved_dir . DIRECTORY_SEPARATOR, $base_dir . DIRECTORY_SEPARATOR) !== 0) {
                return;
            }

            $this->load->library('upload');

            $files = $_FILES;
            $cpt = count($_FILES['others']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                unset($_FILES);
                $_FILES['others']['name'] = $files['others']['name'][$i];
                $_FILES['others']['type'] = $files['others']['type'][$i];
                $_FILES['others']['tmp_name'] = $files['others']['tmp_name'][$i];
                $_FILES['others']['error'] = $files['others']['error'][$i];
                $_FILES['others']['size'] = $files['others']['size'][$i];

                $this->upload->initialize(array(
                    'upload_path' => $resolved_dir . DIRECTORY_SEPARATOR,
                    'allowed_types' => $this->allowed_img_types
                ));
                $this->upload->do_upload('others');
            }
        }
    }

    public function loadOthersImages()
    {
        $output = '';
        $base_dir = realpath('./attachments/shop_images');
        $folder = basename($_POST['folder'] ?? '');
        if ($base_dir !== false && isset($_POST['folder']) && $folder !== '' && $folder !== '.') {
            $dir = $base_dir . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR;
            $resolved_dir = realpath($dir);
            if ($resolved_dir !== false && strpos($resolved_dir . DIRECTORY_SEPARATOR, $base_dir . DIRECTORY_SEPARATOR) === 0 && is_dir($resolved_dir)) {
                if ($dh = opendir($resolved_dir)) {
                    $i = 0;
                    while (($file = readdir($dh)) !== false) {
                        if (is_file($resolved_dir . DIRECTORY_SEPARATOR . $file)) {
                            $output .= '
                                <div class="other-img" id="image-container-' . $i . '">
                                    <img src="' . base_url('attachments/shop_images/' . htmlspecialchars($folder, ENT_QUOTES, 'UTF-8') . '/' . $file) . '" style="width:100px; height: 100px;">
                                    <a href="javascript:void(0);" onclick="removeSecondaryProductImage(\'' . $file . '\', \'' . htmlspecialchars($folder, ENT_QUOTES, 'UTF-8') . '\', ' . $i . ')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                               ';
                        }
                        $i++;
                    }
                    closedir($dh);
                }
            }
        }
        if ($this->input->is_ajax_request()) {
            echo $output;
        } else {
            return $output;
        }
    }

    /*
     * called from ajax
     */

    public function removeSecondaryImage()
    {
        if ($this->input->is_ajax_request()) {
            $base_dir = realpath('./attachments/shop_images');
            if ($base_dir === false) {
                return;
            }
            $folder = basename($_POST['folder'] ?? '');
            $image  = basename($_POST['image'] ?? '');
            if ($folder === '' || $folder === '.' || $image === '') {
                return;
            }
            $img_path = $base_dir . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $image;
            $resolved = realpath($img_path);
            if ($resolved === false || strpos($resolved, $base_dir . DIRECTORY_SEPARATOR) !== 0) {
                return;
            }
            unlink($resolved);
        }
    }

}
