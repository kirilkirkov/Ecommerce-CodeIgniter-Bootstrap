<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        if (!in_array('blog', $this->nonDynPages)) {
            show_404();
        }
        $this->load->helper(array('pagination'));
        $this->load->Model('Admin_model');
        $this->arhives = $this->Articles_model->getArchives();
    }

    public function index($page = 0)
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Articles_model->getSeo('page_blog', $this->my_lang);
        $head['title'] = $arrSeo['title'];
        $head['description'] = $arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        if (isset($_GET['find'])) {
            $find = $_GET['find'];
        } else
            $find = null;
        if (isset($_GET['from']) && isset($_GET['to'])) {
            $month = $_GET;
        } else
            $month = null;
        $data['posts'] = $this->Admin_model->getPosts($this->my_lang, $this->num_rows, $page, $find, $month);
        $data['archives'] = $this->getBlogArchiveHtml();
        $data['bestSellers'] = $this->Articles_model->getbestSellers($this->my_lang);
        $rowscount = $this->Admin_model->postsCount($find);
        $data['links_pagination'] = pagination('blog', $rowscount, $this->num_rows);
        $this->render('blog', $head, $data);
    }

    public function viewPost($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            show_404();
        }
        $data = array();
        $head = array();
        $data['article'] = $this->Articles_model->getOnePost($this->my_lang, $id);
        $data['archives'] = $this->getBlogArchiveHtml();
        $head['title'] = $data['article']['title'];
        $head['description'] = url_title(character_limiter(strip_tags($data['article']['description']), 130));
        $head['keywords'] = str_replace(" ", ",", $data['article']['title']);
        $this->render('view_blog_post', $head, $data);
    }

    private function getBlogArchiveHtml()
    {
        $html = '
		<div class="alone title">
					<span>' . lang('archive') . '</span>
				</div>
				';
        if ($this->arhives !== false) {

            $html .= '<ul class="blog-artchive">';

            foreach ($this->arhives as $archive) {
                $html .= '
					<li class="item">» <a href="' . $this->lang_url . '/blog?from=' . $archive['mintime'] . '&to=' . $archive['maxtime'] . '">' . $archive['month'] . '</a></li>
				';
            }
            $html .= '</ul>';
        } else {
            $html = '<div class="alert alert-info">' . lang('no_archives') . '</div>';
        }
        return $html;
    }

}
