<?php

/*
 * @author: irfan@mediantarakreasindo.com
 * @created: March, 23 2011 - 10:20
 */

class m_sqa_shiftgrp extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm',true);
        $this->dm->init('V_SQA_SHIFTGRP', 'PLANT_CD');
        $this->fieldseq = array(
            0 => 'PLANT_CD',
            1 => 'SHIFTGRP_ID',
            2 => 'SHIFTTGRP_NM',
            3 => 'Updateby',
            4 => 'Updatedt',
        );
    }

    function index() {
        redirect('m_sqa_shiftgrp/browse');
    }

    function browse() {
        // inisialisasi variable
        $searchpaging = $condition = $searchkey = '';
        $page = 0;
        $using_search = false;
        $data['err'] = $this->session->flashdata('FLASH_MESSAGE');

        // deleting
        $cek = $this->input->post('cek');
        if ($cek) {
            foreach ($cek as $v) {
                $delete_keys = array('SHIFTGRP_ID' => $v);
                $this->dm->delete($delete_keys);
            }
            redirect('m_sqa_shiftgrp/browse');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('m_sqa_shiftgrp/browse/search/' . AsciiToHex(base64_encode($searchkey)) . '/0/desc/');
            else
                redirect('m_sqa_shiftgrp/browse');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "SHIFTGRP_ID LIKE '%" . $searchkey . "%' " : '';
        }
        $data['searchkey'] = $searchkey;

        // sorting & order
        $sf = sort_field($this, $using_search);
        $orderby = $sf[0];
        $data['sort'] = $sf[1];
        $data['sorttype'] = $sf[2];
        $sortseq = $sf[3];
        $sorttype = $sf[4];
        $page_segment = $sf[5];

        // setup site_url & browse_url for pagination & view
        $browse_url = 'm_sqa_shiftgrp/browse/';
        $pagination_base_url = site_url('m_sqa_shiftgrp/browse/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('m_sqa_shiftgrp/browse/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'm_sqa_shiftgrp/browse/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_sqa_shiftgrp
        $data['list_m_sqa_shiftgrp'] = $this->dm->select($limit, $orderby, $condition);

        $data['page_title'] = 'Master Shift Group';

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_sqa_shiftgrp/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function change() {
        $PLANT_CD = $SHIFTGRP_ID = $SHIFTTGRP_NM = '';
        $todo = 'ADD';
        $err = '';

        // cek jika ada Key untuk EDIT
        $keys = $this->uri->segment(3);
        if ($keys != '') {
            $codekey = base64_decode(HexToAscii($keys));
            $break = explode(';', $codekey);
            $PLANT_CD = $break[0];
            $SHIFTGRP_ID = $break[1];

            $ds = $this->dm->select('', '', "PLANT_CD = '" . $PLANT_CD . "' and SHIFTGRP_ID = '" . $SHIFTGRP_ID . "'");
            $PLANT_CD = $ds[0]->PLANT_CD;
            $SHIFTGRP_ID = $ds[0]->SHIFTGRP_ID;
            $SHIFTTGRP_NM = $ds[0]->SHIFTTGRP_NM;
            $todo = 'EDIT';
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {

            $PLANT_CD = $this->input->post('PLANT_CD');
            $SHIFTGRP_ID = $this->input->post('SHIFTGRP_ID');
            $SHIFTTGRP_NM = $this->input->post('SHIFTTGRP_NM');
            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {

                $cekdata = $this->dm->select('', '', "PLANT_CD = '" . $PLANT_CD . "' and SHIFTGRP_ID = '" . $SHIFTGRP_ID . "'", 'SHIFTGRP_ID');
                if (count($cekdata) > 0) {
                    $err = 'Shift Group ID already defined for selected Plant';
                } else {
                    $data = array(
                        'PLANT_CD' => $PLANT_CD,
                        'SHIFTGRP_ID' => $SHIFTGRP_ID,
                        'SHIFTTGRP_NM' => $SHIFTTGRP_NM,
                        'Updateby' => get_user_info($this, 'USER_ID'),
                        'Updatedt' => get_date(),
                    );
                    $this->dm->insert($data);
                    redirect('m_sqa_shiftgrp/browse');
                }
            } else {
                $update_keys = "PLANT_CD = '" . $PLANT_CD . "' and SHIFTGRP_ID = '" . $SHIFTGRP_ID . "'";
                $data = array(
                    'SHIFTTGRP_NM' => $SHIFTTGRP_NM,
                    'Updateby' => get_user_info($this, 'USER_ID'),
                    'Updatedt' => get_date(),
                );
                $this->dm->update($data, $update_keys);
                redirect('m_sqa_shiftgrp/browse');
            }
        }

        $data['PLANT_CD'] = $PLANT_CD;
        $data['SHIFTGRP_ID'] = $SHIFTGRP_ID;
        $data['SHIFTTGRP_NM'] = $SHIFTTGRP_NM;        
        $data['todo'] = $todo;
        $data['err'] = $err;

        // list plant
        $this->dm->init('M_SQA_PLANT', 'PLANT_CD');
        $data['list_plant'] = $this->dm->select();
        
        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_sqa_shiftgrp/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function erase() {
        $delete_keys = array('PLANT_CD' => $this->uri->segment(3));
        $this->dm->delete($delete_keys);
        $this->session->set_flashdata('FLASH_MESSAGE', 'SHIFTGRP HAS BEEN DELETED');
        redirect('m_sqa_shiftgrp/browse');
    }

}

?>