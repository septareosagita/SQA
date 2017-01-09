<?php

/*
* @author: ryan@mediantarakreasindo.com
* @created: April, 01 2011 - 00:00
*/

class monthly_report extends CI_Controller
{

    public $fieldseq = array();

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('m_sqa_model', 'dm', true);
        $this->load->vars($data);

        if ($this->session->userdata('user_info') == '')
            redirect('welcome/out');
    }

    function index()
    {
        redirect('monthly_report/monthly_report_screen');
    }

     function monthly_report_screen()
    {   
        $model = $this->uri->segment(3);
       // $bulankurangsatu = date("n",strtotime(get_date()));
        $tahun = date("Y",strtotime(get_date()));
        $bulankurangsatu_tahun = date("M Y", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
        $bulankurangsatu = date("n", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
        
//B. AUDIT RESULT ====================================================================
        //TOTAL UNIT NUM_VEH
        $sql = "select FISCAL_YEAR,MONTH(PDATE) as PDATE ,SUM(NUM_VEH) as TOTAL_NUM_VEH
        from T_SQA_DU_SUMMARY_MDL
        where FISCAL_YEAR = (select max(FISCAL_YEAR) from T_SQA_DU_SUMMARY_MDL)       
        and MODEL = '". $model ."'
        group by MONTH(PDATE),FISCAL_YEAR    
        ";
        $total_unit_month2 = $this->dm->sql_self($sql);     
        $data['total_unit_month2'] = $total_unit_month2;
        
        $sql = "select SUM(NUM_VEH) as TOTAL_NUM_VEH
        from T_SQA_DU_SUMMARY_MDL
        where FISCAL_YEAR = (select max(FISCAL_YEAR) from T_SQA_DU_SUMMARY_MDL)
         and month(PDATE) = '". $bulankurangsatu ."'         
        and MODEL = '". $model ."'       
        ";
        $ambil = $this->dm->sql_self($sql);
        $total_unit_month = $ambil[0]->TOTAL_NUM_VEH;
        $data['total_unit_month'] = $total_unit_month;
        
        
        
        // B. AUDIT RESULT 
        $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG_RANK', 'PLANT_CD');
        $w = "month(PDATE) = '". $bulankurangsatu ."'  and MODEL = '" . $model . "'";
        $list_rank = $this->dm->select('', '', $w);
        $data['list_rank'] = $list_rank;
        
        // C. TREND D/U 
        $this->dm->init('T_SQA_DU_SUMMARY_MDL_CTG_RANK', 'PLANT_CD');
        $w = "MODEL = '" . $model . "'";
        $list_rank_du = $this->dm->select('', '', $w);
        $data['list_rank_du'] = $list_rank_du;
        
        // total C. TREND D/U 
        $sql = "select FISCAL_YEAR,PDATE, SUM(DU_MDL_CTG_RANK_MONTHLY) as DU_MDL_CTG_RANK_MONTHLY
        from T_SQA_DU_SUMMARY_MDL_CTG_RANK
        GROUP BY PDATE,FISCAL_YEAR"; 
        $total_list_rank_du = $this->dm->sql_self($sql);
        $data['total_list_rank_du'] = $total_list_rank_du;
        
        
        //====================================================================
    
//DISTRIBUTION D/U BY RANK AND C. TREND D/U ==================================================
        //max fiscal years
        $sql = "
        select MAX(WORK_PRDT) as MAX_FISCAL,MIN(WORK_PRDT) as MIN_FISCAL
        from V_SQA_WORK_CALENDAR
        where FISCAL_YEAR = '". $tahun ."'
        ";        
        $ambil = $this->dm->sql_self($sql);
        $max_fiscal = date("d-m-Y",strtotime($ambil[0]->MAX_FISCAL));
        $min_fiscal = date("d-m-Y",strtotime($ambil[0]->MIN_FISCAL));
        
         
        
        // menhitung selisih bulan 
        //exlplode 1
        $pecah1 = explode("-", $max_fiscal);
        $date1 = $pecah1[0];
        $month1 = $pecah1[1];
        $year1 = $pecah1[2];
        //exlplode 2
        $pecah2 = explode("-", $min_fiscal);
        $date2 = $pecah2[0];
        $month2 = $pecah2[1];
        $year2 = $pecah2[2];
     
        $bulankurangsatu_max_fiscal = date("M Y", mktime(0, 0, 0, date($month1), date($date1), date($year1)));       
        $bulankurangsatu_min_fiscal = date("M Y", mktime(0, 0, 0, date($month2), date($date2), date($year2)));  
        
         for ($i = 0; $i <= 11; $i++)
        {
            $bulankurangsatu_fiscal[] = date("M", mktime(0, 0, 0, date($month2) +$i, date($date2), date($year2)));  
        }
        $data['bulan_max_fiscal'] = $max_fiscal;
        $data['bulan_min_fiscal'] = $min_fiscal;
        $data['bulan_fiscal'] = $bulankurangsatu_fiscal;
        
         // rank func & apperance
        $sql = "select NUM_VEH,DFCT_CTG,RANK_DESC,RANK_NM,MONTH(PDATE) as M_PDATE,DU_MDL_CTG_RANK_MONTHLY,NUM_DFCT, FISCAL_YEAR
        from T_SQA_DU_SUMMARY_MDL_CTG_RANK
        where MODEL = '" . $model . "'    
        ";       
        $ambil = $this->dm->sql_self($sql);       
        $data['list_rank_DU'] = $ambil;
        
        //actual total per existing month/filled total month from fiscal years
        $sql="select MONTH(PDATE) as month_pdate
        from 
        T_SQA_DU_SUMMARY_MDL_CTG_RANK
        GROUP BY MONTH(PDATE)
        ";
        $ambil = $this->dm->sql_self($sql);
        $count_m_pdate = count($ambil);
        $data['count_m_pdate']=$count_m_pdate;
         
         //====================================================================
         
//C. TREND BY DEFECT CATEGORY==========================================
          
        //defect category driving
        $this->dm->init('V_SQA_CTG','CTG_GRP_ID');
        $w = "SUBSTRING(CTG_GRP_NM,1,1) = 'D'";
        $dfct_ctg_driving = $this->dm->select('','',$w);
        $data['dfct_ctg_driving']=$dfct_ctg_driving;
        
         $sql = "select 
	V_SQA_CTG.CTG_NM,
	V_SQA_CTG.CTG_GRP_NM,
	V_SQA_CTG.CTG_GRP_ID + V_SQA_CTG.CTG_ID AS CTG,
	COUNT(V_T_SQA_DFCT.CTG_NM) AS JML,
	
	V_T_SQA_DFCT.DESCRIPTION,
	MONTH(V_T_SQA_DFCT.SQA_PDATE) AS SQA_PDATE

    from V_SQA_CTG left join V_T_SQA_DFCT on V_T_SQA_DFCT.CTG_NM = V_SQA_CTG.CTG_NM AND V_SQA_CTG.CTG_GRP_NM = V_T_SQA_DFCT.CTG_GRP_NM 
    where
	LEFT(V_SQA_CTG.CTG_GRP_NM,1) = 'D'
    group by V_SQA_CTG.CTG_NM,
	V_SQA_CTG.CTG_GRP_NM,
	V_SQA_CTG.CTG_GRP_ID + V_SQA_CTG.CTG_ID,
	V_T_SQA_DFCT.DESCRIPTION, SQA_PDATE
    ";
        $cate_d = $this->dm->sql_self($sql);
        $data['cate_d']=$cate_d;
       // debug_array($cate_d);
        
        //defect category painting
        $this->dm->init('V_SQA_CTG','CTG_GRP_ID');
        $w = "SUBSTRING(CTG_GRP_NM,1,1) = 'P'";
        $dfct_ctg_painting = $this->dm->select('','',$w);
        $data['dfct_ctg_painting']=$dfct_ctg_painting;
        
        $sql = " select 
	V_SQA_CTG.CTG_NM,
	V_SQA_CTG.CTG_GRP_NM,
	V_SQA_CTG.CTG_GRP_ID + V_SQA_CTG.CTG_ID AS CTG,
	COUNT(V_T_SQA_DFCT.CTG_NM) AS JML,
	
	V_T_SQA_DFCT.DESCRIPTION,
	MONTH(V_T_SQA_DFCT.SQA_PDATE) AS SQA_PDATE

    from V_SQA_CTG left join V_T_SQA_DFCT on V_T_SQA_DFCT.CTG_NM = V_SQA_CTG.CTG_NM AND V_SQA_CTG.CTG_GRP_NM = V_T_SQA_DFCT.CTG_GRP_NM 
    where
	LEFT(V_SQA_CTG.CTG_GRP_NM,1) = 'P'
    group by V_SQA_CTG.CTG_NM,
	V_SQA_CTG.CTG_GRP_NM,
	V_SQA_CTG.CTG_GRP_ID + V_SQA_CTG.CTG_ID,
	V_T_SQA_DFCT.DESCRIPTION, SQA_PDATE
    ORDER BY CTG_GRP_NM
        ";
        $cate_p = $this->dm->sql_self($sql);
        $data['cate_p']=$cate_p;
       // debug_array($cate_a);
        
         //defect category assy
        $this->dm->init('V_SQA_CTG','CTG_GRP_ID');
        $w = "SUBSTRING(CTG_GRP_NM,1,1) = 'A'";
        $dfct_ctg_assy = $this->dm->select('','',$w);
        $data['dfct_ctg_assy']=$dfct_ctg_assy;  
        
         $sql = " select 
	V_SQA_CTG.CTG_NM,
	V_SQA_CTG.CTG_GRP_NM,
	V_SQA_CTG.CTG_GRP_ID + V_SQA_CTG.CTG_ID AS CTG,
	COUNT(V_T_SQA_DFCT.CTG_NM) AS JML,
	
	V_T_SQA_DFCT.DESCRIPTION,
	MONTH(V_T_SQA_DFCT.SQA_PDATE) AS SQA_PDATE

    from V_SQA_CTG left join V_T_SQA_DFCT on V_T_SQA_DFCT.CTG_NM = V_SQA_CTG.CTG_NM AND V_SQA_CTG.CTG_GRP_NM = V_T_SQA_DFCT.CTG_GRP_NM 
    where
	LEFT(V_SQA_CTG.CTG_GRP_NM,1) = 'A'
    group by V_SQA_CTG.CTG_NM,
	V_SQA_CTG.CTG_GRP_NM,
	V_SQA_CTG.CTG_GRP_ID + V_SQA_CTG.CTG_ID,
	V_T_SQA_DFCT.DESCRIPTION, SQA_PDATE
    ORDER BY CTG_NM ASC    
        ";
        $cate_a = $this->dm->sql_self($sql);
        $data['cate_a']=$cate_a;
       // debug_array($cate_a);
      
       
        //==================================================================== 
        
//D. DEFECT DISTRIBUTION / RESPONSIBLE SHOP=================================== 
         // rank func & apperance
        $sql="select SUM(NUM_DFCT) as NUM_DFCT , SHOP_NM
        from T_SQA_DU_SUMMARY_MDL_SHOP
        where month(PDATE) = '". $bulankurangsatu ."' and MODEL = '" . $model . "'
        group by SHOP_NM
        ";
        $list_defect = $this->dm->sql_self($sql);
        $data['list_defect'] = $list_defect;
        
        //total defect 
        $sql="select SUM(NUM_DFCT) as NUM_DFCT
        from T_SQA_DU_SUMMARY_MDL_SHOP
        where month(PDATE) = '". $bulankurangsatu ."' and MODEL = '" . $model . "'";
        $ambil = $this->dm->sql_self($sql);
        $sum_defect = $ambil[0]->NUM_DFCT;
        $data['sum_defect'] = $sum_defect;
        
        //====================================================================    
          
        $data['bulankurangsatu_tahun'] = $bulankurangsatu_tahun;     
        $data['model'] = $model;
        $data['bulankurangsatu'] = $bulankurangsatu;
        $this->load->view('header_plain');
        $this->load->view('download_report/monthly_report',$data);
        
    }
    
    function monthly_report_defect(){
    $model = $this->uri->segment(3);    
    //$bulankurangsatu = date("n",strtotime(get_date()));
    $bulankurangsatu_tahun = date("M Y", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    $bulankurangsatu = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    
    $this->dm->init('V_T_SQA_DFCT','PROBLEM_ID');
    $w = "DatePart(month,SQA_PDATE) = '". $bulankurangsatu . "' and DESCRIPTION = '". $model ."' and APPROVE_PDATE is not null";
    $order = "SQA_PDATE desc";
    $list_sqa_dfct = $this->dm->select('',$order,$w);
   // debug_array($list_sqa_dfct);
   
   //================================================================================================================//
        // di cari replynya berdasarkan ilst_v_sqa_dfct;
        $list_dfct_reply = array();
        foreach ($list_sqa_dfct as $l)
        {
            $problem_id = $l->PROBLEM_ID;
            // cari reply berdasarkan problem id
            $this->dm->init('T_SQA_DFCT_REPLY', 'PROBLEM_REPLY_ID');
            $w = "PROBLEM_ID = '" . $problem_id . "'";
            $dfct_reply = $this->dm->select('', '', $w);
            if (count($dfct_reply) > 0)
            {
               $list_dfct_reply[$problem_id] = $dfct_reply;
            }
        }
    $data['bulan_tahun'] =$bulankurangsatu_tahun;
    $data['list_dfct_reply'] = $list_dfct_reply;    
    $data['list_sqa_dfct'] = $list_sqa_dfct;    
    $data['model']= $model;    
    
    $this->load->view('header_plain');
    $this->load->view('download_report/monthly_report_defect.php',$data);     
    }
}

?>