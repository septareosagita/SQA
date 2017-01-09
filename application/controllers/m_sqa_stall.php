<?php

/*
 * @author: irfan@mediantarakreasindo.com
 * @created: March, 23 2011 - 10:20
 */

class m_sqa_stall extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('V_SQA_STALL', 'STALL_NO');
        $this->fieldseq = array(
            0 => 'PLANT_CD',
            1 => 'STALL_NO',
            2 => 'STALL_DESC',
            3 => 'STALL_STS',
            4 => 'SHOP_ID',
            5 => 'Updateby',
            6 => 'Updatedt'
        );
    }

    function index() {
        redirect('m_sqa_stall/browse');
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
            $this->dm->init('M_SQA_STALL');
            foreach ($cek as $v) {
                $codekey = base64_decode(HexToAscii($v));
                $codekey_x = explode(';', $codekey);
                $PLANT_CD = $codekey_x[0];
                $STALL_NO = $codekey_x[1];                
                
                $delete_keys = array('PLANT_CD' => $PLANT_CD, 'STALL_NO'=> $STALL_NO);                
                $this->dm->delete($delete_keys);
            }
            redirect('m_sqa_stall/browse');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('m_sqa_stall/browse/search/' . AsciiToHex(base64_encode($searchkey)) . '/0/desc/');
            else
                redirect('m_sqa_stall/browse');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "STALL_NO LIKE '%" . $searchkey . "%' OR STALL_DESC LIKE '%" . $searchkey . "%'" : '';
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
        $browse_url = 'm_sqa_stall/browse/';
        $pagination_base_url = site_url('m_sqa_stall/browse/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('m_sqa_stall/browse/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'm_sqa_stall/browse/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_sqa_stall
        $data['list_m_sqa_stall'] = $this->dm->select($limit, $orderby, $condition);

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Stall';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_stall/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function change() {
        $PLANT_CD = $STALL_NO = $STALL_DESC = '';
        $STALL_STS = '0';
        $SHOP_ID = '';
        $todo = 'ADD';
        $err = '';
        
        // cek jika ada Key untuk EDIT
        $editkey = $this->uri->segment(3);
        if ($editkey != '') {
            $codekey = base64_decode(HexToAscii($editkey));
            $codekey_x = explode(';', $codekey);
            $PLANT_CD = $codekey_x[0];
            $STALL_NO = $codekey_x[1];

            $ds = $this->dm->select('', '', "PLANT_CD = '" . $PLANT_CD . "' and STALL_NO ='" . $STALL_NO . "'");
            $STALL_NO = $ds[0]->STALL_NO;
            $STALL_DESC = $ds[0]->STALL_DESC;
            $STALL_STS = $ds[0]->STALL_STS;
            $SHOP_ID = $ds[0]->SHOP_ID;
            $todo = 'EDIT';
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {

            $PLANT_CD = $this->input->post('PLANT_CD');
            $STALL_NO = $this->input->post('STALL_NO');
            $STALL_DESC = $this->input->post('STALL_DESC');
            $STALL_STS = $this->input->post('STALL_STS');
            $SHOP_ID = $this->input->post('SHOP_ID');
            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {

                $cekdata = $this->dm->select('', '', "STALL_NO = '" . $STALL_NO . "' AND PLANT_CD = '" . $PLANT_CD . "'", 'STALL_NO');
                if (count($cekdata) > 0) {
                    $err = 'Stall Number with selected Plant already defined';
                } else {
                    $data = array(
                        'PLANT_CD' => $PLANT_CD,
                        'STALL_NO' => $STALL_NO,
                        'STALL_DESC' => $STALL_DESC,
                        'STALL_STS' => $STALL_STS,
                        'SHOP_ID' => $SHOP_ID,
                        'Updateby' => get_user_info($this, 'USER_ID'),
                        'Updatedt' => get_date()
                    );
                    $this->dm->insert($data);
                    redirect('m_sqa_stall/browse');
                }
            } else {

                $update_keys = "PLANT_CD = '" . $PLANT_CD . "' AND STALL_NO = '" . $STALL_NO . "'";
                $data = array(
                    'STALL_DESC' => $STALL_DESC,
                    'STALL_STS' => $STALL_STS,
                    'SHOP_ID' => $SHOP_ID,
                    'Updateby' => get_user_info($this, 'USER_ID'),
                    'Updatedt' => get_date()
                );
                $this->dm->update($data, $update_keys);
                redirect('m_sqa_stall/browse');
            }
            
        }

        $data['PLANT_CD'] = $PLANT_CD;
        $data['STALL_NO'] = $STALL_NO;
        $data['STALL_DESC'] = $STALL_DESC;
        $data['STALL_STS'] = $STALL_STS;
        $data['SHOP_ID'] = $SHOP_ID;
        $data['err'] = $err;
        $data['todo'] = $todo;

        // list plant
        $this->dm->init('M_SQA_PLANT','PLANT_CD');
        $data['list_plant'] = $this->dm->select();
        
        // list available shop show
        $this->dm->init('M_SQA_SHOP','SHOP_ID');
        $data['list_shop_show'] = $this->dm->select('','',"SHOP_SHOW='0'");

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Maintenance';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_stall/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function erase() {
        $delete_keys = array('PLANT_CD' => $this->uri->segment(3), 'STALL_NO'=> $this->uri->segment(4));
        $this->dm->init('M_SQA_STALL');
        $this->dm->delete($delete_keys);
        redirect('m_sqa_stall/browse');
    }
    
    function load_stall() {
        // get stall available for this PLANT_CD
        $w = "STALL_STS = '0' AND PLANT_CD = '" . get_user_info($this, 'PLANT_CD') . "' AND SHOP_ID = '" . get_user_info($this, 'SHOP_ID') . "'";
        $this->dm->init('M_SQA_STALL', 'STALL_NO');
        $list_stall = $this->dm->select('','', $w);
        $out = '<select name="stall_no" id="stall_no">';
        if (count($list_stall)>0) {            
            $out .= '<option value="0">-- Select --</option>';
            foreach ($list_stall as $l) {
                $out .= '<option value="'.$l->STALL_NO.'">'.$l->STALL_DESC.'</option>';
            }
        } else {
            $out .= '<option value="0">-- No Stall Available --</option>';
        }
        $out .= '</select>';
        echo $out;
        
    }
}
?>