<?php

/*
 * @author: ryan@mediantarakreasindo.com
 * @created: March 24, 2011 - 11:03
 *
 * @modified by: irfan@mediantarakreasindo.com
 */

class m_sqa_rank extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();        
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('M_SQA_RANK', 'RANK_ID');
        $this->fieldseq = array(
            0 => 'RANK_ID',
            1 => 'RANK_NM',
            2 => 'RANK_DESC',
            3 => 'Updateby',
            4 => 'Updatedt',
        );
        if ($this->session->userdata('user_info') == '') redirect('welcome/out');
    }

    function index() {
        redirect('m_sqa_rank/browse');
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
                $delete_keys = array('RANK_ID' => $v);
                $this->dm->delete($delete_keys);
            }
            redirect('m_sqa_rank/browse');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('m_sqa_rank/browse/search/' . AsciiToHex(base64_encode($searchkey)) . '/0/desc/');
            else
                redirect('m_sqa_rank/browse');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "RANK_ID LIKE '%" . $searchkey . "%' or RANK_NM LIKE '%" . $searchkey . "%'  or Updateby LIKE '%" . $searchkey . "%' or Updatedt LIKE '%" . $searchkey . "%' " : '';
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
        $browse_url = 'm_sqa_rank/browse/';
        $pagination_base_url = site_url('m_sqa_rank/browse/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('m_sqa_rank/browse/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'm_sqa_rank/browse/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_sqa_rank
        $data['list_rank'] = $this->dm->select($limit, $orderby, $condition);

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Rank';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_rank/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function change() {
        $RANK_NM = $RANK_DESC = $Updateby = $Updatedt = '';
        $todo = 'ADD';
        $err = '';        

        // cek jika ada Key untuk EDIT
        $RANK_ID = $this->uri->segment(3);
        if ($RANK_ID != '') {
            $ds = $this->dm->select('', '', "RANK_ID = '" . $RANK_ID . "'");

            $RANK_ID = $ds[0]->RANK_ID;
            $RANK_NM = $ds[0]->RANK_NM;
            $RANK_DESC = $ds[0]->RANK_DESC;
            $Updateby = $ds[0]->Updateby;
            $Updatedt = $ds[0]->Updatedt;
            $todo = 'EDIT';
        } else {
            $RANK_ID = $this->dm->generate_key('M_SQA_RANK', 'RANK_ID',2);
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {

            $RANK_ID = $this->input->post('RANK_ID');
            $RANK_NM = $this->input->post('RANK_NM');
            $RANK_DESC = $this->input->post('RANK_DESC');
            $Updateby = get_user_info($this, 'USER_ID');// $this->input->post('Updateby');
            $Updatedt = $this->input->post('Updatedt');
            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {
                $data = array(
                    'RANK_ID' => $RANK_ID,
                    'RANK_NM' => $RANK_NM,
                    'RANK_DESC' => $RANK_DESC,
                    'Updateby' => $Updateby,
                    'Updatedt' => $Updatedt,
                );
                $this->dm->insert($data);
            } else {
                $update_keys = "RANK_ID = '" . $RANK_ID . "'";
                $data = array(
                    'RANK_NM' => $RANK_NM,
                    'RANK_DESC' => $RANK_DESC,
                    'Updateby' => $Updateby,
                    'Updatedt' => $Updatedt,
                );
                $this->dm->update($data, $update_keys);                
            }
            redirect('m_sqa_rank/browse');
        }

        $data['RANK_ID'] = $RANK_ID;
        $data['RANK_NM'] = $RANK_NM;
        $data['RANK_DESC'] = $RANK_DESC;
        $data['Updateby'] = $Updateby;
        $data['Updatedt'] = get_date();
        $data['todo'] = $todo;

        if ($this->session->flashdata('FLASH_MESSAGE') == '1') {
            $data['err'] = 'Error , Please complete the following fields';
        }

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Maintenance';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_rank/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function erase() {
        $delete_keys = array('RANK_ID' => $this->uri->segment(3));
        $this->dm->delete($delete_keys);        
        redirect('m_sqa_rank/browse');
    }

}

?>
