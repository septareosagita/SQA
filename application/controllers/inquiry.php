<?php

/*
 * @author: ryan@mediantarakreasindo.com
 * @created: April, 01 2011 - 00:00
 */

class inquiry extends CI_Controller {

	public $fieldseq = array();

	function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> model('t_sqa_vinf_model', '', true);
		$this -> load -> model('t_sqa_dfct_model', '', true);
		$this -> load -> model('t_sqa_dfct_reply_model', '', true);
		$this -> load -> model('v_sqa_dfct_model', '', true);
		$this -> load -> model('m_sqa_shop_model', '', true);
		$this -> load -> model('m_sqa_rank_model', '', true);
		$this -> load -> model('m_sqa_plant_model', '', true);
		$this -> load -> model('m_sqa_shiftgrp_model', '', true);
		$this -> load -> model('m_sqa_ctg_grp_model', '', true);
		$this -> load -> model('m_sqa_ctg_model', '', true);
		$this -> load -> model('m_sqa_model', 'dm', true);
		
        //$this -> load -> vars($data); edited by irfan.satriadarma@gmail.com 20120418 : ini tidak perlu.

		if ($this -> session -> userdata('user_info') == '')
			die("<script>window.location='" . site_url('welcome/out') . "'</script>");
	}

	function index() {
		redirect('inquiry/browse');
	}

	function browse2() {
		$data['page_title'] = 'Audit Monitoring and Searching';
		$this -> load -> view('header', $data);
		//echo '~~~ harus di debug halaman ini ~~';
		//$this->load->view('inquiry/browse', $data);
		$this -> load -> view('footer');
	}

	function browse() {
		// cek redir
		if ($this -> uri -> segment(3) != '') {
			$this -> session -> set_userdata('us_search', $this -> uri -> segment(3));
			redirect('inquiry/browse');
		}

        /** edited by irfan.satriadarma@gmail.com 18 April 2012 02:45PM 
            untuk solving masalah timeout pengambilan reference
            model problem?
            
            02:56PM ---> ditemukan masalahnya. ternyata inquiry/browse ini meload data berikut yang
                        sebenarnya tidak perlu:
                            1. T_SQA_DFCT_REPLY ?? 
                            2. V_T_SQA_DFCT ?? ada pengaruh ???
                            3. yang paling fatal: T_SQA_VINF ! --> semua data vehicle harus di load di awal? oh no!
                            
            problem solved.
            ^_^v, Cheers
            
            irfan        
        */
		$err = '';
        
        //T_SQA_DFCT_REPLY
        $this->dm->init('T_SQA_DFCT_REPLY', 'SHOP_ID');
        //$data['list_sqa_dfct_reply'] = $this->dm->select();        
		//$data['list_sqa_dfct_reply'] = $this -> t_sqa_dfct_reply_model -> select();
        
        //V_T_SQA_DFCT
        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
        //$data['list_sqa_dfct'] = $this->dm->select();
		//$data['list_sqa_dfct'] = $this -> t_sqa_dfct_model -> select();

		//M_SQA_SHOP
		$this -> dm -> init('M_SQA_SHOP', 'SHOP_ID');
		$data['list_sqa_shop'] = $this->dm-> select('', '', "SHOP_SHOW='1' AND SHOP_ID != 'IN'");

        //M_SQA_RANK
        $this->dm->init('M_SQA_RANK', 'RANK_ID'); 
        $data['list_rank_model'] = $this->dm->select();
		//$data['list_rank_model'] = $this -> m_sqa_rank_model -> select();
        
        /** 
         * INILAH PENYEBABNYA DATA LAMA SAAT DI LOAD, KENAPA inquiry/browse Harus ambil data semua Vehicle ??
         * Tell Me Why? 
        */
        //T_SQA_VINF 
        $this->dm->init('T_SQA_VINF', 'IDNO');
        //$data['list_sqa_vinf'] = $this->dm->select();
		//$data['list_sqa_vinf'] = $this -> t_sqa_vinf_model -> select();        
        
		$data['list_sqa_ctg_grp_model'] = $this -> m_sqa_ctg_grp_model -> select();
		$data['list_sqa_ctg_model'] = $this -> m_sqa_ctg_model -> select('', 'CTG_NM ASC', '');
		$data['list_m_sqa_shiftgrp'] = $this -> m_sqa_shiftgrp_model -> select();

		$this -> dm -> init('M_SQA_SHIFTGRP', 'SHIFTGRP_ID');
		$data['list_shift'] = $this -> dm -> select();

		$this -> dm -> init('M_SQA_PLANT', 'PLANT_CD');
		$data['list_plant_select'] = $this -> dm -> select();
		$data['list_plant'] = get_user_info($this, 'PLANT_NM');
		$data['page_title'] = 'Audit Monitoring and Searching';
		$data['err'] = $err;
		$this -> load -> view('header', $data);
		$this -> load -> view('inquiry/browse', $data);
		$this -> load -> view('footer');
	}

	function get_ctg() {
		$ctg_grp_id = $_POST['ctg_grp_id'];
		$ctg_nm = $_POST['ctg_nm'];
		$this -> dm -> init('V_SQA_CTG', 'CTG_GRP_ID');
		$w = "CTG_GRP_NM = '" . $ctg_grp_id . "'";
		$ctgs = $this -> dm -> select('', '', $w);
		$out = '<sup>- empty category -</sup>';
		//  if (count($ctgs) > 0) {
		$out = '<select name="CTG_NM" id="CTG_NM" style="width: 180px"><option value="0">-- ALL --</option>';
		foreach ($ctgs as $c) {
			$sel = ($ctg_nm == $c -> CTG_NM) ? 'selected="selected"' : '';
			$out .= '<option value="' . $c -> CTG_NM . '">' . $c -> CTG_NM . '</option>';
		}
		$out .= '</select>';
		// }
		echo $out;
	}

	// fungsi untuk pencarian DEFACT
	function search() {
		// sleep(3);
		$condition = '';
		$err = '';
		$param = $_POST['param'];
		$IDNO = (isset($_POST['IDNO'])) ? $_POST['IDNO'] : '';

		if ($param != '') {
			$param_ex = explode(';;', $param);
			$from = $param_ex[0];
			$to = $param_ex[1];
			$sqa_shiftgrpnm = $param_ex[2];
			$plant_nm = $param_ex[3];
			$SHOP_NM = $param_ex[4];

			if (($from != '')) {
				$explode = explode('-', $from);
				$from = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			} else {
				$from = '0';
			}

			if (($to != '')) {
				$explode = explode('-', $to);
				$to = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			} else {
				$to = '0';
			}

            /** edited by irfan.satriadarma@gmail.com 20120418: hal ini tidak perlu **/
			/*if (($ASSY_FROM_PDATE != '')) {
				$explode = explode('-', $ASSY_FROM_PDATE);
				$ASSY_FROM_PDATE = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			} else {
				$ASSY_FROM_PDATE = '';
			}*/

			if ($from != '' && $to != '') {
				$condition .= "( (AUDIT_PDATE) >= '" . $from . "' AND (AUDIT_PDATE) <= '" . $to . "')";
			}
			if ($sqa_shiftgrpnm != '0') {
				$condition .= ($condition != '') ? " AND (SQA_SHIFTGRPNM = '" . $sqa_shiftgrpnm . "' OR AUDIT_SHIFTGRPNM = '" . $sqa_shiftgrpnm . "' )" : " 
                    (SQA_SHIFTGRPNM = '" . $sqa_shiftgrpnm . "' OR AUDIT_SHIFTGRPNM = '" . $sqa_shiftgrpnm . "' )";
			}
			if ($plant_nm != '0') {
				$condition .= ($condition != '') ? " AND (PLANT_NM = '" . $plant_nm . "')" : " (PLANT_NM = '" . $plant_nm . "')";
			}
			if ($SHOP_NM != '0') {
				$condition .= ($condition != '') ? " AND (SHOP_NM = '" . $SHOP_NM . "')" : " (SHOP_NM = '" . $SHOP_NM . "')";
			}
            
		}
		// echo $condition;
		// kembalikan kondisi pencarian ----------------------------------------------
		$us_search = $this -> session -> userdata('us_search');
		if ($us_search != '') {
			$condition = $this -> session -> userdata('ss_search');
			$this -> session -> set_userdata('us_search', '');
			$this -> session -> set_userdata('ss_search', $condition);
		} else {
			$this -> session -> set_userdata('ss_search', $condition);
		}
		$data['us_search'] = $us_search;
		// ---------------------------------------------------------------------------

		$pos_audit_pdate_1 = strpos($condition, '(AUDIT_PDATE) >=');
		$audit_pdate_1 = substr($condition, ($pos_audit_pdate_1 + 18), 10);
		$pos_audit_pdate_2 = strpos($condition, '(AUDIT_PDATE) <=');
		$audit_pdate_2 = substr($condition, ($pos_audit_pdate_2 + 18), 10);

		// cari plant_nm
		$plant_nm_ = 0;
		$pos_plant_nm = strpos($condition, "PLANT_NM = '");
		if ($pos_plant_nm !== false) {
			$condition_plant_nm = substr($condition, $pos_plant_nm, strlen($condition));
			$condition_plant_nm_pos_start = strpos($condition_plant_nm, "'");
			$condition_plant_nm_pos_end = strpos($condition_plant_nm, "')");

			// ambil plant name nya
			$plant_nm_awal = substr($condition_plant_nm, 0, $condition_plant_nm_pos_start + 1);
			$plant_nm_akhir = substr($condition_plant_nm, $condition_plant_nm_pos_end, strlen($condition_plant_nm));
			$pjg_isi_plant_nm = (strlen($condition_plant_nm)) - (strlen($plant_nm_awal) + strlen($plant_nm_akhir));

			$plant_nm_ = substr($condition_plant_nm, $condition_plant_nm_pos_start + 1, $pjg_isi_plant_nm);
		}

		// cari shift_nm
		$shift_nm_ = 0;
		$pos_shift_nm = strpos($condition, "SQA_SHIFTGRPNM = '");
		if ($pos_shift_nm !== false) {
			$condition_shift_nm = substr($condition, $pos_shift_nm, strlen($condition));
			$condition_shift_nm_pos_start = strpos($condition_shift_nm, "'");
			$condition_shift_nm_pos_end = strpos($condition_shift_nm, "')");

			// ambil shift name nya
			$shift_nm_awal = substr($condition_shift_nm, 0, $condition_shift_nm_pos_start + 1);
			$shift_nm_akhir = substr($condition_shift_nm, $condition_shift_nm_pos_end, strlen($condition_shift_nm));
			$pjg_isi_shift_nm = (strlen($condition_shift_nm)) - (strlen($shift_nm_awal) + strlen($shift_nm_akhir));

			$shift_nm_ = substr($condition_shift_nm, $condition_shift_nm_pos_start + 1, $pjg_isi_shift_nm);
		}

		// cari shop_nm
		$shop_nm_ = 0;
		$pos_shop_nm = strpos($condition, "SHOP_NM = '");
		if ($pos_shop_nm !== false) {
			$condition_shop_nm = substr($condition, $pos_shop_nm, strlen($condition));
			$condition_shop_nm_pos_start = strpos($condition_shop_nm, "'");
			$condition_shop_nm_pos_end = strpos($condition_shop_nm, "')");

			// ambil shop name nya
			$shop_nm_awal = substr($condition_shop_nm, 0, $condition_shop_nm_pos_start + 1);
			$shop_nm_akhir = substr($condition_shop_nm, $condition_shop_nm_pos_end, strlen($condition_shop_nm));
			$pjg_isi_shop_nm = (strlen($condition_shop_nm)) - (strlen($shop_nm_awal) + strlen($shop_nm_akhir));

			$shop_nm_ = substr($condition_shop_nm, $condition_shop_nm_pos_start + 1, $pjg_isi_shop_nm);
		}

		//echo $audit_pdate_1 . ';' . $audit_pdate_2 . ';' . $plant_nm_ . ';' . $shift_nm_ . ';' . $shop_nm_;
		$data['audit_pdate_1'] = $audit_pdate_1;
		$data['audit_pdate_2'] = $audit_pdate_2;
		$data['plant_nm_'] = $plant_nm_;
		$data['shift_nm_'] = $shift_nm_;
		$data['shop_nm_'] = $shop_nm_;

		//echo $shop_nm_;

		$order = "AUDIT_PDATE desc";

		//==============jika selain SQA Administrator.. hanya akan muncul hasil pencarian yg sudah diapprove saja=========
		/*$sql = "select distinct VINNO,PLANT_NM, IDNO, BODYNO, REFNO, DFCT = 'UNDER SQA CHECK',SHOP_NM='-', DESCRIPTION,
        SQA_SHIFTGRPNM='-',EXTCLR,SQA_SHIFTGRPNM,AUDITOR_NM_1,AUDITOR_NM_2, AUDIT_FINISH_PDATE
        from V_T_SQA_DFCT_2
        where APPROVE_PDATE is null and " . $condition;*/
		//echo $condition;
        $user_grpauth = get_user_info($this, 'GRPAUTH_ID');
		//echo $user_grpauth;
		$non_sqa = $user_grpauth != '04' && $user_grpauth != '05' && $user_grpauth != '06' && $user_grpauth != '07' && $user_grpauth != '08' && $user_grpauth != '09';
        if ($non_sqa == 1){
            $condition1 = $condition . " AND AUDIT_FINISH_PDATE IS NULL";
        }else{
            $condition1 = $condition;
        }
		$sql = "select distinct VINNO,PLANT_NM, IDNO, BODYNO, REFNO, DFCT = 'UNDER SQA CHECK',SHOP_NM='-', DESCRIPTION,
        AUDIT_SHIFTGRPNM, EXTCLR,SQA_SHIFTGRPNM,AUDITOR_NM_1,AUDITOR_NM_2, AUDIT_FINISH_PDATE, AUDIT_PDATE, REG_IN, REG_OUT, ASSY_SHIFTGRPNM, INSP_SHIFTGRPNM
        from V_T_SQA_DFCT_2
        where APPROVE_PDATE is null and " . $condition1 . " order by AUDIT_PDATE desc";
		
		$list_under_sqa_check = $this -> dm -> sql_self($sql);

		if ($non_sqa == 1) {
			$condition = $condition . " AND APPROVE_PDATE IS NOT NULL";
			$list_v_sqa_dfct = $this -> v_sqa_dfct_model -> select('', $order, $condition);

			// cek jika orang non sqa, ambil data vehicle yg framenya sama di group per frame, di tampilkan under sqa
			// hasilnya (object tsb) di tambahkan ke $list_v_sqa_dfct;

			foreach ($list_under_sqa_check as $l) {
				$list_v_sqa_dfct[] = $l;
			}
			$data['list_v_sqa_dfct'] = $list_v_sqa_dfct;
		} else {
			// cek jika orang non sqa, ambil data vehicle yg framenya sama di group per frame, di tampilkan under sqa
			$list_v_sqa_dfct = $this -> v_sqa_dfct_model -> select('', $order, $condition);
			//list orang SQA
			$data['list_v_sqa_dfct'] = $list_v_sqa_dfct;
		}
		//================================================================================================================//
		// di cari replynya berdasarkan ilst_v_sqa_dfct;
		$list_dfct_reply = array();
		foreach ($list_v_sqa_dfct as $l) {
			$problem_id = $l -> PROBLEM_ID;
			// cari reply berdasarkan problem id
			$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
			$w = "PROBLEM_ID = '" . $problem_id . "'";
			$dfct_reply = $this -> dm -> select('', '', $w);
			if (count($dfct_reply) > 0) {
				$list_dfct_reply[$problem_id] = $dfct_reply;
			}
		}

		//$this->session->set_userdata('sess_search_condition', $condition);
        //echo $sql;
		$data['list_dfct_reply'] = $list_dfct_reply;
		$data['condition'] = AsciiToHex(base64_encode($condition));
		$data['param'] = AsciiToHex(base64_encode($param));

		$this -> load -> view('inquiry/list_vinf', $data);
	}

	// fungsi untuk pencarian ADVANCE DEFACT
	function advance_search() {
		// sleep(5);

		$problem_id = (isset($_POST['problem_id'])) ? $_POST['problem_id'] : '';
		$condition = '';
		$err = '';
		$param = $_POST['param'];

		if ($param != '') {
			$param_ex = explode(';;', $param);
			$from = $param_ex[0];
			$to = $param_ex[1];
			$sqa_shiftgrpnm = $param_ex[2];
			$plant_nm = $param_ex[3];
			$SHOP_NM = $param_ex[4];
			$ASSY_FROM_PDATE = $param_ex[5];
			$ASSY_TO_PDATE = $param_ex[6];
			$ASSY_SHIFTGRPNM = $param_ex[7];
			$INSP_FROM_PDATE = $param_ex[8];
			$INSP_TO_PDATE = $param_ex[9];
			$INSP_SHIFTGRPNM = $param_ex[10];
			$DESCRIPTION = $param_ex[11];
			$KATASHIKI = $param_ex[12];
			$EXTCLR = $param_ex[13];
			$VINNO = $param_ex[14];
			$BODYNO = $param_ex[15];
			$stat_prob = $param_ex[16];
			$DFCT = $param_ex[17];
			$RANK_NM = $param_ex[18];
			$CTG_GRP_NM = $param_ex[19];
			$CTG_NM = $param_ex[20];
			$INSP_ITEM_FLG = $param_ex[21];
			$QLTY_GT_ITEM = $param_ex[22];
			$REPAIR_FLG = $param_ex[23];
			$Problem_Sheet_a = $param_ex[24];
			$Problem_Sheet_b = $param_ex[25];
			$Problem_Sheet_c = $param_ex[26];
			$Problem_Sheet_d = $param_ex[27];
			$Status_Problem_Sheet = $param_ex[28];
			$SHOW_FLG = $param_ex[29];

			if (($from != '')) {
				$explode = explode('-', $from);
				$from = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			} else {
				$from = '0';
			}

			if (($to != '')) {
				$explode = explode('-', $to);
				$to = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			} else {
				$to = '0';
			}

			if (($ASSY_FROM_PDATE != '')) {
				$explode = explode('-', $ASSY_FROM_PDATE);
				$ASSY_FROM_PDATE = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			} else {
				$ASSY_FROM_PDATE = '';
			}

			if (($ASSY_TO_PDATE != '')) {
				$explode = explode('-', $ASSY_TO_PDATE);
				$ASSY_TO_PDATE = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			} else {
				$ASSY_TO_PDATE = '';
			}

			if (($INSP_FROM_PDATE != '')) {
				$explode = explode('-', $INSP_FROM_PDATE);
				$INSP_FROM_PDATE = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			} else {
				$INSP_FROM_PDATE = '';
			}

			if (($INSP_TO_PDATE != '')) {
				$explode = explode('-', $INSP_TO_PDATE);
				$INSP_TO_PDATE = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			} else {
				$INSP_TO_PDATE = '';
			}

			if ($from != '' && $to != '') {
				$condition .= "( (AUDIT_PDATE) >= '" . $from . "' AND (AUDIT_PDATE) <= '" . $to . "')";
			}
			if ($sqa_shiftgrpnm != '0') {
				$condition .= ($condition != '') ? " AND (SQA_SHIFTGRPNM = '" . $sqa_shiftgrpnm . "' OR AUDIT_SHIFTGRPNM = '" . $sqa_shiftgrpnm . "' )" : " 
                    (SQA_SHIFTGRPNM = '" . $sqa_shiftgrpnm . "' OR AUDIT_SHIFTGRPNM = '" . $sqa_shiftgrpnm . "' )";
			}
			if ($plant_nm != '0') {
				$condition .= ($condition != '') ? " AND (PLANT_NM = '" . $plant_nm . "')" : " (PLANT_NM = '" . $plant_nm . "')";
			}
			if ($SHOP_NM != '0') {
				$condition .= ($condition != '') ? " AND (SHOP_NM = '" . $SHOP_NM . "')" : " (SHOP_NM = '" . $SHOP_NM . "')";
			}

			if ($ASSY_FROM_PDATE != '' && $ASSY_TO_PDATE != '') {
				$condition .= " AND ( (ASSY_PDATE) >= '" . $ASSY_FROM_PDATE . "' AND (ASSY_PDATE) <= '" . $ASSY_TO_PDATE . "')";
			}
			if ($ASSY_SHIFTGRPNM != '0') {
				$condition .= ($condition != '') ? " AND (ASSY_SHIFTGRPNM like '%" . $ASSY_SHIFTGRPNM . "%')" : " (ASSY_SHIFTGRPNM like '%" . $ASSY_SHIFTGRPNM . "%')";
			}
			if ($INSP_FROM_PDATE != '' && $INSP_TO_PDATE != '') {
				$condition .= " AND ( (INSP_PDATE) >= '" . $INSP_FROM_PDATE . "' AND (INSP_PDATE) <= '" . $INSP_TO_PDATE . "')";
			}
			if ($INSP_SHIFTGRPNM != '0') {
				$condition .= ($condition != '') ? " AND (INSP_SHIFTGRPNM like '%" . $INSP_SHIFTGRPNM . "%')" : " (INSP_SHIFTGRPNM like '%" . $INSP_SHIFTGRPNM . "%')";
			}
			if ($DESCRIPTION != '') {
				$condition .= ($condition != '') ? " AND (DESCRIPTION like '%" . $DESCRIPTION . "%')" : " (DESCRIPTION like '%" . $DESCRIPTION . "%')";
			}
			if ($KATASHIKI != '') {
				$condition .= ($condition != '') ? " AND (KATASHIKI like '%" . $KATASHIKI . "%')" : " (KATASHIKI like '%" . $KATASHIKI . "%')";
			}
			if ($EXTCLR != '') {
				$condition .= ($condition != '') ? " AND (EXTCLR like '%" . $EXTCLR . "%')" : " (EXTCLR like '%" . $EXTCLR . "%')";
			}
			if ($VINNO != '') {
				$condition .= ($condition != '') ? " AND (VINNO like '%" . $VINNO . "%')" : " (VINNO like '%" . $VINNO . "%')";
			}
			if ($BODYNO != '') {
				$condition .= ($condition != '') ? " AND (BODYNO like '%" . $BODYNO . "%')" : " (BODYNO like '%" . $BODYNO . "%')";
			}
			if ($stat_prob == '1') {
				$condition .= ($condition != '') ? " AND (SQPR_NUM IS NULL AND PRB_SHEET_NUM IS NOT NULL)" : " (SQPR_NUM IS NULL AND PRB_SHEET_NUM IS NOT NULL)";
			}
			if ($stat_prob == '2') {
				$condition .= ($condition != '') ? " AND (SQPR_NUM IS NOT NULL AND PRB_SHEET_NUM IS NOT NULL)" : " (SQPR_NUM IS NOT NULL AND PRB_SHEET_NUM IS NOT NULL)";
			}
			if ($stat_prob == '3') {
				$condition .= ($condition != '') ? " AND (DFCT IS NULL)" : " (DFCT IS NULL)";
			}
			if ($stat_prob == '4') {
				$condition .= ($condition != '') ? " AND (REG_IN IS NOT NULL AND REG_OUT IS NULL)" : " (REG_IN IS NOT NULL AND REG_OUT IS NULL)";
			}
			if ($stat_prob == '5') {
				$condition .= ($condition != '') ? " AND (SHOP_NM = 'Chosagoumi' AND DFCT IS NOT NULL)" : " (SHOP_NM = 'Chosagoumi' AND DFCT IS NOT NULL)";
			}
			if ($DFCT != '') {
				$condition .= ($condition != '') ? " AND (DFCT like '%" . $DFCT . "%')" : " (DFCT like '%" . $DFCT . "%')";
			}
			if ($RANK_NM != '0') {
				$condition .= ($condition != '') ? " AND (RANK_NM2 like '%" . $RANK_NM . "%')" : " (RANK_NM2 like '%" . $RANK_NM . "%')";
			}
			if ($CTG_GRP_NM != '0') {
				$condition .= ($condition != '') ? " AND (CTG_GRP_NM like '%" . $CTG_GRP_NM . "%')" : " (CTG_GRP_NM like '%" . $CTG_GRP_NM . "%')";
			}

			if ($CTG_NM != '0') {
				$condition .= ($condition != '') ? " AND (CTG_NM like '%" . $CTG_NM . "%')" : " (CTG_NM like '%" . $CTG_NM . "%')";
			}
			if ($INSP_ITEM_FLG != '') {
				$condition .= ($condition != '') ? " AND (INSP_ITEM_FLG like '%" . $INSP_ITEM_FLG . "%')" : " (INSP_ITEM_FLG like '%" . $INSP_ITEM_FLG . "%')";
			}
			if ($QLTY_GT_ITEM != '') {
				$condition .= ($condition != '') ? " AND (QLTY_GT_ITEM like '%" . $QLTY_GT_ITEM . "%')" : " (QLTY_GT_ITEM like '%" . $QLTY_GT_ITEM . "%')";
			}
			if ($REPAIR_FLG != '') {
				$condition .= ($condition != '') ? " AND (REPAIR_FLG like '%" . $REPAIR_FLG . "%')" : " (REPAIR_FLG like '%" . $REPAIR_FLG . "%')";
			}

			if ($Problem_Sheet_a != '') {
				$condition .= ($condition != '') ? " AND (PRB_SHEET_NUM like '%" . $Problem_Sheet_a . "%' OR SQPR_NUM like '%" . $Problem_Sheet_a . "%' )" : " (PRB_SHEET_NUM like '%" . $Problem_Sheet_a . "%' OR SQPR_NUM like '%" . $Problem_Sheet_a . "%')";
			}
			if ($Problem_Sheet_b != '') {
				$condition .= ($condition != '') ? " AND (PRB_SHEET_NUM like '%" . $Problem_Sheet_b . "%' OR SQPR_NUM like '%" . $Problem_Sheet_b . "%' )" : " (PRB_SHEET_NUM like '%" . $Problem_Sheet_b . "%' OR SQPR_NUM like '%" . $Problem_Sheet_b . "%')";
			}
			if ($Problem_Sheet_c != '') {
				$condition .= ($condition != '') ? " AND (PRB_SHEET_NUM like '%" . $Problem_Sheet_c . "%' OR SQPR_NUM like '%" . $Problem_Sheet_c . "%' )" : " (PRB_SHEET_NUM like '%" . $Problem_Sheet_c . "%' OR SQPR_NUM like '%" . $Problem_Sheet_c . "%')";
			}
			if ($Problem_Sheet_d != '') {
				$condition .= ($condition != '') ? " AND (PRB_SHEET_NUM like '%" . $Problem_Sheet_d . "%' OR SQPR_NUM like '%" . $Problem_Sheet_d . "%' )" : " (PRB_SHEET_NUM like '%" . $Problem_Sheet_d . "%' OR SQPR_NUM like '%" . $Problem_Sheet_d . "%')";
			}

			if ($Status_Problem_Sheet == '0') {
				$condition .= ($condition != '') ? " AND (CLOSE_FLG like '%" . $Status_Problem_Sheet . "%')" : " (CLOSE_FLG like '%" . $Status_Problem_Sheet . "%')";
			}
			if ($Status_Problem_Sheet == '1') {
				$condition .= ($condition != '') ? " AND (CLOSE_FLG like '%" . $Status_Problem_Sheet . "%')" : " (CLOSE_FLG like '%" . $Status_Problem_Sheet . "%')";
			}
			if ($Status_Problem_Sheet == '2') {
				$condition .= ($condition != '') ? " AND 
               (PROBLEM_ID IN (select PROBLEM_ID FROM T_SQA_DFCT_REPLY WHERE REPLY_TYPE = 'R' AND COUNTERMEASURE_TYPE = 'F' AND APPROVE_PDATE is null ))" : " (PROBLEM_ID IN (select PROBLEM_ID FROM T_SQA_DFCT_REPLY WHERE REPLY_TYPE = 'R' AND COUNTERMEASURE_TYPE = 'F' AND APPROVE_PDATE is null))";
			}
			if ($Status_Problem_Sheet == '3') {
				$condition .= ($condition != '') ? " AND
               (PROBLEM_ID IN (select PROBLEM_ID FROM T_SQA_DFCT_REPLY WHERE REPLY_TYPE = 'R' AND COUNTERMEASURE_TYPE = 'F' AND APPROVE_PDATE is not null AND DUE_DATE < (select PDATE FROM M_SQA_PRDT )))" : " (PROBLEM_ID IN (select PROBLEM_ID FROM T_SQA_DFCT_REPLY WHERE REPLY_TYPE = 'R' AND COUNTERMEASURE_TYPE = 'F' AND APPROVE_PDATE is not null AND DUE_DATE < (select PDATE FROM M_SQA_PRDT )))";
			}
			if ($SHOW_FLG != '') {
				$condition .= ($condition != '') ? " AND (SHOW_FLG like '%" . $SHOW_FLG . "%')" : " (SHOW_FLG like '%" . $SHOW_FLG . "%')";
			}

		}
		// echo $condition;

		// kembalikan kondisi pencarian ----------------------------------------------
		$us_search = $this -> session -> userdata('us_search');
		if ($us_search != '') {
			$condition = $this -> session -> userdata('ss_search');
			$this -> session -> set_userdata('us_search', '');
			$this -> session -> set_userdata('ss_search', $condition);
		} else {
			$this -> session -> set_userdata('ss_search', $condition);
		}
		$data['us_search'] = $us_search;
		// ---------------------------------------------------------------------------

		$pos_audit_pdate_1 = strpos($condition, '(AUDIT_PDATE) >=');
		$audit_pdate_1 = substr($condition, ($pos_audit_pdate_1 + 18), 10);
		$pos_audit_pdate_2 = strpos($condition, '(AUDIT_PDATE) <=');
		$audit_pdate_2 = substr($condition, ($pos_audit_pdate_2 + 18), 10);

		// cari plant_nm
		$plant_nm_ = 0;
		$pos_plant_nm = strpos($condition, "PLANT_NM = '");
		if ($pos_plant_nm !== false) {
			$condition_plant_nm = substr($condition, $pos_plant_nm, strlen($condition));
			$condition_plant_nm_pos_start = strpos($condition_plant_nm, "'");
			$condition_plant_nm_pos_end = strpos($condition_plant_nm, "')");

			// ambil plant name nya
			$plant_nm_awal = substr($condition_plant_nm, 0, $condition_plant_nm_pos_start + 1);
			$plant_nm_akhir = substr($condition_plant_nm, $condition_plant_nm_pos_end, strlen($condition_plant_nm));
			$pjg_isi_plant_nm = (strlen($condition_plant_nm)) - (strlen($plant_nm_awal) + strlen($plant_nm_akhir));

			$plant_nm_ = substr($condition_plant_nm, $condition_plant_nm_pos_start + 1, $pjg_isi_plant_nm);
		}

		// cari shift_nm
		$shift_nm_ = 0;
		$pos_shift_nm = strpos($condition, "SQA_SHIFTGRPNM = '");
		if ($pos_shift_nm !== false) {
			$condition_shift_nm = substr($condition, $pos_shift_nm, strlen($condition));
			$condition_shift_nm_pos_start = strpos($condition_shift_nm, "'");
			$condition_shift_nm_pos_end = strpos($condition_shift_nm, "')");

			// ambil shift name nya
			$shift_nm_awal = substr($condition_shift_nm, 0, $condition_shift_nm_pos_start + 1);
			$shift_nm_akhir = substr($condition_shift_nm, $condition_shift_nm_pos_end, strlen($condition_shift_nm));
			$pjg_isi_shift_nm = (strlen($condition_shift_nm)) - (strlen($shift_nm_awal) + strlen($shift_nm_akhir));

			$shift_nm_ = substr($condition_shift_nm, $condition_shift_nm_pos_start + 1, $pjg_isi_shift_nm);
		}

		// cari shop_nm
		$shop_nm_ = 0;
		$pos_shop_nm = strpos($condition, "SHOP_NM = '");
		if ($pos_shop_nm !== false) {
			$condition_shop_nm = substr($condition, $pos_shop_nm, strlen($condition));
			$condition_shop_nm_pos_start = strpos($condition_shop_nm, "'");
			$condition_shop_nm_pos_end = strpos($condition_shop_nm, "')");

			// ambil shop name nya
			$shop_nm_awal = substr($condition_shop_nm, 0, $condition_shop_nm_pos_start + 1);
			$shop_nm_akhir = substr($condition_shop_nm, $condition_shop_nm_pos_end, strlen($condition_shop_nm));
			$pjg_isi_shop_nm = (strlen($condition_shop_nm)) - (strlen($shop_nm_awal) + strlen($shop_nm_akhir));

			$shop_nm_ = substr($condition_shop_nm, $condition_shop_nm_pos_start + 1, $pjg_isi_shop_nm);
		}

		//echo $audit_pdate_1 . ';' . $audit_pdate_2 . ';' . $plant_nm_ . ';' . $shift_nm_ . ';' . $shop_nm_;
		$data['audit_pdate_1'] = $audit_pdate_1;
		$data['audit_pdate_2'] = $audit_pdate_2;
		$data['plant_nm_'] = $plant_nm_;
		$data['shift_nm_'] = $shift_nm_;
		$data['shop_nm_'] = $shop_nm_;

		//echo $shop_nm_;

		$order = "AUDIT_PDATE desc";

		//==============jika selain SQA Administrator.. hanya akan muncul hasil pencarian yg sudah diapprove saja=========
		/*$sql = "select distinct VINNO,PLANT_NM, IDNO, BODYNO, REFNO, DFCT = 'UNDER SQA CHECK',SHOP_NM='-', DESCRIPTION,
        SQA_SHIFTGRPNM='-',EXTCLR,SQA_SHIFTGRPNM,AUDITOR_NM_1,AUDITOR_NM_2, AUDIT_FINISH_PDATE
        from V_T_SQA_DFCT_2
        where APPROVE_PDATE is null and " . $condition;*/
		//echo $condition;
        $user_grpauth = get_user_info($this, 'GRPAUTH_ID');
		//echo $user_grpauth;
		$non_sqa = $user_grpauth != '04' && $user_grpauth != '05' && $user_grpauth != '06' && $user_grpauth != '07' && $user_grpauth != '08' && $user_grpauth != '09';
        if ($non_sqa == 1){
            $condition1 = $condition . " AND AUDIT_FINISH_PDATE IS NULL";
        }else{
            $condition1 = $condition;
        }
		$sql = "select distinct VINNO,PLANT_NM, IDNO, BODYNO, REFNO, DFCT = 'UNDER SQA CHECK',SHOP_NM='-', DESCRIPTION,
        AUDIT_SHIFTGRPNM, EXTCLR,SQA_SHIFTGRPNM,AUDITOR_NM_1,AUDITOR_NM_2, AUDIT_FINISH_PDATE, AUDIT_PDATE, REG_IN, REG_OUT, ASSY_SHIFTGRPNM, INSP_SHIFTGRPNM
        from V_T_SQA_DFCT_2
        where APPROVE_PDATE is null and " . $condition1 . " order by AUDIT_PDATE desc";
		
		$list_under_sqa_check = $this -> dm -> sql_self($sql);

		if ($non_sqa == 1) {
			$condition = $condition . " AND APPROVE_PDATE IS NOT NULL";
			$list_v_sqa_dfct = $this -> v_sqa_dfct_model -> select('', $order, $condition);

			// cek jika orang non sqa, ambil data vehicle yg framenya sama di group per frame, di tampilkan under sqa
			// hasilnya (object tsb) di tambahkan ke $list_v_sqa_dfct;

			foreach ($list_under_sqa_check as $l) {
				$list_v_sqa_dfct[] = $l;
			}
			$data['list_v_sqa_dfct'] = $list_v_sqa_dfct;
		} else {
			// cek jika orang non sqa, ambil data vehicle yg framenya sama di group per frame, di tampilkan under sqa
			$list_v_sqa_dfct = $this -> v_sqa_dfct_model -> select('', $order, $condition);
			//list orang SQA
			$data['list_v_sqa_dfct'] = $list_v_sqa_dfct;
		}
		//================================================================================================================//
		// di cari replynya berdasarkan ilst_v_sqa_dfct;
		$list_dfct_reply = array();
		foreach ($list_v_sqa_dfct as $l) {
			$problem_id = $l -> PROBLEM_ID;
			// cari reply berdasarkan problem id
			$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
			$w = "PROBLEM_ID = '" . $problem_id . "'";
			$dfct_reply = $this -> dm -> select('', '', $w);
			if (count($dfct_reply) > 0) {
				$list_dfct_reply[$problem_id] = $dfct_reply;
			}
		}

		//$this->session->set_userdata('sess_search_condition', $condition);
        //echo $sql;
		$data['list_dfct_reply'] = $list_dfct_reply;
		$data['condition'] = AsciiToHex(base64_encode($condition));
		$data['param'] = AsciiToHex(base64_encode($param));

		$this -> load -> view('inquiry/list_vinf', $data);

	}

	// fungsi untuk SHOW STATUS
	function show_flag() {
		$err = '';
		$problem_id = $_POST['problem_id'];
		$show_flag = $_POST['show_flag'];
		$description = $_POST['description'];

		// cek concurency
		$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$p = $this -> dm -> select('', '', $w, 'SHOW_FLG');
		$show = ($p[0] -> SHOW_FLG != null) ? $p[0] -> SHOW_FLG : '0';

		if ($show == '0') {
			$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
			$keys = "PROBLEM_ID = '" . $problem_id . "'";
			$w = "SHOW_FLG ='1' AND DESCRIPTION = '" . $description . "'";
			$show_flg = $this -> dm -> select('', '', $w);

			$dfct = $this -> dm -> select('', '', "PROBLEM_ID = '" . $problem_id . "'");
			$dfct = $dfct[0];

			if (count($show_flg) >= 5) {
				echo $err = $description . ' Maximum show up 5 defect';
			} else {
				$data = array('SHOW_FLG' => 1);
				$this -> dm -> update($data, $keys);
			}
		} else {
			echo $err = 'Another user already Flag as Show';
		}
	}

	// fungsi untuk UNSHOW STATUS
	function Unshow_flag() {

		$problem_id = $_POST['problem_id'];
		$show_flag = $_POST['show_flag'];

		// cek concurency
		$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$p = $this -> dm -> select('', '', $w);
		$show = $p[0] -> SHOW_FLG;

		if ($show == '1') {

			$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
			$keys = "PROBLEM_ID = '" . $problem_id . "'";

			$data = array('SHOW_FLG' => 0);
			$this -> dm -> update($data, $keys);

			$order = "SQA_PDATE desc";
			$data['list_v_sqa_dfct'] = $this -> v_sqa_dfct_model -> select('', $order, '');

			//  $this->load->view('inquiry/list_vinf', $data);

		} else {
			echo $err = 'Another user already flag this vehicle as unshow';
		}
	}

	//
	// fungsi untuk CHECKED
	function cek() {
		$err = '';
		$problem_id = $_POST['problem_id'];

		// cek concurency
		$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$p = $this -> dm -> select('', '', $w);
		$check_pdate = $p[0] -> CHECK_PDATE;

		if ($check_pdate == '') {

			$this -> dm -> init('M_SQA_PRDT', 'PLANT_CD');
			$p = $this -> dm -> select('', '', "PLANT_CD ='" . get_user_info($this, 'PLANT_CD') . "'");
			$PDATE = $p[0] -> PDATE;

			$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
			$keys = "PROBLEM_ID = '" . $problem_id . "'";

			if ($PDATE != '') {

				$data = array('CHECK_SYSDATE' => get_date(), 'CHECKED_BY' => get_user_info($this, 'USER_ID'), 'CHECK_PDATE' => $PDATE);
			} else {

				$data = array('CHECK_SYSDATE' => get_date(), 'CHECKED_BY' => get_user_info($this, 'USER_ID'), 'CHECK_PDATE' => get_date());
			}

			$this -> dm -> update($data, $keys);
		} else {
			echo $err = 'Another user already checked this defect';
		}
	}

	// fungsi untuk UNCHEKED
	function Uncek() {
		$err = '';
		$problem_id = $_POST['problem_id'];
		// cek concurency
		$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$p = $this -> dm -> select('', '', $w);
		$check_pdate = $p[0] -> CHECK_PDATE;

		if ($check_pdate != '') {

			$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
			$keys = "PROBLEM_ID = '" . $problem_id . "'";

			$data = array('CHECK_SYSDATE' => null, 'CHECKED_BY' => null, 'CHECK_PDATE' => null);
			$this -> dm -> update($data, $keys);

		} else {
			echo $err = 'Another user already Uncheck this defect';
		}
	}

	// fungsi untuk APPROVED
	function approved() {
		$problem_id = $_POST['problem_id'];

		// cek concurency
		$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$p = $this -> dm -> select('', '', $w);
		$approve_pdate = $p[0] -> APPROVE_PDATE;

		if ($approve_pdate == '') {

			// get prdt
			$this -> dm -> init('M_SQA_PRDT', 'PLANT_CD');
			$p = $this -> dm -> select('', '', "PLANT_CD ='" . get_user_info($this, 'PLANT_CD') . "'");
			$PDATE = $p[0] -> PDATE;

			// get problem sheet number
			$PRB = $this -> dm -> prb_number();

			// get detail defect
			$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
			$keys = "PROBLEM_ID = '" . $problem_id . "'";
			$dfct = $this -> dm -> select('', '', $keys);
			$dfct = $dfct[0];

			if ($dfct -> CHECK_PDATE == '') {
				$err = "DEFECT STATUS MUST BE CHECK FIRST !";
			} else {
				if ($dfct -> SHOP_NM == 'Chosagoumi') {
					$err = "DEFECT CHOSAGOUMI !";
				} else {
					//================================update approval=======================================
					$approve_sysdate = get_date();
					$data = array('PRB_SHEET_NUM' => $PRB, 'APPROVE_SYSDATE' => $approve_sysdate, 'APPROVED_BY' => get_user_info($this, 'USER_ID'), 'APPROVE_PDATE' => $PDATE);
					$this -> dm -> update($data, $keys);

					//================================insert ke reply=======================================

					// get shop_id by shop_nm
					$this -> dm -> init('M_SQA_SHOP', 'SHOP_ID');
					$shop = $this -> dm -> select('', '', "SHOP_NM = '" . $dfct -> SHOP_NM . "'", 'SHOP_ID');
					$shop_id = $shop[0] -> SHOP_ID;

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
					$this -> dm -> sql_self($sql);

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
					$this -> dm -> sql_self($sql);

					// cek jika INSP_ITEM_FLG = true
					if ($dfct -> INSP_ITEM_FLG == '1') {
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
						$this -> dm -> sql_self($sql);

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
						$this -> dm -> sql_self($sql);
					}

					//================================send email============================================
					// find confirm by qcd
					$this -> dm -> init('T_SQA_DFCT_CONFBY', 'PROBLEM_ID');
					$dfct_confby = $this -> dm -> select('', '', "PROBLEM_ID = '" . $problem_id . "'");
					$dfct_confby_qcd = $dfct_confby_rel = '';
					foreach ($dfct_confby as $d) {
						$dfct_confby_qcd .= ($d -> CONF_TYPE == '0') ? $d -> CONF_BY . ', ' : '';
						$dfct_confby_rel .= ($d -> CONF_TYPE == '1') ? $d -> CONF_BY . ', ' : '';
					}

					// find reply
					$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
					$list_reply = $this -> dm -> select('', 'REPLY_TYPE ASC, COUNTERMEASURE_TYPE DESC', "PROBLEM_ID = '" . $problem_id . "'");
					$reply_text = '';
					foreach ($list_reply as $lr) {
						$rep_type = ($lr -> REPLY_TYPE == 'O') ? 'Outflow' : 'Occure';
						$rep_coun = ($lr -> COUNTERMEASURE_TYPE == 'T') ? 'Temporary' : 'Fix';
						$reply_text .= "
                        <tr>
                            <td>" . $rep_type . "</td>
                            <td>" . $rep_coun . "</td>
                            <td>" . date('d/m/Y', strtotime($lr -> DUE_DATE)) . "</td>
                        </tr>
                    ";
					}

					$to = (get_user_email_approval($this));
					$content = get_content_email_approval($dfct, $PRB, $approve_sysdate, $dfct_confby_qcd, $dfct_confby_rel, $reply_text);
					$subject = 'INFORMATION PROBLEM';
					$send = $this -> dm -> send_email($to, $content, $subject);
				}
			}
			//  echo $err;
		} else {
			echo $err = 'Another User already Approved this defect';
		}
	}

	// fungsi untuk UNAPPROVED
	function Unapproved() {
		$err = '';
		$problem_id = $_POST['problem_id'];

		// cek concurency
		$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$p = $this -> dm -> select('', '', $w);
		$approve_pdate = $p[0] -> APPROVE_PDATE;

		if ($approve_pdate != '') {

			$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
			$dfct_reply = $this -> dm -> select('', '', "PROBLEM_ID = '" . $problem_id . "'");
			$dfct_reply = $dfct_reply[0];

			$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
			$keys = "PROBLEM_ID = '" . $problem_id . "'";

			if ($dfct_reply -> APPROVE_PDATE != '') {
				$err = "RELATED USERS MUST BE UNAPPROVE STATUS REPLY COMMENT";
			} else {
				// update field yg berubah
				$data = array('APPROVE_SYSDATE' => null, 'APPROVED_BY' => null, 'APPROVE_PDATE' => null, 'SHOW_FLG' => 0, 'PRB_SHEET_NUM' => null, 'SQPR_NUM' => null);
				$this -> dm -> update($data, $keys);

				// ambil list problem_reply_id
				$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
				$where = "PROBLEM_ID = '" . $problem_id . "'";
				$hapus = $this -> dm -> select('', 'PROBLEM_REPLY_ID', $where);

				// hapus dari attachment foreach problem_reply_id
				foreach ($hapus as $ii) :
					$this -> dm -> init('T_SQA_DFCT_REPLY_ATTACH', 'PROBLEM_REPLY_ID');

					// cari dulu file attachment nya, hapus fisik
					$list_reply_attch = $this -> dm -> select('', '', "PROBLEM_REPLY_ID = '" . $ii -> PROBLEM_REPLY_ID . "'");
					foreach ($list_reply_attch as $l) {
						if (file_exists(PATH_ATTCH . $l -> ATTACH_DOC))
							unlink(PATH_ATTCH . $l -> ATTACH_DOC);
					}

					$keys2 = "PROBLEM_REPLY_ID = '" . $ii -> PROBLEM_REPLY_ID . "'";
					$this -> dm -> delete($keys2);
				endforeach;

				// hapus dari dfct reply
				$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
				$keys = "PROBLEM_ID = '" . $problem_id . "'";
				$this -> dm -> delete($keys);

				// get detail defect to be emailed
				$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
				$dfct = $this -> dm -> select('', '', "PROBLEM_ID = '" . $problem_id . "'");
				$dfct = $dfct[0];

				// find confirm by qcd
				$this -> dm -> init('T_SQA_DFCT_CONFBY', 'PROBLEM_ID');
				$dfct_confby = $this -> dm -> select('', '', "PROBLEM_ID = '" . $problem_id . "'");
				$dfct_confby_qcd = $dfct_confby_rel = '';
				foreach ($dfct_confby as $d) {
					$dfct_confby_qcd .= ($d -> CONF_TYPE == '0') ? $d -> CONF_BY . ', ' : '';
					$dfct_confby_rel .= ($d -> CONF_TYPE == '1') ? $d -> CONF_BY . ', ' : '';
				}

				// send email
				$to = (get_user_email_approval($this));
				$content = get_content_email_unapproval($dfct, $dfct_confby_qcd, $dfct_confby_rel);
				$subject = 'INFORMATION PROBLEM [CANCELLED]';

				$this -> dm -> send_email($to, $content, $subject);
			}
			$data['err'] = $err;
		} else {
			echo $err = 'Another user had to cancel this defect';
		}
	}

	// fungsi untuk SETSQPR
	function setSQPR() {
		$err = '';
		$problem_id = $_POST['problem_id'];

		// cek concurency
		$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$p = $this -> dm -> select('', '', $w);
		$sqpr_num = $p[0] -> SQPR_NUM;

		if ($sqpr_num == '') {

			$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
			$keys = "PROBLEM_ID = '" . $problem_id . "'";
			$SQPR = $this -> dm -> sqpr_number();
			// get detail
			$dfct = $this -> dm -> select('', '', "PROBLEM_ID = '" . $problem_id . "'");
			$dfct = $dfct[0];

			if ($dfct -> APPROVE_PDATE == '') {
				$err = 'DEFECT STATUS MUST BE APPROVE FIRST !';
			} else {
				$data = array('SQPR_NUM' => $SQPR);

				$this -> dm -> update($data, $keys);
			}
			//   $data['err'] = $err;
		} else {
			echo $err = 'Another user already given a SQPR Sign';
		}
	}

	// fungsi untuk CANCEL SETSQPR
	function SQPRcanc() {
		$problem_id = $_POST['problem_id'];

		// cek concurency
		$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$p = $this -> dm -> select('', '', $w);
		$sqpr_num = $p[0] -> SQPR_NUM;

		if ($sqpr_num != '') {

			$this -> dm -> init('T_SQA_DFCT', 'PROBLEM_ID');
			$keys = "PROBLEM_ID = '" . $problem_id . "'";
			$SQPR = $this -> dm -> sqpr_number();

			$data = array('SQPR_NUM' => null);

			$this -> dm -> update($data, $keys);
			//  $order = "SQA_PDATE desc";
			//$data['list_v_sqa_dfct'] = $this->v_sqa_dfct_model->select('', $order, '');
		} else {
			echo $err = 'Cancel SQPR already done by another User';
		}
	}

	// fungsi untuk P/S Closed
	function PSclosed() {
		$err = '';
		$problem_id = $_POST['problem_id'];

		// cek concurency
		$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$p = $this -> dm -> select('', '', $w);
		$close_flg = $p[0] -> CLOSE_FLG;

		if ($close_flg == '0') {

			$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_ID');
			$dfct_reply = $this -> dm -> select('', '', "PROBLEM_ID = '" . $problem_id . "'");
			$dfct_reply = $dfct_reply[0];

			$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
			$keys = "PROBLEM_ID = '" . $problem_id . "'";

			// get detail dfct
			$dfct = $this -> dm -> select('', '', "PROBLEM_ID = '" . $problem_id . "'");
			$dfct = $dfct[0];

			if ($dfct -> APPROVE_PDATE != '' && $dfct -> CLOSE_FLG == '0' && $dfct_reply -> APPROVE_PDATE != '') {
				$data = array('CLOSE_FLG' => 1, 'CLOSE_PDATE' => get_date(), 'CLOSE_SYSDATE' => get_date(), 'CLOSED_BY' => get_user_info($this, 'USER_ID'));
				$this -> dm -> update($data, $keys);
			} else {
				$err = "DEFECT STATUS IS NOT HAVE APPROVE SQA & APRPOVE REPLY !";
			}

			$data['err'] = $err;
		} else {
			echo $err = 'PS/Closed Already done by another User';
		}
		//        $order = "SQA_PDATE desc";
		//        $data['list_v_sqa_dfct'] = $this->v_sqa_dfct_model->select('', $order, '');
		//        $this->load->view('inquiry/list_vinf', $data);
	}

	//=================fungsi download report=================

	function dwnld_report() {
		$bulan = date("n", strtotime(get_date()));
		//tanggal dari work calender
		$sql = "select distinct WORK_PRDT
		from M_SQA_WORK_CALENDAR
		where WORK_FLAG ='1' and month(WORK_PRDT) = '" . $bulan . "' ";
		$tgl_work_calender = $this -> dm -> sql_self($sql);
		$data['tgl_work_calender'] = $tgl_work_calender;

		$user_grpauth = get_user_info($this, 'GRPAUTH_ID');
		$data['user_grpauth'] = $user_grpauth;
		//echo $user_grpauth;

		$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
		$daily = $this -> dm -> select('', '', '');
		$sql = "
            DECLARE @MyIdentity uniqueidentifier;
            SET @MyIdentity = NewID();

            SELECT DISTINCT DESCRIPTION 
            FROM T_SQA_VINF
            ";
		$query = $this -> dm -> sql_self($sql);

		$data['daily'] = $daily;
		$data['query'] = $query;
		$this -> load -> view('header_plain', $data);
		$this -> load -> view('download_report/download_report', $data);
	}

	//=================fungsi result search=================
	function result_search() {

		//=================mengambil uri paramaeter pencarian=================
		$param = base64_decode(HexToAscii($this -> uri -> segment(4)));
		// echo $param;
		$condition = '';
		$IDNO = $_POST['IDNO'];

		if ($param != '') {
			$param_ex = explode(';;', $param);
			$from = $param_ex[0];
			$to = $param_ex[1];
			$sqa_shiftgrpnm = $param_ex[2];
			$plant_nm = $param_ex[3];
			$SHOP_NM = $param_ex[4];
			$ASSY_FROM_PDATE = $param_ex[5];
			$ASSY_TO_PDATE = $param_ex[6];
			$ASSY_SHIFTGRPNM = $param_ex[7];
			$INSP_FROM_PDATE = $param_ex[8];
			$INSP_TO_PDATE = $param_ex[9];
			$INSP_SHIFTGRPNM = $param_ex[10];
			$DESCRIPTION = $param_ex[11];
			$KATASHIKI = $param_ex[12];
			$EXTCLR = $param_ex[13];
			$VINNO = $param_ex[14];
			$BODYNO = $param_ex[15];
			$stat_prob = $param_ex[16];
			$DFCT = $param_ex[17];
			$RANK_NM = $param_ex[18];
			$CTG_GRP_NM = $param_ex[19];
			$CTG_NM = $param_ex[20];
			$INSP_ITEM_FLG = $param_ex[21];
			$QLTY_GT_ITEM = $param_ex[22];
			$REPAIR_FLG = $param_ex[23];
			$Problem_Sheet_a = $param_ex[24];
			$Problem_Sheet_b = $param_ex[25];
			$Problem_Sheet_c = $param_ex[26];
			$Problem_Sheet_d = $param_ex[27];
			$Status_Problem_Sheet = $param_ex[28];

		}
		//=================mengambil uri kondisi=================
		$condition = base64_decode(HexToAscii($this -> uri -> segment(3)));

		//echo $condition;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['sqa_shiftgrpnm'] = $sqa_shiftgrpnm;
		$data['plant_nm'] = $plant_nm;
		$data['SHOP_NM'] = $SHOP_NM;
		$data['ASSY_FROM_PDATE'] = $ASSY_FROM_PDATE;
		$data['ASSY_TO_PDATE'] = $ASSY_TO_PDATE;
		$data['ASSY_SHIFTGRPNM'] = $ASSY_SHIFTGRPNM;
		$data['INSP_FROM_PDATE'] = $INSP_FROM_PDATE;
		$data['INSP_TO_PDATE'] = $INSP_TO_PDATE;
		$data['INSP_SHIFTGRPNM'] = $INSP_SHIFTGRPNM;
		$data['DESCRIPTION'] = $DESCRIPTION;
		$data['KATASHIKI'] = $KATASHIKI;
		$data['EXTCLR'] = $EXTCLR;
		$data['VINNO'] = $VINNO;
		$data['BODYNO'] = $BODYNO;
		$data['stat_prob'] = $stat_prob;
		$data['DFCT'] = $DFCT;
		$data['RANK_NM'] = $RANK_NM;
		$data['INSP_ITEM_FLG'] = $INSP_ITEM_FLG;
		$data['CTG_GRP_NM'] = $CTG_GRP_NM;
		$data['CTG_NM'] = $CTG_NM;
		$data['QLTY_GT_ITEM'] = $QLTY_GT_ITEM;
		$data['REPAIR_FLG'] = $REPAIR_FLG;
		$data['Problem_Sheet_a'] = $Problem_Sheet_a;
		$data['Problem_Sheet_b'] = $Problem_Sheet_b;
		$data['Problem_Sheet_c'] = $Problem_Sheet_c;
		$data['Problem_Sheet_d'] = $Problem_Sheet_d;
		$data['Problem_Sheet'] = $Problem_Sheet;
		$data['Status_Problem_Sheet'] = $Status_Problem_Sheet;
		$data['IDNO'] = $IDNO;

		$w = $condition . " AND APPROVE_PDATE IS NOT NULL";
		$list_v_sqa_dfct = $this -> v_sqa_dfct_model -> select('', 'SQA_PDATE ASC', $w);
		$data['list_v_sqa_dfct'] = $list_v_sqa_dfct;

		// di cari replynya berdasarkan ilst_v_sqa_dfct;
		$list_dfct_reply = array();
		foreach ($list_v_sqa_dfct as $l) {
			$problem_id = $l -> PROBLEM_ID;
			// cari reply berdasarkan problem id
			$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
			$w = "PROBLEM_ID = '" . $problem_id . "'";
			$dfct_reply = $this -> dm -> select('', '', $w);
			if (count($dfct_reply) > 0) {
				$list_dfct_reply[$problem_id] = $dfct_reply;
			}
		}
		$data['list_dfct_reply'] = $list_dfct_reply;

		//=========================Menampilkan tabel hasil pencarian fusion chart ====================================

		// cari data untuk graph
		$sqa_pdate_temp = '';
		$count_sqa = 0;
		$list_graph = array();
		$i = 0;

		//cari banyak selisih hari

		// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
		// dari tanggal pertama

		$pecah1 = explode("-", $from);
		$date1 = $pecah1[0];
		$month1 = $pecah1[1];
		$year1 = $pecah1[2];

		// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
		// dari tanggal kedua

		$pecah2 = explode("-", $to);
		$date2 = $pecah2[0];
		$month2 = $pecah2[1];
		$year2 = $pecah2[2];

		// menghitung JDN dari masing-masing tanggal

		$jd1 = GregorianToJD($month1, $date1, $year1);
		$jd2 = GregorianToJD($month2, $date2, $year2);

		// hitung selisih hari kedua tanggal

		$selisih = $jd2 - $jd1;
		$now = strtotime($from);
		$now2 = date('Y-m-d', strtotime($from));
		$now3 = date('j-m-Y', strtotime($from));
		$w2 = $condition . " AND APPROVE_PDATE IS NOT NULL and SQA_PDATE='$now2'";
		$list_v_sqa_dfct3 = $this -> v_sqa_dfct_model -> select('', 'SQA_PDATE ASC', $w2);
		$data['list_v_sqa_dfct3'] = $list_v_sqa_dfct3;
		foreach ($list_v_sqa_dfct3 as $l) {
			$sqa_pdate = $l -> SQA_PDATE;

			if ($now3 == $sqa_pdate) {
				$count_sqa++;
			} else {
				$now3 = $sqa_pdate;
				$count_sqa = 1;
			}
		}
		$list_graph[] = ($count_sqa);
		$tanggal[] = date('j', strtotime($now3));

		$count_sqa = 0;
		for ($i = 1; $i <= $selisih; $i++) {
			$now = date('j-m-Y', strtotime('+1 day', $now));
			$now2 = date('Y-m-d', strtotime($now));
			$w = $condition . " AND APPROVE_PDATE IS NOT NULL and SQA_PDATE='$now2'";
			$list_v_sqa_dfct2 = $this -> v_sqa_dfct_model -> select('', 'SQA_PDATE ASC', $w);
			$data['list_v_sqa_dfct2'] = $list_v_sqa_dfct2;
			foreach ($list_v_sqa_dfct2 as $l) {
				$sqa_pdate = $l -> SQA_PDATE;

				if ($now == $sqa_pdate) {
					$count_sqa++;
				} else {
					$now = $sqa_pdate;
					$count_sqa = 1;
				}

			}

			$list_graph[] = ($count_sqa);
			$tanggal[] = date('j', strtotime($now));

			$now = strtotime($now);
			$count_sqa = 0;
		}
		//end selisih
		$data['list_graph'] = ($list_graph);
		$data['tanggal'] = ($tes);

		// higchart ========================================================================

		$data['users']['data'] = $list_graph;
		$data['users']['name'] = 'date';
		//	$data['popul']['data'] = array(10, 3, 2, 0, 1);
		//	$data['popul']['name'] = 'World Population';
		$data['axis']['categories'] = $tanggal;

		$this -> load -> library('highcharts');

		$callback = "function() { return '<b>'+ this.x +'</b>: '+ this.y }";
		$tool -> formatter = $callback;
		$plot -> column -> dataLabels -> enabled = 'true';
		$plot -> column -> stacking = 'normal';

		$this -> highcharts -> set_type('column');
		// drauwing type
		$this -> highcharts -> set_title('Result Search SQA System Graph', '');
		// set chart title: title, subtitle(optional)
		$this -> highcharts -> set_axis_titles('Number', 'Number');
		// axis titles: x axis,  y axis
		$this -> highcharts -> set_tooltip($tool);
		$this -> highcharts -> set_plotOptions($plot);

		$this -> highcharts -> set_xAxis($data['axis']);
		// pushing categories for x axis labels
		$this -> highcharts -> set_serie($data['users']);
		// the first serie
		//	$this->highcharts->set_serie($data['popul']); // second serie

		$this -> highcharts -> render_to('my_div');
		// choose a specific div to render to graph

		$data['charts'] = $this -> highcharts -> render();
		// we render js and div in same time

		// end highchart ============================================================

		$this -> load -> view('header_plain');
		$this -> load -> view('download_report/result_search', $data);

	}

	//=================fungsi result search=================
	function result_search_print() {

		//=================mengambil uri paramaeter pencarian=================
		$param = base64_decode(HexToAscii($this -> uri -> segment(4)));
		// echo $param;
		$condition = '';
		$IDNO = $_POST['IDNO'];

		if ($param != '') {
			$param_ex = explode(';;', $param);
			$from = $param_ex[0];
			$to = $param_ex[1];
			$sqa_shiftgrpnm = $param_ex[2];
			$plant_nm = $param_ex[3];
			$SHOP_NM = $param_ex[4];
			$ASSY_FROM_PDATE = $param_ex[5];
			$ASSY_TO_PDATE = $param_ex[6];
			$ASSY_SHIFTGRPNM = $param_ex[7];
			$INSP_FROM_PDATE = $param_ex[8];
			$INSP_TO_PDATE = $param_ex[9];
			$INSP_SHIFTGRPNM = $param_ex[10];
			$DESCRIPTION = $param_ex[11];
			$KATASHIKI = $param_ex[12];
			$EXTCLR = $param_ex[13];
			$VINNO = $param_ex[14];
			$BODYNO = $param_ex[15];
			$stat_prob = $param_ex[16];
			$DFCT = $param_ex[17];
			$RANK_NM = $param_ex[18];
			$CTG_GRP_NM = $param_ex[19];
			$CTG_NM = $param_ex[20];
			$INSP_ITEM_FLG = $param_ex[21];
			$QLTY_GT_ITEM = $param_ex[22];
			$REPAIR_FLG = $param_ex[23];
			$Problem_Sheet_a = $param_ex[24];
			$Problem_Sheet_b = $param_ex[25];
			$Problem_Sheet_c = $param_ex[26];
			$Problem_Sheet_d = $param_ex[27];
			$Status_Problem_Sheet = $param_ex[28];

		}
		//=================mengambil uri kondisi=================
		$condition = base64_decode(HexToAscii($this -> uri -> segment(3)));

		//echo $condition;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['sqa_shiftgrpnm'] = $sqa_shiftgrpnm;
		$data['plant_nm'] = $plant_nm;
		$data['SHOP_NM'] = $SHOP_NM;
		$data['ASSY_FROM_PDATE'] = $ASSY_FROM_PDATE;
		$data['ASSY_TO_PDATE'] = $ASSY_TO_PDATE;
		$data['ASSY_SHIFTGRPNM'] = $ASSY_SHIFTGRPNM;
		$data['INSP_FROM_PDATE'] = $INSP_FROM_PDATE;
		$data['INSP_TO_PDATE'] = $INSP_TO_PDATE;
		$data['INSP_SHIFTGRPNM'] = $INSP_SHIFTGRPNM;
		$data['DESCRIPTION'] = $DESCRIPTION;
		$data['KATASHIKI'] = $KATASHIKI;
		$data['EXTCLR'] = $EXTCLR;
		$data['VINNO'] = $VINNO;
		$data['BODYNO'] = $BODYNO;
		$data['stat_prob'] = $stat_prob;
		$data['DFCT'] = $DFCT;
		$data['RANK_NM'] = $RANK_NM;
		$data['INSP_ITEM_FLG'] = $INSP_ITEM_FLG;
		$data['CTG_GRP_NM'] = $CTG_GRP_NM;
		$data['CTG_NM'] = $CTG_NM;
		$data['QLTY_GT_ITEM'] = $QLTY_GT_ITEM;
		$data['REPAIR_FLG'] = $REPAIR_FLG;
		$data['Problem_Sheet_a'] = $Problem_Sheet_a;
		$data['Problem_Sheet_b'] = $Problem_Sheet_b;
		$data['Problem_Sheet_c'] = $Problem_Sheet_c;
		$data['Problem_Sheet_d'] = $Problem_Sheet_d;
		$data['Problem_Sheet'] = $Problem_Sheet;
		$data['Status_Problem_Sheet'] = $Status_Problem_Sheet;
		$data['IDNO'] = $IDNO;

		$w = $condition . " AND APPROVE_PDATE IS NOT NULL";
		$list_v_sqa_dfct = $this -> v_sqa_dfct_model -> select('', 'SQA_PDATE ASC', $w);
		$data['list_v_sqa_dfct'] = $list_v_sqa_dfct;

		// di cari replynya berdasarkan ilst_v_sqa_dfct;
		$list_dfct_reply = array();
		foreach ($list_v_sqa_dfct as $l) {
			$problem_id = $l -> PROBLEM_ID;
			// cari reply berdasarkan problem id
			$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
			$w = "PROBLEM_ID = '" . $problem_id . "'";
			$dfct_reply = $this -> dm -> select('', '', $w);
			if (count($dfct_reply) > 0) {
				$list_dfct_reply[$problem_id] = $dfct_reply;
			}
		}
		$data['list_dfct_reply'] = $list_dfct_reply;

		//=========================Menampilkan tabel hasil pencarian fusion chart ====================================

		// cari data untuk graph
		$sqa_pdate_temp = '';
		$count_sqa = 0;
		$list_graph = array();
		$i = 0;

		//cari banyak selisih hari

		// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
		// dari tanggal pertama

		$pecah1 = explode("-", $from);
		$date1 = $pecah1[0];
		$month1 = $pecah1[1];
		$year1 = $pecah1[2];

		// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
		// dari tanggal kedua

		$pecah2 = explode("-", $to);
		$date2 = $pecah2[0];
		$month2 = $pecah2[1];
		$year2 = $pecah2[2];

		// menghitung JDN dari masing-masing tanggal

		$jd1 = GregorianToJD($month1, $date1, $year1);
		$jd2 = GregorianToJD($month2, $date2, $year2);

		// hitung selisih hari kedua tanggal

		$selisih = $jd2 - $jd1;
		$now = strtotime($from);
		$now2 = date('Y-m-d', strtotime($from));
		$now3 = date('j-m-Y', strtotime($from));
		$w2 = $condition . " AND APPROVE_PDATE IS NOT NULL and SQA_PDATE='$now2'";
		$list_v_sqa_dfct3 = $this -> v_sqa_dfct_model -> select('', 'SQA_PDATE ASC', $w2);
		$data['list_v_sqa_dfct3'] = $list_v_sqa_dfct3;
		foreach ($list_v_sqa_dfct3 as $l) {
			$sqa_pdate = $l -> SQA_PDATE;

			if ($now3 == $sqa_pdate) {
				$count_sqa++;
			} else {
				$now3 = $sqa_pdate;
				$count_sqa = 1;
			}
		}
		$list_graph[] = ($count_sqa);
		$tanggal[] = date('j', strtotime($now3));

		$count_sqa = 0;
		for ($i = 1; $i <= $selisih; $i++) {
			$now = date('j-m-Y', strtotime('+1 day', $now));
			$now2 = date('Y-m-d', strtotime($now));
			$w = $condition . " AND APPROVE_PDATE IS NOT NULL and SQA_PDATE='$now2'";
			$list_v_sqa_dfct2 = $this -> v_sqa_dfct_model -> select('', 'SQA_PDATE ASC', $w);
			$data['list_v_sqa_dfct2'] = $list_v_sqa_dfct2;
			foreach ($list_v_sqa_dfct2 as $l) {
				$sqa_pdate = $l -> SQA_PDATE;

				if ($now == $sqa_pdate) {
					$count_sqa++;
				} else {
					$now = $sqa_pdate;
					$count_sqa = 1;
				}

			}

			$list_graph[] = ($count_sqa);
			$tanggal[] = date('j', strtotime($now));

			$now = strtotime($now);
			$count_sqa = 0;
		}

		$data['list_graph'] = ($list_graph);
		$data['tanggal'] = ($tes);

		// higchart ========================================================================

		$data['users']['data'] = $list_graph;
		$data['users']['name'] = 'date';
		//	$data['popul']['data'] = array(10, 3, 2, 0, 1);
		//	$data['popul']['name'] = 'World Population';
		$data['axis']['categories'] = $tanggal;

		$this -> load -> library('highcharts');

		$callback = "function() { return '<b>'+ this.x +'</b>: '+ this.y }";
		$tool -> formatter = $callback;
		$plot -> column -> dataLabels -> enabled = 'true';
		$plot -> column -> stacking = 'normal';

		$this -> highcharts -> set_type('column');
		// drauwing type
		$this -> highcharts -> set_title('Result Search SQA System Graph', '');
		// set chart title: title, subtitle(optional)
		$this -> highcharts -> set_axis_titles('Number', 'Number');
		// axis titles: x axis,  y axis
		$this -> highcharts -> set_tooltip($tool);
		$this -> highcharts -> set_plotOptions($plot);

		$this -> highcharts -> set_xAxis($data['axis']);
		// pushing categories for x axis labels
		$this -> highcharts -> set_serie($data['users']);
		// the first serie
		//	$this->highcharts->set_serie($data['popul']); // second serie

		$this -> highcharts -> render_to('my_div');
		// choose a specific div to render to graph

		$data['charts'] = $this -> highcharts -> render();
		// we render js and div in same time

		// end highchart ============================================================

		$this -> load -> view('header_plain');
		$this -> load -> view('download_report/result_search_print', $data);

	}

	function get_problem() {
		$problem_id = $_POST['problem_id'];
		$this -> dm -> init('V_T_SQA_DFCT', 'PROBLEM_ID');
		$problem = $this -> dm -> select('', '', "PROBLEM_ID = '" . $problem_id . "'");

		$this -> dm -> init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
		$w = "PROBLEM_ID = '" . $problem_id . "'";
		$dfct_reply = $this -> dm -> select('', '', $w);

		$ot_date = $of_date = $rt_date = $rf_date = '';

		foreach ($dfct_reply as $r) {
			$srt_due_date = date("Y-m-d", strtotime($r -> DUE_DATE));
			$srt_approve = date("Y-m-d", strtotime($r -> APPROVE_SYSDATE));

			$due_date = explode('-', $srt_due_date);
			$due_date2 = $explode[2] . "-" . $explode[1] . "-" . $explode[0];

			$approve_sysdate = explode('-', $srt_approve);
			$approve_sysdate2 = $explode[2] . "-" . $explode[1] . "-" . $explode[0];

			if ($r -> REPLY_TYPE == 'O' && $r -> COUNTERMEASURE_TYPE == 'T') {// jika OT
				$ot_date = $r -> APPROVE_PDATE;
			} else if ($r -> REPLY_TYPE == 'O' && $r -> COUNTERMEASURE_TYPE == 'F') {// JIKA OF
				$of_date = $r -> APPROVE_PDATE;
			} else if ($r -> REPLY_TYPE == 'R' && $r -> COUNTERMEASURE_TYPE == 'T') {// JIKA RT
				$rt_date = $r -> APPROVE_PDATE;
			} else if ($r -> REPLY_TYPE == 'R' && $r -> COUNTERMEASURE_TYPE == 'F') {// JIKA RF
				$rf_date = $r -> APPROVE_PDATE;
			}
		}

		if (count($problem) > 0) {
			$p = $problem[0];
			$out = array($problem_id, $p -> SHOW_FLG, $p -> APPROVE_PDATE, $p -> REG_IN, $p -> CHECK_PDATE, $p -> SQPR_NUM, $p -> DESCRIPTION, $p -> SHOP_NM, $p -> BODY_NO, $p -> INSP_ITEM_FLG, $ot_date, $of_date, $rt_date, $rf_date, get_user_info($this, 'GRPAUTH_ID'));
		} else {
			$out = array(0, '');
		}
		echo json_encode($out);
	}

}
?>