<?php

/*
 * @author: suhar@mediantarakreasindo.com
 * @created: March 24, 2011 - 11:03
 *
 * @modified by: irfan@mediantarakreasindo.com
 */

class m_sqa_running_text extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('V_SQA_RUNNING_TEXT', 'PLANT_CD');
        $this->fieldseq = array(
            0 => 'PLANT_CD',
            1 => 'RUNTEXT',
            2 => 'FONT_NM',
            3 => 'FONT_SIZE',
            4 => 'FONT_CLR',
            5 => 'BACKGROUND_CLR',
            6 => 'DATE_FROM',
            7 => 'DATE_TO',
            8 => 'Updateby',
            9 => 'Updatedt',
        );
        if ($this->session->userdata('user_info') == '') redirect('welcome/out');
    }

    function index() {
        redirect('m_sqa_running_text/browse');
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
            $this->dm->init('M_SQA_RUNNING_TEXT');
            foreach ($cek as $v) {
                $delete_keys = array('PLANT_CD' => $v);                
                $this->dm->delete($delete_keys);
            }
            redirect('m_sqa_running_text/browse');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('m_sqa_running_text/browse/search/' . AsciiToHex(base64_encode($searchkey)) . '/0/desc/');
            else
                redirect('m_sqa_running_text/browse');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "PLANT_CD LIKE '%" . $searchkey . "%' OR RUNTEXT LIKE '%" . $searchkey . "%'
            OR FONT_NM LIKE '%" . $searchkey . "%' " : '';
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
        $browse_url = 'm_sqa_running_text/browse/';
        $pagination_base_url = site_url('m_sqa_running_text/browse/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('m_sqa_running_text/browse/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'm_sqa_running_text/browse/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_sqa_running_text
        $data['list_m_sqa_running_text'] = $this->dm->select($limit, $orderby, $condition);

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Running Text';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_running_text/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function change() {
        $PLANT_CD = $RUNTEXT = $FONT_NM = $FONT_SIZE = '';
        $FONT_CLR = '000000';
        $BACKGROUND_CLR = 'ffffff';
        $DATE_FROM = $DATE_TO = date('d/m/Y');
        $todo = 'ADD';
        $err = '';

        // cek jika ada Key untuk EDIT
        $PLANT_CD = $this->uri->segment(3);
        if ($PLANT_CD != '') {
            $ds = $this->dm->select('', '', "PLANT_CD = '" . $PLANT_CD . "'");
            $RUNTEXT = $ds[0]->RUNTEXT;
            $FONT_NM = $ds[0]->FONT_NM;
            $FONT_SIZE = $ds[0]->FONT_SIZE;
            $FONT_CLR = $ds[0]->FONT_CLR;
            $BACKGROUND_CLR = $ds[0]->BACKGROUND_CLR;
            $DATE_FROM = conv_date('2', $ds[0]->DATE_FROM);
            $DATE_TO = conv_date('2', $ds[0]->DATE_TO);
            $todo = 'EDIT';
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {
            $this->dm->init('M_SQA_RUNNING_TEXT', 'PLANT_CD');
            $PLANT_CD = $this->input->post('PLANT_CD');
            $RUNTEXT = $this->input->post('RUNTEXT');
            $FONT_NM = $this->input->post('FONT_NM');
            $FONT_SIZE = $this->input->post('FONT_SIZE');
            $FONT_CLR = $this->input->post('FONT_CLR');
            $BACKGROUND_CLR = $this->input->post('BACKGROUND_CLR');
            $DATE_FROM = $this->input->post('DATE_FROM');
            $DATE_TO = $this->input->post('DATE_TO');
            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {
                $cek = $this->dm->select('', '', "PLANT_CD = '" . $PLANT_CD . "'");
                if (count($cek) > 0) {
                    $err = 'Running Text for Plant Code already defined';
                } else {
                    $data = array(
                        'PLANT_CD' => $PLANT_CD,
                        'RUNTEXT' => $RUNTEXT,
                        'FONT_NM' => $FONT_NM,
                        'FONT_SIZE' => $FONT_SIZE,
                        'FONT_CLR' => $FONT_CLR,
                        'BACKGROUND_CLR' => $BACKGROUND_CLR,
                        'DATE_FROM' => conv_date('1', $DATE_FROM),
                        'DATE_TO' => conv_date('1', $DATE_TO),
                        'Updateby' => get_user_info($this, 'USER_ID'),
                        'Updatedt' => get_date(),
                    );
                    $this->dm->insert($data);
                    redirect('m_sqa_running_text/browse');
                }
            } else {
                $update_keys = "PLANT_CD = '" . $PLANT_CD . "'";
                $data = array(
                    'PLANT_CD' => $PLANT_CD,
                    'RUNTEXT' => $RUNTEXT,
                    'FONT_NM' => $FONT_NM,
                    'FONT_SIZE' => $FONT_SIZE,
                    'FONT_CLR' => $FONT_CLR,
                    'BACKGROUND_CLR' => $BACKGROUND_CLR,
                    'DATE_FROM' => conv_date('1', $DATE_FROM),
                    'DATE_TO' => conv_date('1', $DATE_TO),
                    'Updateby' => get_user_info($this, 'USER_ID'),
                    'Updatedt' => get_date(),
                );
                $this->dm->update($data, $update_keys);
                redirect('m_sqa_running_text/browse');
            }
        }

        $data['PLANT_CD'] = $PLANT_CD;
        $data['RUNTEXT'] = $RUNTEXT;
        $data['FONT_NM'] = $FONT_NM;
        $data['FONT_SIZE'] = $FONT_SIZE;
        $data['FONT_CLR'] = $FONT_CLR;
        $data['BACKGROUND_CLR'] = $BACKGROUND_CLR;
        $data['DATE_FROM'] = $DATE_FROM;
        $data['DATE_TO'] = $DATE_TO;
        $data['todo'] = $todo;
        $data['err'] = $err;

        if ($this->session->flashdata('FLASH_MESSAGE') == '1') {
            $data['err'] = 'Error , Please complete the following fields';
        }

        // get list plant
        $this->dm->init('M_SQA_PLANT', 'PLANT_CD');
        $data['list_plant'] = $this->dm->select();

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Maintenance';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_running_text/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function erase() {
        $this->dm->init('M_SQA_RUNNING_TEXT');
        $delete_keys = array('PLANT_CD' => $this->uri->segment(3));
        $this->dm->delete($delete_keys);
        redirect('m_sqa_running_text/browse');
    }

    function preview() {
        $this->load->view('m_sqa_running_text/preview');
    }

}

?>