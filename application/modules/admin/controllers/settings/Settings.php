<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Settings extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Languages_model');
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Settings';
        $head['description'] = '!';
        $head['keywords'] = '';

        $this->postChecker();

        $data['siteLogo'] = $this->Home_admin_model->getValueStore('sitelogo');
        $data['naviText'] = $this->Home_admin_model->getValueStore('navitext');
        $data['footerCopyright'] = $this->Home_admin_model->getValueStore('footercopyright');
        $data['contactsPage'] = $this->Home_admin_model->getValueStore('contactspage');
        $data['footerContactAddr'] = $this->Home_admin_model->getValueStore('footerContactAddr');
        $data['footerContactPhone'] = $this->Home_admin_model->getValueStore('footerContactPhone');
        $data['footerContactEmail'] = $this->Home_admin_model->getValueStore('footerContactEmail');

        $data['footerSocialFacebook'] = $this->Home_admin_model->getValueStore('footerSocialFacebook');
        $data['footerSocialTwitter'] = $this->Home_admin_model->getValueStore('footerSocialTwitter');
        $data['footerSocialGooglePlus'] = $this->Home_admin_model->getValueStore('footerSocialGooglePlus');
        $data['footerSocialPinterest'] = $this->Home_admin_model->getValueStore('footerSocialPinterest');
        $data['footerSocialYoutube'] = $this->Home_admin_model->getValueStore('footerSocialYoutube');

        $data['contactsEmailTo'] = $this->Home_admin_model->getValueStore('contactsEmailTo');
        $data['googleMaps'] = $this->Home_admin_model->getValueStore('googleMaps');
        $data['footerAboutUs'] = $this->Home_admin_model->getValueStore('footerAboutUs');
        $data['shippingOrder'] = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['addJs'] = $this->Home_admin_model->getValueStore('addJs');
        $data['publicQuantity'] = $this->Home_admin_model->getValueStore('publicQuantity');
        $data['publicDateAdded'] = $this->Home_admin_model->getValueStore('publicDateAdded');
        $data['googleApi'] = $this->Home_admin_model->getValueStore('googleApi');
        $data['outOfStock'] = $this->Home_admin_model->getValueStore('outOfStock');
        $data['moreInfoBtn'] = $this->Home_admin_model->getValueStore('moreInfoBtn');
        $data['showBrands'] = $this->Home_admin_model->getValueStore('showBrands');
        $data['showInSlider'] = $this->Home_admin_model->getValueStore('showInSlider');
        $data['cookieLawInfo'] = $this->getCookieLaw();
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['law_themes'] = array_diff(scandir('.' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'imgs' . DIRECTORY_SEPARATOR . 'cookie-law-themes' . DIRECTORY_SEPARATOR), array('..', '.'));
        $data['cookieLawInfo'] = $this->getCookieLaw();
        $this->load->view('_parts/header', $head);
        $this->load->view('settings/settings', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Settings Page');
    }

    private function postChecker()
    {
        if (isset($_POST['uploadimage'])) {
            $config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'site_logo' . DIRECTORY_SEPARATOR;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1500;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('sitelogo')) {
                $this->session->set_flashdata('resultSiteLogoPublish', $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $newImage = $data['upload_data']['file_name'];
                $this->Home_admin_model->setValueStore('sitelogo', $newImage);
                $this->saveHistory('Change site logo');
                $this->session->set_flashdata('resultSiteLogoPublish', 'New logo is set!');
            }
            redirect('admin/settings');
        }
        if (isset($_POST['naviText'])) {
            $this->Home_admin_model->setValueStore('navitext', $_POST['naviText']);
            $this->session->set_flashdata('resultNaviText', 'New navigation text is set!');
            $this->saveHistory('Change navigation text');
            redirect('admin/settings');
        }
        if (isset($_POST['footerCopyright'])) {
            $this->Home_admin_model->setValueStore('footercopyright', $_POST['footerCopyright']);
            $this->session->set_flashdata('resultFooterCopyright', 'New navigation text is set!');
            $this->saveHistory('Change footer copyright');
            redirect('admin/settings');
        }
        if (isset($_POST['contactsPage'])) {
            $this->Home_admin_model->setValueStore('contactspage', $_POST['contactsPage']);
            $this->session->set_flashdata('resultContactspage', 'Contacts page is updated!');
            $this->saveHistory('Change contacts page');
            redirect('admin/settings');
        }
        if (isset($_POST['footerContacts'])) {
            $this->Home_admin_model->setValueStore('footerContactAddr', $_POST['footerContactAddr']);
            $this->Home_admin_model->setValueStore('footerContactPhone', $_POST['footerContactPhone']);
            $this->Home_admin_model->setValueStore('footerContactEmail', $_POST['footerContactEmail']);
            $this->session->set_flashdata('resultfooterContacts', 'Contacts on footer are updated!');
            $this->saveHistory('Change footer contacts');
            redirect('admin/settings');
        }
        if (isset($_POST['footerSocial'])) {
            $this->Home_admin_model->setValueStore('footerSocialFacebook', $_POST['footerSocialFacebook']);
            $this->Home_admin_model->setValueStore('footerSocialTwitter', $_POST['footerSocialTwitter']);
            $this->Home_admin_model->setValueStore('footerSocialGooglePlus', $_POST['footerSocialGooglePlus']);
            $this->Home_admin_model->setValueStore('footerSocialPinterest', $_POST['footerSocialPinterest']);
            $this->Home_admin_model->setValueStore('footerSocialYoutube', $_POST['footerSocialYoutube']);
            $this->session->set_flashdata('resultfooterSocial', 'Social on footer are updated!');
            $this->saveHistory('Change footer contacts');
            redirect('admin/settings');
        }
        if (isset($_POST['googleMaps'])) {
            $this->Home_admin_model->setValueStore('googleMaps', $_POST['googleMaps']);
            $this->Home_admin_model->setValueStore('googleApi', $_POST['googleApi']);
            $this->session->set_flashdata('resultGoogleMaps', 'Google maps coordinates and api key are updated!');
            $this->saveHistory('Update Google Maps Coordinates and Api Key');
            redirect('admin/settings');
        }
        if (isset($_POST['footerAboutUs'])) {
            $this->Home_admin_model->setValueStore('footerAboutUs', $_POST['footerAboutUs']);
            $this->session->set_flashdata('resultFooterAboutUs', 'Footer about us text changed!');
            $this->saveHistory('Change footer about us info');
            redirect('admin/settings');
        }
        if (isset($_POST['contactsEmailTo'])) {
            $this->Home_admin_model->setValueStore('contactsEmailTo', $_POST['contactsEmailTo']);
            $this->session->set_flashdata('resultEmailTo', 'Email changed!');
            $this->saveHistory('Change where going emails from contact form');
            redirect('admin/settings');
        }
        if (isset($_POST['shippingOrder'])) {
            $this->Home_admin_model->setValueStore('shippingOrder', $_POST['shippingOrder']);
            $this->session->set_flashdata('shippingOrder', 'Shipping Order price chagned!');
            $this->saveHistory('Change Shipping free for order more than ' . $_POST['shippingOrder']);
            redirect('admin/settings');
        }
        if (isset($_POST['addJs'])) {
            $this->Home_admin_model->setValueStore('addJs', $_POST['addJs']);
            $this->session->set_flashdata('addJs', 'JavaScript code is added');
            $this->saveHistory('Add JS to website');
            redirect('admin/settings');
        }
        if (isset($_POST['publicQuantity'])) {
            $this->Home_admin_model->setValueStore('publicQuantity', $_POST['publicQuantity']);
            $this->session->set_flashdata('publicQuantity', 'Public quantity visibility changed');
            $this->saveHistory('Change publicQuantity visibility');
            redirect('admin/settings');
        }
        if (isset($_POST['publicDateAdded'])) {
            $this->Home_admin_model->setValueStore('publicDateAdded', $_POST['publicDateAdded']);
            $this->session->set_flashdata('publicDateAdded', 'Public date added visibility changed');
            $this->saveHistory('Change public date added visibility');
            redirect('admin/settings');
        }
        if (isset($_POST['outOfStock'])) {
            $this->Home_admin_model->setValueStore('outOfStock', $_POST['outOfStock']);
            $this->session->set_flashdata('outOfStock', 'Out of stock settings visibility change');
            $this->saveHistory('Change visibility of final checkout page');
            redirect('admin/settings');
        }
        if (isset($_POST['moreInfoBtn'])) {
            $this->Home_admin_model->setValueStore('moreInfoBtn', $_POST['moreInfoBtn']);
            $this->session->set_flashdata('moreInfoBtn', 'Button More Information visibility is changed');
            $this->saveHistory('Change visibility of More Information button in products list');
            redirect('admin/settings');
        }
        if (isset($_POST['showBrands'])) {
            $this->Home_admin_model->setValueStore('showBrands', $_POST['showBrands']);
            $this->session->set_flashdata('showBrands', 'Brands visibility changed');
            $this->saveHistory('Brands visibility changed');
            redirect('admin/settings');
        }
        if (isset($_POST['showInSlider'])) {
            $this->Home_admin_model->setValueStore('showInSlider', $_POST['showInSlider']);
            $this->session->set_flashdata('showInSlider', 'In Slider products visibility changed');
            $this->saveHistory('In Slider products visibility changed');
            redirect('admin/settings');
        }
        if (isset($_POST['setCookieLaw'])) {
            unset($_POST['setCookieLaw']);
            $this->setCookieLaw($_POST);
            $this->saveHistory('Cookie law information changed');
            redirect('admin/settings');
        }
    }

    private function setCookieLaw($post)
    {
        $this->Home_admin_model->setCookieLaw($post);
    }

    private function getCookieLaw()
    {
        return $this->Home_admin_model->getCookieLaw();
    }

}
