<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends MY_Controller {

    private $num_rows = 20;

    public function __construct() {
        parent::__construct();
		$this->load->library('email');
    }

    public function index() {
		$head = array();
		$data = array();
		$head['title'] = 'Title information?';
        $head['description'] = 'Description info';
        $head['keywords'] = 'key,words,for,seo';
		$this->render('contacts', $head, $data);
	}
}