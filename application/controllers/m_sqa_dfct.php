<?php

/*
 * @author: ryan@mediantarakreasindo.com
 * @created: March 24, 2011 - 11:03
 *
 * @modified by: irfan@mediantarakreasindo.com
 */

class m_sqa_dfct extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();        
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('M_SQA_DFCT', 'DFCT_ID');
        $this->fieldseq = array(
            0 => 'DFCT_ID',
            1 => 'DFCTNM',
            2 => 'CTG_GRP_ID',
            3 => 'CTG_ID',
            4 => 'Updateby',
            5 => 'Updatedt',         
        );
        if ($this->session->userdata('user_info') == '') redirect('welcome/out');
    }
    
     function index() {
        redirect('m_sqa_dfct/browse');
    }

    function browse() {
        $this->dm->init('V_SQA_DFCT','DFCT_ID');
        // inisialisasi variable
        $searchpaging = $condition = $searchkey = '';
        $page = 0;
        $using_search = false;
        $data['err'] = '';

        // deleting
        $cek = $this->input->post('cek');
        if ($cek) {
            $this->dm->init('M_SQA_DFCT');
            foreach ($cek as $v) {
                $delete_keys = array('DFCT_ID' => $v);
                $this->dm->delete($delete_keys);
            }
            redirect('m_sqa_dfct/browse');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('m_sqa_dfct/browse/search/' . AsciiToHex(base64_encode($searchkey)) . '/0/desc/');
            else
                redirect('m_sqa_dfct/browse');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "DFCT_ID LIKE '%" . $searchkey . "%' or DFCTNM LIKE '%" . $searchkey . "%'  or CTG_ID LIKE '%" . $searchkey . "%'  or Updateby LIKE '%" . $searchkey . "%'  or Updatedt LIKE '%" . $searchkey . "%'  or CTG_GRP_ID LIKE '%" . $searchkey . "%'" : '';
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
        $browse_url = 'm_sqa_dfct/browse/';
        $pagination_base_url = site_url('m_sqa_dfct/browse/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('m_sqa_dfct/browse/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'm_sqa_dfct/browse/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_sqa_dfct
        $this->dm->init('V_SQA_DFCT','DFCT_ID');
        $data['list_dfct'] = $this->dm->select($limit, $orderby, $condition);

        $data['page_title'] = 'Master Defect';

           $data['sesuatu'] = 'abcd';
        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_sqa_dfct/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function browse_pick() {
        // get list category
        $this->dm->init('M_SQA_CTG_GRP','CTG_GRP_ID');
        $data['list_ctg_grp'] = $this->dm->select();
        $data['list_ctg_grp_header'] = $this->dm->sql_self("select distinct SUBSTRING(CTG_GRP_NM, 1, 3) as grp_head from M_SQA_CTG_GRP ORDER BY grp_head asc");        
        
        
                        
        $this->load->view('header_plain');
        $this->load->view('m_sqa_dfct/browse_pick', $data);
        $this->load->view('footer_plain');
    }

    function load_dfct() {
        $s = $_POST['s'];
        $ctg_grp_id_head = $_POST['ctg_grp_id_head'];
        $ctg_grp_id = $_POST['ctg_grp_id'];
        $ctg_id = $_POST['ctg_id'];
        
        $this->dm->init('V_SQA_DFCT','DFCT_ID');
        $w = "(DFCT_ID LIKE '%" . $s . "%' or DFCTNM LIKE '%" . $s . "%')";
        
        if ($ctg_grp_id_head != '0') {
            $w .= " AND (CTG_GRP_NM LIKE '" . $ctg_grp_id_head . "%')";
        }
        
        if ($ctg_grp_id != '0') {
            $w .= " AND (CTG_GRP_ID = '" . $ctg_grp_id . "')";
        }
        
        if ($ctg_id != '0') {
            $w .= " AND (CTG_ID = '" . $ctg_id . "')";
        }
        $w .= " AND (
                    (VALID_FROM_CTG <= '" . date('Y-m-d') . "' AND VALID_TO_CTG >= '" . date('Y-m-d') . "')
                    AND
                    (VALID_FROM_CTG_GRP <= '" . date('Y-m-d') . "' AND VALID_TO_CTG_GRP >= '" . date('Y-m-d') . "')
                )";
        $data['list_dfct'] = $this->dm->select('','',$w);
        $this->load->view('m_sqa_dfct/browse_pick_detail', $data);
    }

    function get_dfct() {
        $dfct_id = $_POST['dfct_id'];
        $this->dm->init('V_SQA_DFCT','DFCT_ID');
        $w = "DFCT_ID = '" . $dfct_id . "'";
        $d = $this->dm->select('','',$w);
        if (count($d)>0) {
            $d = $d[0];
            
            $dfct_id = $dfct_id;
            $dfct = $d->DFCTNM;
            $rank_id = '';
            $rank_nm = '';
            $ctg_grp_id = $d->CTG_GRP_ID;
            $ctg_id = $d->CTG_ID;
            $ctg_nm = $d->CTG_NM;

            $result = array($dfct_id, $dfct, $rank_id, $rank_nm, $ctg_grp_id, $ctg_id, $ctg_nm);
            echo json_encode($result);

        } else {
            echo 0;
        }
    }

    function change() {
        $DFCT_ID = $DFCTNM = $CTG_ID = $CTG_GRP_ID = '';
        $todo = 'ADD';
        $err = '';

        // cek jika ada Key untuk EDIT
        $DFCT_ID = $this->uri->segment(3);
        if ($DFCT_ID != '') {
            $this->dm->init('V_SQA_DFCT','DFCT_ID');
            $ds = $this->dm->select('', '', "DFCT_ID = '" . $DFCT_ID . "'");
            $DFCT_ID = $ds[0]->DFCT_ID;
            $DFCTNM = $ds[0]->DFCTNM;            
            $CTG_ID = $ds[0]->CTG_ID;
            $CTG_GRP_ID = $ds[0]->CTG_GRP_ID;
            $todo = 'EDIT';
        } else {
            $DFCT_ID = $this->dm->generate_key('M_SQA_DFCT', 'DFCT_ID',7);
            //echo 'test; 7';
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {
            $this->dm->init('M_SQA_DFCT', 'DFCT_ID');

            $DFCT_ID = $this->input->post('DFCT_ID');
            $DFCTNM = $this->input->post('DFCTNM');            
            $CTG_ID = $this->input->post('CTG_ID');
            $CTG_GRP_ID = $this->input->post('ctg_grp_id');
            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {
                $cekdata = $this->dm->select('', '', "DFCT_ID = '" . $DFCT_ID . "'",'DFCT_ID');
                if (count($cekdata) > 0) {
                    // data sudah ada
                    $err = 'Defect ID already Exist in System';
                } else {
                    if ($DFCT_ID != '' && $DFCTNM != '' && $CTG_ID != '0') {
                        $data = array(
                            'DFCT_ID' => $DFCT_ID,
                            'DFCTNM' => $DFCTNM,                            
                            'CTG_ID' => $CTG_ID,
                            'CTG_GRP_ID' => $CTG_GRP_ID,
                            'Updateby' => get_user_info($this, 'USER_ID'),
                            'Updatedt' => get_date()
                            );
                        $this->dm->insert($data);
                        redirect('m_sqa_dfct/browse');
                    } else {
                        $err = 'Please input All Fields';
                    }
                }
            } else {
                $update_keys = "DFCT_ID = '" . $DFCT_ID . "'";
                $data = array(
                    'DFCTNM' => $DFCTNM,                    
                    'CTG_ID' => $CTG_ID,
                    'CTG_GRP_ID' => $CTG_GRP_ID,
                    'Updateby' => get_user_info($this, 'USER_ID'),
                    'Updatedt' => get_date()
                );
                $this->dm->update($data, $update_keys);
                redirect('m_sqa_dfct/browse');
            }
        }

        $data['DFCT_ID'] = $DFCT_ID;
        $data['DFCTNM'] = $DFCTNM;
        $data['CTG_ID'] = $CTG_ID;
        $data['CTG_GRP_ID'] = $CTG_GRP_ID;
        $data['todo'] = $todo;
        $data['err'] = $err;

        // get list rank
        $this->dm->init('M_SQA_RANK', 'RANK_ID');
        $data['list_rank'] = $this->dm->select();

        // get list category
        $this->dm->init('M_SQA_CTG_GRP', 'CTG_GRP_ID');
        $data['list_ctg_grp'] = $this->dm->select();
        
        $data['page_title'] = 'Master Defect';

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_sqa_dfct/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

     function erase() {
        $this->dm->init('M_SQA_DFCT');
        $delete_keys = array('DFCT_ID' => $this->uri->segment(3));
        $this->dm->delete($delete_keys);
        redirect('m_sqa_dfct/browse');
    }
    
    function get_ctg_grp() {
        $ctg_grp_id_head = $_POST['ctg_grp_id_head'];
        $ctg_grp_id = $_POST['ctg_grp_id'];
        $this->dm->init('M_SQA_CTG_GRP','CTG_GRP_ID');
        $w = "CTG_GRP_NM LIKE '" . $ctg_grp_id_head . "%' AND 
            (
                VALID_FROM <= '" . date('Y-m-d') . "' AND VALID_TO >= '" . date('Y-m-d') . "'
            )"
            ;
        $ctg_grp = $this->dm->select('','CTG_GRP_ID ASC',$w);        
        $out = '<select name="ctg_grp_id" id="ctg_grp_id" onchange="change_ctg_grp(0)">';
        $out .= '<option value="0">-- All --</option>';
        if (count($ctg_grp) > 0) {
            foreach ($ctg_grp as $c) {
                $sel = ($c->CTG_GRP_ID == $ctg_grp_id) ? 'selected="selected"' : '';
                $out .= '<option value="'.$c->CTG_GRP_ID.'" '.$sel.'>'.$c->CTG_GRP_NM.'</option>';
            }
        }
        $out .= '</select>';
        echo $out;
    }

    function get_ctg() {
        $ctg_grp_id = $_POST['ctg_grp_id'];
        $ctg_id = $_POST['ctg_id'];
        $this->dm->init('M_SQA_CTG','CTG_ID');
        $w = "CTG_GRP_ID = '" . $ctg_grp_id . "' AND (VALID_FROM <= '" . date('Y-m-d') . "' AND VALID_TO >= '" . date('Y-m-d') . "')";
        $ctgs = $this->dm->select('','',$w);
        $out = '<sup>- empty category -</sup>';
        if (count($ctgs)>0){
            $out = '<select name="CTG_ID" id="ctg_id" onchange="check_btn_add();">';
            foreach ($ctgs as $c) {
                $sel = ($c->CTG_ID == $ctg_id) ? 'selected="selected"' : '';
                $out .= '<option value="'.$c->CTG_ID.'" '.$sel.'>'.$c->CTG_NM.'</option>';
            }
            $out .= '</select>';
        }
        echo $out;
    }
    
    function add_dfct() {
        $dfctnm = $_POST['dfctnm'];
        $ctg_id = $_POST['ctg_id'];
        $ctg_grp_id = $_POST['ctg_grp_id'];
        $DFCT_ID = $this->dm->generate_key('M_SQA_DFCT', 'DFCT_ID',7);
        $data = array(
            'DFCT_ID' => $DFCT_ID,
            'DFCTNM' => $dfctnm,                            
            'CTG_ID' => $ctg_id,
            'CTG_GRP_ID' => $ctg_grp_id,
            'Updateby' => get_user_info($this, 'USER_ID'),
            'Updatedt' => get_date()
            );
        $this->dm->insert($data);
        echo $DFCT_ID;
    }
    
    function edit_dfct() {        
        $this->dm->init('M_SQA_DFCT');
        $keys = "DFCT_ID = '" . $_POST['id_dfct'] . "'";
        $data = array('DFCTNM' => $_POST['detail_dfct']);
        $this->dm->update($data, $keys);
        echo 1;
    }
}

?>