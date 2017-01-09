<?php
class monitoring_info extends CI_Controller {
    function  __construct() {
        parent::__construct();
        $this->load->model('m_sqa_model', 'dm', true);        
    }

    
    function index() {
        redirect('monitoring_info/browse/');
    }
    
    function browse() {
        // default PLANT
        $plant_cd_default = '';
        
        $err = '';
		$plant_nm = ($this->uri->segment(3)!='') ? $this->uri->segment(3) : get_user_info($this, 'PLANT_NM');      
		$plantcd=get_user_info($this, 'PLANT_CD')  ;
        if ($plant_nm == '') {
            $err = 1;
        }
        $sql = "select distinct DESCRIPTION from V_T_SQA_DFCT WHERE SHOW_FLG = '1' AND IS_DELETED = '0' AND PLANT_NM = '" . $plant_nm . "' ORDER BY DESCRIPTION ASC";
        $data['katashiki'] = $this->dm->sql_self($sql);

        $this->dm->init('V_T_SQA_DFCT','PROBLEM_ID');
        $data['dfct_show'] = $this->dm->select('','DESCRIPTION ASC, SQA_PDATE DESC',"SHOW_FLG = '1' AND IS_DELETED = '0' AND PLANT_NM = '" . $plant_nm . "'");
	
        // find running text
        $this->dm->init('V_SQA_RUNNING_TEXT', 'PLANT_CD');
        $tgl_now = get_date();
        $w = "PLANT_NM = '" . $plant_nm . "' and (DATE_FROM <= '" . $tgl_now . "' and DATE_TO >= '" . $tgl_now . "')";
        $rt = $this->dm->select('','',$w);
        $data['rt'] = (count($rt)>0) ? $rt[0] : '';
		
        
         $this->load->library('highcharts');
        
        
       $data['users']['data'] = array(536564837, 444948013, 153309074, 99143700, 82548200);
		$data['users']['name'] = 'Users by Language';
		$data['popul']['data'] = array(1277528133, 1365524982, 420469703, 126804433, 250372925);
		$data['popul']['name'] = 'World Population';
		$data['axis']['categories'] = array('English', 'Chinese', 'Spanish', 'Japanese', 'Portuguese');
			
		$this->load->library('highcharts');
	
		$this->highcharts->set_type('column'); // drauwing type
		$this->highcharts->set_title('INTERNET WORLD USERS BY LANGUAGE', 'Top 5 Languages in 2010'); // set chart title: title, subtitle(optional)
		$this->highcharts->set_axis_titles('language'); // axis titles: x axis,  y axis
        
		
		$this->highcharts->set_xAxis($data['axis']); 
        // pushing categories for x axis labels
		$this->highcharts->set_serie($data['users']); // the first serie
		$this->highcharts->set_serie($data['popul']); // second serie
		
		// we can user credits option to make a link to the source article. 
		// it's possible to pass an object instead of array (but object will be converted to array by the lib)
		$credits->href = 'http://www.internetworldstats.com/stats7.htm';
		$credits->text = "Article on Internet Wold Stats";
		$this->highcharts->set_credits($credits);
		
		$this->highcharts->render_to('my_div'); // choose a specific div to render to graph
	
		$data['mon_info'] = $this->highcharts->render(); // we render js and div in same time
		
        
        
        
        $data['page_title'] = 'TMMIN - SHIPPING QUALITY AUDIT';
        $this->load->view('header', $data);
		$this->load->view('monitoring_du', $data); 					
    }
    
   
    
    function check_runtext() {
        $plant_nm = $_POST['plant_nm'];
        $last_rt_dt = $_POST['last_rt_dt'];
        
        // find running text
        $this->dm->init('V_SQA_RUNNING_TEXT', 'PLANT_CD');
        $tgl_now = get_date();
        $w = "PLANT_NM = '" . $plant_nm . "' and (DATE_FROM <= '" . $tgl_now . "' and DATE_TO >= '" . $tgl_now . "')";
        $w .= ($last_rt_dt != '') ? " and (Updatedt > '" . $last_rt_dt . "')" : '';
        $rt = $this->dm->select('','',$w, '*', true);
        $rt = (count($rt)>0) ? $rt[0] : '';
        
        $out = '';
        if ($rt != '') {
            $out = '<div style="border: 1px solid #B9B9B9; 
                        background-color: #'.$rt->BACKGROUND_CLR.'; 
                        color: #'.$rt->FONT_CLR.'; 
                        font-size: '.$rt->FONT_SIZE.'px; 
                        font-family: '.$rt->FONT_NM.'; 
                        height: auto;">
                        <marquee behavior="scroll" scrollamount="3" direction="left" width="100%">
                            <div style="padding: 15px 0 20px 0;">'.$rt->RUNTEXT.'</div>
                        </marquee>
                    </div>
                    <input type="text" id="last_rt_dt" value="'.date('Y-m-d H:i:s', strtotime($rt->Updatedt)).'" />
                    ';
        }
        echo $out;
    }
    
    

    function test(){
        $this->dm->init('V_T_SQA_DFCT', 'PROBLEM_ID');
        $sql = "select distinct KATASHIKI from V_T_SQA_DFCT where SHOW_FLG = '1'";
        $M= $this->dm->sql_self($sql);
        $k = $M[0];
        echo $k->KATASHIKI;
        $b=  $M[1];
        echo $b->KATASHIKI;
        $c = $M[2];
        echo $c->KATASHIKI;
    }
}

?>