<?php

/*
 * @author: suhar@mediantarakreasindo.com
 * @created: March, 23 2011 - 10:20
 * @modified: irfan@mediantarakreasindo.com
 * 
 */

class m_sqa_shift extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('V_SQA_SHIFT','PLANT_CD');
        $this->fieldseq = array(
            0 => 'PLANT_CD',
            1 => 'SHIFTGRP_ID',
            2 => 'TIME_FROM',
            3 => 'TIME_TO',
            4 => 'DESCRIPTION',
            5 => 'Updateby',
            6 => 'Updatedt'
        );
        if ($this->session->userdata('user_info') == '') redirect('welcome/out');
    }

    function index() {
        redirect('m_sqa_shift/browse');
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
            $this->dm->init('M_SQA_SHIFT');
            foreach ($cek as $v) {
                $codekey = base64_decode(HexToAscii($v));
                $codekey_x = explode(';', $codekey);
                $PLANT_CD = $codekey_x[0];
                $SHIFTGRP_ID = $codekey_x[1];
                $delete_keys = array('SHIFTGRP_ID' => $SHIFTGRP_ID, 'PLANT_CD' => $PLANT_CD);
                $this->dm->delete($delete_keys);
            }
            redirect('m_sqa_shift/browse');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('m_sqa_shift/browse/search/' . AsciiToHex(base64_encode($searchkey)) . '/0/desc/');
            else
                redirect('m_sqa_shift/browse');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "PLANT_CD LIKE '%" . $searchkey . "%' " : '';
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
        $browse_url = 'm_sqa_shift/browse/';
        $pagination_base_url = site_url('m_sqa_shift/browse/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('m_sqa_shift/browse/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'm_sqa_shift/browse/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_sqa_shift
        $data['list_m_sqa_shift'] = $this->dm->select($limit, $orderby, $condition);

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Shift';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_shift/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function change() {
        $PLANT_CD = $SHIFTNO = $DESCRIPTION = '';
        $TIME_FROM = $TIME_TO = '00:00:00';
        $todo = 'ADD';
        $err = '';

        // cek jika ada Key untuk EDIT
        $PLANT_CD = $this->uri->segment(3);
        if ($PLANT_CD != '') {
            $codekey = base64_decode(HexToAscii($PLANT_CD));
            $codekey_x = explode(';', $codekey);
            $PLANT_CD = $codekey_x[0];
            $SHIFTNO = $codekey_x[1];

            $ds = $this->dm->select('', '', "PLANT_CD = '" . $PLANT_CD . "'and SHIFTNO = '".$SHIFTNO."'");
            $PLANT_CD = $ds[0]->PLANT_CD;
            $SHIFTNO = $ds[0]->SHIFTNO;
            //$TIME_FROM = $ds[0]->TIME_FROM;
            //$TIME_TO = $ds[0]->TIME_TO;
            $DESCRIPTION = $ds[0]->DESCRIPTION;
            $todo = 'EDIT';

            $TIME_FROM = substr($ds[0]->TIME_FROM, 0, 2) . ':' . substr($ds[0]->TIME_FROM, 2, 2) . ':' . substr($ds[0]->TIME_FROM, 4, 2);
            $TIME_TO = substr($ds[0]->TIME_TO, 0, 2) . ':' . substr($ds[0]->TIME_TO, 2, 2) . ':' . substr($ds[0]->TIME_TO, 4, 2);
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {
            $this->dm->init('M_SQA_SHIFT', 'PLANT_CD');

            $PLANT_CD = $this->input->post('PLANT_CD');
            $SHIFTNO = $this->input->post('SHIFTNO');
            $TIME_FROM = $this->input->post('TIME_FROM');
            $TIME_TO = $this->input->post('TIME_TO');
            $DESCRIPTION = $this->input->post('DESCRIPTION');
            $todo = $this->input->post('todo');                       

            if ($todo == 'ADD') {
                $cek = $this->dm->select('','',"PLANT_CD = '" . $PLANT_CD . "' AND SHIFTNO = '" . $SHIFTNO . "'");
                if (count($cek) > 0) {
                    $err = 'Shift already exist for Plant CD ' . $PLANT_CD . ' and Shift No ' . $SHIFTNO;
                } else {
                    $TIME_FROM = ($TIME_FROM != '') ? str_replace(':', '', $TIME_FROM) : '000000';
                    $TIME_TO = ($TIME_TO != '') ? str_replace(':', '', $TIME_TO) : '000000';

                    $data = array(
                        'PLANT_CD' => $PLANT_CD,
                        'SHIFTNO' => $SHIFTNO,
                        'TIME_FROM' => $TIME_FROM,
                        'TIME_TO' => $TIME_TO,
                        'DESCRIPTION' => $DESCRIPTION,
                        'Updateby' => get_user_info($this, 'USER_ID'),
                        'Updatedt' => get_date(),
                    );
                    $this->dm->insert($data);
                    redirect('m_sqa_shift/browse');
                }                
            } else {
                $TIME_FROM = ($TIME_FROM != '') ? str_replace(':', '', $TIME_FROM) : '000000';
                $TIME_TO = ($TIME_TO != '') ? str_replace(':', '', $TIME_TO) : '000000';
                
                $update_keys = "PLANT_CD = '" . $PLANT_CD . "' AND SHIFTNO = '" . $SHIFTNO . "'";
                $data = array(
                    'TIME_FROM' => $TIME_FROM,
                    'TIME_TO' => $TIME_TO,
                    'DESCRIPTION' => $DESCRIPTION,
                    'Updateby' => get_user_info($this, 'USER_ID'),
                    'Updatedt' => get_date(),
                );
                $this->dm->update($data, $update_keys);
                redirect('m_sqa_shift/browse');
            }
            
        }
        
        $data['PLANT_CD'] = $PLANT_CD;
        $data['SHIFTNO'] = $SHIFTNO;
        $data['TIME_FROM'] = $TIME_FROM;
        $data['TIME_TO'] = $TIME_TO;
        $data['DESCRIPTION'] = $DESCRIPTION;
        $data['todo'] = $todo;
        $data['err'] = $err;

        // get list plant
        $this->dm->init('M_SQA_PLANT', 'PLANT_CD');
        $data['list_plant'] = $this->dm->select();

        // get list shiftgrp
        $this->dm->init('M_SQA_SHIFTGRP', 'SHIFTGRP_ID');
        $data['list_shiftgrp'] = $this->dm->select();

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Shift';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_shift/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function erase() {
        $this->dm->init('M_SQA_SHIFT');
        $delete_keys = array('PLANT_CD' => $this->uri->segment(3),'SHIFTNO' => $this->uri->segment(4));
        $this->dm->delete($delete_keys);        
        redirect('m_sqa_shift/browse');
    }
}

?>