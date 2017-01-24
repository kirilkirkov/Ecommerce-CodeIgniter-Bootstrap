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

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Settings';
        $head['description'] = '!';
        $head['keywords'] = '';

        $this->postChecker();

        $data['siteLogo'] = $this->AdminModel->getValueStore('sitelogo');
        $data['naviText'] = $this->AdminModel->getValueStore('navitext');
        $data['footerCopyright'] = $this->AdminModel->getValueStore('footercopyright');
        $data['contactsPage'] = $this->AdminModel->getValueStore('contactspage');
        $data['footerContactAddr'] = $this->AdminModel->getValueStore('footerContactAddr');
        $data['footerContactPhone'] = $this->AdminModel->getValueStore('footerContactPhone');
        $data['footerContactEmail'] = $this->AdminModel->getValueStore('footerContactEmail');

        $data['footerSocialFacebook'] = $this->AdminModel->getValueStore('footerSocialFacebook');
        $data['footerSocialTwitter'] = $this->AdminModel->getValueStore('footerSocialTwitter');
        $data['footerSocialGooglePlus'] = $this->AdminModel->getValueStore('footerSocialGooglePlus');
        $data['footerSocialPinterest'] = $this->AdminModel->getValueStore('footerSocialPinterest');
        $data['footerSocialYoutube'] = $this->AdminModel->getValueStore('footerSocialYoutube');

        $data['contactsEmailTo'] = $this->AdminModel->getValueStore('contactsEmailTo');
        $data['googleMaps'] = $this->AdminModel->getValueStore('googleMaps');
        $data['footerAboutUs'] = $this->AdminModel->getValueStore('footerAboutUs');
        $data['shippingOrder'] = $this->AdminModel->getValueStore('shippingOrder');
        $data['addJs'] = $this->AdminModel->getValueStore('addJs');
        $data['publicQuantity'] = $this->AdminModel->getValueStore('publicQuantity');
        $data['publicDateAdded'] = $this->AdminModel->getValueStore('publicDateAdded');
        $data['googleApi'] = $this->AdminModel->getValueStore('googleApi');
        $data['outOfStock'] = $this->AdminModel->getValueStore('outOfStock');
        $data['moreInfoBtn'] = $this->AdminModel->getValueStore('moreInfoBtn');
        $data['showBrands'] = $this->AdminModel->getValueStore('showBrands');
        $data['showInSlider'] = $this->AdminModel->getValueStore('showInSlider');
        $data['cookieLawInfo'] = $this->getCookieLaw();
        $data['languages'] = $this->AdminModel->getLanguages();
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
                $this->AdminModel->setValueStore('sitelogo', $newImage);
                $this->saveHistory('Change site logo');
                $this->session->set_flashdata('resultSiteLogoPublish', 'New logo is set!');
            }
            redirect('admin/settings');
        }
        if (isset($_POST['naviText'])) {
            $this->AdminModel->setValueStore('navitext', $_POST['naviText']);
            $this->session->set_flashdata('resultNaviText', 'New navigation text is set!');
            $this->saveHistory('Change navigation text');
            redirect('admin/settings');
        }
        if (isset($_POST['footerCopyright'])) {
            $this->AdminModel->setValueStore('footercopyright', $_POST['footerCopyright']);
            $this->session->set_flashdata('resultFooterCopyright', 'New navigation text is set!');
            $this->saveHistory('Change footer copyright');
            redirect('admin/settings');
        }
        if (isset($_POST['contactsPage'])) {
            $this->AdminModel->setValueStore('contactspage', $_POST['contactsPage']);
            $this->session->set_flashdata('resultContactspage', 'Contacts page is updated!');
            $this->saveHistory('Change contacts page');
            redirect('admin/settings');
        }
        if (isset($_POST['footerContacts'])) {
            $this->AdminModel->setValueStore('footerContactAddr', $_POST['footerContactAddr']);
            $this->AdminModel->setValueStore('footerContactPhone', $_POST['footerContactPhone']);
            $this->AdminModel->setValueStore('footerContactEmail', $_POST['footerContactEmail']);
            $this->session->set_flashdata('resultfooterContacts', 'Contacts on footer are updated!');
            $this->saveHistory('Change footer contacts');
            redirect('admin/settings');
        }
        if (isset($_POST['footerSocial'])) {
            $this->AdminModel->setValueStore('footerSocialFacebook', $_POST['footerSocialFacebook']);
            $this->AdminModel->setValueStore('footerSocialTwitter', $_POST['footerSocialTwitter']);
            $this->AdminModel->setValueStore('footerSocialGooglePlus', $_POST['footerSocialGooglePlus']);
            $this->AdminModel->setValueStore('footerSocialPinterest', $_POST['footerSocialPinterest']);
            $this->AdminModel->setValueStore('footerSocialYoutube', $_POST['footerSocialYoutube']);
            $this->session->set_flashdata('resultfooterSocial', 'Social on footer are updated!');
            $this->saveHistory('Change footer contacts');
            redirect('admin/settings');
        }
        if (isset($_POST['googleMaps'])) {
            $this->AdminModel->setValueStore('googleMaps', $_POST['googleMaps']);
            $this->AdminModel->setValueStore('googleApi', $_POST['googleApi']);
            $this->session->set_flashdata('resultGoogleMaps', 'Google maps coordinates and api key are updated!');
            $this->saveHistory('Update Google Maps Coordinates and Api Key');
            redirect('admin/settings');
        }
        if (isset($_POST['footerAboutUs'])) {
            $this->AdminModel->setValueStore('footerAboutUs', $_POST['footerAboutUs']);
            $this->session->set_flashdata('resultFooterAboutUs', 'Footer about us text changed!');
            $this->saveHistory('Change footer about us info');
            redirect('admin/settings');
        }
        if (isset($_POST['contactsEmailTo'])) {
            $this->AdminModel->setValueStore('contactsEmailTo', $_POST['contactsEmailTo']);
            $this->session->set_flashdata('resultEmailTo', 'Email changed!');
            $this->saveHistory('Change where going emails from contact form');
            redirect('admin/settings');
        }
        if (isset($_POST['shippingOrder'])) {
            $this->AdminModel->setValueStore('shippingOrder', $_POST['shippingOrder']);
            $this->session->set_flashdata('shippingOrder', 'Shipping Order price chagned!');
            $this->saveHistory('Change Shipping free for order more than ' . $_POST['shippingOrder']);
            redirect('admin/settings');
        }
        if (isset($_POST['addJs'])) {
            $this->AdminModel->setValueStore('addJs', $_POST['addJs']);
            $this->session->set_flashdata('addJs', 'JavaScript code is added');
            $this->saveHistory('Add JS to website');
            redirect('admin/settings');
        }
        if (isset($_POST['publicQuantity'])) {
            $this->AdminModel->setValueStore('publicQuantity', $_POST['publicQuantity']);
            $this->session->set_flashdata('publicQuantity', 'Public quantity visibility changed');
            $this->saveHistory('Change publicQuantity visibility');
            redirect('admin/settings');
        }
        if (isset($_POST['publicDateAdded'])) {
            $this->AdminModel->setValueStore('publicDateAdded', $_POST['publicDateAdded']);
            $this->session->set_flashdata('publicDateAdded', 'Public date added visibility changed');
            $this->saveHistory('Change public date added visibility');
            redirect('admin/settings');
        }
        if (isset($_POST['outOfStock'])) {
            $this->AdminModel->setValueStore('outOfStock', $_POST['outOfStock']);
            $this->session->set_flashdata('outOfStock', 'Out of stock settings visibility change');
            $this->saveHistory('Change visibility of final checkout page');
            redirect('admin/settings');
        }
        if (isset($_POST['moreInfoBtn'])) {
            $this->AdminModel->setValueStore('moreInfoBtn', $_POST['moreInfoBtn']);
            $this->session->set_flashdata('moreInfoBtn', 'Button More Information visibility is changed');
            $this->saveHistory('Change visibility of More Information button in products list');
            redirect('admin/settings');
        }
        if (isset($_POST['showBrands'])) {
            $this->AdminModel->setValueStore('showBrands', $_POST['showBrands']);
            $this->session->set_flashdata('showBrands', 'Brands visibility changed');
            $this->saveHistory('Brands visibility changed');
            redirect('admin/settings');
        }
        if (isset($_POST['showInSlider'])) {
            $this->AdminModel->setValueStore('showInSlider', $_POST['showInSlider']);
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
        $this->AdminModel->setCookieLaw($post);
    }

    private function getCookieLaw()
    {
        return $this->AdminModel->getCookieLaw();
    }

}
