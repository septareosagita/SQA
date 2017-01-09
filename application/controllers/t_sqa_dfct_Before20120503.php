<?php
/*
 * @author: irfan@mediantarakreasindo.com 
 * @created: March, 23 2011 - 10:20
 */

class t_sqa_dfct extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);
        if ($this->session->userdata('user_info') == '') {
            
            // cek jika ngakses dari email, common url:
            // http://10.16.66.74/toyotasqa/t_sqa_dfct/report_sqa/5147C8EE-9EB5-4B3A-8B1C-EE244F08D798/m
            
            //$login_success = '';
//            if ($this->uri->segment(2) == 'report_sqa' && $this->uri->segment(3) != '') {
//                $login_success = 't_sqa_dfct/report_sqa/' . $this->uri->segment(3) . '/' . $this->uri->segment(4);
//                $login_success = AsciiToHex(base64_encode($login_success));
//            }
            
            die("<script>window.location='".site_url('welcome/out/' . $login_success)."'</script>");//redirect('welcome/out');
        }
    }

    function index() {
        redirect('t_sqa_dfct/change');
    }

    function change() {
        $data['auditor_nm_1'] = get_user_info($this);
        $data['plant_nm'] = get_user_info($this, 'PLANT_NM');
        $data['shiftgrp_nm'] = get_user_info($this, 'SHIFTTGRP_NM');

        // get auditor
        $this->dm->init('V_USR', 'USER_ID');
        //$w = "USER_ID <> '" . get_user_info($this, 'USER_ID') . "' AND GRPAUTH_IS_AUDITOR = '1'";
        /** edited by satriadarma on 20110714, 20110727 
            <Audit Registration> "Auditor 2" combobox still viewing the User which 
            have different Shop ID, must listed the auditor 2 based on 
            Plant, ShiftGroupID and ShopID of auditor 1, 
            
            except if auditor 1 is Admin (Shop=AL) then 
            must be viewing all user registration in master user --based on plant code--
        **/
        $grpauth_id = get_user_info($this, 'GRPAUTH_ID');
        if ($grpauth_id == '09') {
            // is Admin (SHOP ALL)
            $w = "(USER_ID <> '" . get_user_info($this, 'USER_ID') . "')";
        } else {
            $w = "(USER_ID <> '" . get_user_info($this, 'USER_ID') . "') AND
                    (PLANT_CD = '" . get_user_info($this, 'PLANT_CD'). "') AND 
                    (SHIFTGRP_ID = '" . get_user_info($this, 'SHIFTGRP_ID') . "') AND
                    (SHOP_ID = '" . get_user_info($this, 'SHOP_ID') . "')
                ";
        }
        
        $w .= " AND (GRPAUTH_ID NOT IN (01,02,03))"; // validasi Responsible tidak boleh muncul.
        
        //$w = "(USER_ID <> '" . get_user_info($this, 'USER_ID') . "') AND (SHIFTGRP_ID = '" . get_user_info($this, 'SHIFTGRP_ID') . "') AND (GRPAUTH_ID NOT IN (01,02,03))";
        $data['list_user'] = $this->dm->select('', '', $w);

        // get stall available for this PLANT_CD
        $w = "STALL_STS = '0' AND PLANT_CD = '" . get_user_info($this, 'PLANT_CD') . "' AND SHOP_ID = '" . get_user_info($this, 'SHOP_ID') . "'";
        $this->dm->init('M_SQA_STALL', 'STALL_NO');
        $data['list_stall'] = $this->dm->select('','', $w);

        // get rank
        $this->dm->init('M_SQA_RANK', 'RANK_ID');
        $data['list_rank'] = $this->dm->select();

        // get shop
        $this->dm->init('M_SQA_SHOP', 'SHOP_ID');
        $data['list_shop'] = $this->dm->select('','',"SHOP_SHOW='1' AND SHOP_ID != 'IN'");

        // get ctg_grp
        $this->dm->init('M_SQA_CTG_GRP', 'CTG_GRP_ID');
        $data['list_ctg_grp'] = $this->dm->select();
        
        // apakah ada problem_id dari uri
        $problem_id = ($this->uri->segment(3)!= '') ? $this->uri->segment(3) : '0';
        $data['problem_id'] = $problem_id;
        
        // ambil detail problem id sesuai dgn yg di dapat, dan dapatkan body_no nya
        $body_no = '';
        if ($problem_id != '0') {
            $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
            $w = "PROBLEM_ID = '" . $problem_id . "'";
            $problem = $this->dm->select('', '', $w);
            if (count($problem)>0) {
                $body_no = $problem[0]->BODYNO;
            }
        }
        $data['body_no'] = $body_no;

        $data['page_title'] = 'Audit Registration';
        $this->load->view('header', $data);
        $this->load->view('t_sqa_dfct/register');
        $this->load->view('footer');
    }

    function get_ctg() {
        $ctg_grp_id = $_POST['ctg_grp_id'];
        $ctg_nm = $_POST['ctg_nm'];
        $this->dm->init('M_SQA_CTG', 'CTG_ID');
        $w = "CTG_GRP_ID = '" . $ctg_grp_id . "'";
        $ctgs = $this->dm->select('', '', $w);
        $out = '<sup>- empty category -</sup>';
        if (count($ctgs) > 0) {
            $out = '<select name="ctg_nm" id="ctg_nm" style="width: 215px">';
            foreach ($ctgs as $c) {
                $sel = ($ctg_nm == $c->CTG_NM) ? 'selected="selected"' : '';
                $out .= '<option value="' . $ctg_nm . '">' . $ctg_nm . '</option>';
            }
            $out .= '</select>';
        }
        echo $out;
    }

    function get_vinf() {        
        $this->dm->init('T_SQA_VINF', 'BODY_NO');

        $by = $_POST['by'];
        $vin_id = $_POST['vin_id'];

		$vin_id = str_replace(' ','',$vin_id);        

		if ($vin_id == '') {
			echo 0;
		} else {
			$where = ($by == 'body_no') ? "BODY_NO = '" . $vin_id . "'" : "VINNO = '" . $vin_id . "'";
	        $data_vin = $this->dm->select('', '', $where, '*');

			// cek datanya
			if (count($data_vin) == 0) {
				echo 0;
			} else {
				$data_vin = $data_vin[0];

				$suffix = $data_vin->SUFFIX;
				$bd_seq = $data_vin->BD_SEQ;
				$katashiki = $data_vin->DESCRIPTION; //model code
				$assy_seq = $data_vin->ASSY_SEQ;
				$assy_pdate = ($data_vin->ASSY_PDATE != '') ? date('d-m-Y', strtotime($data_vin->ASSY_PDATE)) : '';
				$extclr = $data_vin->EXTCLR;
				$vinno = $data_vin->VINNO;
				$body_no = $data_vin->BODY_NO;
				$reg_in = ($data_vin->REG_IN == null) ? '' : $data_vin->REG_IN;
				$reg_out = ($data_vin->REG_OUT == null) ? '' : $data_vin->REG_OUT;
				$idno = $data_vin->IDNO;
				$refno = $data_vin->REFNO;
				$insp_shiftgrpnm = ($data_vin->INSP_SHIFTGRPNM == null) ? '' : $data_vin->INSP_SHIFTGRPNM;
				$assy_shiftgrpnm = ($data_vin->ASSY_SHIFTGRPNM == null) ? '' : $data_vin->ASSY_SHIFTGRPNM;
				$audit_finish_pdate = ($data_vin->AUDIT_FINISH_PDATE==null)?'':$data_vin->AUDIT_FINISH_PDATE;
                $auditor_nm_1 = $data_vin->AUDITOR_NM_1;
                $auditor_nm_2 = $data_vin->AUDITOR_NM_2;
                
				$insp_pdate = $data_vin->INSP_PDATE;// ($data_vin->INSP_PDATE != '') ? date('d-m-Y', strtotime($data_vin->INSP_PDATE)) : '';
                if ($insp_pdate == '' || $insp_pdate == null) {
                    $cek = $this->load->database('dbqis', true);
                    $dfct_qis = $cek->query("select top 1 T_DFCT.CHKPDATE, T_DFCT.CHKPTIME, T_DFCT.CHKPSHIFT from T_DFCT where T_DFCT.LINE = '1' AND T_DFCT.VINNO = '".$vinno."' order by T_DFCT.CHKPDATE asc")->result();
                    if (count($dfct_qis)>0) {
                        $insp_pdate = $dfct_qis[0]->CHKPDATE;
                        $insp_shiftgrpnm = $dfct_qis[0]->CHKPSHIFT;
                        $insp_sysdate = $dfct_qis[0]->CHKPTIME;
                        
                        // update ke table T_SQA_VINF
                        $keys = "BODY_NO = '" . $body_no . "'";
                        $data = array(
                            'INSP_PDATE' => $insp_pdate,
                            'INSP_SYSDATE' => $insp_sysdate,
                            'INSP_SHIFTGRPNM' => $insp_shiftgrpnm                            
                        );
                        $this->dm->update($data, $keys);
                    }
                }
                $insp_pdate = ($insp_pdate != '') ? date('d-m-Y', strtotime($insp_pdate)) : '-';
                

				$result = array($suffix, $bd_seq, $katashiki, $assy_seq, $insp_pdate,
					$assy_pdate, $extclr, $vinno, $body_no, $reg_in, $reg_out,
					$idno, $refno, $insp_shiftgrpnm, $assy_shiftgrpnm, $audit_finish_pdate,
                    $auditor_nm_1, $auditor_nm_2
				);
				echo json_encode($result);
			}
		}
    }

    function get_vinf_under_sqa() {
        $bodyno = $_POST['bodyno'];
        $str_bodyno = ($bodyno != '' && $bodyno != '0') ? " and (BODY_NO = '" . $bodyno . "')" : '';
        $str_bodyno = '';
        
        $where = "(REG_IN <> '' or REG_IN is not NULL) " . $str_bodyno;
        $this->dm->init('T_SQA_VINF', 'BODY_NO');
        
        // pagination ajax
        $page = (isset($_POST['pg'])) ? $_POST['pg'] : 0;
        $limit = $page . ', ' . PAGE_PERVIEW;
        $rows = $this->dm->count($where);                                                                                                     
        $page_url = 'page_ajax';// site_url('sipen/m_web/berita_list/page');
        $data['pagination'] = text_paging_ajax($this, $page_url, $rows, $page, site_url('t_sqa_dfct/get_vinf_under_sqa'), 'content_vinf', '');                        
        
        $vinf = $this->dm->select($limit, 'REG_IN DESC, DESCRIPTION ASC', $where);
        
        // cek posisi
        /*foreach ($vinf as $v) {
            
        }*/
        
        $data['list_t_vinf'] = $vinf;
        $data['bodyno'] = $bodyno;
        $data['total_rows'] = $rows;
        $data['page'] = $page;

        $this->load->view('t_sqa_dfct/list_vinf', $data);
    }

    function reg_in() {
        // update status REG_IN jadi get_date()
        // ambil bodyno
        $body_no = $_POST['bodyno'];
        $vinno = $_POST['vinno'];
        $auditor1 = $_POST['auditor1'];
        $auditor2 = $_POST['auditor2'];
        $stall_no = $_POST['stall_no'];

        // get current pdate        
        $this->dm->init('M_SQA_PRDT', 'PLANT_CD');
        $prdt = $this->dm->select('', '', "PLANT_CD = '" . get_user_info($this, 'PLANT_CD') . "'");
        $prdt = (count($prdt) > 0) ? $prdt[0]->PDATE : date('Y-m-d');

        /* Based on body number or frame number then
         *  update value on T_SQA_VINF table by following description :
          [ok ] REG_IN with Datetime(now)
          [ok ] AUDIT_PDATE with production master date (PDATE) on M_SQA_PRDT table (key : plant code from your user login)
          [ok ] AUDIT_SYSDATE with Datetime(now)
          [ok ] AUDIT_SHIFTGRPNM with SHIFTGRP_NM on M_SQA_SHIFTGRP table (key : Plant_Cd and SHIFTGRP_ID from your user login)
          [ok ] STALL_NO with Stall Selected in "Auditor" form
          [ok ] set STALL_STS with 1 ( table M_SQA_STALL based on STALL_NO)
          [ok ] Change Status FINISH at Datagrid from "Not Yet" become "Finish"

          @todo: 20110510 -
         *
          If only INSP_PDATE= Blank then
          get INSP_PDATE from QIS DB (T_DFCT table based on VINNO - Oldest CHKPDATE)
          get INSP_SYSDATE from QIS DB (T_DFCT table based on VINNO - Oldest CHKSYSDATE)
          get INSP_SHIFTGRPNM from QIS DB (T_DFCT table based on VINNO - CHKSHIFTGRP)

          Change label button from "Reg In" to "Cancel Reg IN" and enable it
          Change label button from "Cancel / REG OUT" to "Reg OUT" and enable it
          Show Message Confirmation : Update Reg In Status in Vehicle [ ] Complete
         */

        // get vin terlebih dahulu
        $this->dm->init('T_SQA_VINF', 'BODY_NO');
        $vin = $this->dm->select('', '', "BODY_NO = '" . $body_no . "'");
        $vin = $vin[0];

        $insp_pdate = $vin->INSP_PDATE;
        $insp_sysdate = $vin->INSP_SYSDATE;
        $insp_shiftgrpnm = $vin->INSP_SHIFTGRPNM;
        
        // gak usah karena sdh dicek saat barcode
        /*if ($insp_pdate == '' || $insp_pdate == null) {            
            // @todo ambil dari QIS DB, how to connect to QIS DB?
            // update T_SQA_VINF set INSP_PDATE = PDATE dari QIS
            // get dfct from QIS db                        
            $cek = $this->load->database('dbqis', true);
            $dfct_qis = $cek->query("select top 1 T_DFCT.CHKPDATE, T_DFCT.CHKPSHIFT from T_DFCT where T_DFCT.LINE = '1' AND T_DFCT.BODY_NO = '".$body_no."' order by T_DFCT.CHKPDATE asc")->result();
            if (count($dfct_qis)>0) {
                $insp_pdate = $dfct_qis[0]->CHKPDATE;
                $insp_shiftgrpnm = $dfct_qis[0]->CHKPSHIFT;
            }
        }*/
        
        /** edited 20110811, cek dulu apakah stall nya memang masih available atau tidak (concurency) */
        $this->dm->init('M_SQA_STALL', 'STALL_NO');
        $w_cek = "(PLANT_CD = '" . get_user_info($this, 'PLANT_CD') . "') AND
                    (STALL_NO = '" . $stall_no . "') AND 
                    (STALL_STS = '0')";
        $cek = $this->dm->count($w_cek);
        if ($cek != 0) {
            
            // load lagi T_SQA_VINF nya
            $this->dm->init('T_SQA_VINF', 'BODY_NO');
            
            $keys = "BODY_NO = '" . $body_no . "'";
            $data = array(
                'REG_IN' => get_date(),
                'AUDIT_PDATE' => $prdt,
                'AUDIT_SYSDATE' => get_date(),
                'AUDIT_SHIFTGRPNM' => get_user_info($this, 'SHIFTTGRP_NM'),
                'STALL_NO' => $stall_no,
                'AUDITOR_NM_1' => $auditor1,
                'AUDITOR_NM_2' => $auditor2,
                'INSP_PDATE' => $insp_pdate,
                'INSP_SYSDATE' => $insp_sysdate,
                'INSP_SHIFTGRPNM' => $insp_shiftgrpnm
            );
            $this->dm->update($data, $keys);
    
            // update stall_sts with 1
            $this->dm->init('M_SQA_STALL');
            $keys = "STALL_NO = '" . $stall_no . "' AND PLANT_CD = '" . get_user_info($this, 'PLANT_CD') . "'"; 
            $data = array('STALL_STS' => '1', 'Updateby' => get_user_info($this, 'USER_ID'), 'Updatedt' => get_date());
            $this->dm->update($data, $keys);
            echo '1';      
        } else {
            echo 'ERR_STALL';
        }

              
    }

    function reg_in_cancel() {                

        /*
          [ok ] then clear REG_IN, AUDIT_PDATE,AUDIT_SYSDATE,AUDIT_SHIFTGRPNM value on T_SQA_VINF table
          [ok ] Delete all defect in T_SQA_DFCT based on VINNO selected                              
         */

        // ambil bodyno
        $body_no = $_POST['bodyno'];
        
        // get vin terlebih dahulu
        $this->dm->init('T_SQA_VINF', 'BODY_NO');
        $vin = $this->dm->select('', '', "BODY_NO = '" . $body_no . "'");
        $vin = $vin[0];
        
        // update stall status, sebelum di null kan
        $data = array('STALL_STS' => '0', 'Updateby' => get_user_info($this, 'USER_ID'), 'Updatedt' => get_date());
        $keys = "STALL_NO = '" . $vin->STALL_NO . "'";
        $this->dm->init('M_SQA_STALL');
        $this->dm->update($data, $keys);
        
        $keys = "BODY_NO = '" . $body_no . "'";
        $data = array(
            'REG_IN' => null,
            'AUDIT_PDATE' => null,
            'AUDIT_SYSDATE' => null,
            'AUDIT_SHIFTGRPNM' => null,
            'AUDIT_FINISH_PDATE' => null,
            'AUDIT_FINISH_SYSDATE' => null,
            'STALL_NO' => null,
            'AUDITOR_NM_1' => null,
            'AUDITOR_NM_2' => null
            
        );
        $this->dm->init('T_SQA_VINF', 'BODY_NO');
        $this->dm->update($data, $keys);

        // delete all defect
        $keys = array('BODYNO' => $body_no);
        $this->dm->init('T_SQA_DFCT');
        $this->dm->delete($keys); 
    }

    function reg_out() {
        $this->dm->init('T_SQA_VINF', 'BODY_NO');

        // update status REG_IN jadi get_date()
        // ambil bodyno
        $body_no = $_POST['bodyno'];
        $keys = "BODY_NO = '" . $body_no . "'";
        $data = array(
            'REG_OUT' => get_date()
        );
        $this->dm->update($data, $keys);
        
        // get vin terlebih dahulu
        $this->dm->init('T_SQA_VINF', 'BODY_NO');
        $vin = $this->dm->select('', '', "BODY_NO = '" . $body_no . "'");
        $vin = $vin[0];
        
        // update stall status
        $data = array('STALL_STS' => '0', 'Updateby' => get_user_info($this, 'USER_ID'), 'Updatedt' => get_date());
        $keys = "STALL_NO = '" . $vin->STALL_NO . "'";
        $this->dm->init('M_SQA_STALL');
        $this->dm->update($data, $keys);
    }

    function reg_out_cancel() {
        $this->dm->init('T_SQA_VINF', 'BODY_NO');

        // update status REG_IN jadi get_date()
        // ambil bodyno
        $body_no = $_POST['bodyno'];
        $keys = "BODY_NO = '" . $body_no . "'";
        $data = array(
            'REG_OUT' => null
        );
        $this->dm->update($data, $keys);
    }

    function search_dfct() {
        $dfct = $_POST['dfct'];
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
        $w = "DFCT LIKE '%" . $dfct . "%'";
        $result = $this->dm->select('', '', $w);

        if (count($result) > 0) {
            echo '1';
        } else {
            echo '0';
        }
    }

    function add_dfct() {
        // init dfct table first
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');

        $plant_nm = $_POST['plant_nm'];
        $shftgrp_nm = $_POST['shftgrp_nm'];
        $idno = $_POST['idno'];
        $body_no = $_POST['body_no'];
        $refno = $_POST['refno'];
        $vinno = $_POST['vinno'];

        $problem_id = $_POST['problem_id'];
        $dfct_id = $_POST['dfct_id'];
        $dfct = $_POST['dfct'];
        $rank_nm = $_POST['rank_nm'];
        $ctg_grp_id = $_POST['ctg_grp_id'];
        $ctg_nm = $_POST['ctg_nm'];
        $shop_nm = $_POST['shop_nm'];
        $measurement = $_POST['measurement'];
        $refval = htmlspecialchars($_POST['refval']);
        $conf_by_qcd = $_POST['conf_by_qcd'];
        $conf_by_related = $_POST['conf_by_related'];
        $insp_item_flag = $_POST['insp_item_flag'];
        $qlty_gt_item = $_POST['qlty_gt_item'];
        $repair_flg = $_POST['repair_flg'];
        $auditor_nm_1 = $_POST['auditor_nm_1'];
        $auditor_nm_2 = $_POST['auditor_nm_2'];
				
		// validasi reference value
		$refval = str_replace('♦', '&diams;', $refval);
		$refval = str_replace('±', '&plusmn;', $refval);
		$refval = str_replace('≤', '&le;', $refval);
		$refval = str_replace('≥', '&ge;', $refval);
		$refval = str_replace('Ø', '&Oslash;', $refval);		

        // get ctg_grp_nm        
        $this->dm->init('M_SQA_CTG_GRP', 'CTG_GRP_ID');
        $grp = $this->dm->select('', '', "CTG_GRP_ID = '" . $ctg_grp_id . "'");
        $ctg_grp_nm = (count($grp) > 0) ? $grp[0]->CTG_GRP_NM : '';
        
        // get current pdate        
        $this->dm->init('M_SQA_PRDT', 'PLANT_CD');
        $prdt = $this->dm->select('', '', "PLANT_CD = '" . get_user_info($this, 'PLANT_CD') . "'");
        $prdt = (count($prdt) > 0) ? $prdt[0]->PDATE : date('Y-m-d');

        if ($problem_id == '' || $problem_id == '0') {
            // sql self for newid()
            $sql = "
                    DECLARE @MyIdentity uniqueidentifier;
                    SET @MyIdentity = NewID();

                    INSERT INTO T_SQA_DFCT (
                        PROBLEM_ID,
                        PLANT_NM,
                        IDNO,
                        BODYNO,
                        REFNO,
                        VINNO,
                        DFCT,
                        RANK_NM,
                        CTG_GRP_NM,
                        CTG_NM,
                        MEASUREMENT,
                        REFVAL,
                        INSP_ITEM_FLG,
                        REPAIR_FLG,
                        QLTY_GT_ITEM,
                        AUDITOR_NM_1,
                        AUDITOR_NM_2,
                        
                        SQA_PDATE,
                        SQA_SHIFTGRPNM,
                        SQA_SYSDATE,
                        CLOSE_FLG,
                        IS_DELETED,
                        SHOP_NM,
                        updateby,
                        updatedt)
                VALUES (
                        @MyIdentity,
                        '" . $plant_nm . "',
                        '" . $idno . "',
                        '" . $body_no . "',
                        '" . $refno . "',
                        '" . $vinno . "',
                        '" . $dfct . "',
                        '" . $rank_nm . "',
                        '" . $ctg_grp_nm . "',
                        '" . $ctg_nm . "',
                        '" . $measurement . "',
                        '" . $refval . "',
                        '" . $insp_item_flag . "',
                        '" . $repair_flg . "',
                        '" . $qlty_gt_item . "',
                        '" . $auditor_nm_1 . "',
                        '" . $auditor_nm_2 . "',
                            
                        '" . $prdt . "',
                        '" . $shftgrp_nm . "',
                        '" . get_date() . "',
                        '0',
                        '0',
                        '" . $shop_nm . "', 
                        '" . get_user_info($this, 'USER_ID') . "',
                        '" . get_date() . "'
                );
                SELECT @MyIdentity as PROBLEM_ID;
                ";                
            $this->dm->sql_self($sql);            
            $sql_retrieve_new_problem_id = "
                select TOP 1 PROBLEM_ID from T_SQA_DFCT where BODYNO = '".$body_no."' and VINNO = '" . $vinno . "' order by updatedt desc
            ";
            $d = $this->dm->sql_self($sql_retrieve_new_problem_id);
            $problem_id = $d[0]->PROBLEM_ID;
            
            //echo 'prob_id : ' . $problem_id;

            // isikan ke dalam conf_by qcds
            if ($conf_by_qcd != '') {
                $conf_by_qcd .= ';';
                $conf_by_qcd_x = explode(';', $conf_by_qcd);
                
                $temp_cb = '';
                foreach ($conf_by_qcd_x as $conf) {                    
                    if ($conf != '') {
                        
                        // cek apakah sama
                        if ($temp_cb != $conf) {
                            $temp_cb = $conf;
                            
                            // insert here to T_SQA_CONFBY
                            $this->dm->init('T_SQA_DFCT_CONFBY');
                            $data = array(
                                'PROBLEM_ID' => $problem_id,
                                'CONF_BY' => $conf,
                                'CONF_SYSDATE' => get_date(),
                                'CONF_TYPE' => 0,
                                'Updateby' => get_user_info($this, 'USER_ID'),
                                'Updatedt' => get_date()
                            );
                            $this->dm->insert($data);
                            
                        }                                                
                    }
                }
            }

            // isikan ke dalam conf_by related
            if ($conf_by_related != '') {
                $conf_by_related .= ';';
                $conf_by_related_x = explode(';', $conf_by_related);
                $temp_cb = '';
                foreach ($conf_by_related_x as $conf) {
                    if ($conf != '') {
                        
                        // cek apakah tdk sama
                        if ($temp_cb != $conf) {
                            $temp_cb = $conf;
                            
                            // insert here to T_SQA_CONFBY
                            $this->dm->init('T_SQA_DFCT_CONFBY');
                            $data = array(
                                'PROBLEM_ID' => $problem_id,
                                'CONF_BY' => $conf,
                                'CONF_SYSDATE' => get_date(),
                                'CONF_TYPE' => 1,
                                'Updateby' => get_user_info($this, 'USER_ID'),
                                'Updatedt' => get_date()
                            );
                            $this->dm->insert($data);    
                        }
                    }
                }
            }

            /*
             * CANCELED -- Insert into responsible refer to dokumen works-daily-todo
             * di insert ketika defect ini di approve
             */
            echo $problem_id;
        } else {
            // edit defect by problem id
            $data = array(
                'DFCT' => $dfct,
                'RANK_NM' => $rank_nm,
                'CTG_GRP_NM' => $ctg_grp_nm,
                'CTG_NM' => $ctg_nm,
                'MEASUREMENT' => $measurement,
                'REFVAL' => $refval,
                'INSP_ITEM_FLG' => $insp_item_flag,
                'REPAIR_FLG' => $repair_flg,
                'QLTY_GT_ITEM' => $qlty_gt_item,
                'AUDITOR_NM_1' => $auditor_nm_1,
                'AUDITOR_NM_2' => $auditor_nm_2,
                'SQA_SYSDATE' => get_date(),
                'SHOP_NM' => $shop_nm,
                'Updateby' => get_user_info($this, 'USER_ID'),
                'Updatedt' => get_date()
            );
            $keys = "PROBLEM_ID = '" . $problem_id . "'";
            $this->dm->init('T_SQA_DFCT');
            $this->dm->update($data, $keys);

            // hapus dulu semua di CONF_BY where PROBLEM_ID nya sama
            $keys = "PROBLEM_ID = '" . $problem_id . "'";
            $this->dm->init('T_SQA_DFCT_CONFBY');
            $this->dm->delete($keys);

            // isikan ke dalam conf_by qcds
            if ($conf_by_qcd != '') {
                $conf_by_qcd .= ';';
                $conf_by_qcd_x = explode(';', $conf_by_qcd);
                foreach ($conf_by_qcd_x as $conf) {
                    if ($conf != '') {
                        // insert here to T_SQA_CONFBY
                        $this->dm->init('T_SQA_DFCT_CONFBY');
                        $data = array(
                            'PROBLEM_ID' => $problem_id,
                            'CONF_BY' => $conf,
                            'CONF_SYSDATE' => get_date(),
                            'CONF_TYPE' => 0,
                            'Updateby' => get_user_info($this, 'USER_ID'),
                            'Updatedt' => get_date()
                        );
                        $this->dm->insert($data);
                    }
                }
            }

            // isikan ke dalam conf_by related
            if ($conf_by_related != '') {
                $conf_by_related .= ';';
                $conf_by_related_x = explode(';', $conf_by_related);
                foreach ($conf_by_related_x as $conf) {
                    if ($conf != '') {
                        // insert here to T_SQA_CONFBY
                        $this->dm->init('T_SQA_DFCT_CONFBY');
                        $data = array(
                            'PROBLEM_ID' => $problem_id,
                            'CONF_BY' => $conf,
                            'CONF_SYSDATE' => get_date(),
                            'CONF_TYPE' => 1,
                            'Updateby' => get_user_info($this, 'USER_ID'),
                            'Updatedt' => get_date()
                        );
                        $this->dm->insert($data);
                    }
                }
            }
            echo 2;
        }
    }

    function get_dfct() {
        //sleep(2);
        $body_no = $_POST['body_no'];

        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
        $w = "BODYNO = '" . $body_no . "' AND (IS_DELETED = '' OR IS_DELETED = '0')";
        $data['list_dfct'] = $this->dm->select('', '', $w);
        $data['problem_id'] = $_POST['problem_id'];
        $this->load->view('t_sqa_dfct/list_dfct', $data);
    }

    function get_dfct_by_problem_id() {
        sleep(1);
        $problem_id = $_POST['problem_id'];
        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
        $w = ($problem_id != '') ? "PROBLEM_ID = '" . $problem_id . "'" : "PROBLEM_ID IS NULL";
        $problem = $this->dm->select('', '', $w);
        if (count($problem) > 0) {
            // ada data, keluarkan, jadikan JSON
            $p = $problem[0];
            $dfct = $p->DFCT;
            $rank_nm = $p->RANK_NM;
            $ctg_grp_id = $p->CTG_GRP_ID;
            $ctg_nm = $p->CTG_NM;
            $measurement = $p->MEASUREMENT;
            $refval = $p->REFVAL;
            $insp_item_flg = $p->INSP_ITEM_FLG;
            $qlty_gt_item = $p->QLTY_GT_ITEM;
            $repair_flg = $p->REPAIR_FLG;
            $shop_nm = $p->SHOP_NM;
            $reg_out = $p->REG_OUT;
            $audit_finish_pdate = $p->AUDIT_FINISH_PDATE;
            $approve_sysdate = ($p->APPROVE_SYSDATE == null) ? '' : $p->APPROVE_SYSDATE;
            $auditor_nm_1 = $p->AUDITOR_NM_1;
            $auditor_nm_2 = $p->AUDITOR_NM_2;
			
			// de-validasi reference value
			$refval = str_replace('&diams;', '♦', $refval);
			$refval = str_replace('&plusmn;', '±', $refval);
			$refval = str_replace('&le;', '≤', $refval);
			$refval = str_replace('&ge;', '≥', $refval);
			$refval = str_replace('&Oslash;', 'Ø', $refval);
			$refval = str_replace('&lt;', '<', $refval);
			$refval = str_replace('&gt;', '>', $refval);
			
            // get conf by qcd & conf by related
            $this->dm->init('T_SQA_DFCT_CONFBY', 'PROBLEM_ID');
            $conf_by_qcd = '';
            $conf_by_qcd_data = $this->dm->select('', '', "PROBLEM_ID = '" . $problem_id . "' AND CONF_TYPE = '0'");
            if (count($conf_by_qcd_data) > 0) {
                $i = 1;
                foreach ($conf_by_qcd_data as $c) {
                    $conf_by_qcd .= $c->CONF_BY;
                    if ($i < count($conf_by_qcd_data)) {
                        $conf_by_qcd .= ';';
                    }
                    $i++;
                }
            }

            $conf_by_related = '';
            $conf_by_related_data = $this->dm->select('', '', "PROBLEM_ID = '" . $problem_id . "' AND CONF_TYPE = '1'");
            if (count($conf_by_related_data) > 0) {
                $i = 1;
                foreach ($conf_by_related_data as $c) {
                    $conf_by_related .= $c->CONF_BY;
                    if ($i < count($conf_by_related_data)) {
                        $conf_by_related .= ';';
                    }
                    $i++;
                }
            }

            $out = array($problem_id, 
                        $dfct, 
                        $rank_nm, 
                        $ctg_grp_id, 
                        $ctg_nm, 
                        $measurement, 
                        $refval, 
                        $insp_item_flg, 
                        $qlty_gt_item, 
                        $repair_flg, 
                        $conf_by_qcd, 
                        $conf_by_related, 
                        $shop_nm,
                        $reg_out,
                        $audit_finish_pdate,
                        $approve_sysdate,
                        $auditor_nm_1,
                        $auditor_nm_2);
            echo json_encode($out);
        } else {
            // data tdk ada, bersihkan frame
            echo 0;
        }
    }

    function delete_dfct() {
        $problem_id = $_POST['problem_id'];
        $keys = "PROBLEM_ID = '" . $problem_id . "'";
        
        // cari attachment nya
        $this->dm->init('T_SQA_DFCT_ATTACH','PROBLEM_ID');
        $cek = $this->dm->select('','',$keys);
        if (count($cek) > 0) {
            foreach ($cek as $c) {
                // del file
                if (file_exists(PATH_ATTCH . $c->ATTACH_DOC)) {
                    unlink(PATH_ATTCH . $c->ATTACH_DOC);
                }
            }
            $this->dm->delete($keys);
        }
         
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
        $dfct = $this->dm->select('','',$keys);
        if (count($dfct) > 0) {
            if (file_exists(PATH_IMG . $dfct[0]->MAIN_IMG)) {
                unlink(PATH_IMG . $dfct[0]->MAIN_IMG);
            }
            if (file_exists(PATH_IMG . $dfct[0]->PART_IMG)) {
                unlink(PATH_IMG . $dfct[0]->PART_IMG);
            }            
        }
        echo $this->dm->delete($keys);
    }

    function upload_img() {
        $img_main = 'none';
        $img_part = 'none';
        $messages = '';
        $img = '';
        
        if ($this->uri->segment(3) == '1') {
            $messages = 'Adding Text to Image Successful, Press Refresh Button if picture doesn\'t change';
        } else if ($this->uri->segment(3) == '2') {
            $messages = 'Adding Rectangle to Image Successful, Press Refresh Button if picture doesn\'t change';
        }
        
        $colset_r = ($this->session->userdata('COLSET_R') == '') ? 132 : $this->session->userdata('COLSET_R');
        $colset_g = ($this->session->userdata('COLSET_G') == '') ? 135 : $this->session->userdata('COLSET_G');
        $colset_b = ($this->session->userdata('COLSET_B') == '') ? 28 : $this->session->userdata('COLSET_B');

        if (isset($_POST['problem_id'])) {
            
            // get color
            $colset_r = $_POST['colset_r'];
            $colset_g = $_POST['colset_g'];
            $colset_b = $_POST['colset_b'];
            
            $this->session->set_userdata('COLSET_R', $colset_r);
            $this->session->set_userdata('COLSET_G', $colset_g);
            $this->session->set_userdata('COLSET_B', $colset_b);            
                        
            $problem_id = $_POST['problem_id'];
            // -=-=-=-=-=-=- BEGIN FILE UPLOAD -=-=-=-=-=-=-
            $err = '';
            $save = false;

            $config[0]['upload_path'] = PATH_IMG;
            //$config[0]['allowed_types'] = 'jpg|jpeg';
            $config[0]['allowed_types'] = '*';

            $config[1]['upload_path'] = PATH_IMG;
            //$config[0]['allowed_types'] = 'jpg|jpeg';
            $config[1]['allowed_types'] = '*';

            // files
            $files[0] = 'userfile_0';
            $files[1] = 'userfile_1';

            // upload
            $errors = $successes = array();

            $this->load->library('upload');
            for ($i = 0, $j = count($files); $i < $j; $i++) {

                $file_x = $_FILES[$files[$i]]['name'];
                if ($file_x != '') {
                    $this->upload->initialize($config[$i]);

                    // hapus file sebelumnya kalau ada
                    $file_name = $config[$i]['upload_path'] . $file_x;
                    if (file_exists($file_name))
                        unlink($file_name);
                    if (!$this->upload->do_upload($files[$i])) {
                        $errors[$files[$i]] = $this->upload->display_errors();
                        $save = false;
                        $err .= '<br/>' . $this->upload->display_errors();
                    } else {
                        $successes[$files[$i]] = $this->upload->data();
                        $save = true;
                    }
                } else {
                    $save = true;
                }
            }
            $messages = array($errors, $successes);
            //echo '<pre>'; print_r($messages); echo '</pre>';

            if (count($successes) > 0) {
                $this->load->library('image_lib');
                $i = 0;
                foreach ($successes as $s) {
                    //echo 'processing: ' . PATH_IMG . $s['file_name'] . "<hr />";
                    // rename it first here
                    $dname = PATH_IMG . $s['file_name'];
                    //echo $dname . '<hr/>';
                    if ($i == 0) {
                        $dname = PATH_IMG . $problem_id . '_main' . $s['file_ext'];
                        //rename(PATH_IMG . $s['file_name'], $dname);
                        copy(PATH_IMG . $s['file_name'], $dname);
                        $img_main = $dname;
                    }
                    if ($i == 1) {
                        $dname = PATH_IMG . $problem_id . '_part' . $s['file_ext'];
                        //rename(PATH_IMG . $s['file_name'], $dname);
                        copy(PATH_IMG . $s['file_name'], $dname);

                        $img_part = $dname;
                    }

                    //create thumbnail
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $dname;
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 400;
                    $config['height'] = 400;
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    //echo 'processing done <br/>';
                    // delete file aslinya
                    if (file_exists($config['source_image'])) {
                        unlink($config['source_image']);
                    }

                    // rename thumb nya
                    $img_temp = str_ireplace('.', '_thumb.', $dname);
                    if (file_exists($img_temp)) {
                        rename($img_temp, $dname);
                    }
                    $i++;
                }
                
                // hapus file aslinya
                foreach ($successes as $s) {
                    $dname = PATH_IMG . $s['file_name'];
                    unlink($dname);
                }
                
                
                $this->dm->init('T_SQA_DFCT');
                $data = array(
                    'MAIN_IMG' => str_ireplace(PATH_IMG, '', $img_main),
                    'PART_IMG' => str_ireplace(PATH_IMG, '', $img_part)
                );
                $keys = "PROBLEM_ID = '" . $problem_id . "'";
                $this->dm->update($data, $keys);
                
                $messages = 'Upload Image Successful, Press Refresh Button if picture doesn\'t change';
            } else { 
                if (!$save) {
                    $messages = 'Upload images failed, please try again';    
                } else {
                    $messages = '';
                }
            }

            // cek jika mau croping
            $save_img = $_POST['save_img'];

            if ($save_img != '1' && $save_img != '2') {
                // mau add text
                $tipenya = ($save_img == 'thumbnail1') ? '_main' : '_part';
                $img = $_POST['img' . $tipenya];

                $xpos = $_POST['xpos_' . $save_img];
                $ypos = $_POST['ypos_' . $save_img];
                $txt_add = $_POST['txt_add'];

                //echo $xpos . ' - ' . $ypos . ' - ' . $txt_add;

                $img_name = $img;
                $img = imagecreatefromjpeg(PATH_IMG . $img);
                $green = imagecolorallocate($img, $colset_r, $colset_g, $colset_b);
                imagestring($img, 5, $xpos, $ypos, $txt_add, $green);
                imagejpeg($img, PATH_IMG . $img_name);
                redirect('t_sqa_dfct/upload_img/1');
            } else {
                // mau rectangle
                $tipenya = ($save_img == 1) ? '_main' : '_part';

                $x1 = $_POST["x1" . $tipenya];
                $y1 = $_POST["y1" . $tipenya];
                $x2 = $_POST["x2" . $tipenya];
                $y2 = $_POST["y2" . $tipenya];
                $img = $_POST['img' . $tipenya];

                if ($x1 != '' && $y1 != '' && $x2 != '' && $y2 != '' && $img != '') {
                    //Scale the image to the thumb_width set above
                    $img_name = $img;
                    $img = imagecreatefromjpeg(PATH_IMG . $img);
                    $green = imagecolorallocate($img, $colset_r, $colset_g, $colset_b);
                    imagerectangle($img, $x1, $y1, $x2, $y2, $green);
                    imagerectangle($img, $x1 - 1, $y1 - 1, $x2 + 1, $y2 + 1, $green);
                    imagerectangle($img, $x1 - 2, $y1 - 2, $x2 + 2, $y2 + 2, $green);
                    imagerectangle($img, $x1 - 3, $y1 - 3, $x2 + 3, $y2 + 3, $green);
                    imagejpeg($img, PATH_IMG . $img_name);
                    redirect('t_sqa_dfct/upload_img/2');
                }
            }
        }

        $data['img_main'] = $img_main;
        $data['img_part'] = $img_part;
        $data['messages'] = $messages;
        
        // default rgb
        $data['colset_r'] = $colset_r;
        $data['colset_g'] = $colset_g;
        $data['colset_b'] = $colset_b;

        $this->load->view('header_plain');
        $this->load->view('t_sqa_dfct/upload', $data);
    }

    function get_img() {
        $out = 0;
        $problem_id = $_POST['problem_id'];
        if ($problem_id != '') {
            $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
            $problem = $this->dm->select('', '', "PROBLEM_ID = '" . $problem_id . "'");
            $out = 0;
            if (count($problem) > 0) {
                $main_img = $problem[0]->MAIN_IMG;
                $part_img = $problem[0]->PART_IMG;
                $out = json_encode(array($main_img, $part_img));
            }
        }
        echo $out;
    }

    function upload_attch() {
        $problem_id = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : '';
        if (isset($_POST['problem_id'])) {
            $problem_id = $_POST['problem_id'];
            // -=-=-=-=-=-=- BEGIN FILE UPLOAD -=-=-=-=-=-=-
            $err = '';
            $save = false;

            $config[0]['upload_path'] = PATH_ATTCH;
            $config[0]['allowed_types'] = '*';

            // files
            $files[0] = 'userfile_0';

            // upload
            $errors = $successes = array();

            $this->load->library('upload');
            for ($i = 0, $j = count($files); $i < $j; $i++) {

                $file_x = $_FILES[$files[$i]]['name'];
                if ($file_x != '') {
                    $this->upload->initialize($config[$i]);

                    // hapus file sebelumnya kalau ada
                    $file_name = $config[$i]['upload_path'] . $file_x;
                    if (file_exists($file_name))
                        unlink($file_name);
                    if (!$this->upload->do_upload($files[$i])) {
                        $errors[$files[$i]] = $this->upload->display_errors();
                        $save = false;
                        $err .= '<br/>' . $this->upload->display_errors();
                    } else {
                        $successes[$files[$i]] = $this->upload->data();
                        $save = true;
                    }
                } else {
                    $save = true;
                }
            }
            $messages = array($errors, $successes);
            if (count($successes) > 0) {
                $file_name = $successes['userfile_0']['file_name'];
                $file_ext = $successes['userfile_0']['file_ext'];
                // insert ke table                
                $sql = "
                        DECLARE @MyIdentity uniqueidentifier;
                        SET @MyIdentity = NewID();

                        INSERT INTO T_SQA_DFCT_ATTACH (
                        PROBLEM_ID,
                        FILE_ID,
                        ATTACH_DOC,
                        ATTACH_NAME,
                        ATTACH_SYSDATE,
                        ATTACH_USERID)

                        VALUES (

                            '" . $problem_id . "',
                            @MyIdentity,
                            null,
                            null,
                            '" . get_date() . "',
                            '" . get_user_info($this, 'USER_ID') . "'

                        );
                        SELECT @MyIdentity as FILE_ID;
                        ";
                $f = $this->dm->sql_self($sql);
                
                $sql_retrieve_new_file_id = "
                    select TOP 1 FILE_ID from T_SQA_DFCT_ATTACH where PROBLEM_ID = '".$problem_id."' order by ATTACH_SYSDATE desc
                ";
                $f = $this->dm->sql_self($sql_retrieve_new_file_id);
                $file_id = $f[0]->FILE_ID;

                // update lagi nama atach docnya, rename dulu tapi
                $new_name = $file_id . $file_ext;
                rename(PATH_ATTCH . $file_name, PATH_ATTCH . $new_name);

                $this->dm->init('T_SQA_DFCT_ATTACH');
                $data = array('ATTACH_DOC' => $new_name, 'ATTACH_NAME' => $file_name);
                $keys = "PROBLEM_ID = '" . $problem_id . "' AND FILE_ID = '" . $file_id . "'";
                $this->dm->update($data, $keys);
            } else {
                if (isset($errors['userfile_0'])) {
                    echo 'Upload Gagal : ' . $errors['userfile_0'];
                }
            }
        }
        $data['problem_id'] = $problem_id;
        $this->load->view('header_plain');
        $this->load->view('t_sqa_dfct/attach', $data);
    }
    

    function get_attch() {
        $problem_id = $_POST['problem_id'];
        $this->dm->init('T_SQA_DFCT_ATTACH', 'PROBLEM_ID');
        $attch = $this->dm->select('', '', "PROBLEM_ID='" . $problem_id . "'");
        $data['attch'] = $attch;
        $this->load->view('t_sqa_dfct/attach_list', $data);
    }

    function remove_attch() {
        $problem_id = $_POST['problem_id'];
        $file_id = $_POST['file_id'];

        // get detail data first
        $this->dm->init('T_SQA_DFCT_ATTACH', 'PROBLEM_ID');
        $attch = $this->dm->select('', '', "PROBLEM_ID='" . $problem_id . "' AND FILE_ID = '" . $file_id . "'");
        if (count($attch) > 0) {
            $attach_doc = $attch[0]->ATTACH_DOC;
            if (file_exists(PATH_ATTCH . $attach_doc)) {
                unlink(PATH_ATTCH . $attach_doc);
            }
            $keys = array('PROBLEM_ID' => $problem_id, 'FILE_ID' => $file_id);
            $this->dm->delete($keys);
        }
    }
    
    function att_sqpr() {
        $problem_id = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : '';
        if (isset($_POST['problem_id'])) {
            $problem_id = $_POST['problem_id'];
            // -=-=-=-=-=-=- BEGIN FILE UPLOAD -=-=-=-=-=-=-
            $err = '';
            $save = false;

            $config[0]['upload_path'] = PATH_ATTCH;
            $config[0]['allowed_types'] = '*';

            // files
            $files[0] = 'userfile_0';

            // upload
            $errors = $successes = array();

            $this->load->library('upload');
            for ($i = 0, $j = count($files); $i < $j; $i++) {

                $file_x = $_FILES[$files[$i]]['name'];
                if ($file_x != '') {
                    $this->upload->initialize($config[$i]);

                    // hapus file sebelumnya kalau ada
                    $file_name = $config[$i]['upload_path'] . $file_x;
                    if (file_exists($file_name))
                        unlink($file_name);
                    if (!$this->upload->do_upload($files[$i])) {
                        $errors[$files[$i]] = $this->upload->display_errors();
                        $save = false;
                        $err .= '<br/>' . $this->upload->display_errors();
                    } else {
                        $successes[$files[$i]] = $this->upload->data();
                        $save = true;
                    }
                } else {
                    $save = true;
                }
            }
            $messages = array($errors, $successes);
            if (count($successes) > 0) {
                $file_name = $successes['userfile_0']['file_name'];
                $file_ext = $successes['userfile_0']['file_ext'];
                // insert ke table                
                $sql = "
                        DECLARE @MyIdentity uniqueidentifier;
                        SET @MyIdentity = NewID();

                        INSERT INTO T_SQA_DFCT_SQPR_ATTACH (
                        PROBLEM_ID,
                        FILE_ID,
                        SQPR_DOC,
                        SQPR_NAME,
                        SQPR_SYSDATE,
                        SQPR_USERID)

                        VALUES (

                            '" . $problem_id . "',
                            @MyIdentity,
                            null,
                            null,
                            '" . get_date() . "',
                            '" . get_user_info($this, 'USER_ID') . "'

                        );
                        SELECT @MyIdentity as FILE_ID;
                        ";
                $f = $this->dm->sql_self($sql);
                
                $sql_retrieve_new_file_id = "
                    select TOP 1 FILE_ID from T_SQA_DFCT_SQPR_ATTACH where PROBLEM_ID = '".$problem_id."' order by SQPR_SYSDATE desc
                ";
                $f = $this->dm->sql_self($sql_retrieve_new_file_id);
                $file_id = $f[0]->FILE_ID;

                // update lagi nama atach docnya, rename dulu tapi
                $new_name = $file_id . $file_ext;
                rename(PATH_ATTCH . $file_name, PATH_ATTCH . $new_name);

                $this->dm->init('T_SQA_DFCT_SQPR_ATTACH');
                $data = array('SQPR_DOC' => $new_name, 'SQPR_NAME' => $file_name);
                $keys = "PROBLEM_ID = '" . $problem_id . "' AND FILE_ID = '" . $file_id . "'";
                $this->dm->update($data, $keys);
            } else {
                if (isset($errors['userfile_0'])) {
                    echo 'Upload Gagal : ' . $errors['userfile_0'];
                }
            }
        }
        $data['problem_id'] = $problem_id;
        $this->load->view('header_plain');
        $this->load->view('t_sqa_dfct/att_sqpr', $data);
    }
    
    function get_att_sqpr() {
        $problem_id = $_POST['problem_id'];
        $this->dm->init('T_SQA_DFCT_SQPR_ATTACH', 'PROBLEM_ID');
        $attch = $this->dm->select('', '', "PROBLEM_ID='" . $problem_id . "'");
        $data['attch'] = $attch;
        $this->load->view('t_sqa_dfct/attach_list_sqpr', $data);
    }

    function remove_att_sqpr() {
        $problem_id = $_POST['problem_id'];
        $file_id = $_POST['file_id'];

        // get detail data first
        $this->dm->init('T_SQA_DFCT_SQPR_ATTACH', 'PROBLEM_ID');
        $attch = $this->dm->select('', '', "PROBLEM_ID='" . $problem_id . "' AND FILE_ID = '" . $file_id . "'");
        if (count($attch) > 0) {
            $attach_doc = $attch[0]->ATTACH_DOC;
            if (file_exists(PATH_ATTCH . $attach_doc)) {
                unlink(PATH_ATTCH . $attach_doc);
            }
            $keys = array('PROBLEM_ID' => $problem_id, 'FILE_ID' => $file_id);
            $this->dm->delete($keys);
        }
    }
    
    function print_cs() {
        $body_no = $this->uri->segment(3);

        $this->load->library('pdf');
        $this->pdf->SetSubject('CHECK SHEET REPAIR - SQA');
        $this->pdf->SetFont('helvetica', '', 8);

        // set default header data
        $ht = 'PT. Toyota Motor MFG Indonesia';
        $this->pdf->SetHeaderData('toyota_logo.jpg', 10, $ht, "QAD - Customer Quality Audit\nAudit Section\n\n");
        $this->pdf->setPrintHeader(true);
        $this->pdf->setPrintFooter(true);
        $this->pdf->setTopMargin(65);
        $this->pdf->SetLeftMargin(10);
        $this->pdf->setPageOrientation('P');

        // array of detail vinf
        $this->dm->init('T_SQA_VINF', 'BODY_NO');
        $detail_vinf = $this->dm->select('', '', "BODY_NO = '" . $body_no . "'");
        if (count($detail_vinf) > 0) {
            $this->pdf->setVinf($detail_vinf[0]);
        }

        // list of dfct
        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
        $dfct = $this->dm->select('', '', "BODYNO = '" . $body_no . "'");
        $data['dfct'] = $dfct;

        $data['something'] = 'hah';

        $this->pdf->AddPage();
        $html = $this->load->view('t_sqa_dfct/print_cs', $data, true);
        $this->pdf->writeHTML($html, true, false, true, false, '');
        $this->pdf->Output('Check Sheet Repair - SQA.pdf', 'I');
    }

    function finish_audit() {
        $body_no = $_POST['body_no'];
        $this->dm->init('T_SQA_VINF', 'BODY_NO');
        $vin = $this->dm->select('', '', "BODY_NO = '" . $body_no . "'");
        $out = 0;
        if (count($vin) > 0) {
            $vin = $vin[0];
            if ($vin->AUDIT_FINISH_PDATE != '' || $vin->REG_IN != '' || $vin->REG_OUT == '') {
                // get pdate
                $this->dm->init('M_SQA_PRDT', 'PLANT_CD');
                $pdate = $this->dm->select('', '', "PLANT_CD = '" . get_user_info($this, 'PLANT_CD') . "'", 'PDATE');
                $pdate = (count($pdate) > 0) ? $pdate[0]->PDATE : get_date();

                $data = array(
                    'AUDIT_FINISH_PDATE' => $pdate,
                    'AUDIT_FINISH_SYSDATE' => get_date(),
                    'AUDIT_SHIFTGRPNM' => get_user_info($this, 'SHIFTTGRP_NM'),
                );
                $keys = "BODY_NO = '" . $body_no . "'";
                $this->dm->init('T_SQA_VINF');
                $this->dm->update($data, $keys);

                // update stall status
                $data = array('STALL_STS' => '0', 'Updateby' => get_user_info($this, 'USER_ID'), 'Updatedt' => get_date());
                $keys = "STALL_NO = '" . $vin->STALL_NO . "'";
                $this->dm->init('M_SQA_STALL');
                $this->dm->update($data, $keys);
                $out = 1;
            } else {
                $out = 2;
            }
        }
        echo $out;
    }

    function vin_history() {
        $body_no = $this->uri->segment(3);
        $print = $this->uri->segment(4);
        $vin = '';
        if ($body_no != '') {
            $this->dm->init('T_SQA_VINF', 'BODY_NO');
            $w = "BODY_NO = '" . $body_no . "'";
            $vehicle = $this->dm->select('','',$w);
            $vin = $vehicle[0];            
        }
        $data['vin'] = $vin;
        $data['print'] = $print;
        
        // get dfct by body_no
        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
        $w = "BODYNO = '" . $body_no . "' AND (IS_DELETED = '' OR IS_DELETED = '0')";
        $data['list_dfct'] = $this->dm->select('', '', $w);
        
        // find confirmation by qcd / div
        $list_confby = array();
        foreach ($data['list_dfct'] as $l) {
            $problem_id = $l->PROBLEM_ID;
            $this->dm->init('T_SQA_DFCT_CONFBY', 'PROBLEM_ID');
            $list_confby_qcd = $this->dm->select('','',"PROBLEM_ID = '" . $problem_id . "' and CONF_TYPE = '0'");
            $list_confby_div = $this->dm->select('','',"PROBLEM_ID = '" . $problem_id . "' and CONF_TYPE = '1'");
            $list_confby[$problem_id] = array($list_confby_qcd, $list_confby_div);
        }
        $data['list_confby'] = $list_confby;
        
        // get dfct from QIS db
        $this->dm->init_dbqis('T_DFCT', 'TDFCT_ID');
        $w = "BODY_NO = '" . $body_no . "' and (IDFCT <> '' or IDFCT <> null)";
        $data['list_dfctqis'] = $this->dm->select_qis('','',$w);
                
        if ($print == ''):
            $this->load->view('header_plain');
            $this->load->view('t_sqa_dfct/vin_history', $data);
        else: 
            $this->load->view('t_sqa_dfct/vin_history_print', $data);
        endif;
    }
/*     * ************************************************************************
     * 
     * @description: Problem Report & Problem Reply
     * 
     * ************************************************************************ */

    function remove_attch_reply() {
        $problem_id = $_POST['problem_id'];
        $file_id = $_POST['file_id'];
		
        // get detail data first
        $this->dm->init('T_SQA_DFCT_REPLY_ATTACH', 'PROBLEM_REPLY_ID');
        $attch = $this->dm->select('', '', "PROBLEM_REPLY_ID='" . $problem_id . "' AND FILE_ID = '" . $file_id . "'");

        if (count($attch) > 0) {
            $attach_doc = $attch[0]->ATTACH_DOC;
            if (file_exists(PATH_ATTCH . $attach_doc)) {
                unlink(PATH_ATTCH . $attach_doc);
                $keys = array('PROBLEM_REPLY_ID' => $problem_id, 'FILE_ID' => $file_id);
                $this->dm->delete($keys);
            }
        }
    }

    function get_attch_reply() {
        $problem_id = $_POST['problem_id'];
        $this->dm->init('T_SQA_DFCT_REPLY_ATTACH', 'PROBLEM_REPLY_ID');
        $attch = $this->dm->select('', '', "PROBLEM_REPLY_ID='" . $problem_id . "'");
        $data['attch'] = $attch;
        $this->load->view('t_sqa_dfct/attach_list_reply', $data);
    }

    function upload_attch_reply() {
        $problem_id = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : '';
        if (isset($_POST['problem_id'])) {
            $problem_id = $_POST['problem_id'];
            // -=-=-=-=-=-=- BEGIN FILE UPLOAD -=-=-=-=-=-=-
            $err = '';
            $save = false;

            $config[0]['upload_path'] = PATH_ATTCH;
            //$config[0]['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|txt|rtf|jpg|jpeg|gif|bmp|jar|rar|zip';
            $config[0]['allowed_types'] = '*';

            // files
            $files[0] = 'userfile_0';

            // upload
            $errors = $successes = array();

            $this->load->library('upload');
            for ($i = 0, $j = count($files); $i < $j; $i++) {

                $file_x = $_FILES[$files[$i]]['name'];
                if ($file_x != '') {
                    $this->upload->initialize($config[$i]);

                    // hapus file sebelumnya kalau ada
                    $file_name = $config[$i]['upload_path'] . $file_x;
                    if (file_exists($file_name))
                        unlink($file_name);
                    if (!$this->upload->do_upload($files[$i])) {
                        $errors[$files[$i]] = $this->upload->display_errors();
                        $save = false;
                        $err .= '<br/>' . $this->upload->display_errors();
                    } else {
                        $successes[$files[$i]] = $this->upload->data();
                        $save = true;
                    }
                } else {
                    $save = true;
                }
            }
            $messages = array($errors, $successes);
            //debug_array($messages);
            if (count($successes) > 0) {
                $file_name = $successes['userfile_0']['file_name'];
                $file_ext = $successes['userfile_0']['file_ext'];

                // insert ke table                
                $sql = "
                        DECLARE @MyIdentity uniqueidentifier;
                        SET @MyIdentity = NewID();

                        INSERT INTO T_SQA_DFCT_REPLY_ATTACH (
                        PROBLEM_REPLY_ID,
                        FILE_ID,
                        ATTACH_DOC,
						ATTACH_NAME,
                        ATTACH_SYSDATE,
                        ATTACH_USERID)
                      VALUES (

                            '" . $problem_id . "',
                            @MyIdentity,
                            null,
							'" . $file_name . "',
                            '" . get_date() . "',
                            '" . get_user_info($this, 'USER_ID') . "'

                        );
                        SELECT @MyIdentity as FILE_ID;
                        ";
                $f = $this->dm->sql_self($sql);
                                
                $sql_retrieve_new_file_id = "
                    select TOP 1 FILE_ID from T_SQA_DFCT_REPLY_ATTACH where PROBLEM_REPLY_ID = '".$problem_id."' order by ATTACH_SYSDATE desc
                ";
                $f = $this->dm->sql_self($sql_retrieve_new_file_id);                
                                                                
                $file_id = $f[0]->FILE_ID;

                // update lagi nama atach docnya, rename dulu tapi
                $new_name = $file_id . $file_ext;
                rename(PATH_ATTCH . $file_name, PATH_ATTCH . $new_name);

                $this->dm->init('T_SQA_DFCT_REPLY_ATTACH');
                $data = array('ATTACH_DOC' => $new_name);
                $keys = "PROBLEM_REPLY_ID = '" . $problem_id . "' AND FILE_ID = '" . $file_id . "'";
                $this->dm->update($data, $keys);
            } else {
                if (isset($errors['userfile_0'])) {
                    echo 'Upload Gagal : ' . $errors['userfile_0'];
                }
            }
        }
        $data['problem_id'] = $problem_id;
        $this->load->view('header_plain');
        $this->load->view('t_sqa_dfct/attach_reply', $data);
    }

    function reply_sqa() {
        $problem_id = $this->uri->segment(3); // $_POST['problem_id'];        
        $url_from = $this->uri->segment(4);
        $vinno = $this->uri->segment(5); // $_POST['vinno'];
//        $vinno = 'xxxxxxxxxxxxxxxxx'; 
//        $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';

        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
        $where = "PROBLEM_ID = '" . $problem_id . "'";
        $dfct = $this->dm->select('', '', $where);
        if (count($dfct) > 0) {
            $dfct = $dfct[0];
            $frame_no = $vinno;
            $idno == $dfct->IDNO;
            $plant_nm == $dfct->PLANT_NM;
            $refno == $dfct->REFNO;
            $prb_sheet_num = $dfct->PRB_SHEET_NUM;
            $measurement = $dfct->MEASUREMENT;
            $refval = $dfct->REFVAL;
            $sqpr_num = $dfct->SQPR_NUM;
            $dfct_desc = $dfct->DFCT;
            $main_img = $dfct->MAIN_IMG;
            $part_img = $dfct->PART_IMG;
            $katashiki = $dfct->KATASHIKI;
            $shop_nm = $dfct->SHOP_NM;
            $auditor1 = $dfct->AUDITOR_NM_1;
            $auditor2 = $dfct->AUDITOR_NM_2;
            $plant_nm = $dfct->PLANT_NM;
            $checked_by = $dfct->CHECKED_BY;
            $approved_by = $dfct->APPROVED_BY;
            $approve_pdate = $dfct->APPROVE_PDATE;
            $bodyno = $dfct->BODYNO;
            $frame_no = $vinno;
            $suffix = $dfct->SUFFIX;
            $bd_seq = $dfct->BD_SEQ;
            $assy_seq = $dfct->ASSY_SEQ;
            $model_code = $dfct->KATASHIKI;
            $insp_sysdate = $dfct->INSP_SYSDATE;
            $insp_item_flg_status = $dfct->INSP_ITEM_FLG;
            $insp_pdate = $dfct->INSP_PDATE;
            $color = $dfct->EXTCLR;
            $sqa_shiftgrpnm = $dfct->SQA_SHIFTGRPNM;
            $approved_by = $dfct->APPROVED_BY;
            $checked_by = $dfct->CHECKED_BY;
            $assy_pdate = $dfct->ASSY_PDATE;
            $rank_nm = $dfct->RANK_NM;
            $rank_nm2 = $dfct->RANK_NM2;
            $ctg_grp_nm = $dfct->CTG_GRP_NM;
            $ctg_nm = $dfct->CTG_NM;
            $close_flg = $dfct->CLOSE_FLG;
            $is_deleted = $dfct->IS_DELETED;
            //Update by Ipan 20111216 1639
            $description = $dfct->DESCRIPTION;
            
            if ($dfct->INSP_ITEM_FLG == 1
            )
                $insp_item_flg = 'Yes'; else
                $insp_item_flg='No';
            if ($dfct->QLTY_GT_ITEM == 1
            )
                $qlty_gt_item = 'Yes'; else
                $qlty_gt_item='No';
            if ($dfct->REPAIR_FLG == 1
            )
                $repair_flg = 'Yes'; else
                $repair_flg='No';

            /* T_SQA_DFCT_CONFBY  */
            $this->dm->init('T_SQA_DFCT_CONFBY', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_dfct_conf'] = $this->dm->select('', '', $where);
            /* END T_SQA_DFCT_CONFBY  */

            /* T_SQA_DFCT_REPLY */
            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_reply'] = $this->dm->select('', '', $where);
            /* END T_SQA_DFCT_REPLY */

            /* T_SQA_DFCT_ATTACH */
            $this->dm->init('T_SQA_DFCT_ATTACH', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $dfct_attach = $this->dm->select('', '', $where);
            $dfct_attach = $dfct_attach[0];
            $attach_doc = $dfct_attach->ATTACH_DOC;
            $data['attach_doc'] = $attach_doc;
            /* END T_SQA_DFCT_ATTACH_HIST */

            /* T_SQA_VINF */
            $this->dm->init('T_SQA_VINF', 'BODY_NO');
            $where = "BODY_NO = '" . $bodyno . "'";
            $dfct_vinf = $this->dm->select('', '', $where);
            $dfct_vinf = $dfct_vinf[0];
            $dfct_stall = $dfct_vinf->STALL_NO;
            $data['dfct_stall'] = $dfct_stall;
            $data['dfct_stall_desc'] = $dfct->STALL_DESC;
            /* END T_SQA_VINF */


            $pln_cd = get_user_info($this, 'PLANT_CD');
            $data['pln_user'] = get_user_info($this, 'USER_ID');
            $data['shop_user'] = get_user_info($this, 'SHOP_ID');
            $data['user_grpauth'] = get_user_info($this, 'GRPAUTH_ID');

            /* m_sqa_prdt */
            $this->dm->init('M_SQA_PRDT', 'PLANT_CD');
            $where = "PLANT_CD = '" . $pln_cd . "'";
            $dfct_pln_cd = $this->dm->select('', '', $where);
            $dfct_pln_cd = $dfct_pln_cd[0];
            $reply_pdate = $dfct_pln_cd->PDATE;
            $data['reply_pdate'] = $reply_pdate;
            /* end sqa prdt */
            
            // get shop_id by shop_nm
            $this->dm->init('M_SQA_SHOP', 'SHOP_ID');
            $detail_shop = $this->dm->select('','',"SHOP_NM = '" . $shop_nm . "'",'SHOP_ID');
            $shop_id = (count($detail_shop) > 0) ? $detail_shop[0]->SHOP_ID : 0;
            $data['shop_defect'] = $shop_id;

            $data['measurement'] = $measurement;
            $data['refval'] = $refval;
            $data['prb_sheet_num'] = $prb_sheet_num;
            $data['problem_id'] = $problem_id;
            $data['vinno'] = $vinno;
            $data['sqpr_num'] = $sqpr_num;
            $data['dfct_desc'] = $dfct_desc;
            $data['bodyno'] = $bodyno;
            $data['frame_no'] = $frame_no;
            $data['main_img'] = $main_img;
            $data['part_img'] = $part_img;
            $data['sqa_shiftgrpnm'] = $sqa_shiftgrpnm;
            $data['katashiki'] = $katashiki;
            $data['shop_nm'] = $shop_nm;
            $data['auditor1'] = $auditor1;
            $data['auditor2'] = $auditor2;
            $data['plant_nm'] = $plant_nm;
            $data['checked_by'] = $checked_by;
            $data['approved_by'] = $approved_by;
            $data['app_pdate'] = $approve_pdate;
            $data['suffix'] = $suffix;
            $data['bd_seq'] = $bd_seq;
            $data['assy_seq'] = $assy_seq;
            $data['model_code'] = $model_code;
            $data['insp_sysdate'] = $insp_sysdate;
            $data['insp_item_flg_status']=$insp_item_flg_status;
            $data['insp_pdate'] = $insp_pdate;
            $data['color'] = $color;
            $data['approved_by'] = $approved_by;
            $data['checked_by'] = $checked_by;
            $data['assy_pdate'] = $assy_pdate;
            $data['rank_nm'] = $rank_nm;
            $data['rank_nm2'] = $rank_nm2;
            $data['ctg_grp_nm'] = $ctg_grp_nm;
            $data['ctg_nm'] = $ctg_nm;
            $data['insp_item_flg'] = $insp_item_flg;
            $data['qlty_gt_item'] = $qlty_gt_item;
            $data['repair_flg'] = $repair_flg;
            $data['close_flg'] = $close_flg;
            $data['is_deleted'] = $is_deleted;
            //Update by Ipan 20111216 1639
            $data['description'] = $description;
            
            $this->load->view('header', $data);
            $this->load->view('t_sqa_dfct/reply_dfct', $data);
            $this->load->view('t_sqa_dfct/reply_investigasi', $data);
            $this->load->view('footer');
        }
        else {
            $this->load->view('header');
            $this->load->view('footer');
        }
    }

    function report_sqa() {
        $url_from = $this->uri->segment(4);
        $i = $this->uri->segment(5);
        $force_dl = $this->uri->segment(6);
        
        $problem_id = (isset($_POST['problem_id'])) ? $_POST['problem_id'] : $this->uri->segment(3);

        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
		$where = "PROBLEM_ID = '" . $problem_id . "'";
        $dfct = $this->dm->select('', '', $where);                
		
        if (count($dfct) > 0) {
            $dfct = $dfct[0];            
            $frame_no = $dfct->VINNO;            
            
            $insp_item = $dfct->INSP_ITEM_FLG;
            $check_pdate = $dfct->CHECK_PDATE;
            $sqpr_num = $dfct->SQPR_NUM;
            $approve_pdate = $dfct->APPROVE_PDATE;
            $measurement = $dfct->MEASUREMENT;
            $refval = $dfct->REFVAL;
            $idno = (isset($dfct->IDNO)) ? $dfct->IDNO : '';
            $plant_nm = (isset($dfct->PLANT_NM)) ? $dfct->PLANT_NM : '';
            $refno = (isset($dfct->REFNO)) ? $dfct->REFNO : '';
            $prb_sheet_num = $dfct->PRB_SHEET_NUM;
            $sqpr_num = $dfct->SQPR_NUM;
            $dfct_desc = $dfct->DFCT;
            $main_img = $dfct->MAIN_IMG;
            $part_img = $dfct->PART_IMG;
            $katashiki = $dfct->KATASHIKI;
            $shop_nm = $dfct->SHOP_NM;
            $auditor1 = $dfct->AUDITOR_NM_1;
            $auditor2 = $dfct->AUDITOR_NM_2;
            $plant_nm = $dfct->PLANT_NM;
            $checked_by = $dfct->CHECKED_BY;
            $approved_by = $dfct->APPROVED_BY;
            $bodyno = $dfct->BODYNO;            
            $suffix = $dfct->SUFFIX;
            $bd_seq = $dfct->BD_SEQ;
            $assy_seq = $dfct->ASSY_SEQ;
            $model_code = $dfct->KATASHIKI;
            $insp_sysdate = $dfct->INSP_SYSDATE;
            $insp_pdate = $dfct->INSP_PDATE;
            $color = $dfct->EXTCLR;
            $sqa_shiftgrpnm = $dfct->SQA_SHIFTGRPNM;
            $approved_by = $dfct->APPROVED_BY;
            $checked_by = $dfct->CHECKED_BY;
            $assy_pdate = $dfct->ASSY_PDATE;
            $rank_nm = $dfct->RANK_NM;
            $rank_nm2 = $dfct->RANK_NM2;
            $ctg_grp_nm = $dfct->CTG_GRP_NM;
            $ctg_nm = $dfct->CTG_NM;
            $close_flg = $dfct->CLOSE_FLG;
            $is_deleted = $dfct->IS_DELETED;
            //update by Ipan 20111214 1239
            $description = $dfct->DESCRIPTION;
            
            // get shop_id by shop_nm
            $this->dm->init('M_SQA_SHOP', 'SHOP_ID');
            $detail_shop = $this->dm->select('','',"SHOP_NM = '" . $shop_nm . "'",'SHOP_ID');
            $shop_id = (count($detail_shop) > 0) ? $detail_shop[0]->SHOP_ID : 0;
            $data['shop_defect'] = $shop_id;

            if ($dfct->INSP_ITEM_FLG == 1)
                $insp_item_flg = 'Yes'; else
                $insp_item_flg='No';
            if ($dfct->QLTY_GT_ITEM == 1)
                $qlty_gt_item = 'Yes'; else
                $qlty_gt_item='No';
            if ($dfct->REPAIR_FLG == 1)
                $repair_flg = 'Yes'; else
                $repair_flg='No';

            /* T_SQA_DFCT_CONFBY  */
            $this->dm->init('T_SQA_DFCT_CONFBY', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_dfct_conf'] = $this->dm->select('', '', $where);
            /* END T_SQA_DFCT_CONFBY  */

            /* T_SQA_DFCT_REPLY */
            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_reply'] = $this->dm->select('', '', $where);
            /* END T_SQA_DFCT_REPLY */

            /* T_SQA_DFCT_ATTACH */
            $this->dm->init('T_SQA_DFCT_ATTACH', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $dfct_attach = $this->dm->select('', '', $where);
            $attach_doc = '';
            if (count($dfct_attach) > 0) {
                $dfct_attach = $dfct_attach[0];
                $attach_doc = $dfct_attach->ATTACH_DOC;
            }
            //$dfct_attach = $dfct_attach[0];
            //$attach_doc = $dfct_attach->ATTACH_DOC;
            $data['attach_doc'] = $attach_doc;
            /* END T_SQA_DFCT_ATTACH_HIST */

            /* T_SQA_VINF */
            $this->dm->init('T_SQA_VINF', 'BODY_NO');
            $where = "BODY_NO = '" . $bodyno . "'";
            $dfct_vinf = $this->dm->select('', '', $where);
            $dfct_vinf = $dfct_vinf[0];
            $dfct_stall = $dfct_vinf->STALL_NO;
            $data['dfct_stall'] = $dfct_stall;
            $data['dfct_stall_desc'] = $dfct->STALL_DESC;

            /* END T_SQA_VINF */

            $pln_cd = get_user_info($this, 'PLANT_CD');
            $data['pln_user'] = get_user_info($this, 'USER_ID');
            /* m_sqa_prdt */
            $this->dm->init('M_SQA_PRDT', 'PLANT_CD');
            $where = "PLANT_CD = '" . $pln_cd . "'";
            $dfct_pln_cd = $this->dm->select('', '', $where);
            $dfct_pln_cd = $dfct_pln_cd[0];
            $reply_pdate = $dfct_pln_cd->PDATE;
            $data['reply_pdate'] = $reply_pdate;
            /* end sqa prdt */                        
            
            $data['insp_item'] = $insp_item;
            $data['sqpr_num'] = $sqpr_num;
            $data['check_pdate'] = $check_pdate;
            $data['measurement'] = $measurement;
            $data['refval'] = $refval;
            $data['prb_sheet_num'] = $prb_sheet_num;
            $data['problem_id'] = $problem_id;
            $data['sqpr_num'] = $sqpr_num;
            $data['dfct_desc'] = $dfct_desc;
            $data['bodyno'] = $bodyno;
            $data['frame_no'] = $frame_no;
            $data['main_img'] = $main_img;
            $data['part_img'] = $part_img;
            $data['sqa_shiftgrpnm'] = $sqa_shiftgrpnm;
            $data['katashiki'] = $katashiki;
            $data['shop_nm'] = $shop_nm;
            $data['auditor1'] = $auditor1;
            $data['auditor2'] = $auditor2;
            $data['plant_nm'] = $plant_nm;
            $data['checked_by'] = $checked_by;
            $data['approved_by'] = $approved_by;
            $data['app_pdate'] = $approve_pdate;
            $data['suffix'] = $suffix;
            $data['bd_seq'] = $bd_seq;
            $data['assy_seq'] = $assy_seq;
            $data['model_code'] = $model_code;
            $data['insp_sysdate'] = $insp_sysdate;
            $data['insp_pdate'] = $insp_pdate;
            $data['color'] = $color;
            $data['approved_by'] = $approved_by;
            $data['checked_by'] = $checked_by;
            $data['assy_pdate'] = $assy_pdate;
            $data['rank_nm'] = $rank_nm;
            $data['rank_nm2'] = $rank_nm2;
            $data['ctg_grp_nm'] = $ctg_grp_nm;
            $data['ctg_nm'] = $ctg_nm;
            $data['insp_item_flg'] = $insp_item_flg;
            $data['qlty_gt_item'] = $qlty_gt_item;
            $data['repair_flg'] = $repair_flg;
            $data['close_flg'] = $close_flg;
            $data['is_deleted'] = $is_deleted;
            //update by Ipan 20111214 1239
            $data['description'] = $description;
			//$data['vinno'] = $vinno;
                        
            
            $grpid=get_user_info($this, 'GRPAUTH_ID');
            $data['grpid'] = $grpid;
			
			/* LIST ATTACHMENT DI REPORT REPLY SQA*/
			$this->dm->init('T_SQA_DFCT_ATTACH', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_sqa']= $this->dm->select('', '', $where);
            /* END LIST ATTACHMENT DI REPORT REPLY */
            
            /* LIST ATTACHMENT DI ATTACH SQPR*/
			$this->dm->init('T_SQA_DFCT_SQPR_ATTACH', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_att_sqpr']= $this->dm->select('', '', $where);
            /* END LIST ATTACHMENT DI ATTACH SQPR */
			
			/* LIST ATTACHMENT DI REPORT REPLY OT,OF,RT,RF*/
			
			$this->dm->init('V_T_SQA_DFCT_REPLY_ATTACH', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_rep_att']= $this->dm->select('', '', $where);
            /* END LIST ATTACHMENT DI REPORT REPLY OT,OF,RT,RF*/
            
            /* LIST ATTACHMENT DI REPORT REPLY OT,OF,RT,RF*/
			
			$this->dm->init('T_SQA_DFCT_SQPR_ATTACH', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $att_sqpr = $this->dm->select('', '', $where);
                        
            $doc_att_sqpr = (count($att_sqpr) >0) ? $att_sqpr[0]->SQPR_DOC : '';    
            $data['doc_att_sqpr'] = $doc_att_sqpr;
            /* END LIST ATTACHMENT DI REPORT REPLY OT,OF,RT,RF*/
			
			
			if($i!='1') {
                $this->load->view('header', $data);
                $this->load->view('t_sqa_dfct/report_dfct', $data);
                $this->load->view('footer');
			} else {
                if ($force_dl != '') {
                    
                    $this->load->library('pdf_ori');
                    
                    $ht = 'PT. Toyota Motor MFG Indonesia';
                    //$this->pdf_ori->SetHeaderData('toyota_logo.jpg', 10, $ht, "QAD - Customer Quality Audit\nAudit Section\n\n");
                    $this->pdf_ori->setPrintHeader(false);
                    $this->pdf_ori->setPrintFooter(true);
                    $this->pdf_ori->setTopMargin(5);
                    $this->pdf_ori->SetLeftMargin(5);
                    //$this->pdf_ori->SetRightMargin(10);
                    $this->pdf_ori->setPageOrientation('P');                
                                                    
                    $this->pdf_ori->AddPage();
                    $html = $this->load->view('t_sqa_dfct/print_reply2', $data, true);                    
                    
                    $this->pdf_ori->writeHTML($html, true, false, true, false, '');                
                    $this->pdf_ori->Output('SQA Problem Sheet - '.$bodyno.'.pdf', 'I');  
                } else {
        			$this->load->view('header_plain', $data);
                    $this->load->view('t_sqa_dfct/print_reply3', $data);
                    $this->load->view('footer_plain');}                        
                }
        } else {
            $this->load->view('header');            
            $this->load->view('footer');
            echo "<script>window.alert('Warning, Defect Data Already Missing !')</script>";
        }
    }

    function update_ot() {
        $err = '';
        $app_pdate_ot = $_POST['app_pdate_ot'];
        $reply_comment_ot = $_POST['reply_comment_ot'];
        $reply_pdate_ot = $_POST['reply_pdate_ot'];
        $problem_reply_id_ot = $_POST['problem_reply_id_ot'];
        $reply_userid_ot = $_POST['reply_userid_ot'];
        $reply_type_ot = $_POST['reply_type_ot'];
        $countermeasure_type_ot = $_POST['countermeasure_type_ot'];
        $edit_ot = trim($_POST['edit_ot']);
        $approved_ot = trim($_POST['approved_ot']);
        $unapproved_ot = trim($_POST['unapproved_ot']);
		$problem_id = $_POST['problem_id'];

        if ($problem_reply_id_ot == '') {
            $err = "Problem reply not yet created";
        } else {
            /* T_SQA_DFCT_REPLY (CEK ADA REPLY SEBELUMNYA ATAU GA) */
            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
            $where = "PROBLEM_REPLY_ID = '" . $problem_reply_id_ot . "'";
            $rply = $this->dm->select('', '', $where);
            $rply = $rply[0];
            $rply_com = $rply->REPLY_COMMENT;
            /* END T_SQA_DFCT_REPLY */

            if ($app_pdate_ot == '') {
                $err = "Related User Must be Approve Status Problem Sheet";
                /* $data['err']=$err; */
                /* T_SQA_DFCT_REPLY */
                /* $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                  $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                  $where = "PROBLEM_ID = '" . $problem_id . "'";
                  $data['list_reply'] = $this->dm->select('', '', $where);
                  /* END T_SQA_DFCT_REPLY */
                /* $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
            } else { //start
                if ($reply_type_ot == 'O' && $countermeasure_type_ot == 'T') {
                    if ($rply_com == '' && $edit_ot == 'Save') {
                        $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                        $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_ot . "'";
                        $data = array(
                            'REPLY_COMMENT' => $reply_comment_ot,
                            'REPLY_PDATE' => $reply_pdate_ot,
                            'REPLY_SYSDATE' => get_date(),
                            'REPLY_USERID' => get_user_info($this, 'USER_ID'),
                            
                        );
                        $this->dm->update($data, $keys);
                        $err = "Save has been successfully";
                        /* T_SQA_DFCT_REPLY 
                          $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                          $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                          $where = "PROBLEM_ID = '" . $problem_id . "'";
                          $data['list_reply'] = $this->dm->select('', '', $where);
                          /* END T_SQA_DFCT_REPLY
                          $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                    } else { //edit
                        if ($edit_ot == 'Edit') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_ot . "'";
                            $data = array(
                                'REPLY_COMMENT' => $reply_comment_ot,
                                'UPDATEDT' => get_date(),
                                'UPDATEBY' => get_user_info($this, 'USER_ID'),
                            );
                            $this->dm->update($data, $keys);
                            $err = "changes has been successfully";
                            /* T_SQA_DFCT_REPLY 
                              $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                              $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                              $where = "PROBLEM_ID = '" . $problem_id . "'";
                              $data['list_reply'] = $this->dm->select('', '', $where);
                              /* END T_SQA_DFCT_REPLY
                              $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                        } elseif ($approved_ot == 'Approved') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_ot . "'";
                            $data = array(
                                'APPROVE_PDATE' => $reply_pdate_ot,
                                'APPROVE_SYSDATE' => get_date(),
                                'APPROVED_BY' => get_user_info($this, 'USER_ID')
                            );
                            $this->dm->update($data, $keys);
                            $err = "approval has been successfully";
							/*send email*/
							$this->dm->init('M_USR', 'USER_ID');
							$where = "GRPAUTH_ID IN ('03','05','06','07')";
							$list_email = $this->dm->select('', '', $where,'email');
							foreach ($list_email as $i): 
							$emaill[]= $i->email;
							endforeach;
						//	$this->dm->send_email($emaill,'DEAR ALL, HARAP REPLY EMAIL INI APA BILA SUDAH DI TERIMA. thx','TES KIRIM EMAIL');
                            /*END send email*/
                        } elseif ($unapproved_ot == 'Cancel Approved') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_ot . "'";
                            $data = array(
                                'APPROVE_PDATE' => null,
                                'APPROVE_SYSDATE' => null,
                                'APPROVED_BY' => null,
                                'UPDATEDT' => get_date()
                            );
                            $this->dm->update($data, $keys);
                            $err = "approval has been canceled";
                            /* T_SQA_DFCT_REPLY 
                              $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                              $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                              $where = "PROBLEM_ID = '" . $problem_id . "'";
                              $data['list_reply'] = $this->dm->select('', '', $where);
                              /* END T_SQA_DFCT_REPLY
                              $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                        }
                    }
                }
            }
        }
        $data['err'] = $err;
        $data['shop_user'] = get_user_info($this, 'SHOP_ID');
        $data['user_grpauth'] = get_user_info($this, 'GRPAUTH_ID');
        /* T_SQA_DFCT_REPLY */
        $problem_id = $_POST['problem_id'];
		$this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
        $where = "PROBLEM_ID = '" . $problem_id . "'";
        $data['list_reply'] = $this->dm->select('', '', $where);
		$data['problem_id'] = $problem_id;
		
        /* END T_SQA_DFCT_REPLY */
        //$this->load->view('t_sqa_dfct/reply_investigasi', $data);
        echo $err;
    }

    function update_of() {
        $err = '';
        $app_pdate_of = $_POST['app_pdate_of'];
        $reply_comment_of = $_POST['reply_comment_of'];
        $reply_pdate_of = $_POST['reply_pdate_of'];
        $problem_reply_id_of = $_POST['problem_reply_id_of'];
        $reply_userid_of = $_POST['reply_userid_of'];
        $reply_type_of = $_POST['reply_type_of'];
        $countermeasure_type_of = $_POST['countermeasure_type_of'];
        $edit_of = trim($_POST['edit_of']);
        $approved_of = trim($_POST['approved_of']);
        $unapproved_of = trim($_POST['unapproved_of']);
		$problem_id = $_POST['problem_id'];
        if ($problem_reply_id_of == '') {
            $err = "Problem reply not yet created";
        } else {
            /* T_SQA_DFCT_REPLY (CEK ADA REPLY SEBELUMNYA ATAU GA) */
            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
            $where = "PROBLEM_REPLY_ID = '" . $problem_reply_id_of . "'";
            $rply = $this->dm->select('', '', $where);
            $rply = $rply[0];
            $rply_com = $rply->REPLY_COMMENT;
            /* END T_SQA_DFCT_REPLY */

            if ($app_pdate_of == '') {
                $err = "Related User Must be Approve Status Problem Sheet";
            } else { //start
                if ($reply_type_of == 'O' && $countermeasure_type_of == 'F') {
                    if ($rply_com == '' && $edit_of == 'Save') {
                        $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                        $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_of . "'";
                        $data = array(
                            'REPLY_COMMENT' => $reply_comment_of,
                            'REPLY_PDATE' => $reply_pdate_of,
                            'REPLY_SYSDATE' => get_date(),
                            'REPLY_USERID' => get_user_info($this, 'USER_ID'),
                            
                        );
                        $this->dm->update($data, $keys);
                        /* T_SQA_DFCT_REPLY 
                          $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                          $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                          $where = "PROBLEM_ID = '" . $problem_id . "'";
                          $data['list_reply'] = $this->dm->select('', '', $where);
                          /* END T_SQA_DFCT_REPLY
                          $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                        $err = "Save has been successfully";
                    } else { //edit
                        if ($edit_of == 'Edit') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_of . "'";
                            $data = array(
                                'REPLY_COMMENT' => $reply_comment_of,
                                'UPDATEDT' => get_date(),
                                'UPDATEBY' => get_user_info($this, 'USER_ID'),
                            );
                            $this->dm->update($data, $keys);
                            $err = "changes has been successfully";
                            /* T_SQA_DFCT_REPLY 
                              $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                              $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                              $where = "PROBLEM_ID = '" . $problem_id . "'";
                              $data['list_reply'] = $this->dm->select('', '', $where);
                              /* END T_SQA_DFCT_REPLY
                              $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                        } elseif ($approved_of == 'Approved') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_of . "'";
                            $data = array(
                                'APPROVE_PDATE' => $reply_pdate_of,
                                'APPROVE_SYSDATE' => get_date(),
                                'APPROVED_BY' => get_user_info($this, 'USER_ID')
                            );
                            $this->dm->update($data, $keys);
                            $err = "approval has been successfully";
							/*send email*/
							$this->dm->init('M_USR', 'USER_ID');
							$where = "GRPAUTH_ID IN ('02','03','05','06','07')";
							$list_email = $this->dm->select('', '', $where,'email');
							foreach ($list_email as $i): 
							$emaill[]= $i->email;
							endforeach;
						//	$this->dm->send_email($emaill,'DEAR ALL, HARAP REPLY EMAIL INI APA BILA SUDAH DI TERIMA. thx','TES KIRIM EMAIL');
                            /*END send email*/
                            
                        } elseif ($unapproved_of == 'Cancel Approved') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_of . "'";
                            $data = array(
                                'APPROVE_PDATE' => null,
                                'APPROVE_SYSDATE' => null,
                                'APPROVED_BY' => null,
                                'UPDATEDT' => get_date()
                            );
                            $this->dm->update($data, $keys);
                            $err = "approval has been canceled";
                            /* T_SQA_DFCT_REPLY 
                              $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                              $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                              $where = "PROBLEM_ID = '" . $problem_id . "'";
                              $data['list_reply'] = $this->dm->select('', '', $where);
                              /* END T_SQA_DFCT_REPLY
                              $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                        }
                    }
                }

                //stop
            }
        }
        $data['err'] = $err;
        $data['shop_user'] = get_user_info($this, 'SHOP_ID');
        $data['user_grpauth'] = get_user_info($this, 'GRPAUTH_ID');
        /* T_SQA_DFCT_REPLY */
        $problem_id = $_POST['problem_id'];
        $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
        $where = "PROBLEM_ID = '" . $problem_id . "'";
        $data['list_reply'] = $this->dm->select('', '', $where);
		$data['problem_id'] = $problem_id;
        /* END T_SQA_DFCT_REPLY */
        //$this->load->view('t_sqa_dfct/reply_investigasi', $data);
		echo $err;			
    }

    function update_rt() {
        $err = '';
        $app_pdate_rt = $_POST['app_pdate_rt'];
        $reply_comment_rt = $_POST['reply_comment_rt'];
        $reply_pdate_rt = $_POST['reply_pdate_rt'];
        $problem_reply_id_rt = $_POST['problem_reply_id_rt'];
        $reply_userid_rt = $_POST['reply_userid_rt'];
        $reply_type_rt = $_POST['reply_type_rt'];
        $countermeasure_type_rt = $_POST['countermeasure_type_rt'];
        $edit_rt = trim($_POST['edit_rt']);
        $approved_rt = trim($_POST['approved_rt']);
        $unapproved_rt = trim($_POST['unapproved_rt']);
		$problem_id = $_POST['problem_id'];
        if ($problem_reply_id_rt == '') {
            $err = "Problem reply not yet created";
        } else {
            /* T_SQA_DFCT_REPLY (CEK ADA REPLY SEBELUMNYA ATAU GA) */
            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
            $where = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rt . "'";
            $rply = $this->dm->select('', '', $where);
            $rply = $rply[0];
            $rply_com = $rply->REPLY_COMMENT;
            /* END T_SQA_DFCT_REPLY */

            if ($app_pdate_rt == '') {
                $err = "Related User Must be Approve Status Problem Sheet";
            } else { //start
                if ($reply_type_rt == 'R' && $countermeasure_type_rt == 'T') {
                    if ($rply_com == '' && $edit_rt == 'Save') {
                        $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                        $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rt . "'";
                        $data = array(
                            'REPLY_COMMENT' => $reply_comment_rt,
                            'REPLY_PDATE' => $reply_pdate_rt,
                            'REPLY_SYSDATE' => get_date(),
                            'REPLY_USERID' => get_user_info($this, 'USER_ID'),
                            
                        );
                        $this->dm->update($data, $keys);
                        $err = "Save has been successfully";
                        /* T_SQA_DFCT_REPLY 
                          $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                          $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                          $where = "PROBLEM_ID = '" . $problem_id . "'";
                          $data['list_reply'] = $this->dm->select('', '', $where);
                          /* END T_SQA_DFCT_REPLY
                          $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                    } else { //edit
                        if ($edit_rt == 'Edit') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rt . "'";
                            $data = array(
                                'REPLY_COMMENT' => $reply_comment_rt,
                                'UPDATEDT' => get_date(),
                                'UPDATEBY' => get_user_info($this, 'USER_ID'),
                            );
                            $this->dm->update($data, $keys);
                            $err = "changes has been successfully";
                            /* T_SQA_DFCT_REPLY 
                              $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                              $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                              $where = "PROBLEM_ID = '" . $problem_id . "'";
                              $data['list_reply'] = $this->dm->select('', '', $where);
                              /* END T_SQA_DFCT_REPLY
                              $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                        } elseif ($approved_rt == 'Approved') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rt . "'";
                            $data = array(
                                'APPROVE_PDATE' => $reply_pdate_rt,
                                'APPROVE_SYSDATE' => get_date(),
                                'APPROVED_BY' => get_user_info($this, 'USER_ID')
                            );
                            $this->dm->update($data, $keys);
                            $err = "approval has been successfully";
                            /*send email*/
							$this->dm->init('M_USR', 'USER_ID');
							$where = "GRPAUTH_ID IN ('03','05','06','07')";
							$list_email = $this->dm->select('', '', $where,'email');
							foreach ($list_email as $i): 
							$emaill[]= $i->email;
							endforeach;
						//	$this->dm->send_email($emaill,'DEAR ALL, HARAP REPLY EMAIL INI APA BILA SUDAH DI TERIMA. thx','TES KIRIM EMAIL');
                            /*END send email*/
                        } elseif ($unapproved_rt == 'Cancel Approved') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rt . "'";
                            $data = array(
                                'APPROVE_PDATE' => null,
                                'APPROVE_SYSDATE' => null,
                                'APPROVED_BY' => null,
                                'UPDATEDT' => get_date()
                            );
                            $this->dm->update($data, $keys);
                            $err = "approval has been canceled";
                            /* T_SQA_DFCT_REPLY 
                              $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                              $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                              $where = "PROBLEM_ID = '" . $problem_id . "'";
                              $data['list_reply'] = $this->dm->select('', '', $where);
                              /* END T_SQA_DFCT_REPLY
                              $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                        }
                    }
                }

                //stop
            }
        }
        $data['err'] = $err;
        $data['shop_user'] = get_user_info($this, 'SHOP_ID');
        $data['user_grpauth'] = get_user_info($this, 'GRPAUTH_ID');
        /* T_SQA_DFCT_REPLY */
        $problem_id = $_POST['problem_id'];
        $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
        $where = "PROBLEM_ID = '" . $problem_id . "'";
        $data['list_reply'] = $this->dm->select('', '', $where);
		$data['problem_id'] = $problem_id;
        /* END T_SQA_DFCT_REPLY */
        //$this->load->view('t_sqa_dfct/reply_investigasi', $data);
        echo $err;
    }

    function update_rf() {
        $err = '';
        $app_pdate_rf = $_POST['app_pdate_rf'];
        $reply_comment_rf = $_POST['reply_comment_rf'];
        $reply_pdate_rf = $_POST['reply_pdate_rf'];
        $problem_reply_id_rf = $_POST['problem_reply_id_rf'];
        $reply_userid_rf = $_POST['reply_userid_rf'];
        $reply_type_rf = $_POST['reply_type_rf'];
        $countermeasure_type_rf = $_POST['countermeasure_type_rf'];
        $edit_rf = trim($_POST['edit_rf']);
        $approved_rf = trim($_POST['approved_rf']);
        $unapproved_rf = trim($_POST['unapproved_rf']);
		$problem_id = $_POST['problem_id'];
        if ($problem_reply_id_rf == '') {
            $err = "Problem reply not yet created";
        } else {
            /* T_SQA_DFCT_REPLY (CEK ADA REPLY SEBELUMNYA ATAU GA) */
            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
            $where = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rf . "'";
            $rply = $this->dm->select('', '', $where);
            $rply = $rply[0];
            $rply_com = $rply->REPLY_COMMENT;
            /* END T_SQA_DFCT_REPLY */

            if ($app_pdate_rf == '') {
                $err = "Related User Must be Approve Status Problem Sheet";
            } else { //start
                if ($reply_type_rf == 'R' && $countermeasure_type_rf == 'F') {
                    if ($rply_com == '' && $edit_rf == 'Save') {
                        $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                        $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rf . "'";
                        $data = array(
                            'REPLY_COMMENT' => $reply_comment_rf,
                            'REPLY_PDATE' => $reply_pdate_rf,
                            'REPLY_SYSDATE' => get_date(),
                            'REPLY_USERID' => get_user_info($this, 'USER_ID'),
                            
                        );
                        $this->dm->update($data, $keys);
                        $err = "Save has been successfully";
                        /* T_SQA_DFCT_REPLY 
                          $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                          $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                          $where = "PROBLEM_ID = '" . $problem_id . "'";
                          $data['list_reply'] = $this->dm->select('', '', $where);
                          /* END T_SQA_DFCT_REPLY
                          $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                    } else { //edit
                        if ($edit_rf == 'Edit') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rf . "'";
                            $data = array(
                                'REPLY_COMMENT' => $reply_comment_rf,
                                'UPDATEDT' => get_date(),
                                'UPDATEBY' => get_user_info($this, 'USER_ID'),
                            );
                            $this->dm->update($data, $keys);
                            $err = "changes has been successfully";
                            /* T_SQA_DFCT_REPLY 
                              $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                              $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                              $where = "PROBLEM_ID = '" . $problem_id . "'";
                              $data['list_reply'] = $this->dm->select('', '', $where);
                              /* END T_SQA_DFCT_REPLY
                              $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                        } elseif ($approved_rf == 'Approved') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rf . "'";
                            $data = array(
                                'APPROVE_PDATE' => $reply_pdate_rf,
                                'APPROVE_SYSDATE' => get_date(),
                                'APPROVED_BY' => get_user_info($this, 'USER_ID')
                            );
                            $this->dm->update($data, $keys);
                            $err = "approval has been successfully";
                            /*send email*/
							$this->dm->init('M_USR', 'USER_ID');
							$where = "GRPAUTH_ID IN ('02','03','05','06','07')";
							$list_email = $this->dm->select('', '', $where,'email');
							foreach ($list_email as $i): 
							$emaill[]= $i->email;
							endforeach;
						//	$this->dm->send_email($emaill,'DEAR ALL, HARAP REPLY EMAIL INI APA BILA SUDAH DI TERIMA. thx','TES KIRIM EMAIL');
                            /*END send email*/
                        } elseif ($unapproved_rf == 'Cancel Approved') {
                            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                            $keys = "PROBLEM_REPLY_ID = '" . $problem_reply_id_rf . "'";
                            $data = array(
                                'APPROVE_PDATE' => null,
                                'APPROVE_SYSDATE' => null,
                                'APPROVED_BY' => null,
                                'UPDATEDT' => get_date()
                            );
                            $this->dm->update($data, $keys);
                            $err = "approval has been canceled";
                            /* T_SQA_DFCT_REPLY 
                              $problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';
                              $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
                              $where = "PROBLEM_ID = '" . $problem_id . "'";
                              $data['list_reply'] = $this->dm->select('', '', $where);
                              /* END T_SQA_DFCT_REPLY
                              $this->load->view('t_sqa_dfct/reply_investigasi',$data); */
                        }
                    }
                }

                //stop
            }
        }
        $data['err'] = $err;
        $data['shop_user'] = get_user_info($this, 'SHOP_ID');
        $data['user_grpauth'] = get_user_info($this, 'GRPAUTH_ID');
        /* T_SQA_DFCT_REPLY */
        
        $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
        $where = "PROBLEM_ID = '" . $problem_id . "'";
        $data['list_reply'] = $this->dm->select('', '', $where);
		$data['problem_id'] = $problem_id;
        /* END T_SQA_DFCT_REPLY */
		$data['problem_id'] = $problem_id;
        //$this->load->view('t_sqa_dfct/reply_investigasi', $data);
        echo $err;
    }

    function update_checked() {
        $err = '';
        $vinno = $_POST['vinno'];
        $problem_id = $_POST['problem_id'];
        $prdt_pdate = $_POST['prdt_pdate'];
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_REPLY_ID');
        $keys = "PROBLEM_ID = '" . $problem_id . "'";
        $data = array(
            'CHECK_PDATE' => $prdt_pdate,
            'CHECK_SYSDATE' => get_date(),
            'CHECKED_BY' => get_user_info($this, 'USER_ID'),
        );
        $this->dm->update($data, $keys);
        $err = "Your Defect [ ] in Vehicle [ ] already Checked by [ ] ";
		   //$data['vinno'] = $vinno;
        $data['problem_id'] = $problem_id;
        $data['err'] = $err;
		echo '1';
	}
	
	function update_unchecked() {
        $err = '';
        //$vinno = $_POST['vinno'];
        $problem_id = $_POST['problem_id'];
        $prdt_pdate = $_POST['prdt_pdate'];
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_REPLY_ID');
        $keys = "PROBLEM_ID = '" . $problem_id . "'";
        $data = array(
            'CHECK_PDATE' => null,
            'CHECK_SYSDATE' => null,
            'CHECKED_BY' => null,
			'updatedt' =>get_date(),
			'updateby' =>get_user_info($this, 'USER_ID'),
        );
        $this->dm->update($data, $keys);
        $err = "Your Defect [ ] in Vehicle [ ] already Unchecked by [ ] ";
        
		//$data['vinno'] = $vinno;
        $data['problem_id'] = $problem_id;
        $data['err'] = $err;
		echo '1';
	}
	
	 function approved() {
        $problem_id = $_POST['problem_id'];
        
        // get prdt
        $this->dm->init('M_SQA_PRDT', 'PLANT_CD');
        $p = $this->dm->select('', '', "PLANT_CD ='" . get_user_info($this, 'PLANT_CD') . "'");        
        $PDATE = $p[0]->PDATE;
        
        // ge prb number
        $PRB = $this->dm->prb_number();
		
		// get detail dfct
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
        $keys = "PROBLEM_ID = '" . $problem_id . "'";        
        $dfct = $this->dm->select('', '', $keys);
        $dfct = $dfct[0];
        
        // cek jika chosagoumi
		if($dfct->SHOP_NM =='Chosagoumi'){
		  echo 'Defect Chosagoumi' ;
		} else {
            // update 		      
            $data = array(
                'PRB_SHEET_NUM' => $PRB,
                'APPROVE_SYSDATE' => get_date(),
                'APPROVED_BY' => get_user_info($this, 'USER_ID'),
                'APPROVE_PDATE' => $PDATE
            );
            $this->dm->update($data, $keys);
            
            // get shop_id by shop_nm
            $this->dm->init('M_SQA_SHOP', 'SHOP_ID');
            $shop = $this->dm->select('', '', "SHOP_NM = '" . $dfct->SHOP_NM . "'", 'SHOP_ID');
            $shop_id = $shop[0]->SHOP_ID;

            // pdate parsing
            $PDATE_x = explode('-', $PDATE);
            $y = $PDATE_x[0];
            $m = $PDATE_x[1];
            $d = $PDATE_x[2];

            $one_works = mktime(0, 0, 0, $m, $d + 1, $y);
            $three_works = mktime(0, 0, 0, $m, $d + 3, $y);
            $one_works = date("Y-m-d", $one_works);
            $three_works = date("Y-m-d", $three_works);
            // @TODO:
            // untuk masing2 one/three harus di cek ke work calendar,
            // cek ke M_SQA_WORK_CALENDAR, jika WORK_FLAG = false,
            // tambah 1 hari lagi, cek sampai WORK_FLAG = true,
            // return WORK_PRDT record ybs
            // insert data default ke T_SQA_DFCT_REPLY
            $sql = "
            DECLARE @MyIdentity uniqueidentifier;
            SET @MyIdentity = NewID();

            INSERT INTO T_SQA_DFCT_REPLY
            (
                PROBLEM_REPLY_ID,
                SHOP_ID,
                PROBLEM_ID,
                REPLY_TYPE,
                COUNTERMEASURE_TYPE,
                DUE_DATE
            )
            VALUES
            (
                @MyIdentity,
                '" . $shop_id . "',
                '" . $problem_id . "',
                'R',
                'T',
                '" . $one_works . "'
            ); ";
            $this->dm->sql_self($sql);

            // insert data default ke T_SQA_DFCT_REPLY
            $sql = "
            DECLARE @MyIdentity uniqueidentifier;
            SET @MyIdentity = NewID();

            INSERT INTO T_SQA_DFCT_REPLY
            (
                PROBLEM_REPLY_ID,
                SHOP_ID,
                PROBLEM_ID,
                REPLY_TYPE,
                COUNTERMEASURE_TYPE,
                DUE_DATE
            )
            VALUES
            (
                @MyIdentity,
                '" . $shop_id . "',
                '" . $problem_id . "',
                'R',
                'F',
                '" . $three_works . "'
            ); ";
            $this->dm->sql_self($sql);



            // cek jika INSP_ITEM_FLG = true
            if ($dfct->INSP_ITEM_FLG == '1') {
                // insert lagi 2 record untuk Outflow
                // insert data default ke T_SQA_DFCT_REPLY
                $sql = "
                DECLARE @MyIdentity uniqueidentifier;
                SET @MyIdentity = NewID();

                INSERT INTO T_SQA_DFCT_REPLY
                (
                    PROBLEM_REPLY_ID,
                    SHOP_ID,
                    PROBLEM_ID,
                    REPLY_TYPE,
                    COUNTERMEASURE_TYPE,
                    DUE_DATE
                )
                VALUES
                (
                    @MyIdentity,
                    '" . $shop_id . "',
                    '" . $problem_id . "',
                    'O',
                    'T',
                    '" . $one_works . "'
                ); ";
                $this->dm->sql_self($sql);


                $sql = "
                DECLARE @MyIdentity uniqueidentifier;
                SET @MyIdentity = NewID();

                INSERT INTO T_SQA_DFCT_REPLY
                (
                    PROBLEM_REPLY_ID,
                    SHOP_ID,
                    PROBLEM_ID,
                    REPLY_TYPE,
                    COUNTERMEASURE_TYPE,
                    DUE_DATE
                )
                VALUES
                (
                    @MyIdentity,
                    '" . $shop_id . "',
                    '" . $problem_id . "',
                    'O',
                    'F',
                    '" . $three_works . "'
                ); ";
                $this->dm->sql_self($sql);
            }
     	}

        // cek shop_nm, jika chousagoumi tdk insert
        if ($dfct->SHOP_NM != 'Chosagoumi') {
            
        }
				
		/*send email*/
		$this->dm->init('V_USR', 'USER_ID');
		//$where = "GRPAUTH_ID IN ('02','03','05','06','07') OR SHOP_ID=substring('".$dfct->SHOP_NM."',0,1)";
        $where = "GRPAUTH_ID IN ('02','03','05','06','07') AND (SHOP_ID=left('".$dfct->SHOP_NM."',1) AND GRPAUTH_ID = '01')";            
		$list_email = $this->dm->select('', '', $where,'email');
		foreach ($list_email as $i): 
			$emaill[]= $i->email;
		endforeach;

		/**
			buka komentar di bawah untuk pengiriman email ketika APPROVAL,
			20110720 - Format EMail belum
		**/
		
		//$this->dm->send_email($emaill,'DEAR ALL, HARAP REPLY EMAIL INI APA BILA SUDAH DI TERIMA. thx','TES KIRIM EMAIL');

        /*END send email*/
        echo '1';
    }

    // fungsi untuk UNAPPROVED
    function Unapproved() {
        $problem_id = $_POST['problem_id'];

        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
        $keys = "PROBLEM_ID = '" . $problem_id . "'";

        $data = array(
            'PRB_SHEET_NUM' => NULL,
			'SQPR_NUM' => NULL,
			'APPROVE_PDATE' => NULL,
			'APPROVE_SYSDATE' => NULL,
            'APPROVED_BY' => NULL,
            'Updatedt' => get_date(),
			'updateby' => get_user_info($this, 'USER_ID')
			/*,
            'SHOW_FLG' => 0			*/
        );
        $this->dm->update($data, $keys);

		
		$this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
        $where = "PROBLEM_ID = '" . $problem_id . "'";
        $hapus = $this->dm->select('', 'PROBLEM_REPLY_ID', $where);
		
        
		foreach($hapus as $ii): 
			$this->dm->init('T_SQA_DFCT_REPLY_ATTACH', 'PROBLEM_REPLY_ID');
			$keys2 = "PROBLEM_REPLY_ID = '" . $ii->PROBLEM_REPLY_ID. "'";
			$this->dm->delete($keys2);
		endforeach;
						
        $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
        $keys = "PROBLEM_ID = '" . $problem_id . "'";
        $this->dm->delete($keys);
				
		$problem_id = $this->uri->segment(3);
		$data['problem_id']=$problem_id;
        
        
        /*send email*/
		$this->dm->init('V_USR', 'USER_ID');
		//$where = "GRPAUTH_ID IN ('02','03','05','06','07') OR SHOP_ID=substring('".$dfct->SHOP_NM."',0,1)";
        $where = "GRPAUTH_ID IN ('02','03','05','06','07') AND (SHOP_ID=left('".$dfct->SHOP_NM."',1) AND GRPAUTH_ID = '01')";            
		$list_email = $this->dm->select('', '', $where,'email');
		foreach ($list_email as $i): 
			$emaill[]= $i->email;
		endforeach;

		/**
			buka komentar di bawah untuk pengiriman email ketika APPROVAL,
			20110720 - Format EMail belum
		**/
		
		//$this->dm->send_email($emaill,'DEAR ALL, HARAP REPLY EMAIL INI APA BILA SUDAH DI TERIMA. thx','TES KIRIM EMAIL');

        /*END send email*/
        echo '1';
    }
	
	// fungsi untuk SETSQPR
    function setSQPR() {
        $problem_id = $_POST['problem_id'];
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
        $keys = "PROBLEM_ID = '" . $problem_id . "'";
        $SQPR = $this->dm->sqpr_number();

        $data = array(
            'SQPR_NUM' => $SQPR
        );


        $this->dm->update($data, $keys);
        $data['problem_id']=$problem_id;
        echo '1';
    }

    // fungsi untuk CANCEL SETSQPR
    function SQPRcanc() {
        $problem_id = $_POST['problem_id'];
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
        $keys = "PROBLEM_ID = '" . $problem_id . "'";
        $SQPR = $this->dm->sqpr_number();

        $data = array(
            'SQPR_NUM' => NULL
        );

        $this->dm->update($data, $keys);
       $data['problem_id']=$problem_id;
        echo '1';
    }

	 // fungsi untuk P/S Closed
    function PSclosed() {
        $problem_id = $_POST['problem_id'];	
        $this->dm->init('T_SQA_DFCT', 'PROBLEM_ID');
        $keys = "PROBLEM_ID = '" . $problem_id . "'";
		
        // get detail dfct
        $dfct = $this->dm->select('', '', "PROBLEM_ID = '" . $problem_id . "'");
        $dfct = $dfct[0];
      	
		if($dfct->APPROVE_PDATE !='' && $dfct->CLOSE_FLG =='0'){
        $data = array(
            'CLOSE_FLG' => 1,
                'CLOSE_PDATE' => get_date(),
                'CLOSE_SYSDATE'=> get_date(),
                'CLOSED_BY' => get_user_info($this, 'USER_ID')
        );
        $this->dm->update($data, $keys);
      	}
		else{
		echo 'gagal';
		}
        
		$data['problem_id']=$proble_id;
        echo '1';
    }
 
function pdf_reply() {
		$i='';
		$i=$this->uri->segment(4);
		
		if($_POST['problem_id']==''){
        $problem_id = $this->uri->segment(3);}
		else
		{
		$problem_id=$_POST['problem_id'];
		}
		
      //  $vinno = $this->uri->segment(4); // $_POST['vinno'];
        //$vinno = 'xxxxxxxxxxxxxxxxx';
        //$problem_id = '1ea0c1c6-9fda-4851-82f2-7888cf442e6d';

        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
        //$where = "PROBLEM_ID = '" . $problem_id . "' and VINNO='" . $vinno . "'";
		$where = "PROBLEM_ID = '" . $problem_id . "'";
        $dfct = $this->dm->select('', '', $where);
		
        if (count($dfct) > 0) {
            $dfct = $dfct[0];
            $frame_no = $vinno;

            $check_pdate = $dfct->CHECK_PDATE;
            $sqpr_num = $dfct->SQPR_NUM;
            $approve_pdate = $dfct->APPROVE_PDATE;
            $measurement = $dfct->MEASUREMENT;
            $refval = $dfct->REFVAL;
            $idno == $dfct->IDNO;
            $plant_nm == $dfct->PLANT_NM;
            $refno == $dfct->REFNO;
            $prb_sheet_num = $dfct->PRB_SHEET_NUM;
            $sqpr_num = $dfct->SQPR_NUM;
            $dfct_desc = $dfct->DFCT;
            $main_img = $dfct->MAIN_IMG;
            $part_img = $dfct->PART_IMG;
            $katashiki = $dfct->KATASHIKI;
            $shop_nm = $dfct->SHOP_NM;
            $auditor1 = $dfct->AUDITOR_NM_1;
            $auditor2 = $dfct->AUDITOR_NM_2;
            $plant_nm = $dfct->PLANT_NM;
            $checked_by = $dfct->CHECKED_BY;
            $approved_by = $dfct->APPROVED_BY;
            $bodyno = $dfct->BODYNO;
            $frame_no = $vinno;
            $suffix = $dfct->SUFFIX;
            $bd_seq = $dfct->BD_SEQ;
            $assy_seq = $dfct->ASSY_SEQ;
            $model_code = $dfct->KATASHIKI;
            $insp_sysdate = $dfct->INSP_SYSDATE;
            $insp_pdate = $dfct->INSP_PDATE;
            $color = $dfct->EXTCLR;
            $sqa_shiftgrpnm = $dfct->SQA_SHIFTGRPNM;
            $approved_by = $dfct->APPROVED_BY;
            $checked_by = $dfct->CHECKED_BY;
            $assy_pdate = $dfct->ASSY_PDATE;
            $rank_nm = $dfct->RANK_NM;
            $ctg_grp_nm = $dfct->CTG_GRP_NM;
            $ctg_nm = $dfct->CTG_NM;
            $close_flg = $dfct->CLOSE_FLG;
            $is_deleted = $dfct->IS_DELETED;

            if ($dfct->INSP_ITEM_FLG == 1)
                $insp_item_flg = 'Yes'; else
                $insp_item_flg='No';
            if ($dfct->QLTY_GT_ITEM == 1)
                $qlty_gt_item = 'Yes'; else
                $qlty_gt_item='No';
            if ($dfct->REPAIR_FLG == 1)
                $repair_flg = 'Yes'; else
                $repair_flg='No';

            /* T_SQA_DFCT_CONFBY  */
            $this->dm->init('T_SQA_DFCT_CONFBY', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_dfct_conf'] = $this->dm->select('', '', $where);
            /* END T_SQA_DFCT_CONFBY  */

            /* T_SQA_DFCT_REPLY */
            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_reply'] = $this->dm->select('', '', $where);
            /* END T_SQA_DFCT_REPLY */

            /* T_SQA_DFCT_ATTACH */
            $this->dm->init('T_SQA_DFCT_ATTACH', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $dfct_attach = $this->dm->select('', '', $where);
            $dfct_attach = $dfct_attach[0];
            $attach_doc = $dfct_attach->ATTACH_DOC;
            $data['attach_doc'] = $attach_doc;
            /* END T_SQA_DFCT_ATTACH_HIST */

            /* T_SQA_VINF */
            $this->dm->init('T_SQA_VINF', 'BODY_NO');
            $where = "BODY_NO = '" . $bodyno . "'";
            $dfct_vinf = $this->dm->select('', '', $where);
            $dfct_vinf = $dfct_vinf[0];
            $dfct_stall = $dfct_vinf->STALL_NO;
            $data['dfct_stall'] = $dfct_stall;

            /* END T_SQA_VINF */

            $pln_cd = get_user_info($this, 'PLANT_CD');
            $data['pln_user'] = get_user_info($this, 'USER_ID');
            /* m_sqa_prdt */
            $this->dm->init('M_SQA_PRDT', 'PLANT_CD');
            $where = "PLANT_CD = '" . $pln_cd . "'";
            $dfct_pln_cd = $this->dm->select('', '', $where);
            $dfct_pln_cd = $dfct_pln_cd[0];
            $reply_pdate = $dfct_pln_cd->PDATE;
            $data['reply_pdate'] = $reply_pdate;
            /* end sqa prdt */

            $data['sqpr_num'] = $sqpr_num;
            $data['check_pdate'] = $check_pdate;
            $data['measurement'] = $measurement;
            $data['refval'] = $refval;
            $data['prb_sheet_num'] = $prb_sheet_num;
            $data['problem_id'] = $problem_id;
            $data['sqpr_num'] = $sqpr_num;
            $data['dfct_desc'] = $dfct_desc;
            $data['bodyno'] = $bodyno;
            $data['frame_no'] = $frame_no;
            $data['main_img'] = $main_img;
            $data['part_img'] = $part_img;
            $data['sqa_shiftgrpnm'] = $sqa_shiftgrpnm;
            $data['katashiki'] = $katashiki;
            $data['shop_nm'] = $shop_nm;
            $data['auditor1'] = $auditor1;
            $data['auditor2'] = $auditor2;
            $data['plant_nm'] = $plant_nm;
            $data['checked_by'] = $checked_by;
            $data['approved_by'] = $approved_by;
            $data['app_pdate'] = $approve_pdate;
            $data['suffix'] = $suffix;
            $data['bd_seq'] = $bd_seq;
            $data['assy_seq'] = $assy_seq;
            $data['model_code'] = $model_code;
            $data['insp_sysdate'] = $insp_sysdate;
            $data['insp_pdate'] = $insp_pdate;
            $data['color'] = $color;
            $data['approved_by'] = $approved_by;
            $data['checked_by'] = $checked_by;
            $data['assy_pdate'] = $assy_pdate;
            $data['rank_nm'] = $rank_nm;
            $data['ctg_grp_nm'] = $ctg_grp_nm;
            $data['ctg_nm'] = $ctg_nm;
            $data['insp_item_flg'] = $insp_item_flg;
            $data['qlty_gt_item'] = $qlty_gt_item;
            $data['repair_flg'] = $repair_flg;
            $data['close_flg'] = $close_flg;
            $data['is_deleted'] = $is_deleted;
			$data['vinno'] = $vinno;
			
			/* LIST ATTACHMENT DI REPORT REPLY SQA*/
			$this->dm->init('T_SQA_DFCT_ATTACH', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_sqa']= $this->dm->select('', '', $where);
            /* END LIST ATTACHMENT DI REPORT REPLY */
			
			/* LIST ATTACHMENT DI REPORT REPLY OT,OF,RT,RF*/
			
			$this->dm->init('V_T_SQA_DFCT_REPLY_ATTACH', 'PROBLEM_ID');
            $where = "PROBLEM_ID = '" . $problem_id . "'";
            $data['list_rep_att']= $this->dm->select('', '', $where);
            /* END LIST ATTACHMENT DI REPORT REPLY OT,OF,RT,RF*/
					
            
        $this->load->library('pdf_print');
        $this->pdf_print->SetSubject('CHECK SHEET REPAIR - SQA');
        $this->pdf_print->SetFont('helvetica', '', 8);

        // set default header data
        $ht = 'PT. Toyota Motor MFG Indonesia';
        $this->pdf_print->SetHeaderData('toyota_logo.jpg', 10, $ht, "QAD - Customer Quality Audit\nAudit Section\n\n");
        $this->pdf_print->setPrintHeader(true);
        $this->pdf_print->setPrintFooter(true);
        $this->pdf_print->setTopMargin(70);
        $this->pdf_print->setPageOrientation('P');


        $this->pdf_print->AddPage();
        $html = $this->load->view('t_sqa_dfct/pdf_reply', $data,true);
        $this->pdf_print->writeHTML($html, true, false, true, false, '');
        $this->pdf_print->Output('Check Sheet Repair - SQA.pdf', 'I');
		}
    }
    
    
    /**
     * CRF START HERE    
     * CRF Number: 3 - Move Defect to Another Nowhere Server
     * konsep:
     *      begin 
     *          - masukkan T_SQA_DFCT dan turunannya ke sebuah temporary object
     *          - delete dari AUDIT.T_SQA_DFCT where PROBLEM_ID ybs
     *          ~ replikasi akan otomatis berjalan menyesuaikan di ADT_SQA.T_SQA_DFCT
     *          - cek ke ADT_SQA.T_SQA_DFCT --> SUDAH BENERAN KE DELETE JUGA ga.
     *          - jika masih Ada,, tdk boleh moving. --> LOOP sampai bener2 kosong dengan pRoblem_ID yg sama
     *          - jika sudah tdk Ada,,
     *          - Insertkan data dari temporary object ke dalam ADT_SQA.T_SQA_DFCT dan turunannya.
     *      end    
    */  
    function move_dfct() {                
        //sleep(2);
        $problem_id = $_POST['problem_id'];
        $w = "PROBLEM_ID = '" . $problem_id . "'";
        
        // get detail problem first
        $this->dm->init('T_SQA_DFCT','problem_id asc');
        $dfct = $this->dm->select('','',$w);
        if (count($dfct)>0) {
            // cari attachment nya
            $this->dm->init('T_SQA_DFCT_ATTACH', 'problem_id asc');
            $dfct_attach = $this->dm->select('','',$w);
            
            // cari confby nya
            $this->dm->init('T_SQA_DFCT_CONFBY', 'problem_id asc');
            $dfct_confby = $this->dm->select('','',$w);
            
            // cari reply
            $this->dm->init('T_SQA_DFCT_REPLY', 'problem_id asc');
            $dfct_reply = $this->dm->select('','',$w);
            
            // gabung All Dfct
            $dfct_all = array($dfct, $dfct_attach, $dfct_confby, $dfct_reply);
            
            // delete all dfct from main server
            echo 'Menghapus All Defect ... ,';
            $keys = array('PROBLEM_ID'=>$problem_id);
            $this->dm->init('T_SQA_DFCT_CONFBY');
            $this->dm->delete($keys);
            $this->dm->init('T_SQA_DFCT_REPLY');
            $this->dm->delete($keys);
            $this->dm->init('T_SQA_DFCT_ATTACH');
            $this->dm->delete($keys);
            $this->dm->init('T_SQA_DFCT');
            $this->dm->delete($keys);
                                    
            echo 'Save set to False... ,';
            $save = false; $i=1;
            while(!$save) {
                echo 'cek ke ADT_SQA... ,';
            
                // cek ke ADT_SQA
                $this->dm->init_dbrep('T_SQA_DFCT', 'PROBLEM_ID');
                $w = "PROBLEM_ID = '" . $problem_id . "'";
                $dfct_adt = $this->dm->select_rep('','',$w);
                
                if (count($dfct_adt)==0) {
                    echo 'Dfct ADT == 0... ,';            
                    
                    // lakukan pemindahan, start from DFCT
                    $dfct = $dfct[0];
                    $data_dfct = array(
                                    'PROBLEM_ID' => $dfct->PROBLEM_ID,
                                    'PLANT_NM' => $dfct->PLANT_NM,
                                    'IDNO' => $dfct->IDNO,
                                    'BODYNO' => $dfct->BODYNO,
                                    'REFNO' => $dfct->REFNO,
                                    'VINNO' => $dfct->VINNO,
                                    'DFCT' => $dfct->DFCT,
                                    'RANK_NM' => $dfct->RANK_NM,
                                    'MAIN_IMG' => $dfct->MAIN_IMG,
                                    'PART_IMG' => $dfct->PART_IMG,
                                    'CTG_GRP_NM' => $dfct->CTG_GRP_NM,
                                    'CTG_NM' => $dfct->CTG_NM,
                                    'MEASUREMENT' => $dfct->MEASUREMENT,
                                    'REFVAL' => $dfct->REFVAL,
                                    'INSP_ITEM_FLG' => $dfct->INSP_ITEM_FLG,
                                    'REPAIR_FLG' => $dfct->REPAIR_FLG,
                                    'QLTY_GT_ITEM' => $dfct->QLTY_GT_ITEM,
                                    'AUDITOR_NM_1' => $dfct->AUDITOR_NM_1,
                                    'AUDITOR_NM_2' => $dfct->AUDITOR_NM_2,
                                    'SQA_PDATE' => $dfct->SQA_PDATE,
                                    'SQA_SHIFTGRPNM' => $dfct->SQA_SHIFTGRPNM,
                                    'SQA_SYSDATE' => $dfct->SQA_SYSDATE,
                                    'CLOSE_FLG' => $dfct->CLOSE_FLG,
                                    'IS_DELETED' => $dfct->IS_DELETED,
                                    'SHOP_NM' => $dfct->SHOP_NM,
                                    'updateby' => $dfct->updateby,
                                    'updatedt' => $dfct->updatedt
                                );
                    $this->dm->insert_rep($data_dfct);
                    echo 'insert ke DFCT, ini datanya: ... ,';
                    //print_r($data_dfct);
                    
                    // isikan ke dfct attachment
                    $this->dm->init_dbrep('T_SQA_DFCT_ATTACH', 'PROBLEM_REPLY_ID');
                    foreach($dfct_attach as $da) {
                        $data_attach = array(
                                        'PROBLEM_ID' => $da->PROBLEM_ID,
                                        'FILE_ID' => $da->FILE_ID,
                                        'ATTACH_DOC' => $da->ATTACH_DOC,
                                        'ATTACH_NAME' => $da->ATTACH_NAME,
                                        'ATTACH_SYSDATE' => $da->ATTACH_SYSDATE,
                                        'ATTACH_USERID' => $da->ATTACH_USERID
                                    );
                        $this->dm->insert_rep($data_attach);
                        echo 'insert ke DFCT ATTACH, ini datanya: ...,';
                        //print_r($data_attach);
                    
                    }
                    
                    // isikan ke reply;
                    $this->dm->init_dbrep('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
                    foreach ($dfct_reply as $dr) {
                        $data_reply = array(
                                        'PROBLEM_REPLY_ID' => $dr->PROBLEM_REPLY_ID,
                                        'SHOP_ID' => $dr->SHOP_ID,
                                        'PROBLEM_ID' => $dr->PROBLEM_ID,
                                        'REPLY_TYPE' => $dr->REPLY_TYPE,
                                        'COUNTERMEASURE_TYPE' => $dr->COUNTERMEASURE_TYPE,
                                        'REPLY_COMMENT' => $dr->REPLY_COMMENT,
                                        'REPLY_PDATE' => $dr->REPLY_PDATE,
                                        'REPLY_SYSDATE' => $dr->REPLY_SYSDATE,
                                        'REPLY_USERID' => $dr->REPLY_USERID,
                                        'APPROVE_PDATE' => $dr->APPROVE_PDATE,
                                        'APPROVE_SYSDATE' => $dr->APPROVE_SYSDATE,
                                        'APPROVED_BY' => $dr->APPORVED_BY,
                                        'DUE_DATE' => $dr->DUE_DATE,
                                        'updatedt' => $dr->updatedt,
                                        'Updateby' => $dr->Updateby
                                    );
                        echo 'insert ke DFCT REPLY, ini datanya: ...,';
                        //print_r($data_reply);            
                                                        
                        $this->dm->insert_rep($data_reply);                        
                    }
                    
                    // isikan ke dalam conf_by qcds
                    $this->dm->init_dbrep('T_SQA_DFCT_CONFBY', 'PROBLEM_ID');
                    foreach ($dfct_confby as $dc) {
                        $data_confby = array(
                                        'PROBLEM_ID' => $dc->PROBLEM_ID,
                                        'CONF_BY' => $dc->CONF_BY,
                                        'CONF_SYSDATE' => $dc->CONF_SYSDATE,
                                        'CONF_TYPE' => $dc->CONF_TYPE,
                                        'Updateby' => $dc->Updateby,
                                        'Updatedt' => $dc->Updatedt
                                    );
                                    
                        echo 'insert ke DFCT CONFBY, ini datanya: ...,';
                        //print_r($data_confby);
                    
                        $this->dm->insert_rep($data_confby);
                    }
                    
                    // keluar dari loop
                    echo 'save = true, keluar looping !';
                    
                    $this->dm->init_dbrep('T_SQA_DFCT','PROBLEM_ID');
                    $akhir = $this->dm->select_rep('','',"PROBLEM_ID = '" . $problem_id . "'");
                    print_r($akhir);
                    
                    $save = true;
                }
                echo 'Loop: ' .$i. '----\n';
                $i++;
            }        
            echo 'Selesai. Its done when its done!!<br/>';
        } else {
            echo 'Problem already deleted / moved by another user';
        }
    }
}

?>