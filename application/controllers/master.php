<?php

class master extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        if ($this->session->userdata('user_info') == '') redirect('welcome/out');
    }

    function index() {
        $data['page_title'] = 'Master Maintenance';

        // get sub menu
        $menu_ctrl = $this->uri->segment(1);
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $m = $this->dm->select('', '', "MENU_CTRL = '" . $menu_ctrl . "'", 'MENU_ID');
        $m_sub = array();
        if (count($m) > 0) {
            $menu_id = $m[0]->MENU_ID;
            $m_sub = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '" . $menu_id . "'");
        }
        $data['m_sub'] = $m_sub;

        $this->load->view('header', $data);
        $this->load->view('master');
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

}

?>
