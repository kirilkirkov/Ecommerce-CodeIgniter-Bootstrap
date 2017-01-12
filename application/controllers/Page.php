<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->Model('Publicmodel');
    }

    public function index($page = null)
    {
        $this->goOut($page);
        $page = $this->Publicmodel->getOnePage($page);
        $this->goOut($page);
        $data = array();
        $head = array();
        $head['title'] = $page['name'];
        $head['description'] = character_limiter(strip_tags(trim($page['content'])), 120);
        $head['keywords'] = str_replace(" ", ",", $page['name']);
        $data['content'] = $page['content'];
        $this->render('dynPage', $head, $data);
    }

    private function goOut($page)
    {
        if ($page == null) {
            redirect();
        }
    }

}
