<?php

/*
 * @author: ryan@mediantarakreasindo.com
 * @created: March 24, 2011 - 11:03
 *
 * @modified by: irfan@mediantarakreasindo.com
 */

class m_sqa_ctg extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('M_SQA_CTG', 'CTG_ID');
        $this->fieldseq = array(
            0 => 'CTG_ID',
            1 => 'CTG_GRP_ID',
            2 => 'CTG_NM',
            3 => 'CTG_DESC',
            4 => 'Updateby',
            5 => 'Updatedt',
        );
        if ($this->session->userdata('user_info') == '') redirect('welcome/out');
    }

    function index() {
        redirect('m_sqa_ctg/browse');
    }

    function browse() {
        // inisialisasi variable
        $searchpaging = $searchkey = '';
        $page = 0;
        $using_search = false;

        $ctg_grp_id = $this->uri->segment(3);
        $condition = "CTG_GRP_ID = '" . $ctg_grp_id . "'";
        $this->dm->init('M_SQA_CTG_GRP', 'CTG_GRP_ID');
        $ctg_grp = $this->dm->select('','',$condition);
        $data['ctg_grp'] = $ctg_grp[0];

        $this->dm->init('V_SQA_CTG', 'CTG_ID');
        $data['list_ctg'] = $this->dm->select('', '', $condition);
        
        $this->load->view('header_plain');
        $this->load->view('m_sqa_ctg/browse', $data);
        $this->load->view('footer_plain');
    }

    function change() {
        $CTG_ID = $CTG_GRP_ID = $CTG_NM = $CTG_DESC = $Updateby = $Updatedt = '';
        $VALID_FROM = $VALID_TO = date('Y-m-d');
        $todo = 'ADD';
        
        // category group nya
        $CTG_GRP_ID = $this->uri->segment(3);
        $condition = "CTG_GRP_ID = '" . $CTG_GRP_ID . "'";
        $this->dm->init('M_SQA_CTG_GRP', 'CTG_GRP_ID');
        $ctg_grp = $this->dm->select('','',$condition);
        $data['ctg_grp'] = $ctg_grp[0];


        // cek jika ada Key untuk EDIT
        $this->dm->init('M_SQA_CTG', 'CTG_ID');
        $CTG_ID = $this->uri->segment(4);
        if ($CTG_ID != '') {            
            $ds = $this->dm->select('', '', "CTG_ID = '" . $CTG_ID . "' AND CTG_GRP_ID = '" . $CTG_GRP_ID . "'");
            $CTG_GRP_ID = $ds[0]->CTG_GRP_ID;
            $CTG_ID = $ds[0]->CTG_ID;
            $CTG_NM = $ds[0]->CTG_NM;
            $CTG_DESC = $ds[0]->CTG_DESC;
            $VALID_FROM = $ds[0]->VALID_FROM;
            $VALID_TO = $ds[0]->VALID_TO;
            $Updateby = $ds[0]->Updateby;
            $Updatedt = $ds[0]->Updatedt;
            $todo = 'EDIT';
        } else {
            $CTG_ID = $this->dm->generate_key('M_SQA_CTG', 'CTG_ID',4, "CTG_GRP_ID = '" . $CTG_GRP_ID . "'");                        
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {
            $CTG_ID = $this->input->post('CTG_ID');
            $CTG_GRP_ID = $this->input->post('CTG_GRP_ID');
            $CTG_NM = $this->input->post('CTG_NM');
            $CTG_DESC = $this->input->post('CTG_DESC');
            $VALID_FROM = $this->input->post('VALID_FROM');
            $VALID_TO = $this->input->post('VALID_TO');
            $Updateby = get_user_info($this, 'USER_ID');// $this->input->post('Updateby');
            $Updatedt = $this->input->post('Updatedt');

            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {                    
                    $data = array(
                    'CTG_ID' => $CTG_ID,
                    'CTG_GRP_ID' => $CTG_GRP_ID,
                    'CTG_NM' => $CTG_NM,
                    'CTG_DESC' => $CTG_DESC,
                    'VALID_FROM' => conv_date(1, $VALID_FROM),
                    'VALID_TO' => conv_date(1, $VALID_TO),
                    'Updateby' => $Updateby,
                    'Updatedt' => get_date(),
                );
                $this->dm->insert($data);
                
                if (isset($_POST['check_insert']) == '1') {
                    redirect('m_sqa_ctg/change/');
                } else {
                    redirect('m_sqa_ctg/browse/' . $CTG_GRP_ID);
                }
                                
            } else {
                $update_keys = "CTG_ID = '" . $CTG_ID . "' AND CTG_GRP_ID = '" . $CTG_GRP_ID . "'";
                $data = array(
                    /*'CTG_GRP_ID' => $CTG_GRP_ID,*/
                    'CTG_NM' => $CTG_NM,
                    'CTG_DESC' => $CTG_DESC,
                    'VALID_FROM' => conv_date(1, $VALID_FROM),
                    'VALID_TO' => conv_date(1, $VALID_TO),
                    'Updateby' => $Updateby,
                    'Updatedt' => get_date(),
                );
                $this->dm->update($data, $update_keys);
                redirect('m_sqa_ctg/browse/' . $CTG_GRP_ID);
            }
            
        }

        $data['CTG_ID'] = $CTG_ID;        
        $data['CTG_GRP_ID'] = $CTG_GRP_ID;
        $data['CTG_NM'] = $CTG_NM;
        $data['CTG_DESC'] = $CTG_DESC;
        $data['VALID_FROM'] = $VALID_FROM;
        $data['VALID_TO'] = $VALID_TO;
        $data['Updateby'] = $Updateby;
        $data['Updatedt'] = get_date();
        $data['todo'] = $todo;        
        
        $this->load->view('header_plain');
        $this->load->view('m_sqa_ctg/change', $data);        
        $this->load->view('footer_plain');
    }

    function erase() {
        $delete_keys = array('CTG_GRP_ID' => $this->uri->segment(3), 'CTG_ID' => $this->uri->segment(4));
        $this->dm->delete($delete_keys);        
        redirect('m_sqa_ctg/browse/' . $this->uri->segment(3));
    }   
}
?>