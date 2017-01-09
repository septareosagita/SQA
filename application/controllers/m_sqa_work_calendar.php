<?php

/*
 * @author: irfan@mediantarakreasindo.com
 * @created: March, 23 2011 - 10:20
 */

class m_sqa_work_calendar extends CI_Controller {

    public $fieldseq = array();

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        $this->dm->init('V_SQA_WORK_CALENDAR', 'PLANT_CD');
        $this->fieldseq = array(
            0 => 'WORK_PRDT',
            1 => 'WORK_FLAG',
            2 => 'SHIFTNO',
            3 => 'SHIFTGRP_ID',
            4 => 'FISCAL_YEAR',
            5 => 'WEEK',
            6 => 'PLANT_CD'
        );
        if ($this->session->userdata('user_info') == '')
            redirect('welcome/out');
    }

    function index() {
        redirect('m_sqa_work_calendar/browse');
    }

    function browse() {
        // inisialisasi variable
        $searchpaging = $condition = $searchkey = '';
        $page = 0;
        $using_search = false;
        $data['err'] = '';
        $fiscal_year = 0;
        $work_prdt_from = $work_prdt_to = '';

        // deleting
        $cek = $this->input->post('cek');
        if ($cek) {
            foreach ($cek as $v) {
                $delete_keys = array('USER_ID' => $v);
                $this->dm->delete($delete_keys);
            }
            redirect('m_sqa_work_calendar/browse');
        }

        // searching
        if (isset($_POST['searchkey'])) {
            $searchkey = $this->input->post('searchkey', true);
            $fiscal_year = $_POST['fiscal_year'];
            $work_prdt_from = $_POST['work_prdt_from'];
            $work_prdt_to = $_POST['work_prdt_to'];

            if ($searchkey == '' && $fiscal_year == '0' && $work_prdt_from == '' && $work_prdt_to == '')
                redirect('m_sqa_work_calendar/browse');
            else
                redirect('m_sqa_work_calendar/browse/search/' . AsciiToHex(base64_encode($searchkey . ';;' . $fiscal_year . ';;' . $work_prdt_from . ';;' . $work_prdt_to)) . '/0/asc/');
        }

        // process searching
        $searchkey = ($this->uri->segment(3) == 'search') ? $this->uri->segment(4) : '';
        if ($searchkey != '') {
            $using_search = true;
            $searchkey = base64_decode(HexToAscii($searchkey));

            // temukan jika ada lebih dari satu kondisi berdasarkan array ';;' explode
            $exp_searchkey = explode(';;', $searchkey);

            if (count($exp_searchkey) > 0) {
                $searchkey = $exp_searchkey[0];
                $fiscal_year = $exp_searchkey[1];
                $work_prdt_from = $exp_searchkey[2];
                $work_prdt_to = $exp_searchkey[3];

                $condition = "(PLANT_CD like '%" . $searchkey . "%')";

                if ($fiscal_year != '0') {
                    $condition .= " and (FISCAL_YEAR = '" . $fiscal_year . "')";
                }
                if ($work_prdt_from != '' && $work_prdt_to != '') {
                    $condition .= " and (WORK_PRDT >= '" . conv_date('1', $work_prdt_from) . "' and WORK_PRDT <= '" . conv_date('1', $work_prdt_to) . "')";
                }
            }            
        }
        $data['searchkey'] = $searchkey;

        // sorting & order
        $sf = sort_field($this, $using_search, 0, 'asc');        
        $orderby = $sf[0];
        $data['sort'] = $sf[1];
        $data['sorttype'] = $sf[2];
        $sortseq = $sf[3];
        $sorttype = $sf[4];
        $page_segment = $sf[5];

        // setup site_url & browse_url for pagination & view
        $browse_url = 'm_sqa_work_calendar/browse/';
        $pagination_base_url = site_url('m_sqa_work_calendar/browse/' . $sortseq . '/' . $sorttype . '/page/');
        if ($using_search) {            
            $ath_search = AsciiToHex(base64_encode($searchkey . ';;' . $fiscal_year . ';;' . $work_prdt_from . ';;' . $work_prdt_to));
            $pagination_base_url = site_url('m_sqa_work_calendar/browse/search/' . $ath_search . '/' . $sortseq . '/' . $sorttype . '/page/');
            $browse_url = 'm_sqa_work_calendar/browse/search/' . $ath_search . '/';
        }
        $data['browse_url'] = $browse_url;

        //pagination
        $page = ($this->uri->segment($page_segment) != '') ? $this->uri->segment($page_segment) : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $total_rows = $this->dm->count($condition);
        $data['pagination'] = text_paging($this, $page_segment, $pagination_base_url, $total_rows, $page);

        //list m_sqa_work_calendar
        $data['list_m_sqa_work_calendar'] = $this->dm->select($limit, $orderby, $condition);

        // list all fiscal years
        $data['list_fy'] = $this->dm->sql_self("select distinct FISCAL_YEAR from V_SQA_WORK_CALENDAR");

        $data['fiscal_year'] = $fiscal_year;
        $data['work_prdt_from'] = $work_prdt_from;
        $data['work_prdt_to'] = $work_prdt_to;

        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");                

        $data['page_title'] = 'Master Work Calendar';
        $this->load->view('header', $data);
        $this->load->view('m_sqa_work_calendar/browse', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function change() {

        $err = '';

        $data['page_title'] = 'Master Work Calendar';

        if (isset($_POST['FISCAL_YEAR'])) {
            $FISCAL_YEAR = $_POST['FISCAL_YEAR'];
            $r1 = $_POST['r1'];
            $r2 = $_POST['r2'];
            $PLANT_CD = $_POST['PLANT_CD'];

            if ($FISCAL_YEAR != '' && $r1 != '' && $r2 != '') {
                // cek dulu apakah sdh ada atau belum pLant code yg bersangkutann
                $cek = $this->dm->select('', '', "PLANT_CD = '" . $PLANT_CD . "' and FISCAL_YEAR = '" . $FISCAL_YEAR . "'");
                if (count($cek) > 0) {
                    $err = 'Work Calendar Already Exist in the Selected Fiscal Year';
                } else {
                    // ambil data shift
                    $this->dm->init('M_SQA_SHIFT','SHIFTNO');
                    $shifts = $this->dm->select('','',"PLANT_CD = '" . $PLANT_CD . "' AND SHIFTNO > 1 ");
                    
                    $test = createDateRangeArray(conv_date('1', $r1), conv_date('1', $r2));                    
                    foreach ($test as $t) {
                        $tx = explode('-', $t);
                        //w: 0      1       2       3       4       5       6
                        //w: minggu senin   selasa  rabu    kamis   jumat   sabtu

                        $d = date("w", mktime(0, 0, 0, $tx[1], $tx[2], $tx[0]));
                        $w = date("W", mktime(0, 0, 0, $tx[1], $tx[2], $tx[0]));
                        //echo $t . ': ' . $d . ' : ' . $w .  '<hr />';
                        
                        $this->dm->init('M_SQA_WORK_CALENDAR');
                        foreach ($shifts as $s) {                            
                            $data = array(
                                'PLANT_CD' => $PLANT_CD,
                                'WORK_PRDT' => $t,
                                'WORK_FLAG' => ($d!=0 && $d!=6) ? '1' :'0',
                                'SHIFTNO' => $s->SHIFTNO,
                                'WEEK' => $w,
                                'FISCAL_YEAR' => $FISCAL_YEAR,
                                'Updateby' => get_user_info($this,'USER_ID'),
                                'Updatedt' => get_date()
                            );
                            $this->dm->insert($data);
                        }                       
                    }
                    redirect('m_sqa_work_calendar/browse');
                }
            } else {
                $err = 'Please add Fiscal Year &amp; Date Range';
            }
        }

        // list plant
        $this->dm->init('M_SQA_PLANT', 'PLANT_CD');
        $data['list_plant'] = $this->dm->select();

        $data['err'] = $err;
        $data['todo'] = '';


        // get sub menu
        $this->dm->init('M_SQA_MENU', 'MENU_ID');
        $data['m_sub'] = $this->dm->select('', 'MENU_NM ASC', "MENU_PARENT = '009'");

        $this->load->view('header', $data);
        $this->load->view('m_sqa_work_calendar/change', $data);
        $this->load->view('master_sub');
        $this->load->view('footer');
    }

    function erase() {
        $delete_keys = array('PLANT_CD' => $this->uri->segment(3));
        $this->dm->delete($delete_keys);
        $this->session->set_flashdata('FLASH_MESSAGE', 'WORK CALENDAR HAS BEEN DELETED');
        redirect('m_sqa_work_calendar/browse');
    }

    function change_work_flag() {
        $plant_cd = $_POST['plant_cd'];
        $work_prdt = $_POST['work_prdt'];
        $shiftno = $_POST['shiftno'];
        $work_flag = $_POST['work_flag'];        
        $this->dm->init('M_SQA_WORK_CALENDAR');
        $data = array('WORK_FLAG' => $work_flag);
        $keys = "PLANT_CD = '" . $plant_cd . "' and WORK_PRDT = '" . $work_prdt ."' AND SHIFTNO = '" . $shiftno . "'";
        $this->dm->update($data, $keys);

        $wf_to = ($work_flag=='1')?'0':'1';
        $p = "change_work_flag('".$plant_cd."', '".$work_prdt."','".$shiftno."', '" . $wf_to . "')";
        $gbr = ($work_flag=='1')?'accept':'error';
        $alt = ($work_flag=='1')?'Yes':'No';

        $out = '
            <a href="javascript:;" onclick="'.$p.'" title="Click to Change Work Flag Status">
                <img src="'.base_url().'assets/img/icon_'.$gbr.'.png" alt="'.$alt.'" />
            </a>
        ';
        echo $out;        
    }
    
    function get_shiftgrp () {
        $plant_cd = $_POST['plant_cd'];
        $work_prdt = $_POST['work_prdt'];
        $shiftno = $_POST['shiftno'];
        $shiftgrp_id = $_POST['shiftgrp_id'];
        
        // list shiftgrp
        $this->dm->init('M_SQA_SHIFTGRP', 'SHIFTGRP_ID');
        $shiftgrp = $this->dm->select('','',"PLANT_CD = '" . $plant_cd . "'");
        
        $out = '';
        if (count($shiftgrp)>0) {
            $out = '<select name="shiftgrp_id_'.$plant_cd.$work_prdt.$shiftno.'" id="shiftgrp_id_'.$plant_cd.$work_prdt.$shiftno.'">';
            //$out .= '<option value="0">- Set -</option>';
            foreach ($shiftgrp as $s) {
                $sel = ($s->SHIFTGRP_ID == $shiftgrp_id) ? 'selected="selected"' : '';
                $out .= '<option value="'.$s->SHIFTGRP_ID.'" '.$sel.'>'.$s->SHIFTTGRP_NM.'</option>';
            }
            $out .= '</select>';
            $p = "set_shiftgrp('".$plant_cd."','".$work_prdt."','".$shiftno."')";
            $out .= '<a hfef="javascript:;" onclick="'.$p.'" style="cursor: pointer">[Set]</a>';
        }
        echo $out;
        
    }
    
    function set_shiftgrp () {
        $plant_cd = $_POST['plant_cd'];
        $work_prdt = $_POST['work_prdt'];
        $shiftno = $_POST['shiftno'];
        $shiftgrp_id = $_POST['shiftgrp_id'];
        
        // update shift grp id
        $this->dm->init('M_SQA_WORK_CALENDAR');
        $keys = "PLANT_CD = '" . $plant_cd . "' and WORK_PRDT = '" . $work_prdt . "' and SHIFTNO = '" . $shiftno . "'";
        $data = array('SHIFTGRP_ID' => $shiftgrp_id);
        $this->dm->update($data, $keys);
        
        // get shiftgrp nm
        $this->dm->init('M_SQA_SHIFTGRP', 'SHIFTGRP_ID');
        $shiftgrp = $this->dm->select('','',"SHIFTGRP_ID = '" . $shiftgrp_id . "'");
        $shiftgrp_nm = (count($shiftgrp)>0) ? $shiftgrp[0]->SHIFTTGRP_NM : '';
        
        /*<a href="javascript:;" onclick="on_change_shiftgrp('<?=$l->PLANT_CD?>', '<?=$l->WORK_PRDT?>', '<?=$l->SHIFTNO?>', '<?=$l->SHIFTGRP_ID?>');" class="tested">
                                            <?= ($l->SHIFTTGRP_NM!='')?$l->SHIFTTGRP_NM:'Set Group &raquo;' ?>
                                        </a>*/

        $p = "on_change_shiftgrp('".$plant_cd."','".$work_prdt."','".$shiftno."', '" . $shiftgrp_id . "');";
        $out = '<a href="javascript:;" onclick="'.$p.'" class="tested">'.$shiftgrp_nm.'</a>';
        echo $out;
    }
    
    function erasefiscal() {
        $this->dm->init('M_SQA_WORK_CALENDAR');
        $keys = array('FISCAL_YEAR' => $this->uri->segment(3));
        $this->dm->delete($keys);
        redirect('m_sqa_work_calendar');
    }

}

?>