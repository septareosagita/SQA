<?php

/*
 * @author: irfan@mediantarakreasindo.com
 * @created: March, 23 2011 - 10:20
 */

class m_sqa_shop extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('M_SQA_SHOP', 'SHOP_ID');
        $this->fieldseq = array(
            0 => 'PLANT_CD',
            1 => 'SHOP_ID',
            2 => 'SHOP_NM',
            3 => 'SHOP_SHOW'
        );
        if ($this->session->userdata('user_info') == '') redirect('welcome/out');
    }

    function index() {
        redirect('m_sqa_shop/browse');
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
                $delete_keys = array('SHOP_ID' => $v);
                $this->dm->delete($delete_keys);
            }
            redirect('m_sqa_shop/browse');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            if ($searchkey != '')
                redirect('m_sqa_shop/browse/search/' . AsciiToHex(base64_encode($searchkey)) . '/0/desc/');
            else
                redirect('m_sqa_shop/browse');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));
            $condition .= ( $searchkey != '') ? "PLANT_CD LIKE '%" . $searchkey . "%' or SHOP_ID LIKE '%" . $searchkey . "%'  or SHOP_NM LIKE '%" . $searchkey . "%' " : '';
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
        $browse_url = 'm_sqa_shop/browse/';
        $pagination_base_url = site_url('m_sqa_shop/browse/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {
            $ath_search = AsciiToHex(base64_encode($searchkey));
            $pagination_base_url = site_url('m_sqa_shop/browse/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'm_sqa_shop/browse/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_sqa_shop
        $data['list_m_sqa_shop'] = $this->dm->select($limit, $orderby, $condition);

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Responsible';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_shop/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function change() {
        $PLANT_CD = $SHOP_ID = $SHOP_NM = $Updateby = $Updatedt = '';
        $SHOP_SHOW = '0';
        $todo = 'ADD';
        $err = '';

        // cek jika ada Key untuk edit
        $SHOP_ID = $this->uri->segment(3);
        if ($SHOP_ID != '') {
            $ds = $this->dm->select('', '', "SHOP_ID = '" . $SHOP_ID . "'");
            $PLANT_CD = $ds[0]->PLANT_CD;
            $SHOP_NM = $ds[0]->SHOP_NM;
            $SHOP_SHOW = $ds[0]->SHOP_SHOW;
            $todo = 'EDIT';
        }

        // jika Form tersubmit
        if (isset($_POST['todo'])) {

            $PLANT_CD = $this->input->post('PLANT_CD');
            $SHOP_ID = $this->input->post('SHOP_ID');
            $SHOP_NM = $this->input->post('SHOP_NM');
            $SHOP_SHOW = isset($_POST['SHOP_SHOW']) ? '1' : '0';
            $todo = $this->input->post('todo');

            if ($todo == 'ADD') {
                if ($SHOP_ID == '' || $SHOP_NM == '') {
                    $err = 'Please Input ID &amp; name for this Responsible Shop';
                } else {
                    $cekdata = $this->dm->select('', '', "SHOP_ID = '" . $SHOP_ID . "'", 'SHOP_ID');
                    if (count($cekdata) > 0) {
                        // dah ada shop id untk plant yg sama
                        $err = 'Shop ID already exist';
                    } else {
                        $data = array(
                            'PLANT_CD' => $PLANT_CD,
                            'SHOP_ID' => $SHOP_ID,
                            'SHOP_NM' => $SHOP_NM,
                            'SHOP_SHOW' => $SHOP_SHOW,
                            'Updateby' => get_user_info($this, 'USER_ID'),
                            'Updatedt' => get_date()
                        );
                        $this->dm->insert($data);
                        redirect('m_sqa_shop/browse');
                    }
                }                              
            } else {
                $update_keys = "PLANT_CD = '" . $PLANT_CD . "' and SHOP_ID = '" . $SHOP_ID . "'";
                $data = array(
                    'SHOP_NM' => $SHOP_NM,
                    'SHOP_SHOW' => $SHOP_SHOW,
                    'Updateby' => get_user_info($this, 'USER_ID'),
                    'Updatedt' => get_date(),
                );
                $this->dm->update($data, $update_keys);
                redirect('m_sqa_shop/browse');
            }
        }

        $data['PLANT_CD'] = $PLANT_CD;
        $data['SHOP_ID'] = $SHOP_ID;
        $data['SHOP_NM'] = $SHOP_NM;
        $data['SHOP_SHOW'] = $SHOP_SHOW;
        $data['todo'] = $todo;
        $data['err'] = $err;

        // list plant
        $this->dm->init('M_SQA_PLANT', 'PLANT_CD');
        $data['list_plant'] = $this->dm->select();

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $data['page_title'] = 'Master Maintenance';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_shop/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function erase() {
        $this->dm->init('M_SQA_SHOP', 'SHOP_ID');
        $delete_keys = array('SHOP_ID' => $this->uri->segment(3));
        $this->dm->delete($delete_keys);
        redirect('m_sqa_shop/browse');
    }
}

?>