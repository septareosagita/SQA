<?php

/*
 * @author: ryan@mediantarakreasindo.com
 * @created: March 24, 2011 - 11:03
 *
 * @modified by: irfan@mediantarakreasindo.com
 */

class m_sqa_ctg_grp extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();        
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('M_SQA_CTG_GRP', 'CTG_GRP_ID');
        $this->fieldseq = array(
            0 => 'CTG_GRP_ID',
            1 => 'CTG_GRP_NM',
            2 => 'CTG_GRP_DESC',
            3 => 'Updateby',
            4 => 'Updatedt',
            5 => 'VALID_FROM'
        );
        if ($this->session->userdata('user_info') == '') redirect('welcome/out');
    }

    function index() {
        redirect('m_sqa_ctg_grp/browse');
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
                $delete_keys = array('CTG_GRP_ID' => $v);
                // delete child and parent
                $this->dm->init('M_SQA_CTG');
                $this->dm->delete($delete_keys);
                $this->dm->init('M_SQA_CTG_GRP');
                $this->dm->delete($delete_keys);
            }
            redirect('m_sqa_ctg_grp/browse');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('m_sqa_ctg_grp/browse/search/' . AsciiToHex(base64_encode($searchkey)) . '/0/desc/');
            else
                redirect('m_sqa_ctg_grp/browse');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "CTG_GRP_ID LIKE '%" . $searchkey . "%'  or CTG_GRP_NM LIKE '%" . $searchkey . "%' or Updateby LIKE '%" . $searchkey . "%'  or Updatedt LIKE '%" . $searchkey . "%'  " : '';
        }
        $data['searchkey'] = $searchkey;

        // sorting & order
        $sf = sort_field($this, $using_search,0,'asc');
        $orderby = $sf[0];
        $data['sort'] = $sf[1];
        $data['sorttype'] = $sf[2];
        $sortseq = $sf[3];
        $sorttype = $sf[4];
        $page_segment = $sf[5];

        // setup site_url & browse_url for pagination & view
        $browse_url = 'm_sqa_ctg_grp/browse/';
        $pagination_base_url = site_url('m_sqa_ctg_grp/browse/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('m_sqa_ctg_grp/browse/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'm_sqa_ctg_grp/browse/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_sqa_ctg_grp        
        $data['list_ctg_grp'] = $this->dm->select($limit, $orderby, $condition);

        $data['page_title'] = 'Master Category';
        
        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_sqa_ctg_grp/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function change() {
        $CTG_GRP_ID = $CTG_GRP_NM = $CTG_GRP_DESC = $Updateby = $Updatedt = '';
        $todo = 'ADD';
        $VALID_FROM = $VALID_TO = date('Y-m-d');
        $err = '';

        // cek jika ada Key untuk EDIT
        $CTG_GRP_ID = $this->uri->segment(3);
        if ($CTG_GRP_ID != '') {
            $ds = $this->dm->select('', '', "CTG_GRP_ID = '" . $CTG_GRP_ID . "'");
            //print_r($ds);

            $CTG_GRP_ID = $ds[0]->CTG_GRP_ID;
            $CTG_GRP_NM = $ds[0]->CTG_GRP_NM;
            $CTG_GRP_DESC = $ds[0]->CTG_GRP_DESC;
            $VALID_FROM = $ds[0]->VALID_FROM;
            $VALID_TO = $ds[0]->VALID_TO;
            $Updateby = $ds[0]->Updateby;
            $Updatedt = $ds[0]->Updatedt;
            $todo = 'EDIT';
        } else {
            $CTG_GRP_ID = $this->dm->generate_key('M_SQA_CTG_GRP', 'CTG_GRP_ID',4);
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {

            $CTG_GRP_ID = $this->input->post('CTG_GRP_ID');
            $CTG_GRP_NM = htmlspecialchars($this->input->post('CTG_GRP_NM'));
            $CTG_GRP_DESC = htmlspecialchars($this->input->post('CTG_GRP_DESC'));
            $VALID_FROM = $this->input->post('VALID_FROM');
            $VALID_TO = $this->input->post('VALID_TO');
            $Updateby = get_user_info($this, 'USER_ID');// $this->input->post('Updateby');
            $Updatedt = $this->input->post('Updatedt');

            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {                
                $cek = $this->dm->select('','',"CTG_GRP_NM = '" . $CTG_GRP_NM . "'");
                if (count($cek) > 0) {
                    $err = 'Category Group Name already exist: ' . $CTG_GRP_NM;
                } else {
                    $data = array(
                        'CTG_GRP_ID' => $CTG_GRP_ID,
                        'CTG_GRP_NM' => $CTG_GRP_NM,
                        'CTG_GRP_DESC' => $CTG_GRP_DESC,
                        'VALID_FROM' => conv_date(1, $VALID_FROM),
                        'VALID_TO' => conv_date(1, $VALID_TO),
                        'Updateby' => $Updateby,
                        'Updatedt' => get_date(),
                    );
                    $this->dm->insert($data);
                    redirect('m_sqa_ctg_grp/browse');    
                }
            } else {

                $update_keys = "CTG_GRP_ID = '" . $CTG_GRP_ID . "'";
                $data = array(
                    'CTG_GRP_ID' => $CTG_GRP_ID,
                    'CTG_GRP_NM' => $CTG_GRP_NM,
                    'CTG_GRP_DESC' => $CTG_GRP_DESC,
                    'VALID_FROM' => conv_date(1, $VALID_FROM),
                    'VALID_TO' => conv_date(1, $VALID_TO),
                    'Updateby' => $Updateby,
                    'Updatedt' => get_date(),
                );
                $this->dm->update($data, $update_keys);
                redirect('m_sqa_ctg_grp/browse');                
            }            
        }

        $data['CTG_GRP_ID'] = $CTG_GRP_ID;
        $data['CTG_GRP_NM'] = $CTG_GRP_NM;
        $data['CTG_GRP_DESC'] = $CTG_GRP_DESC;
        $data['VALID_FROM'] = $VALID_FROM;
        $data['VALID_TO'] = $VALID_TO;
        $data['Updateby'] = $Updateby;
        $data['Updatedt'] = get_date();
        $data['todo'] = $todo;
        $data['err'] = $err;

        //$data['list_ctg_grp'] = $this->dm->select();

        $data['page_title'] = 'Master Category';
        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_sqa_ctg_grp/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function erase() {
        $delete_keys = array('CTG_GRP_ID' => $this->uri->segment(3));
        // delete child and parent
        $this->dm->init('M_SQA_CTG');
        $this->dm->delete($delete_keys);
        $this->dm->init('M_SQA_CTG_GRP');
        $this->dm->delete($delete_keys);        
        redirect('m_sqa_ctg_grp/browse');
    }   
}

?>